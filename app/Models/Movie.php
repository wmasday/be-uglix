<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'sources_url',
        'release_year',
        'country',
        'type',
        'genre_id',
        'duration_sec',
        'rating',
        'created_by',
        'is_published',
    ];

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_casts')->withPivot('role_name');
    }
}


