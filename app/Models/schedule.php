<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    use HasFactory;
    protected $table = 'schedule';
    protected $fillable = [
        'poly_id',
        'doctor_id',
        'tgl',
        'jam_praktek'
    ];

    public function poly(){
        return $this->belongsTo(poly::class, 'poly_id');
    }

    public function doctor(){
        return $this->belongsTo(doctor_profile::class, 'doctor_id');
    }

    public function scopejoinList($query)
    {
        return $query ->leftJoin('poly as model_a', 'schedule.poly_id', '=', 'model_a.id')
        ->leftJoin('doctorprofile as model_b', 'schedule.doctor_id', '=', 'model_b.id')
        ->select(
            'schedule.id', 
            'model_a.nama as nama_poly',
            'model_b.nama as nama_doctor',
            'schedule.tgl',
            'schedule.jam_praktek',
        );   
    }
}
