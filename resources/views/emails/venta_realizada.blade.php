<!DOCTYPE html>
<html>

<head>
    <title>Venta realizada</title>
</head>

<body>
    <h1>¡Felicidades por tu venta!</h1>

    <p>Has vendido la pieza <strong>{{ $pieza->titulo }}</strong> a <strong>{{ $comprador->name }}</strong> por
        {{ number_format($pieza->precio, 2) }}€.</p>

    <h2>Información importante:</h2>
    <p>Tienes <strong>3 días hábiles</strong> para enviar la pieza al comprador. Por favor, procede con el envío lo
        antes posible.</p>

    <h3>Datos del comprador:</h3>
    <p>Nombre: {{ $comprador->name }}</p>
    <p>Email: {{ $comprador->email }}</p>
    @if ($comprador->direccion)
        <p>Dirección de envío: {{ $comprador->direccion }}</p>
    @endif

    <p>Por favor, contacta con el comprador si necesitas más información para el envío.</p>

    <p>Gracias por usar nuestra plataforma,</p>
    <p>El equipo de {{ config('app.name') }}</p>
</body>

</html>
