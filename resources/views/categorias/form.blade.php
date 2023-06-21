<div class="row mt-1 flex-center">

    <p class="mt-4 text-center rt-color-1">📝 Información de la Categoría:</p>
    <hr/>

    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('nombre', 'Ingrese el nombre: *', ['class' => 'form-label']) }}
            {{ Form::text('nombre', $categoria->nombre, ['class' => 'form-control', 'placeholder' => '-', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('estado', 'Estado: *', ['class' => 'form-label']) }}
            {{ Form::select('estado', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], $categoria->estado, ['class' => 'form-control', 'placeholder' => 'Selecione un estado', 'Estado', 'required']) }}
        </div>
    </div>

</div>

<div class="col-lg-12 mt-4 mb-4 flex-center">
    <button class="btn btn-primary me-1 mb-1" type="submit">Confirmar Categoría 💾</button>
</div>