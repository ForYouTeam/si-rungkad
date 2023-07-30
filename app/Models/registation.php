<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class registation extends Model
{
    use HasFactory;
    protected $table = 'registation';
    protected $fillable = [
        'no_registrasi',
        'id_medical_card',
        'id_poly',
        'tgl_registrasi',
        'id_attachment',
        'qr_code'
    ];
}
