<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EpisodesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('episodes')->insert([
            ['movie_id'=>11,'season_number'=>1,'episode_number'=>1,'title'=>'The Vanishing of Will Byers','duration_sec'=>3100,'sources_url'=>'https://example.com/st_s1e1.mp4','thumbnail_url'=>null,'release_date'=>'2016-07-15'],
            ['movie_id'=>12,'season_number'=>1,'episode_number'=>1,'title'=>'The End\'s Beginning','duration_sec'=>3600,'sources_url'=>'https://example.com/w_s1e1.mp4','thumbnail_url'=>null,'release_date'=>'2019-12-20'],
            ['movie_id'=>13,'season_number'=>1,'episode_number'=>1,'title'=>'Episode 1','duration_sec'=>3900,'sources_url'=>'https://example.com/v_s1e1.mp4','thumbnail_url'=>null,'release_date'=>'2021-02-20'],
            ['movie_id'=>14,'season_number'=>1,'episode_number'=>1,'title'=>'Episode 1','duration_sec'=>3800,'sources_url'=>'https://example.com/c_l_s1e1.mp4','thumbnail_url'=>null,'release_date'=>'2020-02-14'],
            ['movie_id'=>15,'season_number'=>1,'episode_number'=>1,'title'=>'Episode 1','duration_sec'=>3600,'sources_url'=>'https://example.com/g_s1e1.mp4','thumbnail_url'=>null,'release_date'=>'2016-12-02'],
        ]);
    }
}

