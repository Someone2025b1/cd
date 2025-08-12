<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Referencia = $_POST["Referencia"];

$Query = mysqli_query($db, "SELECT *
                        FROM Taquilla.INGRESO_ACOMPANIANTE AS A
                        WHERE A.IA_REFERENCIA = '".$Referencia."'");

while($Fila = mysqli_fetch_array($Query))
{
    ?>
        <tr>
            <td><h6><?php echo $Fila["IAT_NOMBRE"] ?></h6></td>
            <td><h6><?php echo $Fila["IAT_EDAD"] ?></h6></td>
            <td><h6><?php echo $Fila["IAT_CORREO"] ?></h6></td>
        </tr>
    <?php
}

?>