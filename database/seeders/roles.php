<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $doctor = Role::create(['name' => 'usuario']);

        // ADMIN USER
        $admin = User::create([
            'name' => 'Emanuel',
            'email' => 'emanuel.escareno@alumnos.udg.mx',
            'password' => bcrypt('asd123'),
        ]);

        $admin->assignRole('admin');

    }
}
