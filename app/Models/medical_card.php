<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medical_card extends Model
{
    use HasFactory;
    protected $table = 'medical_card';
    protected $fillable = [
        'no_rm',
        'user_id',
        'qr_code'
    ];
}
