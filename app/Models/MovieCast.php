<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieCast extends Model
{
    public $timestamps = false;

    protected $table = 'movie_casts';

    protected $fillable = [
        'movie_id',
        'actor_id',
        'role_name',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function actor()
    {
        return $this->belongsTo(Actor::class, 'actor_id');
    }
}
