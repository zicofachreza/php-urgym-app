<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $existingNews = DB::table('news')
            ->exists();

        if ($existingNews) {
            Log::info('News already exist, skipping seeder...');

            return;
        }

        $newsData = json_decode(
            file_get_contents(database_path('data/news.data.json')),
            true
        );

        $newsData = array_map(function ($el) {
            unset($el['id']);

            return [
                'id' => Str::uuid(),
                'gym_id' => $el['gym_id'],
                'title' => $el['title'],
                'sub_title' => $el['sub_title'],
                'content' => $el['content'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $newsData);

        DB::table('news')->insert($newsData);
    }
}
