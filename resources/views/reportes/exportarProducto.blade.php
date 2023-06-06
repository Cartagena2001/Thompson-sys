<div class="table-responsive scrollbar">
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Stock</th>
                <th>Precio</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
                <tr>
                    <td scope="col">{{ $producto->nombre }}</td>
                    <td scope="col">{{ $producto->descripcion }}</td>
                    <td scope="col">{{ $producto->stock }}</td>
                    <td scope="col">{{ $producto->precio }}</td>
                    <td scope="col">{{ $producto->estado }}</td>
                </tr>
            @endforeach
        </tbody>    
    </table>
</div>