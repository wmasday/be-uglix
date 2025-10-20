<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'bio',
        'birth_date',
        'photo_url',
    ];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_casts')->withPivot('role_name');
    }
}


