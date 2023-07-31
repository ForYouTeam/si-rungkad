<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctor_profile extends Model
{
    use HasFactory;
    protected $table = 'doctor_profile';
    protected $fillable = [
        'user_id',
        'nama',
        'alamat',
        'no_hp',
        'jk',
        'email',
        'pekerjaan',
        'status',
        'tgl_lahir',
        'agama',
    ];
}
