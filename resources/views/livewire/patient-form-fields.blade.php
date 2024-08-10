<div class="mb-3">
    <label for="name" class="form-label">Nombre</label>
    <input type="text" wire:model="patient.name" class="form-control" id="name">
</div>

<div class="mb-3">
    <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
    <input type="date" wire:model="patient.birth_date" class="form-control" id="birth_date">
</div>

<div class="mb-3">
    <label for="invoice" class="form-label">Factura</label>
    <input type="text" wire:model="patient.invoice" class="form-control" id="invoice">
</div>

<div class="mb-3">
    <label for="code" class="form-label">Código</label>
    <input type="text" wire:model="patient.code" class="form-control" id="code">
</div>

<div class="mb-3">
    <label for="sex" class="form-label">Sexo</label>
    <select wire:model="patient.sex" class="form-select" id="sex">
        <option value="">Seleccione...</option>
        <option value="female">Femenino</option>
        <option value="male">Masculino</option>
        <option value="other">Otro</option>
    </select>
</div>

<div class="mb-3">
    <label for="career" class="form-label">Carrera</label>
    <input type="text" wire:model="patient.career" class="form-control" id="career">
</div>

<div class="mb-3">
    <label for="civil_status" class="form-label">Estado Civil</label>
    <select wire:model="patient.civil_status" class="form-select" id="civil_status">
        <option value="">Seleccione...</option>
        <option value="Soltero/a">Soltero/a</option>
        <option value="Casado/a">Casado/a</option>
    </select>
</div>

<div class="mb-3">
    <label for="average" class="form-label">Promedio</label>
    <input type="number" wire:model="patient.average" class="form-control" id="average">
</div>

<div class="mb-3">
    <label for="semester" class="form-label">Semestre</label>
    <input type="number" wire:model="patient.semester

