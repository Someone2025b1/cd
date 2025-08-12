<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php"); 
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Estanque = $_POST["Estanque"];
$Fecha = $_POST["Fecha"];
$Info = mysqli_fetch_array(mysqli_query($db, "SELECT a.UnidadesTerminadas, a.LibrasTerminadas FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estanque = '$Estanque'"));
?>
<div class="row">
<div class="col-lg-3">
    <div class="form-group ">
        <label for="Capacidad">Unidades terminadas</label>
        <input readonly value="<?php echo $Info['UnidadesTerminadas']?>" class="form-control" type="number" min="1" name="UniTerminadas" id="UniTerminadas" required/> 
    </div>
</div>
</div>
<div class="row">
<div class="col-lg-3">
    <div class="form-group ">
        <label for="Capacidad">Libras</label>
        <input readonly value="<?php echo $Info['LibrasTerminadas']?>" class="form-control" step="any" type="number" min="1" name="LibrasTerminadas" id="LibrasTerminadas" required/> 
    </div>
</div>
</div>