<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaInicio = $_POST["fechaInicial"];




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
	<script src="../../../../../js/libs/tableexport/tableExport.js"></script>
	<!-- <script src="../../../../../js/libs/tableexport/base64.min.js"></script> -->
	<script src="../../../../../js/libs/tableexport/jquery.base64.js"></script>
	<script src="../../../../../libs/TableFilter/tablefilter_all_min.js"></script>
	
	<!-- END JAVASCRIPT -->
	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="../../../../../libs/TableFilter/filtergrid.css">
	<!-- END STYLESHEETS -->

	<style type="text/css">
        .well{
        	 background: rgb(134, 192, 72);
        }

        table th {
	  color: #fff;
	  background-color: #f00;
	}
    </style>

</head>


<div align="left">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
	</div> <br>
   
	<br>
	<div style="overflow-x:auto;">
		<table class="table table-hover" id="TblTicketsHotel">
		    <thead>
        
		    </thead>
		    <tbody> 
            <tr>
            <td align="center" colspan="6" ><b>RETIROS REALIZADOS</b></td>
          </tr>
        <tr>
			<td><b>#</b></td>
			<td><b>Codigo</b></td>
			<td><b>Fecha</b></td>
			<td><b>Punto de Venta</b></td>
            <td><b>Monto</b></td>
			<td><b>Quien Retiro</b></td>
          </tr>
<?php
$Correlativo=1;

$NomTitulo = mysqli_query($db, "SELECT RETIRO_DINERO.*, usuarios.nombre
FROM Bodega.RETIRO_DINERO, info_bbdd.usuarios
WHERE RETIRO_DINERO.RD_USUARIO = usuarios.id_user
AND RETIRO_DINERO.RD_FECHA = '$FechaInicio'
ORDER BY RETIRO_DINERO.RD_FECHA");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Cod=$row1["RD_CODIGO"];
			$Fecha=$row1["RD_FECHA"];
            $Nombre=$row1["nombre"];
            $Punto=$row1["RD_PUNTO"];
            $Monto=$row1["RD_MONTO"];
?>
				<tr>
				<td><?php echo $Correlativo ?></td>
		    	<td><?php echo $Cod ?></td>
		    	<td><?php echo date($Fecha) ?></td>
		    	<td><?php echo $Punto ?></td>
                <td>Q.<?php echo number_format($Monto, 2, ".", "") ?></td>
		    	<td><?php echo $Nombre ?></td>
		   	  </tr>
<?php
		$Correlativo+=1;
		$TotalR+=$row1["RD_MONTO"];

        }

?>

		    
<tr>
				<td colspan="4"><b>TOTAL RETIRADO</b></td>>
                <td colspan="2"><b>Q.<?php echo number_format($TotalR, 2, ".", "") ?></b></td>

		   	  </tr>
       
         </tbody>
		  </table>
	</div>
	<script>
		 $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
	</script>		    		
</html>
