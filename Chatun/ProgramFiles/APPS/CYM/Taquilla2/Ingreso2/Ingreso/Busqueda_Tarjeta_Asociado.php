<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php"); 
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<!-- END META -->

	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../../js/core/source/App.js"></script>
	<script src="../../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../../libs/alertify/js/alertify.js"></script>
	<script src="../../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container">
				<div class="col-lg-12">
					<br>
					<div class="card" style="margin-left: -10%;width: 120%">
						<div class="card-head style-primary">
							<h4 class="text-center"><strong>Busqueda Tarjeta SOY COOSAJO</strong></h4>
						</div>
						<div class="card-body">
							<div class="panel panel-primary">

    <div id="collapse2" class="row align-items-start">
      <div class="panel-body">
          <table class="table">
        
    <thead>
      <form action="Busqueda_Tarjeta_Asociado.php" method="get" enctype="multipart/form-data" id="subir_archivo">
      
<div class="row">
    <div class="col-lg-4 col-md-5">
      <div class="form-group floating-label">
        
      </div>
      <div id="DivAutorizadorNuevo"></div>
    </div>

    <div class="col-lg-4 col-md-5">
      <div class="form-group floating-label">
        <label for="regular3">No. Tarjeta:</label>
        <input type="input"  class="form-control" name="no_tarjeta" id="no_tarjeta" required />
        <input name="buscar" type="hidden" id="buscar" value="1">
      </div>
      <div id="DivAutorizadorNuevo"></div>
    </div>
    
  </div>

  <div class="row">
    <div class="col-lg-5 col-md-5">
      <div class="form-group floating-label">
        <label for="regular3"></label>       
      </div>      
    </div>
    <div class="col-lg-5 col-md-5">
      <div class="form-group floating-label">
        <label for="regular3"></label>
        <input class="btn btn-primary" type="submit" value="CONSULTAR">
      </div>
    </div> 
  </div> 
  </div>
      </form>          
    </thead>    
<br>
   <tr align="center">
    <td align="center">

</tr>
</td>
</table>




<?php
/////////////////////// MOTIVO PARA DESACTIVAR LA TARJETA ////////////////////
$buscar = $_GET['buscar'];


 if($buscar == '1'){

$no_tarjeta = $_GET['no_tarjeta'];

  $saber_asociado = mysqli_fetch_array(mysqli_query($dbc, "SELECT cif_asociado, agencia, estado, motivo_rechazo FROM coosajo_asociatividad.tarjeta_soy_coosajo where id_tarjeta = '$no_tarjeta'"));

$cif_correspondiente 	= $saber_asociado['cif_asociado'];
$estado_tarjeta 		= $saber_asociado['estado'];
$motivo_rechazo 		= $saber_asociado['motivo_rechazo'];

/////////////PARA SACAR LA FOTO ////////////////////////
$solicitud_ingreso = mysqli_fetch_array(mysqli_query($dbc, "SELECT fotografia_solicitante FROM coosajo_asociatividad.solicitud_ingreso where cif = '$cif_correspondiente' AND fotografia_solicitante != '';"));
$ruta_fotografia_solicitante = trim($solicitud_ingreso['fotografia_solicitante']);

$fotografia_solicitante = "http://10.60.8.209/portal/Gestion_Documental/Asociatividad/ingreso_asociado/fotos_asociados/".$ruta_fotografia_solicitante." ";


?>

<div align="center" class="alert alert-success col-md-6 col-md-offset-3">
  <form action="adm_tarjeta.php?desactivar_tc=1" method="post" enctype="multipart/form-data" id="subir_archivo">
  <div align="center" class="col-md-6 col-md-offset-3">
      <div align="center" class="col-lg-12 col-md-5">
      <label for="regular3"><strong><?php echo saber_nombre_asociado_orden($cif_correspondiente);
                     
                      if($cif_correspondiente == NULL){
                        echo "NO POSEE ASOCIADO ASIGNADO";
                      }

        ?></strong></label>
        <label for="regular3"><strong><?php echo "CIF: ".$cif_correspondiente; ?></strong></label>
        <label for="regular3"><strong><?php echo "AGENCIA: ".utf8_encode(saber_nombre_agencia($saber_asociado['agencia'])) ?></strong></label>
        <input name="id_tc_desactivar" type="hidden" id="subir" value="<?php echo $id_tarjeta ?>">

      </div>
      
    </div>

    <div >
      <?php
        if($ruta_fotografia_solicitante !="")//si posee fotografia en perfil asociado
        {    ?>
             <embed src="<?php echo $fotografia_solicitante?>" width="300" height="300" alt="pdf">
      <?php } ?>
            </div> 


           <div align="center" class="alert alert-success col-md-6 col-md-offset-3">
			      <?php
			        if($estado_tarjeta == '3')//si la tarjeta esta inactiva
			        {    ?>
			             <img src="images/no.png">
			            
			      <?php 
			      	
			  		} 
			        if($estado_tarjeta != '3')//si la tarjeta esta inactiva
			        {    ?>
			             <img src="images/ok.png">
			      <?php } ?>
            </div> 
             <div align="center" class="alert alert-success col-md-8 col-md-offset-2">
			             	 <?php 
			      				echo $motivo_rechazo;
			      			 ?>
			      		</div>
          
</div>
</form>













<?php


}





?>
      
<div class="col-md-10 col-md-offset-1">  
    
    <div align="center">        
      <header>
        <h3></h3>
      </header>
    </div>
    
        <div class="table-responsive" >
     <table>
       
     </table>
          
    </div>
          
</div>

 


  


      </div>
    </div>

  </div>
 
 </div>
       

						</div>
					</div>
				</div>
				<br>
				<br>
			</div>
		</div>
		
		<?php if(saber_puesto($id_user) == 17)
		{
			include("../MenuCajero.html"); 
		}
		else
		{
			include("../MenuUsers.html"); 
		}
		?>
	

	</div><!--end #base-->
	<!-- END BASE -->
	</body>
	</html>
