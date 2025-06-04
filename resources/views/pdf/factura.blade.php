<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Recibo de compra</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #333;
        }

        .contenido {
            margin: 20px;
        }

        .foto {
            width: 100%;
            max-width: 300px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        td,
        th {
            padding: 8px;
            border: 1px solid #ccc;
        }

        .titulo {
            background: #f4f4f4;
        }
    </style>
</head>

<body>
    <div class="contenido">
        <h1>Recibo de Compra</h1>

        @if ($pieza->foto)
            <img src="{{ public_path('storage/' . $pieza->foto) }}" class="foto" alt="Imagen de la pieza">
        @endif

        <h3>{{ $pieza->titulo }}</h3>
        <p><strong>Precio:</strong> €{{ number_format($pieza->precio, 2) }}</p>

        <table>
            <tr>
                <th class="titulo">Categoría</th>
                <td>{{ $pieza->categoria }}</td>
            </tr>
            <tr>
                <th class="titulo">Marca</th>
                <td>{{ $pieza->marca }}</td>
            </tr>
            <tr>
                <th class="titulo">Modelo</th>
                <td>{{ $pieza->modelo }}</td>
            </tr>
            <tr>
                <th class="titulo">Motor</th>
                <td>{{ $pieza->motor }}</td>
            </tr>
            <tr>
                <th class="titulo">Año</th>
                <td>{{ $pieza->año }}</td>
            </tr>
            <tr>
                <th class="titulo">Estado</th>
                <td>{{ $pieza->estado }}</td>
            </tr>
            <tr>
                <th class="titulo">Descripción</th>
                <td>{!! $pieza->descripcion !!}</td>
            </tr>
        </table>

        <p><strong>Comprador:</strong> {{ $user->name }} ({{ $user->email }})</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>
