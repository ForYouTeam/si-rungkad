<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    use HasFactory;
    protected $table = 'schedule';
    protected $fillable = [
        'hari'
    ];

    public function scopeJoinList()
    {
        return DB::table('schedule')
        ->leftJoin('detail_schedule as ds', 'schedule.id', '=', 'ds.schedule_id')
        ->select(
            'schedule.id',
            'schedule.hari',
            'ds.poly_id',
            'ds.start_time',
            'ds.end_time'
        );
    }
}
