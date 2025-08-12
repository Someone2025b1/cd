<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$tarjeta = $_POST["tarjeta"];
$rowTarjeta = mysqli_fetch_array(mysqli_query($db, "SELECT *FROM Taquilla.TARJETAS_FAMILIARES a WHERE a.TF_NUMERO = $tarjeta"));
$fechaAct = date("Y-m-d");
?>
<div class="col-lg-2"></div>
<div class="col-lg-8">
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span> </button>
    <h3 class="text-success"><i class="fa fa-exclamation-circle"></i> </h3>
    <div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-4">
        <div class="form-group">
        <label for="titular">Titular</label>
        <input type="text" value="<?php echo $rowTarjeta["TF_NOMBRE_TITULAR"]?>" readonly class="form-control"  >
        </div>
    </div>
    <div class="col-lg-4">
        <div class="form-group">
        <label for="adultosTarjeta">Ingresos Disponibles</label>
        <input type="number" id="ingresoDisp" name="ingresoDisp" value="<?php echo $rowTarjeta["TF_INGRESOS_DISPONIBLES"]?>" readonly class="form-control"  >
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-4">
        <div class="form-group">
        <label for="noTarjeta">Vigencia</label>
        <input type="text" value="<?php echo $rowTarjeta["TF_VIGENCIA"]?>" readonly class="form-control" >
        </div>
    </div> 
</div>
<!--</div>
   <?php if ($fechaAct>$rowTarjeta["TF_VIGENCIA"]){ ?>
   	<div class="alert alert-danger alert-rounded">  
         La fecha de vigencia ha expirado... 
    </div>
   <?php } ?>
</div>
</div>-->
   <?php 
   if (!$rowTarjeta){ ?>
   	<div class="alert alert-danger alert-rounded">  
         NO EXISTE EN LA BASE DE DATOS 
    </div>
   <?php }elseif($fechaAct>$rowTarjeta["TF_VIGENCIA"]){ ?>
   	<div class="alert alert-danger alert-rounded">  
         La fecha de vigencia ha expirado... 
    </div>
   <?php } ?>
</div>