<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSchedule extends Model
{
    use HasFactory;
    protected $table = 'detail_schedule';
    protected $fillable = [
        'schedule_id', 'poly_id', 'start_time', 'end_time'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function poly()
    {
        return $this->belongsTo(Poly::class, 'poly_id');
    }

    public function scopejoinList($query) {
        return $query
            ->leftJoin('schedule as r1', 'r1.id', '=', 'detail_schedule.schedule_id')
            ->leftJoin('poly as r2', 'r2.id', '=', 'detail_schedule.poly_id');
    }
}
