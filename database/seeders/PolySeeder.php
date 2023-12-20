<?php

namespace Database\Seeders;

use App\Models\Poly;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PolySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Poly::create([
            'nama' => 'kulit',
            'ruangan' => 'AB11',
            'jam_praktek' => '20:00 - 12:00'
        ]);
    }
}
