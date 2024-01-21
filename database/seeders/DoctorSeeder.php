<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Poly;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Doctor::create([
            'user_id' => User::all()->value('id'),
            'nip'    => '722733847',
            'nama'     => 'musfira khairunisa',
            'alamat' => 'Jl. Kijang no. 12',
            'jk' => 'wanita',
            'agama' => 'islam',
            'jurusan' => 'spesialis kulit',
            'poly_id' => Poly::all()->value('id'),
        ]);
    }
}
