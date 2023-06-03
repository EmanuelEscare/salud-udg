<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function getCount(Request $request){
        $data = json_decode($request);

        DB::table('api_requests')->insert([
            'object' => $data
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);

    }
    public function getAll(Request $request){
        $data = json_decode($request);

        DB::table('api_requests')->insert([
            'object' => $data
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);
        
    }
    public function getFiltered(Request $request){
        $data = json_decode($request);

        DB::table('api_requests')->insert([
            'object' => $data
        ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);
        
    }
    public function newResult(Request $request){
        $data = $request->input("data");

        DB::table('api_requests')->insert([
            'object' => json_encode($data)
        ]);

        // Test::create([
        //     'test' => $
        // ]);

        return response()->json(['message' => 'Datos recibidos correctamente'], 200);
        
    }
}
