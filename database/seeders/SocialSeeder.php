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
            'name' => 'Alfredo Orozco',
            'email' => 'alfredo.orozco@cucea.udg.mx',
            'password' => bcrypt('asd123'),
        ]);

        $admin->assignRole('admin');

        // ADMIN USER
        $admin = User::create([
            'name' => 'Desarrollo',
            'email' => 'desarrollo@cucea.udg.mx',
            'password' => bcrypt('asd123'),
        ]);

        $admin->assignRole('admin');

        // // USER 
        // $user = User::create([
        //     'name' => 'Emanuel User',
        //     'email' => 'emanuel.user@alumnos.udg.mx',
        //     'password' => bcrypt('asd123'),
        // ]);

        // FOLIO 
        $invoice = config('psy-config.folio');

        // $user->assignRole('user');


        // $patient = Patient::create([
        //     'name' => 'Alumno Prueba',
        //     'birth_date' => '2000-02-01',
        //     'code' => '2162381722',
        //     'sex' => 'male',
        //     'email' => 'alumno@alumnos.udg.mx',
        //     'phone' => '3317008886',
        //     'civil_status' => 'Soltero/a',
        //     'education' => 'Secundaria',
        //     'occupation' => 'Profesor',
        //     'user_id' => $admin->id
        // ]);

        // $patient_id = $patient->id;
        // $patientIdFormatted = str_pad($patient_id, 2, '0', STR_PAD_LEFT);
        // $patient->invoice = $invoice . $patientIdFormatted;
        // $patient->save();

        // $patient = Patient::create([
        //     'name' => 'Ana',
        //     'birth_date' => '2001-02-01',
        //     'code' => '2162382722',
        //     'sex' => 'female',
        //     'email' => 'ana@alumnos.udg.mx',
        //     'phone' => '3317009346',
        //     'civil_status' => 'Soltero/a',
        //     'education' => 'Secundaria',
        //     'occupation' => 'Profesor',
        //     'user_id' => $user->id
        // ]);

        // $patient_id = $patient->id;
        // $patientIdFormatted = str_pad($patient_id, 2, '0', STR_PAD_LEFT);
        // $patient->invoice = $invoice.$patientIdFormatted;
        // $patient->save();

        // $patient = Patient::create([
        //     'name' => 'Pedro',
        //     'birth_date' => '2001-02-01',
        //     'code' => '2111382722',
        //     'sex' => 'other',
        //     'email' => 'pedro@alumnos.udg.mx',
        //     'phone' => '3317109346',
        //     'civil_status' => 'Soltero/a',
        //     'education' => 'Secundaria',
        //     'occupation' => 'Profesor',
        //     'user_id' => $admin->id
        // ]);

        // $patient_id = $patient->id;
        // $patientIdFormatted = str_pad($patient_id, 2, '0', STR_PAD_LEFT);
        // $patient->invoice = $invoice.$patientIdFormatted;
        // $patient->save();

    }
}
