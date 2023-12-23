<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MovieItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'movies_id',
        'title',
        'thumbnail',
        'duration',
        'url',
    ];

    // public function getUrlAttribute($url)
    // {
    //     return config('app.url') . Storage::url($url);
    // }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movies_id', 'id');
    }
}
