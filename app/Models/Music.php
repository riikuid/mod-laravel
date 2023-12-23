<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'musics';

    protected $fillable = [
        'title',
        'singers_id',
        'duration',
        'url_music',
        'url_poster',
    ];


    // public function singer()
    // {
    //     return $this->belongsTo(Singer::class, 'singers_id', 'id');
    // }
    public function singer()
    {
        return $this->belongsTo(Singer::class, 'singers_id', 'id');
    }
}
