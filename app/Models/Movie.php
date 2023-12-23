<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'url_poster',
        'description',
        'genres_id',
        'duration',
        'release_year',
    ];

    public function items()
    {
        return $this->hasMany(MovieItem::class, 'movies_id', 'id');
    }

    public function genre()
    {
        return $this->belongsTo(MovieGenre::class, 'genres_id', 'id');
    }
}
