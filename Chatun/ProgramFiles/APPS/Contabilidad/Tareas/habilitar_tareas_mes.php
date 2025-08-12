<?php 
include ("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");?>
<?php include_once("app/header2.php"); ?>

<?php
$msjsuccess = "Mes habilitado con exito";
if (isset($_POST['mes1'])) {

  $mes = $_POST['mes1'];
  $year1 = $_POST['year1'];

  
}


  $id_user = $_SESSION["iduser"];
  $query = "SELECT * FROM tareas.tareas_mes where Usuario = $id_user"; 
  $respuesta_year = mysqli_query($db, $query);

  while ($row = mysqli_fetch_array($respuesta_year)) {
    $IdTarea = $row['Id_tarea_mes'];
    $tarea =  $row['Tarea']; 
    $query = "INSERT INTO tareas.editar_tareas(ID_TAREA_MES, Id_usuario, NOMBRE_TAREA, MES, YEA ) VALUES ('$IdTarea', '$id_user', '$tarea', '$mes','$year1')";
    $resultado = mysqli_query($db, $query);
 
  

 }

?>


<div class="container">
  <div class="card-body">
    <h1><?php if (!$resultado) {
          echo  "El mes solicitado ya fue habilitado antes";
        } else {
          echo $msjsuccess;
        }
        ?></h1>
        <div class="card-footer">
          <a href="habilitacion_mes.php"><button class="btn btn-primary">Habilitar Nuevo</button></a>

        </div>
  </div>
</div>


<?php include_once("app/footer2.php"); ?>