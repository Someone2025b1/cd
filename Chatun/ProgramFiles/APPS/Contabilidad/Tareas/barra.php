<?php 
include ("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
 

$MES = $_POST['MES'];
$YEA = $_POST['YEA'];

$query = "SELECT COUNT(ESTATUS) AS CONTEO FROM tareas.editar_tareas WHERE MES = '$MES' AND YEA = $YEA AND ESTATUS = 1";
$respuestacount = mysqli_query($db, $query);
$rowC = mysqli_fetch_array($respuestacount)
?>

<?php $query = "SELECT COUNT(ESTATUS) AS CONTEO2 FROM tareas.editar_tareas WHERE MES = '$MES' AND YEA = $YEA";
$respuestacount = mysqli_query($db, $query);
$rowC2 = mysqli_fetch_array($respuestacount)
?>

<?php $conteo = $rowC['CONTEO'];
$conteo2 = $rowC2['CONTEO2'];
$porcentaje = ($conteo / $conteo2) * (100);

?>


    <div class="progress">
        <div  class="progress-bar" role="progressbar" style="width:<?php echo number_format($porcentaje, 1) ?>%;" aria-valuenow="6" aria-valuemin="6" aria-valuemax="100"><?php echo number_format( $porcentaje, 0 ) ?>%</div>
    </div>

 