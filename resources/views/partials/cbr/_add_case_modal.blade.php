<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#retainCaseModal">
    Guardar Caso
  </button> --}}

<!-- Modal -->
<div class="modal fade" id="retainCaseModal" tabindex="-1" aria-labelledby="retainCaseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="retainCaseModalLabel"><i class="fa-solid fa-brain"></i> Guardar caso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="m-2">
                    <div class="alert alert-info" role="alert">
                        <div class="text-muted small">* El caso se guarda con los síntomas seleccionados y sus pesos
                            (1.0 por defecto) y las soluciones propuestas cuando sea posible mapearlas a sus códigos.
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" wire:click="retainCase({{ $this->retainCaseSelectedIdx }})"
                    class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="module">
        document.addEventListener("DOMContentLoaded", () => {
            window.addEventListener('openRetainCaseModal', event => {
                $("#retainCaseModal").modal('show');
            })

            window.addEventListener('closeRetainCaseModal', event => {
                $("#retainCaseModal").modal('hide');
            })
        });
    </script>
@endpush
