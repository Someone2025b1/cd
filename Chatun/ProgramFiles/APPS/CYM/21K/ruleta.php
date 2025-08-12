<?php
// Genera un número aleatorio entre 1 y 1000
$randomNumber = rand(1, 1000);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruleta Aleatoria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            background-image: url("FondoTombola.png");
            background-repeat: no-repeat;
            background-size: cover;
        }
        .ruleta-container {
            margin-top: 50px;
        }
        .ruleta {
            width: 100%;
            height: 100%;

            display: flex;
            align-items: center;
            justify-content: center;
           
            color: black;
            font-size: 100px;
            font-weight: bold;
        }
        .boton {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .boton:hover {
            background-color: #3742fa;
        }
    </style>
</head>
<body>
    <div class="ruleta-container">
    <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>

        <div class="ruleta" id="ruleta">
            
            <?php echo $randomNumber; ?>
        </div>
        <form action="" method="post">
            <button type="submit" class="boton">Girar Ruleta</button>
        </form>
    </div>
</body>
</html>
