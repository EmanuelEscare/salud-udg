<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use App\Models\Test;
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
            'sex' => 'male',
            'email' => 'emanuel.escareno@alumnos.udg.mx',
            'phone' => '3317009646',
        ]);

        Test::create([
            'test' => 'SCL-90-R',
            'patient_id' => $patient->id,
            'result' => '{}',
        ]);

        Test::create([
            'test' => 'Inventario de Depresión de Beck (BDI-2)',
            'patient_id' => $patient->id,
            'result' => '{}',
        ]);

        Test::create([
            'test' => 'Escala de ansiedad de Hamilton',
            'patient_id' => $patient->id,
            'result' => '{}',
        ]);

        $patient = Patient::create([
            'name' => 'Ana',
            'birth_date' => '2001-02-01',
            'code' => '2162382722',
            'sex' => 'female',
            'email' => 'ana@alumnos.udg.mx',
            'phone' => '3317009346',
        ]);

        Test::create([
            'test' => 'Inventario de Depresión de Beck (BDI-2)',
            'patient_id' => $patient->id,
            'result' => '{}',
        ]);

        Test::create([
            'test' => 'Escala de ansiedad de Hamilton',
            'patient_id' => $patient->id,
            'result' => '{}',
        ]);

        $patient = Patient::create([
            'name' => 'Pedro',
            'birth_date' => '2001-02-01',
            'code' => '2111382722',
            'sex' => 'other',
            'email' => 'pedro@alumnos.udg.mx',
            'phone' => '3317109346',
        ]);

        Test::create([
            'test' => 'SCL-90-R',
            'patient_id' => $patient->id,
            'result' => '{}',
        ]);
    }
}
