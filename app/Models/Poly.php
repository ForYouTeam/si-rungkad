<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poly extends Model
{
    use HasFactory;
    protected $table = 'poly';
    protected $fillable = [
        'nama',
        'ruangan',
        'jam_praktek'
    ];
}
