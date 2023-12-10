<?php

namespace App\Models;

use App\Models\profile as ModelsProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attachment extends Model
{
    use HasFactory;
    protected $table = 'attachment';
    protected $fillable = [
        'user_id',
        'profile_id',
        'foto_ktp',
        'foto_kartu_berobat'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function profile(){
        return $this->belongsTo(profile::class, 'profile_id');
    }
}
