<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctor_profile extends Model
{
    use HasFactory;
    protected $table = 'doctorprofile';
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

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopejoinList($query)
    {
        return $query ->leftJoin('user as model_a', 'doctorprofile.user_id', '=', 'model_a.id')
        ->select(
            'doctorprofile.id', 
            'model_a.username',
            'doctorprofile.nama',
            'doctorprofile.alamat',
            'doctorprofile.no_hp',
            'doctorprofile.jk',
            'doctorprofile.email',
            'doctorprofile.pekerjaan',
            'doctorprofile.status',
            'doctorprofile.tgl_lahir',
            'doctorprofile.agama',
        );   
    }
}
