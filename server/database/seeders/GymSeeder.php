<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GymSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingGym = DB::table('gyms')
            ->exists();

        if ($existingGym) {
            Log::info('Gym already exist, skipping seeder...');

            return;
        }

        $gymData = json_decode(
            file_get_contents(database_path('data/gym.data.json')),
            true
        );

        $gymData = array_map(function ($el) {
            unset($el['id']);

            return [
                'id' => Str::uuid(),
                'name' => $el['name'],
                'address' => $el['address'],
                'city' => $el['city'],
                'country' => $el['country'],
                'phone_number' => $el['phone_number'],
                'latitude' => $el['latitude'],
                'longitude' => $el['longitude'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $gymData);

        DB::table('gyms')->insert($gymData);
    }
}
