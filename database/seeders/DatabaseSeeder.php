<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersTableSeeder::class,
            GenresTableSeeder::class,
            ActorsTableSeeder::class,
            MoviesTableSeeder::class,
            EpisodesTableSeeder::class,
            MovieCastsTableSeeder::class,
        ]);
    }
}
