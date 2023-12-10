<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poly extends Model
{
    use HasFactory;
    protected $table = 'poly';
    protected $fillable = [
        'user_id',
        'nama',
        'ruangan',
        'jam_praktek'
    ];
}
