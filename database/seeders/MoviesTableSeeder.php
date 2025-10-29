<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoviesTableSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure at least one user and genre exist (IDs 1)
        DB::table('movies')->insert([
            [
                'title' => 'The Dark Knight',
                'description' => 'A superhero film about Batman facing the Joker',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/dark_knight.mp4',
                'release_year' => 2008,
                'country' => 'USA',
                'type' => 'Movie',
                'genre_id' => 1, // Action
                'duration_sec' => 9120, // 152 minutes
                'rating' => 4.80,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'Inception',
                'description' => 'A mind-bending sci-fi thriller about dreams within dreams',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/inception_s1e1.mp4',
                'release_year' => 2010,
                'country' => 'USA',
                'type' => 'Series',
                'genre_id' => 4, // Sci-Fi
                'duration_sec' => null, // Series don't have fixed duration
                'rating' => 4.70,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'Parasite',
                'description' => 'A South Korean thriller about class struggle',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/parasite.mp4',
                'release_year' => 2019,
                'country' => 'South Korea',
                'type' => 'Movie',
                'genre_id' => 3, // Drama
                'duration_sec' => 7920, // 132 minutes
                'rating' => 4.90,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'The Office',
                'description' => 'A mockumentary sitcom about office life',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/office_s1e1.mp4',
                'release_year' => 2005,
                'country' => 'USA',
                'type' => 'Series',
                'genre_id' => 2, // Comedy
                'duration_sec' => null,
                'rating' => 4.60,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'Stranger Things',
                'description' => 'A supernatural horror series set in the 1980s',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/stranger_things_s1e1.mp4',
                'release_year' => 2016,
                'country' => 'USA',
                'type' => 'Series',
                'genre_id' => 4, // Sci-Fi
                'duration_sec' => null,
                'rating' => 4.50,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'Amélie',
                'description' => 'A French romantic comedy about a shy waitress',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/amelie.mp4',
                'release_year' => 2001,
                'country' => 'France',
                'type' => 'Movie',
                'genre_id' => 2, // Comedy
                'duration_sec' => 7320, // 122 minutes
                'rating' => 4.40,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'The Crown',
                'description' => 'A historical drama about the British Royal Family',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/crown_s1e1.mp4',
                'release_year' => 2016,
                'country' => 'UK',
                'type' => 'Series',
                'genre_id' => 3, // Drama
                'duration_sec' => null,
                'rating' => 4.30,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
            [
                'title' => 'Dune',
                'description' => 'An epic sci-fi film based on Frank Herbert\'s novel',
                'poster_url' => null,
                'sources_url' => 'https://example.com/videos/dune.mp4',
                'release_year' => 2021,
                'country' => 'USA',
                'type' => 'Movie',
                'genre_id' => 4, // Sci-Fi
                'duration_sec' => 9300, // 155 minutes
                'rating' => 4.20,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_published' => true,
            ],
        ]);
    }
}


