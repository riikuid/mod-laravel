<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Singer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'url_profile',
    ];

    public function musics()
    {
        return $this->hasMany(Music::class, 'singers_id', 'id');
    }
}
