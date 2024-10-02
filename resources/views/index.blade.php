@extends('layouts.public')

@section('content')

        <div class="row m-auto">
            <div class="col-lg-6 bg-zinc-400 rounded-2xl shadow-lg">
                <br>
                <img class="m-auto w-50" src="{{ asset('cucei-logo.png') }}" alt="">
                <h1 class="text-center text-black font-semibold">
                    Programa Salud Mental Universitaria
                </h1>
                <br>
            </div>
            <div class="col-lg-6">
                <h2 class="m-5 text-center">
                    La Universidad de Guadalajara te ofrece acompañamiento psicológico
                </h2>
                <br>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="{{route('agendarCita')}}" class="btn btn-success btn-lg" type="button">Agendar cita</a>
                </div>
            </div>
        </div>
@endsection
