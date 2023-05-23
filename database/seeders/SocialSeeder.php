<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SocialSeeder extends Seeder
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


        $patient = Patient::create([
            'name' => 'Emanuel Esc',
            'birth_date' => '2000-02-01',
            'code' => '2162381722',
            'secret_code' => '2162381722',
            'sex' => 'other',
            'email' => 'emanuel.escareno@alumnos.udg.mx',
            'phone' => '3317009646',
        ]);
    }
}
