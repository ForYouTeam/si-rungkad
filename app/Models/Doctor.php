<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctor';
    protected $fillable = [
        'user_id', 'nip', 'nama', 'alamat', 'jk', 'agama', 'jurusan', 'poly_id'
    ];
}
