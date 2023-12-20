<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profile';
    protected $fillable = [
        'user_id', 'nama', 'no_rm', 'nik', 'alamat', 'status_nikah', 'pekerjaan', 'kewarganegaraan', 'verified'
    ];
}
