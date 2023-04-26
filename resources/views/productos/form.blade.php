<div class="row">
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('nombre', 'Nombre del producto *', ['class' => 'form-label']) }}
            {{ Form::text('nombre', $producto->nombre, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('sku', 'SKU del producto *', ['class' => 'form-label']) }}
            {{ Form::text('sku', $producto->sku, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
            {{-- validar que sku sea unico --}}
            @if ($errors->has('sku'))
                <span class="text-danger">{{ $errors->first('sku') }}</span>
            @endif
        </div>
        <div class="mb-3">
            {{ Form::label('marca_id', 'Seleciona la marca *', ['class' => 'form-label']) }}
            {{ Form::select('marca_id', $marcas, $producto->marca_id, ['class' => 'form-select', 'aria-label' => 'Default select example', 'required', 'placeholder' => 'Selecione una marca']) }}
        </div>
        <div>
            {{ Form::label('estado_producto_id', 'Estado del producto *', ['class' => 'form-label']) }}
            {{ Form::select('estado_producto_id', $estadoProductos, $producto->estado_producto_id, ['class' => 'form-select mb-3', 'aria-label' => 'Default select example', 'required', 'placeholder' => 'Selecione el estado']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('descripcion', 'Descripcion del producto *', ['class' => 'form-label']) }}
            {{ Form::textarea('descripcion', $producto->descripcion, ['class' => 'form-control', 'rows' => '4', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('ref_1', 'Referencia 1 del producto', ['class' => 'form-label']) }}
            {{ Form::text('ref_1', $producto->ref_1, ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('ref_2', 'Referencia 2 del producto', ['class' => 'form-label']) }}
            {{ Form::text('ref_2', $producto->ref_2, ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('ref_3', 'Referencia 3 del producto', ['class' => 'form-label']) }}
            {{ Form::text('ref_3', $producto->ref_3, ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-3">
                    {{ Form::label('volumen', 'Ingrese Volumen del producto', ['class' => 'form-label']) }}
                    {{ Form::text('volumen', $producto->volumen, ['class' => 'form-control', 'placeholder' => '']) }}
                    {{-- validar que el dato sea un numero con el validate del controlador --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-3">
                    {{ Form::label('unidad_volumen', 'Ingrese Unidad del Volumen', ['class' => 'form-label']) }}
                    {{ Form::select('unidad_volumen', ['ml' => 'Mililitros', 'l' => 'Litros', 'gal' => 'Galones'], $producto->unidad_volumen, ['class' => 'form-control', 'placeholder' => 'Volumen']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('peso', 'Ingrese Peso del producto', ['class' => 'form-label']) }}
                    {{ Form::text('peso', $producto->peso, ['class' => 'form-control', 'placeholder' => '']) }}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-3">
                    {{ Form::label('unidad_peso', 'Ingrese Unidad del Peso', ['class' => 'form-label']) }}
                    {{ Form::select('unidad_peso', ['g' => 'Gramos', 'kg' => 'Kilogramos', 'lb' => 'Libras'], $producto->unidad_peso, ['class' => 'form-control', 'placeholder' => 'Peso']) }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('categoria', 'Seleciona la categoria *', ['class' => 'form-label']) }}
            {{ Form::select('categoria_id', $categorias, $producto->categoria_id, ['class' => 'form-select', 'aria-label' => 'Default select example', 'required', 'placeholder' => 'Selecione la categoria']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('lote', 'Lote *', ['class' => 'form-label']) }}
            {{ Form::text('lote', $producto->lote, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('fecha_ingreso', 'Fecha de ingreso *', ['class' => 'form-label']) }}
            {{ Form::date('fecha_ingreso', $producto->fecha_ingreso, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('existencia', 'Unidad por caja *', ['class' => 'form-label']) }}
            {{ Form::number('existencia', $producto->existencia, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('existencia_limite', 'Unidad por caja Existencia limite*', ['class' => 'form-label']) }}
            {{ Form::number('existencia_limite', $producto->existencia_limite, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('etiqueta_destacado', 'Etiqueta para destacar destacar el producto*', ['class' => 'form-label']) }}
            {{ Form::select('etiqueta_destacado', ['1' => 'Activar Etiqueta', '0' => 'Desactivar Etiqueta'], $producto->etiqueta_destacado, ['class' => 'form-control', 'placeholder' => 'Selecione el estado de la etiqueta', 'required']) }}
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-3">
                    {{ Form::label('precio_1', 'Precio principal *', ['class' => 'form-label']) }}
                    {{ Form::number('precio_1', $producto->precio_1, ['class' => 'form-control', 'placeholder' => '', 'required', 'step' => 'any']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('precio_2', 'Segundo Precio', ['class' => 'form-label']) }}
                    {{ Form::number('precio_2', $producto->precio_2, ['class' => 'form-control', 'placeholder' => '', 'step' => 'any']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('precio_3', 'Tercer Precio', ['class' => 'form-label']) }}
                    {{ Form::number('precio_3', $producto->precio_3, ['class' => 'form-control', 'placeholder' => '', 'step' => 'any']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('precio_4', 'Cuarto Precio', ['class' => 'form-label']) }}
                    {{ Form::number('precio_4', $producto->precio_4, ['class' => 'form-control', 'placeholder' => '', 'step' => 'any']) }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            {{ Form::label('oem', 'OEM del producto', ['class' => 'form-label']) }}
            {{ Form::text('oem', $producto->OEM, ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('garantia', 'Garantia del producto', ['class' => 'form-label']) }}
            {{ Form::text('garantia', $producto->garantia, ['class' => 'form-control', 'placeholder' => '']) }}
        </div>
    </div>
    <div class="mb-3">
        {{ Form::label('ficha_tecnica_herf', 'Ficha tecnica del producto', ['class' => 'form-label']) }}
        {{ Form::hidden('ficha_tecnica_herf', $producto->ficha_tecnica_herf, ['id' => 'ficha_tecnica_herf']) }}
        {{ Form::file('ficha_tecnica_herf', ['class' => 'form-control', 'placeholder' => '']) }}
    </div>
    <div class="mb-3">
        {{ Form::label('imagen_1_src', 'Imagen del producto principal', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_1_src', $producto->imagen_1_src, ['id' => 'imagen_1_src']) }}
        {{ Form::file('imagen_1_src', ['class' => 'form-control', 'placeholder' => '']) }}
        {{-- mostrar imagen del producto con una etiqueta img comprobar si hay imagen para mostrar --}}
        @if ($producto->imagen_1_src)
            <img src="{{ $producto->imagen_1_src }}" alt="" width="100px">
        @endif

    </div>
    <div class="mb-3">
        {{ Form::label('imagen_2_src', 'Imagen del producto extra', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_2_src', $producto->imagen_2_src, ['id' => 'imagen_2_src']) }}
        {{ Form::file('imagen_2_src', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->imagen_2_src)
            <img src="{{ $producto->imagen_2_src }}" alt="" width="100px">
        @endif
    </div>
    <div class="mb-3">
        {{ Form::label('imagen_3_src', 'Imagen del producto extra', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_3_src', $producto->imagen_3_src, ['id' => 'imagen_3_src']) }}
        {{ Form::file('imagen_3_src', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->imagen_3_src)
            <img src="{{ $producto->imagen_3_src }}" alt="" width="100px">
        @endif
    </div>
    <div class="mb-3">
        {{ Form::label('imagen_4_src', 'Imagen del producto extra', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_4_src', $producto->imagen_4_src, ['id' => 'imagen_4_src']) }}
        {{ Form::file('imagen_4_src', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->imagen_4_src)
            <img src="{{ $producto->imagen_4_src }}" alt="" width="100px">
        @endif
    </div>
</div>
<div class="col-lg-3 mt-4">
    <button class="btn btn-primary me-1 mb-1" type="submit">Confirmar producto <i
            class="fa-solid fa-floppy-disk"></i></button>
</div>
{{ Form::close() }}
