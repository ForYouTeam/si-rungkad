<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class History extends Model
{
    use HasFactory;
    protected $table = 'historie';
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

    public function getHistoryByVisit()
    {
        return DB::table('historie')
            ->select('historie.*');
    }
}
