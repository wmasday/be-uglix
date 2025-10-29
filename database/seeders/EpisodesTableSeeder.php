<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EpisodesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Inception Series (movie_id 2) episodes
        DB::table('episodes')->insert([
            [
                'movie_id' => 2,
                'season_number' => 1,
                'episode_number' => 1,
                'title' => 'The Dream Begins',
                'description' => 'Cobb and his team attempt their first dream heist, but things go wrong when the target\'s subconscious fights back.',
                'duration_sec' => 3600, // 60 minutes
                'sources_url' => 'https://example.com/videos/inception_s1e1.mp4',
                'thumbnail_url' => null,
                'release_date' => '2010-07-16',
            ],
            [
                'movie_id' => 2,
                'season_number' => 1,
                'episode_number' => 2,
                'title' => 'The Architect',
                'description' => 'Cobb recruits Ariadne as the new architect for the team\'s most dangerous mission yet.',
                'duration_sec' => 3550, // 59 minutes
                'sources_url' => 'https://example.com/videos/inception_s1e2.mp4',
                'thumbnail_url' => null,
                'release_date' => '2010-07-23',
            ],
        ]);
    }
}


