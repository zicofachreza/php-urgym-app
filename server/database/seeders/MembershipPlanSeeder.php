<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah data membership plan sudah ada
        $existingMembershipPlan = DB::table('membership_plans')
            ->exists();

        if ($existingMembershipPlan) {
            Log::info('Membership plans already exist, skipping seeder...');

            return;
        }

        $membershipPlanData = json_decode(
            file_get_contents(database_path('data/membershipplan.data.json')),
            true
        );

        $membershipPlanData = array_map(function ($el) {
            unset($el['id']);

            return [
                'id' => Str::uuid(),
                'name' => $el['name'],
                'duration_months' => $el['duration_months'],
                'price' => $el['price'],
                'description' => $el['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $membershipPlanData);

        DB::table('membership_plans')->insert($membershipPlanData);
    }
}
