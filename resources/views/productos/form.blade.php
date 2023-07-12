<div class="row mt-1">
    
    <p class="mt-4 text-start rt-color-1">📝 Información del Producto:</p>
    <hr/>

    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('OEM', 'OEM del producto: *', ['class' => 'form-label']) }}
            {{ Form::text('OEM', $producto->OEM, ['class' => 'form-control', 'placeholder' => '-', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('nombre', 'Nombre del producto: *', ['class' => 'form-label']) }}
            {{ Form::text('nombre', $producto->nombre, ['class' => 'form-control', 'placeholder' => '', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('descripcion', 'Descripción del producto: *', ['class' => 'form-label']) }}
            {{ Form::textarea('descripcion', $producto->descripcion, ['class' => 'form-control', 'rows' => '4', 'required']) }}
        </div>
        {{-- <div class="mb-3">
            {{ Form::label('sku', 'SKU del producto:', ['class' => 'form-label']) }}
            {{ Form::text('sku', $producto->sku, ['class' => 'form-control', 'placeholder' => '-', 'required']) }}
            @if ($errors->has('sku'))
                <span class="text-danger">{{ $errors->first('sku') }}</span>
            @endif
        </div> --}}
        <div class="mb-3">
            {{ Form::label('garantia', 'Garantía del producto: *', ['class' => 'form-label']) }}
            {{ Form::text('garantia', $producto->garantia, ['class' => 'form-control', 'placeholder' => '-', 'required']) }}
        </div>
        <div>
            {{ Form::label('estado_producto_id', 'Estado del producto: *', ['class' => 'form-label']) }}
            {{ Form::select('estado_producto_id', $estadoProductos, $producto->estado_producto_id, ['class' => 'form-select mb-3', 'aria-label' => 'Default select example', 'placeholder' => 'Selecione el estado']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('ref_1', 'Referencia #1 del producto:', ['class' => 'form-label']) }}
            {{ Form::text('ref_1', $producto->ref_1, ['class' => 'form-control', 'placeholder' => '-']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('ref_2', 'Referencia #2 del producto:', ['class' => 'form-label']) }}
            {{ Form::text('ref_2', $producto->ref_2, ['class' => 'form-control', 'placeholder' => '-']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('ref_3', 'Referencia #3 del producto:', ['class' => 'form-label']) }}
            {{ Form::text('ref_3', $producto->ref_3, ['class' => 'form-control', 'placeholder' => '-']) }}
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-3">
                    {{ Form::label('volumen', 'Ingrese volumen del producto: *', ['class' => 'form-label']) }}
                    {{ Form::text('volumen', $producto->volumen, ['class' => 'form-control', 'placeholder' => '0.00']) }}
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
                    {{ Form::label('unidad_volumen', 'Ingrese unidad del volumen: *', ['class' => 'form-label']) }}
                    {{ Form::select('unidad_volumen', ['galon.' => 'Galón', 'galones.' => 'Galones', 'ml.' => 'Mililitros', 'litro.' => 'Litros'], $producto->unidad_volumen, ['class' => 'form-control', 'placeholder' => 'Seleccine una unidad de Volumen',  'required']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('peso', 'Ingrese peso del producto: *', ['class' => 'form-label']) }}
                    {{ Form::text('peso', $producto->peso, ['class' => 'form-control', 'placeholder' => '0.0']) }}
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
                    {{ Form::label('unidad_peso', 'Ingrese unidad del peso: *', ['class' => 'form-label']) }}
                    {{ Form::select('unidad_peso', ['grs.' => 'Gramos', 'kgs.' => 'Kilogramos', 'oz.' => 'Onza', 'lb.' => 'Libras'], $producto->unidad_peso, ['class' => 'form-control', 'placeholder' => 'Seleccion una Unidad de Peso', 'required']) }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="mb-3">
            {{ Form::label('lote', 'Lote:', ['class' => 'form-label']) }}
            {{ Form::text('lote', $producto->lote, ['class' => 'form-control', 'placeholder' => '-']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('marca_id', 'Selecione la marca: *', ['class' => 'form-label']) }}
            {{ Form::select('marca_id', $marcas, $producto->marca_id, ['class' => 'form-select', 'aria-label' => 'Default select example', 'required', 'placeholder' => 'Selecione una marca']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('origen', 'Origen del producto: *', ['class' => 'form-label']) }}
            {{ Form::select('origen', ['HECHO EN MEXICO' => 'HECHO EN MEXICO', 'HECHO EN USA' => 'HECHO EN USA'], $producto->origen, ['class' => 'form-control', 'placeholder' => 'Origen', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('categoria', 'Selecione la categoría: *', ['class' => 'form-label']) }}
            {{ Form::select('categoria_id', $categorias, $producto->categoria_id, ['class' => 'form-select', 'aria-label' => 'Default select example', 'required', 'placeholder' => 'Selecione la categoría', 'required']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('fecha_ingreso', 'Fecha de ingreso:', ['class' => 'form-label']) }}
            {{ Form::date('fecha_ingreso', $producto->fecha_ingreso, ['class' => 'form-control', 'placeholder' => 'dd/mm/aaaa']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('unidad_por_caja', 'Unidad por caja: *', ['class' => 'form-label']) }}
            {{ Form::number('unidad_por_caja', $producto->unidad_por_caja, ['class' => 'form-control', 'placeholder' => '0']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('existencia', 'Existencia:', ['class' => 'form-label']) }}
            {{ Form::number('existencia', $producto->existencia, ['class' => 'form-control', 'placeholder' => '0']) }}
        </div>
        <div class="mb-3">
            {{ Form::label('etiqueta_destacado', 'Etiqueta "Producto Destacado": *', ['class' => 'form-label']) }}
            {{ Form::select('etiqueta_destacado', ['1' => 'Activar Etiqueta', '0' => 'Desactivar Etiqueta'], $producto->etiqueta_destacado, ['class' => 'form-control', 'placeholder' => 'Selecione el estado de la etiqueta', 'required']) }}
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    {{ Form::label('precio_distribuidor', 'Precio distribuidor: *', ['class' => 'form-label']) }}
                    {{ Form::number('precio_distribuidor', $producto->precio_distribuidor, ['class' => 'form-control', 'placeholder' => '0.00 US$', 'required' ,'step' => 'any']) }}
                </div>
                <div class="col-6">
                    {{ Form::label('precio_taller', 'Precio taller: *', ['class' => 'form-label']) }}
                    {{ Form::number('precio_taller', $producto->precio_taller, ['class' => 'form-control', 'placeholder' => '0.00 US$', 'required' ,'step' => 'any']) }}
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-3">
                    {{ Form::label('precio_1', 'Precio principal: *', ['class' => 'form-label']) }}
                    {{ Form::number('precio_1', $producto->precio_1, ['class' => 'form-control', 'placeholder' => '0.00 US$','step' => 'any']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('precio_2', 'Segundo precio: *', ['class' => 'form-label']) }}
                    {{ Form::number('precio_2', $producto->precio_2, ['class' => 'form-control', 'placeholder' => '0.00 US$', 'step' => 'any']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('precio_3', 'Tercer precio: *', ['class' => 'form-label']) }}
                    {{ Form::number('precio_3', $producto->precio_3, ['class' => 'form-control', 'placeholder' => '0.00 US$', 'step' => 'any']) }}
                </div>
                <div class="col-3">
                    {{ Form::label('precio_oferta', 'Precio oferta: *', ['class' => 'form-label']) }}
                    {{ Form::number('precio_oferta', $producto->precio_oferta, ['class' => 'form-control', 'placeholder' => '0.00 US$', 'step' => 'any']) }}
                </div>
            </div>
        </div>
    </div>

    <p class="mt-4 text-start rt-color-1">📕 Documentos Adjuntos:</p>
    <hr/>

    <div class="mb-3">
        {{ Form::label('hoja_seguridad', 'Hoja de seguridad (.pdf):', ['class' => 'form-label']) }}
        {{ Form::hidden('hoja_seguridad', $producto->hoja_seguridad, ['id' => 'hoja_seguridad']) }}
        {{ Form::file('hoja_seguridad', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->hoja_seguridad != null)
            <a href="{{ asset(''.$producto->hoja_seguridad) }}" target="_blank">Ver archivo 📃 </a>
        @endif
    </div>
    <div class="mb-3">
        {{ Form::label('ficha_tecnica_href', 'Ficha técnica del producto (.pdf):', ['class' => 'form-label']) }}
        {{ Form::hidden('ficha_tecnica_href', $producto->ficha_tecnica_href, ['id' => 'ficha_tecnica_herf']) }}
        {{ Form::file('ficha_tecnica_href', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->ficha_tecnica_href != null)
            <a href="{{ asset(''.$producto->ficha_tecnica_href) }}" target="_blank">Ver archivo 📃</a>
        @endif
    </div>

    <p class="mt-4 text-start rt-color-1">📷 Imagenes del Producto:</p>
    <hr/>

    <div class="mb-3">
        {{ Form::label('imagen_1_src', 'Imagen principal (800x800px | .jpg, .jpeg, .png):', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_1_src', $producto->imagen_1_src, ['id' => 'imagen_1_src']) }}
        {{ Form::file('imagen_1_src', ['class' => 'form-control', 'placeholder' => '']) }}
        {{-- mostrar imagen del producto con una etiqueta img comprobar si hay imagen para mostrar --}}
        @if ($producto->imagen_1_src)
            <img src="{{ $producto->imagen_1_src }}" alt="" width="100px">
        @endif

    </div>
    <div class="mb-3">
        {{ Form::label('imagen_2_src', 'Imagen #2 (800x800px | .jpg, .jpeg, .png):', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_2_src', $producto->imagen_2_src, ['id' => 'imagen_2_src']) }}
        {{ Form::file('imagen_2_src', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->imagen_2_src)
            <img src="{{ $producto->imagen_2_src }}" alt="" width="100px">
        @endif
    </div>
    <div class="mb-3">
        {{ Form::label('imagen_3_src', 'Imagen #3 (800x800px | .jpg, .jpeg, .png):', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_3_src', $producto->imagen_3_src, ['id' => 'imagen_3_src']) }}
        {{ Form::file('imagen_3_src', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->imagen_3_src)
            <img src="{{ $producto->imagen_3_src }}" alt="" width="100px">
        @endif
    </div>
    <div class="mb-3">
        {{ Form::label('imagen_4_src', 'Imagen #4 (800x800px | .jpg, .jpeg, .png):', ['class' => 'form-label']) }}
        {{ Form::hidden('imagen_4_src', $producto->imagen_4_src, ['id' => 'imagen_4_src']) }}
        {{ Form::file('imagen_4_src', ['class' => 'form-control', 'placeholder' => '']) }}
        @if ($producto->imagen_4_src)
            <img src="{{ $producto->imagen_4_src }}" alt="" width="100px">
        @endif
    </div>
</div>

<div class="col-lg-12 mt-4 mb-4 flex-center">
    <button class="btn btn-primary me-1 mb-1" type="submit">Confirmar Producto 💾</button>
</div>

{{ Form::close() }}
