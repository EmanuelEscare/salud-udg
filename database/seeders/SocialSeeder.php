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

        $user = Role::create(['name' => 'user']);

        $user_create = Permission::create(['name' => 'user_create']);
        $user_update = Permission::create(['name' => 'user_update']);
        $user_delete = Permission::create(['name' => 'user_delete']);

        $patient_create = Permission::create(['name' => 'patient_create']);
        $patient_update = Permission::create(['name' => 'patient_update']);
        $patient_delete = Permission::create(['name' => 'patient_delete']);
        
        $admin->givePermissionTo($user_create);
        $admin->givePermissionTo($user_update);
        $admin->givePermissionTo($user_delete);

        $admin->givePermissionTo($patient_create);
        $admin->givePermissionTo($patient_update);
        $admin->givePermissionTo($patient_delete);

        $user->givePermissionTo($patient_create);
        $user->givePermissionTo($patient_update);
        $user->givePermissionTo($patient_delete);

        // ADMIN USER
        $admin = User::create([
            'name' => 'Emanuel Admin',
            'email' => 'emanuel.escareno@alumnos.udg.mx',
            'password' => bcrypt('asd123'),
        ]);

        $admin->assignRole('admin');

        // USER 
        $user = User::create([
            'name' => 'Emanuel User',
            'email' => 'emanuel.user@alumnos.udg.mx',
            'password' => bcrypt('asd123'),
        ]);

        $user->assignRole('user');


        $patient = Patient::create([
            'name' => 'Emanuel Esc',
            'birth_date' => '2000-02-01',
            'code' => '2162381722',
            'sex' => 'male',
            'email' => 'emanuel.escareno@alumnos.udg.mx',
            'phone' => '3317009646',
            'civil_status' => 'Soltero/a',
            'education' => 'Secundaria',
            'occupation' => 'Profesor',
            'user_id' => $user->id
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
            'civil_status' => 'Soltero/a',
            'education' => 'Secundaria',
            'occupation' => 'Profesor',
            'user_id' => $user->id
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
            'civil_status' => 'Soltero/a',
            'education' => 'Secundaria',
            'occupation' => 'Profesor',
            'user_id' => $admin->id
        ]);

        Test::create([
            'test' => 'SCL-90-R',
            'patient_id' => $patient->id,
            'result' => '{}',
        ]);
    }
}
