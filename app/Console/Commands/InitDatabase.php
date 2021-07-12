<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InitDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:db {--T|test}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize Database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $exitCode = 0;

        try {
            $exitCode = Artisan::call('migrate:refresh', []);
            $this->line('<fg=green>[✔] Successful Migrate Database</>');
        } catch (\Exception $e) {
            $this->line('<fg=red>[✘] Unsuccessful Migrate Database</>');
            $this->line($e->getMessage());

            return 1;
        }

        try {
            $exitCode = Artisan::call('db:seed', []);
            $this->line('<fg=green>[✔] Successful Seeding</>');
        } catch (\Exception $e) {
            $this->line('<fg=red>[✘] Unsuccessful Seeding</>');
            $this->line($e->getMessage());

            return 1;
        }

        if(!empty($this->option('test'))) {
            try {
                $exitCode = Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Test\\DatabaseSeeder']);
                $this->line('<fg=green>[✔] Successful Seeding Test Data</>');
            } catch (\Exception $e) {
                $this->line('<fg=red>[✘] Unsuccessful Seeding Test Data</>');
                $this->line($e->getMessage());

                return 1;
            }
        }

        return $exitCode;
    }
}
