<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('actors')->insert([
            [
                'name' => 'Robert Downey Jr.',
                'bio' => 'American actor and producer',
                'birth_date' => '1965-04-04',
                'photo_url' => null,
            ],
            [
                'name' => 'Scarlett Johansson',
                'bio' => 'American actress',
                'birth_date' => '1984-11-22',
                'photo_url' => null,
            ],
        ]);
    }
}


