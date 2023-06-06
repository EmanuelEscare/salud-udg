<x-app-layout>
    <style>
        .bg1 {
            background: rgb(48, 48, 255);
            background: linear-gradient(90deg, rgba(48, 48, 255, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }

        .bg2{
            background: rgb(113,198,0);
background: linear-gradient(90deg, rgba(113,198,0,1) 0%, rgba(34,153,0,1) 100%);
        }

        .bg3{
            background: rgb(255,132,0);
background: linear-gradient(90deg, rgba(255,132,0,1) 0%, rgba(255,42,0,1) 100%);   }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card bg1 shadow-sm border-none">
                        <div class="card-body text-white">
                            <h2 class="card-title fw-bold">20</h2>
                            <p class="card-text fs-5 fw-bold">Pruebas Aplicadas</p>
                            <div class="text-right">
                                <h2 class="text-right"><i
                                        style="display: block;
                                text-align: right;
                                margin: 1rem;
                                font-size: 3rem;"
                                        class="fa-regular fa-file"></i></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card bg2 shadow-sm border-none">
                        <div class="card-body text-white">
                            <h2 class="card-title fw-bold">12</h2>
                            <p class="card-text fs-5 fw-bold">Pacientes</p>
                            <div class="text-right">
                                <h2 class="text-right"><i
                                        style="display: block;
                                text-align: right;
                                margin: 1rem;
                                font-size: 3rem;"
                                        class="fa-solid fa-users"></i></h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card bg3 shadow-sm border-none">
                        <div class="card-body text-white">
                            <h2 class="card-title fw-bold">3</h2>
                            <p class="card-text fs-5 fw-bold">Usuarios</p>
                            <div class="text-right">
                                <h2 class="text-right"><i
                                        style="display: block;
                                text-align: right;
                                margin: 1rem;
                                font-size: 3rem;"
                                        class="fa-solid fa-user"></i></h2>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <br>


</x-app-layout>
