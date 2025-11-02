<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieCastsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('movie_casts')->insert([
            ['movie_id'=>1,'actor_id'=>1,'role_name'=>'Tony Stark'],
            ['movie_id'=>1,'actor_id'=>2,'role_name'=>'Steve Rogers'],
            ['movie_id'=>2,'actor_id'=>3,'role_name'=>'Cobb'],
            ['movie_id'=>3,'actor_id'=>4,'role_name'=>'John Wick'],
            ['movie_id'=>4,'actor_id'=>3,'role_name'=>'Cooper'],
            ['movie_id'=>5,'actor_id'=>5,'role_name'=>'Ethan Hunt'],

            ['movie_id'=>11,'actor_id'=>6,'role_name'=>'Eleven'], // Stranger Things
            ['movie_id'=>12,'actor_id'=>7,'role_name'=>'Geralt'],
            ['movie_id'=>13,'actor_id'=>8,'role_name'=>'Vincenzo'],
            ['movie_id'=>13,'actor_id'=>9,'role_name'=>'Hong Cha-young'],
            ['movie_id'=>14,'actor_id'=>10,'role_name'=>'Ri Jeong-hyuk'],
            ['movie_id'=>14,'actor_id'=>11,'role_name'=>'Yoon Se-ri'],
            ['movie_id'=>15,'actor_id'=>12,'role_name'=>'Goblin'],
            ['movie_id'=>15,'actor_id'=>13,'role_name'=>'Ji Eun-tak'],
        ]);
    }
}
