<div class="row mt-1 flex-center">

    <p class="mt-4 text-center rt-color-1">📝 Información de la Marca:</p>
    <hr/>

    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('nombre', 'Ingrese el nombre: *', ['class' => 'form-label']) }}
            {{ Form::text('nombre', $marca->nombre, ['class' => 'form-control', 'placeholder' => '-', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('estado', 'Estado: *', ['class' => 'form-label']) }}
            {{ Form::select('estado', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], $marca->estado, ['class' => 'form-control', 'placeholder' => 'Selecione un estado', 'Estado', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('logo_src', 'Logo de la marca (300x300px | .jpg, .jpeg, .png):', ['class' => 'form-label']) }}

            <img class="rounded mt-2 mb-2" src="{{ $marca->logo_src }}" alt="logo-marca" width="200" style="display: block;margin: 0 auto; border: solid 1px #000;" />

            {{ Form::hidden('logo_src', $marca->logo_src, ['id' => 'logo_src']) }}
            {{ Form::file('logo_src', ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
    </div>

</div>

<div class="col-lg-12 mt-4 mb-4 flex-center">
    <button class="btn btn-primary me-1 mb-1" type="submit">Confirmar Marca 💾</button>
</div>