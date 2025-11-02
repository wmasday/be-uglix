<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('actors')->insert([
            ['name' => 'Robert Downey Jr.', 'bio' => 'Iron Man', 'birth_date' => '1965-04-04', 'photo_url' => 'https://image.tmdb.org/t/p/w500/1YjdSym1jTG7xjHSI0yGGWEsw5i.jpg'],
            ['name' => 'Chris Evans', 'bio' => 'Captain America', 'birth_date' => '1981-06-13', 'photo_url' => 'https://image.tmdb.org/t/p/w500/3bOGNsHlrswhyW79uvIHH1V43JI.jpg'],
            ['name' => 'Leonardo DiCaprio', 'bio' => 'Oscar winning actor', 'birth_date' => '1974-11-11', 'photo_url' => 'https://image.tmdb.org/t/p/w500/wo2hJpn04vbtmh0B9utCFdsQhxM.jpg'],
            ['name' => 'Keanu Reeves', 'bio' => 'The John Wick legend', 'birth_date' => '1964-09-02', 'photo_url' => 'https://image.tmdb.org/t/p/w500/4D0PpNI0kmP58hgrwGC3wCjxhnm.jpg'],
            ['name' => 'Tom Cruise', 'bio' => 'Mission Impossible star', 'birth_date' => '1962-07-03', 'photo_url' => 'https://image.tmdb.org/t/p/w500/8qBylBsQf4llkGrWR3qAsOtOU8O.jpg'],

            // Series Actors
            ['name' => 'Millie Bobby Brown', 'bio' => 'Stranger Things star', 'birth_date' => '2004-02-19', 'photo_url' => 'https://image.tmdb.org/t/p/w500/pXUyx7kwh28YmpLh7L0K0rYIAVL.jpg'],
            ['name' => 'Henry Cavill', 'bio' => 'Geralt in The Witcher', 'birth_date' => '1983-05-05', 'photo_url' => 'https://image.tmdb.org/t/p/w500/4L1Au8A97vmFqgDfvG2RqDBjWuZ.jpg'],

            // K-Drama Stars
            ['name' => 'Song Joong-ki', 'bio' => 'Vincenzo star', 'birth_date' => '1985-09-19', 'photo_url' => 'https://image.tmdb.org/t/p/w500/3d4ionck9PkwJOV44VvWy7astJf.jpg'],
            ['name' => 'Jeon Yeo-been', 'bio' => 'Vincenzo actress', 'birth_date' => '1989-07-26', 'photo_url' => 'https://image.tmdb.org/t/p/w500/3KFDwg4zby08cCqswNyotOXoXoT.jpg'],
            ['name' => 'Hyun Bin', 'bio' => 'Crash Landing On You star', 'birth_date' => '1982-09-25', 'photo_url' => 'https://image.tmdb.org/t/p/w500/aQd1YHULjKAmhpN6wX6ZspGDZkj.jpg'],
            ['name' => 'Son Ye-jin', 'bio' => 'Crash Landing actress', 'birth_date' => '1982-01-11', 'photo_url' => 'https://image.tmdb.org/t/p/w500/rYyAzS9z35nE9gHhp1lCJ2unf3E.jpg'],
            ['name' => 'Gong Yoo', 'bio' => 'Goblin actor', 'birth_date' => '1979-07-10', 'photo_url' => 'https://image.tmdb.org/t/p/w500/1z5D0gYpTQeUKGwEuUXXSb9VjA5.jpg'],
            ['name' => 'Kim Go-eun', 'bio' => 'Goblin actress', 'birth_date' => '1991-07-02', 'photo_url' => 'https://image.tmdb.org/t/p/w500/kv8ECeNwDANSqPlYMBX5AZt0pOQ.jpg'],
        ]);
    }
}

