@extends('layouts.public')

@section('content')
    {{-- <div class="py-3 px-5" style="background: #B12028;">
    <img class="w-3/12 m-auto" src="{{asset('index/Logo_UDG_horiz_blanco-01.svg')}}" alt="">
</div> --}}
    <div class="py-3 px-5 bg-white shadow-lg">
        <img class="lg:w-2/12 md:w-6/12 sm:w-full m-auto" src="{{ asset('index/Logo-cucea-colores-icono.png') }}"
            alt="">
    </div>

    <div class="m-5">
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
                    CUCEA te ofrece un servicio de acompañamiento psicológico
                </h2>
                <br>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-success btn-lg" type="button">Agendar cita</button>
                </div>
            </div>
        </div>
    </div>
@endsection
