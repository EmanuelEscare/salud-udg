<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card border-0 shadow-sm container ps-none">
                <div>
                    <div>
                        {{-- Do your work, then step back. --}}
                        <div class="rounded-4 p-4">
                            <h3 class="mb-5">{{ __('Configuración') }}</h3>
                            <br>
                            <div
                                class="d-flex justify-content-center align-items-centerd-flex justify-content-center align-items-center">
                                <div class="m-3 col-lg-6">
                                    <p class="m-1">Folio</p>
                                    <input class="form-control form-control-lg" type="text">

                                    <div class="d-grid gap-2 mt-2">
                                        <button class="btn btn-lg btn-primary" type="button">Guardar</button>
                                    </div>

                                </div>
                            </div>

                            <div class="my-5">
                            </div>
                            <div
                                class="d-flex mb-5 justify-content-center align-items-centerd-flex justify-content-center align-items-center">
                                <div class="m-3 col-lg-6 box-danger">
                                    <div class="row">
                                        <div class="col-lg-6 text-center">
                                            <p class="m-3">Restablecer plataforma</p>
                                        </div>
                                        <div class="col-lg-2">
                                        </div>
                                        <div class="col-lg-2 text-center">
                                            <button class="btn btn-danger my-2" type="button">Restablecer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>
