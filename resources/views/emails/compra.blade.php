<!DOCTYPE html>
<html>
<head>
    <title>¡Gracias por tu compra!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2d3748;
        }
        .panel {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 16px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #718096;
        }
        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">¡Gracias por tu compra!</div>
    
    <p><span class="bold">Has adquirido la pieza:</span><br>
    {{ $pieza->titulo }}</p>
    
    <p><span class="bold">Precio:</span><br>
    {{ number_format($pieza->precio, 2) }}€</p>
    
    <p>Adjuntamos tu factura en PDF.</p>
    
    <div class="panel">
        Gracias por confiar en RetroMotor
    </div>
    
    <div class="footer">
        Atentamente,<br>
        El equipo de RetroMotor
    </div>
</body>
</html>