@extends('layouts.public')

@section('content')

        <div class="row m-auto">
            <div class="col-lg-6 bg-blue-600 rounded-2xl shadow-lg">
                <img class="m-auto" src="{{ asset('paz-udg.png') }}" alt="">
                <h1 class="text-center text-zinc-50 font-semibold">
                    Programa Integral de Cultura de Paz
                </h1>
                <br>
            </div>
            <div class="col-lg-6">
                <h2 class="m-5 text-center">
                </h2>
                <br>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <h2 class="m-5 text-center">
                        Cita confirmada
                    </h2>
                    <br>
                    <h1 class="text-center text-success" style="font-size: 10rem;">
                        <i class="fa-regular fa-circle-check"></i>
                    </h1>
                </div>
            </div>
        </div>
@endsection
