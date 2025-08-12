<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaInicio = $_POST["fechaInicial"];
$FechaFin = $_POST["fechaFinal"]; 
$Punto = $_POST["Punto"];



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
    <div align="left">
		<a type="button" href="Ajax/ExistenciaGeneralPDF.php" target="_blank" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar PDF</a>
	</div> 
	<br>
	<div style="overflow-x:auto;">
		<table class="table table-hover" id="TblTicketsHotel">
		    <thead>
        
		    </thead>
		    <tbody> 
            <tr>
            <td align="center" colspan="6" ><b>TRASLADOS</b></td>
          </tr>
        <tr>
			<td><b>#</b></td>
			<td><b>Codigo</b></td>
			<td><b>Codigo Transacción</b></td>
			<td><b>Fecha</b></td>
			<td><b>Hora</b></td>
            <td><b>Nombre</b></td>
            <td><b>Cantidad</b></td>
            <td><b>Costo Ponderado</b></td>
            <td><b>Sub Total</b></td>
			<td><b>Ultimo Costo Entro</b></td>
            <td><b>Sub Total Costo</b></td>
			<?php
			
			?>
          </tr>
<?php
$Correlativo=1;

$NomTitulo = mysqli_query($db, "SELECT KARDEX.*, PRODUCTO.P_NOMBRE, PUNTO_VENTA.PV_NOMBRE, PRODUCTO.P_PRECIO_COMPRA_PONDERADO
FROM Productos.KARDEX, Productos.PRODUCTO, CompraVenta.PUNTO_VENTA
WHERE KARDEX.P_CODIGO = PRODUCTO.P_CODIGO
AND PUNTO_VENTA.PV_CODIGO = KARDEX.K_PUNTO_VENTA
AND KARDEX.K_DESCRPCION LIKE '%Envío de producto interno de %'
AND KARDEX.K_FECHA BETWEEN '$FechaInicio' AND '$FechaFin'
AND KARDEX.K_PUNTO_VENTA =".$Punto
);
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Cod=$row1["K_CODIGO"];
			$CodTra=$row1["TRA_CODIGO"];
            $Fecha=$row1["K_FECHA"];
            $Hora=$row1["K_HORA"];
            $Descripcion=$row1["K_DESCRPCION"];
            $ExiGAnt=$row1["K_EXISTENCIA_ANTERIOR"];
			$ExiGAct=$row1["K_EXISTENCIA_ACTUAL"];
            $ExiPAnt=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
			$ExiPAct=$row1["K_EXISTENCIA_ACTUAL_PUNTO"];
			#$CostoAn=$row1["P_PRECIO_COMPRA_PONDERADO"];
			$CostoEn=$row1["K_COSTO_ENTRO"];
			$CostoPo=$row1["K_COSTO_PONDERADO"];
			$PuntoV=$row1["PV_NOMBRE"];
			$Prod=$row1["P_NOMBRE"];
			$Producto1=$row1["P_CODIGO"];

			$EXIS = mysqli_query($db, "SELECT * FROM Productos.KARDEX
			WHERE KARDEX.K_FECHA <= '$Fecha'
			AND KARDEX.P_CODIGO = ".$Producto1."
			AND (KARDEX.K_COSTO_PONDERADO > 0
			OR KARDEX.K_COSTO_PONDERADO <> '')
			ORDER BY KARDEX.K_FECHA DESC, KARDEX.K_HORA DESC
			LIMIT 1");
			while($rowEX = mysqli_fetch_array($EXIS))
					{
						$CostoAn=$rowEX["K_COSTO_PONDERADO"];
					}
	
					if(!$CostoAn | $CostoAn==0){
	
						$CostoAn=$row1["P_PRECIO_COMPRA_PONDERADO"];
					}
			
			
			if($row1["K_EXISTENCIA_ANTERIOR_PUNTO"]>$row1["K_EXISTENCIA_ACTUAL_PUNTO"]){

				$Cantidad=$row1["K_EXISTENCIA_ANTERIOR_PUNTO"]-$row1["K_EXISTENCIA_ACTUAL_PUNTO"];
			}else{
				$Cantidad=$row1["K_EXISTENCIA_ACTUAL_PUNTO"]-$row1["K_EXISTENCIA_ANTERIOR_PUNTO"];
			}
			$SubTo=$Cantidad*$CostoAn;

			############# Costo Entro Ultimo #####################
			$EXIS = mysqli_query($db, "SELECT * FROM Productos.KARDEX
			WHERE KARDEX.K_FECHA <= '$Fecha'
			AND KARDEX.P_CODIGO = ".$Producto1."
			AND KARDEX.K_DESCRPCION LIKE '%Ingreso%'
			AND (KARDEX.K_COSTO_ENTRO > 0
			OR KARDEX.K_COSTO_ENTRO <> '')
			ORDER BY KARDEX.K_FECHA DESC, KARDEX.K_HORA DESC
			LIMIT 1");
			while($rowEX = mysqli_fetch_array($EXIS))
					{
						$CostoEntro=$rowEX["K_COSTO_ENTRO"];
					}
	
					if(!$CostoEntro | $CostoEntro==0){
	
						$CostoEntro=$row1["K_COSTO_ENTRO"];
					}
			
			
			
			$SubToEntro=$Cantidad*$CostoEntro;
			########################################
?>
				<tr>
				<td><?php echo $Correlativo ?></td>
		    	<td><?php echo $Cod ?></td>
		    	<td><?php echo $CodTra ?></td>
		    	<td><?php echo date($Fecha) ?></td>
		    	<td><?php echo date($Hora)?></td>
		    	<td><?php echo $Prod ?></td>
                <td><?php echo number_format($Cantidad, 4, ".", "") ?></td>
				<td><?php echo number_format($CostoAn, 4, ".", "") ?></td>
				<td><?php echo number_format($SubTo, 4, ".", "") ?></td>
				<td><?php echo number_format($CostoEntro, 4, ".", "") ?></td>
				<td><?php echo number_format($SubToEntro, 4, ".", "") ?></td>
				</tr>
			
		   	  
<?php
		$Correlativo+=1;
		$CostoAn=0;
		$CostoEntro=0;

        }

?>

		    
        
       
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
