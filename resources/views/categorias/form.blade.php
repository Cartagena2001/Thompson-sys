<div class="row mt-1 flex-center">

    <p class="mt-4 text-center rt-color-1">📝 Información de la Categoría:</p>
    <hr/>

    <p class="text-center">Categoría ID: <b>{{ $categoria->id }}</b></p>

    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('nombre', 'Ingrese el nombre: *', ['class' => 'form-label']) }}
            {{ Form::text('nombre', $categoria->nombre, ['class' => 'form-control', 'placeholder' => '-', 'required']) }}
            @if ($errors->has('nombre'))
                <span class="text-danger">{{ $errors->first('nombre') }}</span>
            @endif
        </div>
        <div class="mb-3">
            {{ Form::label('estado', 'Estado: *', ['class' => 'form-label']) }}
            {{ Form::select('estado', ['Activo' => 'Activo', 'Inactivo' => 'Inactivo'], $categoria->estado, ['class' => 'form-control', 'placeholder' => 'Selecione un estado', 'Estado', 'required']) }}
            @if ($errors->has('estado'))
                <span class="text-danger">{{ $errors->first('estado') }}</span>
            @endif
        </div>
        <div class="mb-3">

            <label>Marcas Disponibles (asocia la categoría a una marca/s): *</label>

                <div class="col-sm-12">
                    <div class="flex-center">
                        
                        <div>
                        @foreach ($marcas as $marca)
                            <label for="{{ $marca->nombre }}-{{ $marca->id }}">
                                <input id="{{ $marca->nombre }}-{{ $marca->id }}" type="checkbox" value="{{ $marca->id }}" name="marcasCategoria[]" @if ( in_array( $marca->id, $marcasAsoc ) ) checked @endif /> {{ $marca->id }} - {{ $marca->nombre }}
                            </label>
                            <br/>
                        @endforeach
                        </div>
                    
                    </div>

                    @if ($errors->has('marcasCategoria'))
                        <p class="text-center"><span class="text-danger">{{ $errors->first('marcasCategoria') }}</span></p>
                    @endif

                </div>


        </div>
    </div>

</div>

<div class="col-lg-12 mt-4 mb-4 flex-center">
    <button class="btn btn-primary me-1 mb-1" type="submit">Confirmar Categoría 💾</button>
</div>