<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GymClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah data gym class sudah ada
        $existingGymClass = DB::table('gym_classes')
            ->exists();

        if ($existingGymClass) {
            Log::info('Gym classes already exist, skipping seeder...');

            return;
        }

        $gymClassData = json_decode(
            file_get_contents(database_path('data/gymclass.data.json')),
            true
        );

        $gymClassData = array_map(function ($el) {
            unset($el['id']);

            return [
                'id' => Str::uuid(),
                'name' => $el['name'],
                'instructor' => $el['instructor'],
                'schedule' => $el['schedule'],
                'capacity' => $el['capacity'],
                'duration' => $el['duration'],
                'description' => $el['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $gymClassData);

        DB::table('gym_classes')->insert($gymClassData);
    }
}
