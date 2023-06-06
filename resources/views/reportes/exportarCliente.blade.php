<table>
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Correo</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            //validar que muestre solo el estatus sea aprobado
            @if ($cliente->estatus == 'aprobado')
                <tr>
                    <td>{{ $cliente->name }}</td>
                    <td>{{ $cliente->apellido }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->estatus }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
