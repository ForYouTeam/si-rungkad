<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medical_card extends Model
{
    use HasFactory;
    protected $table = 'medicalcard';
    protected $fillable = [
        'no_rm',
        'profile_id',
        'barcode'
    ];

    public function profile(){
        return $this->belongsTo(profile::class, 'profile_id');
    }

    public function scopejoinList($query)
    {
        return $query ->leftJoin('profile as model_a', 'medicalcard.profile_id', '=', 'model_a.id')

        ->select(
            'medicalcard.id', 
            'medicalcard.no_rm', 
            'model_a.nama',
            'model_a.tgl_lahir',
            'medicalcard.barcode',
        );   
    }
}
