<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;
    protected $table = 'histories';
    protected $fillable = [
        'visit_id',
        'ket',
        'tgl',
        'visit_sugest',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function scopejoinList($query) 
    {
        return $query
            ->leftJoin('visit as r1', 'r1.id', '=', 'histories.visit_id');
    }
}
