<div>
    <!-- When there is no desire, all things are at peace. - Laozi -->
    @if ($confirming === $item->id)
        <button type="button" wire:click="delete({{ $item->id }})" class="btn btn-danger">¿Seguro?</button>
    @else
        <button type="button" wire:click="confirmDelete({{ $item->id }})" class="btn btn-danger">Eliminar</button>
    @endif
</div>
