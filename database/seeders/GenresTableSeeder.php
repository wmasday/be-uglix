<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenresTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            ['name' => 'Action', 'description' => 'High energy, fights and chases'],
            ['name' => 'Comedy', 'description' => 'Humorous and light-hearted'],
            ['name' => 'Drama', 'description' => 'Serious narratives and character development'],
            ['name' => 'Sci-Fi', 'description' => 'Science fiction and futuristic themes'],
        ]);
    }
}


