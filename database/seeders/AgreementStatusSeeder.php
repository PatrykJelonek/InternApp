<?php

namespace Database\Seeders;

use App\Constants\AgreementStatusConstants;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgreementStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (AgreementStatusConstants::STATUSES as $STATUS) {
            DB::table('agreement_statuses')->insert(
                [
                    'name' => $STATUS,
                    'description' => AgreementStatusConstants::STATUS_DESCRIPTIONS[$STATUS],
                    'display_name' => AgreementStatusConstants::STATUS_DISPLAY_NAMES[$STATUS],
                    'hex_color' => AgreementStatusConstants::STATUS_HEX_COLORS[$STATUS],
                    'group' => AgreementStatusConstants::STATUS_GROUP[$STATUS],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }
    }
}
