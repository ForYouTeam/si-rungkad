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
        ->leftJoin('poly as p', 'ds.poly_id', '=', 'p.id')
        ->select(
            'schedule.id',
            'schedule.hari',
            'ds.poly_id',
            'ds.start_time',
            'ds.end_time',
            'p.nama as nama_poly'
        );
    }

    public function createData($payload)
    {
        return DetailSchedule::create($payload);
    }
}
