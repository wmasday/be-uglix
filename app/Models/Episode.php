<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'movie_id',
        'season_number',
        'episode_number',
        'title',
        'description',
        'duration_sec',
        'sources_url',
        'thumbnail_url',
        'release_date',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}


