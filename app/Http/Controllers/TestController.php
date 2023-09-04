<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function getCount(Request $request)
    {
        $data = json_decode($request);

        DB::table('api_requests')->insert([
            'object' => $data
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);
    }
    public function getAll(Request $request)
    {
        $data = json_decode($request);

        DB::table('api_requests')->insert([
            'object' => $data
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);
    }
    public function getFiltered(Request $request)
    {
        $data = json_decode($request);

        DB::table('api_requests')->insert([
            'object' => $data
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);
    }

    public function newResult(Request $request)
    {
        $data = $request->input("data");

        DB::table('api_requests')->insert([
            'object' => json_encode($data)
        ]);

        Test::create([
            'test' => $data['appliedTest'],
            'patient_id' => $data['patient_id'],
            'diagnostic' => json_encode($data['diagnostic']),
            'result' => json_encode($data['testResults']),
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);
    }

    public function result($id){
        $months = [
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'septiembre',
            'octubre',
            'noviembre',
            'diciembre',
        ];

        $test = Test::where("id", $id)->first();

        $num_month = $test->created_at->format('n');

        $month = $months[$num_month-1];

        $test->date = $test->created_at->format('d') . ' de ' . $month . ' de ' . $test->created_at->format('Y');

        return;
    }
}
