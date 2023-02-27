<div class="col-lg-6">
    <div class="mb-3">
        {{ Form::label('nombre', 'Ingrese el nombre *', ['class' => 'form-label']) }}
        {{ Form::text('nombre', $marca->nombre, ['class' => 'form-control', 'placeholder' => 'Nombre', 'required']) }}
    </div>
    <div class="mb-3">
        {{ Form::label('estado', 'Ingrese el estado *', ['class' => 'form-label']) }}
        {{ Form::select('estado', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], $marca->estado, ['class' => 'form-control', 'placeholder' => 'Selecione un estado', 'Estado', 'required']) }}
    </div>
    <div class="mb-3">
        {{ Form::label('logo_src', 'Ingrese el logo de la marca', ['class' => 'form-label']) }}
        {{ Form::hidden('logo_src', $marca->logo_src, ['id' => 'logo_src']) }}
        {{ Form::file('logo_src', ['class' => 'form-control', 'placeholder' => '']) }}
    </div>
</div>
<div class="col-lg-3 mt-4">
    <button class="btn btn-primary me-1 mb-1" type="submit">Confirmar Marca <i class="fa-solid fa-floppy-disk"></i></button>
</div>