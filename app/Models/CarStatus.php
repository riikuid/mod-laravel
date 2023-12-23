<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'temperature',
        'origin',
        'destination',
        'next_station',
    ];
}
