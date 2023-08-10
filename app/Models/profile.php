<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    use HasFactory;
    protected $table = 'profile';
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
        return $query ->leftJoin('user as model_a', 'profile.user_id', '=', 'model_a.id')
        ->select(
            'profile.id', 
            'model_a.username',
            'profile.nama',
            'profile.alamat',
            'profile.no_hp',
            'profile.jk',
            'profile.email',
            'profile.pekerjaan',
            'profile.status',
            'profile.tgl_lahir',
            'profile.agama',
        );   
    }
}
