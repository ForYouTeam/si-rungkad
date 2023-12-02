<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class visit_history extends Model
{
    use HasFactory;
    protected $table = 'visithistory';
    protected $fillable = [
        'profile_id',
        'registation_id',
        'tgl_kunjungan',
        'waktu_kunjungan',
        'keterangan'
    ];

    public function profile(){
        return $this->belongsTo(profile::class, 'profile_id');
    }

    public function registation(){
        return $this->belongsTo(registation::class, 'registation_id');
    }

    public function scopejoinList($query)
    {
        return $query ->leftJoin('profile as model_a', 'visithistory.profile_id', '=', 'model_a.id')
        ->leftJoin('registation as model_b', 'visithistory.registation_id', '=', 'model_b.id')
        ->select(
            'visithistory.id', 
            'model_a.nama as nama_profile',
            'model_b.no_registrasi as registrasi',
            'visithistory.tgl_kunjungan',
            'visithistory.waktu_kunjungan',
            'visithistory.keterangan',
        );   
    }
}
