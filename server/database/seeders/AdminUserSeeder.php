<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $existingAdmin = DB::table('users')
            ->where('role', 'admin')
            ->exists();

        if ($existingAdmin) {
            Log::info('Admin user already exists, skipping seeder...');

            return;
        }

        $adminData = json_decode(
            file_get_contents(database_path('data/admin.data.json')),
            true
        );

        $adminData = array_map(function ($el) {
            unset($el['id']);

            return [
                'id' => Str::uuid(),
                'gym_id' => $el['gym_id'],
                'username' => $el['username'],
                'email' => $el['email'],
                'role' => $el['role'],
                'password' => Hash::make($el['password']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $adminData);

        DB::table('users')->insert($adminData);
    }
}
