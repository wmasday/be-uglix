<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            ['name' => 'Action', 'description' => 'Explosive and fast-paced stories'],
            ['name' => 'Comedy', 'description' => 'Humorous and entertaining'],
            ['name' => 'Drama', 'description' => 'Emotional storytelling'],
            ['name' => 'Sci-Fi', 'description' => 'Futuristic and science themes'],
            ['name' => 'Fantasy', 'description' => 'Magic & mythical worlds'],
            ['name' => 'Romance', 'description' => 'Love-based plots'],
        ]);
    }
}


