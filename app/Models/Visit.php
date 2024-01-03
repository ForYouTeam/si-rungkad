<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $table = "visit";

    protected $fillable = [
        'profile_id',
        'no_rm',
        'no_registrasi'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
