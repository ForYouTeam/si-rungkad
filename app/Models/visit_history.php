<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visit_history extends Model
{
    use HasFactory;
    protected $table = 'visit_history';
    protected $fillable = [
        'id_user',
        'id_registation',
        'tgl_kunjungan',
        'waktu_kunjungan',
        'keterangan'
    ];
}
