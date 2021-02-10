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
    protected $signature = 'init:database {--T|test}';

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
            echo "[✔] Successful Migrate Database \n";
        } catch (\Exception $e) {
            echo "[✘] Unsuccessful Migrate Database \n\n";
            echo $e->getMessage();
        }

        try {
            $exitCode = Artisan::call('db:seed', []);
            echo "[✔] Successful Migrate Database \n";
        } catch (\Exception $e) {
            echo "[✘] Unsuccessful Seeding \n\n";
            echo $e->getMessage();
        }

        if(!empty($this->option('test'))) {
            try {
                $exitCode = Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\Test\\DatabaseSeeder']);
                echo "[✔] Successful Migrate Database \n";
            } catch (\Exception $e) {
                echo "[✘] Unsuccessful Seeding Test Data \n\n";
                echo $e->getMessage();
            }
        }

        return $exitCode;
    }
}
