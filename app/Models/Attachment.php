<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    protected $table = 'attachment';
    protected $fillable = [
        'profile_id',
        'nama',
        'path',
        'to_ocr'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }
}
