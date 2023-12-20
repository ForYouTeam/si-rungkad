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
}
