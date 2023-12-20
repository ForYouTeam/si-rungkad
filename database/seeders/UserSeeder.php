<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'nama'     => 'super-admin',
                'email'    => 'suadmin@mail.com',
                'password' => Hash::make('123456'),
                'scope'    => 'super-admin'
            ], 
            [
                'nama'     => 'irwandi paputungan',
                'email'    => 'oned@mail.com',
                'password' => Hash::make('123456'),
                'scope'    => 'pasien'
            ],
            [
                'nama'     => 'musfira',
                'email'    => 'musfira@mail.com',
                'password' => Hash::make('123456'),
                'scope'    => 'doctor'
            ]
        );
    }
}
