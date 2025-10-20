<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieCastsTableSeeder extends Seeder
{
    public function run(): void
    {
        // Link actors to movies
        DB::table('movie_casts')->insert([
            [
                'movie_id' => 1,
                'actor_id' => 1,
                'role_name' => 'Lead',
            ],
            [
                'movie_id' => 1,
                'actor_id' => 2,
                'role_name' => 'Supporting',
            ],
            [
                'movie_id' => 2,
                'actor_id' => 2,
                'role_name' => 'Lead',
            ],
        ]);
    }
}


