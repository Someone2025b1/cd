<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaInicio = $_POST["fechaInicial"];
$FechaFin = $_POST["fechaFinal"]; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">

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
            <td align="center" colspan="6" ><b>EXISTENCIAS GENERALES</b></td>
          </tr>
        <tr>
            <td><b>Codigo</b></td>
            <td><b>Nombre</b></td>
            <td><b>Promedio Ponderado</b></td>
            <td><b>Precio Venta</b></td>
            <td><b>Existencia Bodega</b></td>
            <td><b>Existencia Terrazas</b></td>
            <td><b>Existencia Souvenir</b></td>
            <td><b>Existencia Cafe Los Abuelos</b></td>
            <td><b>Existencia Helados</b></td>
            <td><b>Existencia General</b></td>
          </tr>
<?php

$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_LLEVA_EXISTENCIA=1");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Cod = $row1["P_CODIGO"];
            $Nombre=$row1["P_NOMBRE"];
            $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
            $Venta=$row1["P_PRECIO_VENTA"];
            $Bodega=$row1["P_EXISTENCIA_BODEGA"];
            $Terrazas=$row1["P_EXISTENCIA_TERRAZAS"];
            $Souvenir=$row1["P_EXISTENCIA_SOUVENIRS"];
            $Cafe=$row1["P_EXISTENCIA_CAFE"];
            $Helados=$row1["P_EXISTENCIA_HELADOS"];
            

			$EXGen=$Bodega+$Terrazas+$Souvenir+$Cafe+$Helados;

			$General=$row1["P_EXISTENCIA_GENERAL"];
			
			# Activar Para Actualizar Existencia GEneral
			#$QueryPU = mysqli_query($db, "UPDATE Productos.PRODUCTO SET
							#P_EXISTENCIA_GENERAL = '".$EXGen."'
							#WHERE P_CODIGO = ".$Cod);

			
?>
<tr>
		    	<td><?php echo $Cod ?></td>
		    	<td><?php echo $Nombre ?></td>
		    	<td><?php echo number_format($Ponderado, 3, ".", "") ?></td>
		    	<td><?php echo number_format($Venta, 3, ".", "") ?></td>
		    	<td><?php echo number_format($Bodega, 3, ".", "") ?></td>
		    	<td><?php echo number_format($Terrazas, 3, ".", "") ?></td>
                <td><?php echo number_format($Souvenir, 3, ".", "") ?></td>
		    	<td><?php echo number_format($Cafe, 3, ".", "") ?></td>
		    	<td><?php echo number_format($Helados, 3, ".", "") ?></td>
		    	<td><?php echo number_format($General, 3, ".", "") ?></td>
		   	  </tr>
<?php



		}

?>

		    
        
        <tr>
		    	<td><b>Totales</b></td>
		    	<td><b><?php echo number_format($TotalesSalAnte, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesSumaCargos, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesSumaAbonos, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesDiferencia, 3, ".", "") ?></b></td>
		    	<td><b><?php echo number_format($TotalesSalActu, 3, ".", "") ?></b></td>
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
