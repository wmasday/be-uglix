<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EpisodesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Assume movie with ID 2 is a Series
        DB::table('episodes')->insert([
            [
                'movie_id' => 2,
                'season_number' => 1,
                'episode_number' => 1,
                'title' => 'Pilot',
                'description' => 'First episode of the series',
                'duration_sec' => 3600,
                'sources_url' => 'https://example.com/videos/series_s1e1.mp4',
                'thumbnail_url' => null,
                'release_date' => '2023-01-01',
            ],
            [
                'movie_id' => 2,
                'season_number' => 1,
                'episode_number' => 2,
                'title' => 'Next Chapter',
                'description' => 'Second episode of the series',
                'duration_sec' => 3550,
                'sources_url' => 'https://example.com/videos/series_s1e2.mp4',
                'thumbnail_url' => null,
                'release_date' => '2023-01-08',
            ],
        ]);
    }
}


