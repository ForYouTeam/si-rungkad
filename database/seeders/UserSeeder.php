<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'read-data'  ]);
        Permission::create(['name' => 'create-data']);
        Permission::create(['name' => 'update-data']);
        Permission::create(['name' => 'delete-data']);

        $roleSuAdmin = Role::create(['name' => 'super-admin']);
        $roleSuAdmin->givePermissionTo('read-data'  );
        $roleSuAdmin->givePermissionTo('create-data');
        $roleSuAdmin->givePermissionTo('update-data');
        $roleSuAdmin->givePermissionTo('delete-data');

        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo('read-data'  );
        $roleAdmin->givePermissionTo('create-data');
        $roleAdmin->givePermissionTo('update-data');

        $user = User::create([
            'nama'       => 'super admin'              ,
            'email'      => 'ica_cantik@gmail.com'               ,
            'password'   => Hash::make('123123'),
            'scope'      => 'super-admin'              ,
            'created_at' => Carbon::now()              ,
            'updated_at' => Carbon::now()              ,
        ]);

        $user->assignRole('super-admin');

        $user2 = User::create([
            'nama'       => 'admin'                  ,
            'email'      => 'admin@gmail.com'                  ,
            'password'   => Hash::make('123123'),
            'scope'      => 'admin'                  ,
            'created_at' => Carbon::now()            ,
            'updated_at' => Carbon::now()            ,
        ]);

        $user2->assignRole('admin');
    }
}
