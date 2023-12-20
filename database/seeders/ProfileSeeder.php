<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::create(
            [
                'user_id' => 2,
                'no_rm' => '008921',
                'nik' => '7101121210990214',
                'nama' => 'irwandi paputungan',
                'alamat' => 'jl. asam 1',
                'jk' => 'pria',
                'agama' => 'islam',
                'status_nikah' => false,
                'pekerjaan' => 'kurir',
                'kewarganegaraan' => 'indonesia',
                'verified' => true
            ]
        );
    }
}
