<?php
$statuses = ["Pendiente", "Procesando", "Enviado", "Entregado", "Cancelado"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estados del Pedido</title>
    <style>
        .container {
            width: 300px;
            margin: 50px auto;
            padding: 15px;
            background: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            cursor: pointer;
        }
        .status-list {
            margin-top: 10px;
            display: none;
        }
        .status-list.active {
            display: block;
        }
        .status {
            padding: 8px;
            background: #f3f3f3;
            margin: 5px 0;
            text-align: center;
            border-radius: 5px;
        }
    </style>
    <script>
        function toggleStatus() {
            var list = document.getElementById("statusList");
            list.classList.toggle("active");
        }
    </script>
</head>
<body>
    <div class="container" onclick="toggleStatus()">
        <h3>Estado del Pedido</h3>
        <div id="statusList" class="status-list">
            <?php foreach ($statuses as $status): ?>
                <div class="status"><?php echo $status; ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
