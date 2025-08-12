<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php"); 
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"]; 
$Fecha = $_POST["Fecha"];  
$Contador = mysqli_fetch_array(mysqli_query($db, "SELECT a.Unidades FROM Bodega.LIMPIEZA_TILAPIA a WHERE a.Fecha = '$Fecha'"));
$Total = $Contador["Unidades"];
$ContadorA = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Unidades) AS Unidades FROM Bodega.ARRASTRE_TILAPIA a WHERE a.Estado = 0 and a.Unidades > 0"));
$Arrastre = $ContadorA["Unidades"];
?>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group ">
            <label for="Capacidad">Disponible</label>
            <input class="form-control" name="Disponible" id="Disponible" readonly=""  value="<?php echo $Total ?>" /> 
        </div>
    </div>
</div> 
<?php 
if ($Arrastre>0) {
 
?>
<div class="row">
    <div class="col-lg-3">
        <div class="form-group ">
            <label for="Capacidad">Arrastre</label>
            <input class="form-control" name="Arrastre" id="Arrastre" readonly=""  value="<?php echo $Arrastre ?>" /> 
        </div>
    </div>
</div> 
<?php 
} ?>