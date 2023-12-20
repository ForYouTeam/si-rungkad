<?php

namespace Database\Seeders;

use App\Models\DetailSchedule;
use App\Models\Poly;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetailSchedule::create(
            [
                'schedule_id' => Schedule::all()->value('id'),
                'poly_id' => Poly::all()->value('id'),
                'start_time' => '09:00',
                'end_time' => '10:00',
            ]
        );
    }
}
