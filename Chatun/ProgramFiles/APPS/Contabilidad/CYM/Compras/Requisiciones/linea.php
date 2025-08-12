<?php
$estados = [
    "Pedido recibido",
    "Cotizando",
    "Pendiente de Confirmar Cotización",
    "Cotización Confirmada",
    "Confirmación de Director Ejecutivo",
    "Pedido",
    "Recibido",
    "Pendiente de Factura",
    "Pendiente de Pagar",
    "Pagado"
];

$estado_actual = "Pendiente de Pagar"; // Cambia esto según el estado actual
$estado_cancelado = "Cancelado";
$is_cancelled = ($estado_actual == $estado_cancelado);

if ($is_cancelled) {
    $estados[] = $estado_cancelado;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado del Envío</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: white;
        }
        .container {
            width: 80%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background: white;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .timeline {
            display: flex;
            justify-content: space-between;
            align-items: center;
            list-style: none;
            padding: 10px;
            width: 100%;
        }
        .step {
            position: relative;
            margin: 5px 0;
            padding: 5px;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }
        .circle {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            display: inline-block;
            background: <?php echo $is_cancelled ? 'red' : '#ccc'; ?>;
        }
        .completed .circle {
            background: green;
        }
        .cancelled .circle {
            background: red;
        }
        .line {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 5px;
            background: <?php echo $is_cancelled ? 'red' : '#ccc'; ?>;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Seguimiento</h2>
        <ul class="timeline">
            <?php foreach ($estados as $estado): ?>
                <li class="step <?php echo $is_cancelled ? 'cancelled' : (($estado == $estado_actual || array_search($estado, $estados) < array_search($estado_actual, $estados)) ? 'completed' : ''); ?>">
                    <div class="circle"></div>
                    <span><?php echo $estado; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
