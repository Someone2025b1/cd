<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Bodega = $_POST["Bodega"];


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
		<a type="button" href="Ajax/ExistenciaPuntolPDF.php?Bodega=<?php echo $Bodega?>" target="_blank" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar PDF</a>
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
		  <?php
		  $query = "SELECT * FROM CompraVenta.PUNTO_VENTA WHERE PV_CODIGO=".$Bodega;
		  $result = mysqli_query($db, $query);
		  while($row = mysqli_fetch_array($result))
		  {
			$NomBodega=$row["PV_NOMBRE"];
		  }
		  ?>
        <tr>
            <td><b>Codigo</b></td>
            <td><b>Nombre</b></td>
			<td><b>Unidad de Medida</b></td>
            <td><b>Promedio Ponderado</b></td>
            <td><b>Precio Venta</b></td>
            <td><b>Existencia En <?php echo $NomBodega ?></b></td>
			<td><b>Subtotal</b></td>
          </tr>
<?php
if($Bodega==1){
$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_TERRAZAS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Cod = $row1["P_CODIGO"];
            $Nombre=$row1["P_NOMBRE"];
            $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
            $Venta=$row1["P_PRECIO_VENTA"];
            $Terrazas=$row1["P_EXISTENCIA_TERRAZAS"];

			$subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_TERRAZAS"];
			$Total+=$subtot;

			$UM=$row1["UM_CODIGO"];

			$unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
			while($rowmedida = mysqli_fetch_array($unidadmedida))
			{
				$unidadDeMedidad=$rowmedida["UM_NOMBRE"];
				
			}

?>
<tr>
		    	<td><?php echo $Cod ?></td>
		    	<td><?php echo $Nombre ?></td>
				<td><?php echo $unidadDeMedidad ?></td>
		    	<td><?php echo number_format($Ponderado, 3, ".", "") ?></td>
		    	<td><?php echo number_format($Venta, 3, ".", "") ?></td>
		    	<td><?php echo number_format($Terrazas, 3, ".", "") ?></td>
				<td><?php echo number_format($subtot, 2, ".", "") ?></td>
		   	  </tr>
<?php

        }
	}

elseif($Bodega==2){
$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_SOUVENIRS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Cod = $row1["P_CODIGO"];
            $Nombre=$row1["P_NOMBRE"];
            $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
            $Venta=$row1["P_PRECIO_VENTA"];
            $Souivenirs=$row1["P_EXISTENCIA_SOUVENIRS"];

			$subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_SOUVENIRS"];
			$Total+=$subtot;

			$UM=$row1["UM_CODIGO"];

			$unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
			while($rowmedida = mysqli_fetch_array($unidadmedida))
			{
				$unidadDeMedidad=$rowmedida["UM_NOMBRE"];
				
			}

?>
<tr>
		    	<td><?php echo $Cod ?></td>
		    	<td><?php echo $Nombre ?></td>
				<td><?php echo $unidadDeMedidad ?></td>
		    	<td><?php echo number_format($Ponderado, 2, ".", "") ?></td>
		    	<td><?php echo number_format($Venta, 2, ".", "") ?></td>
		    	<td><?php echo number_format($Souivenirs, 2, ".", "") ?></td>
				<td><?php echo number_format($subtot, 2, ".", "") ?></td>
		   	  </tr>
<?php

        }
	}

	elseif($Bodega==3){
		$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_HELADOS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
		while($row1 = mysqli_fetch_array($NomTitulo))
				{
					$Cod = $row1["P_CODIGO"];
					$Nombre=$row1["P_NOMBRE"];
					$Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
					$Venta=$row1["P_PRECIO_VENTA"];
					$Helados=$row1["P_EXISTENCIA_HELADOS"];
		
					$subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_HELADOS"];
					$Total+=$subtot;
		
					$UM=$row1["UM_CODIGO"];

					$unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
					while($rowmedida = mysqli_fetch_array($unidadmedida))
					{
						$unidadDeMedidad=$rowmedida["UM_NOMBRE"];
						
					}
		
		?>
		<tr>
						<td><?php echo $Cod ?></td>
						<td><?php echo $Nombre ?></td>
						<td><?php echo $unidadDeMedidad ?></td>
						<td><?php echo number_format($Ponderado, 2, ".", "") ?></td>
						<td><?php echo number_format($Venta, 2, ".", "") ?></td>
						<td><?php echo number_format($Helados, 2, ".", "") ?></td>
						<td><?php echo number_format($subtot, 2, ".", "") ?></td>
						 </tr>
		<?php
		
				}
			}
			elseif($Bodega==4){
				$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_CAFE=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
				while($row1 = mysqli_fetch_array($NomTitulo))
						{
							$Cod = $row1["P_CODIGO"];
							$Nombre=$row1["P_NOMBRE"];
							$Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
							$Venta=$row1["P_PRECIO_VENTA"];
							$Souivenirs=$row1["P_EXISTENCIA_SOUVENIRS"];
				
							$subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_SOUVENIRS"];
							$Total+=$subtot;
				
							$UM=$row1["UM_CODIGO"];

							$unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
							while($rowmedida = mysqli_fetch_array($unidadmedida))
							{
								$unidadDeMedidad=$rowmedida["UM_NOMBRE"];
								
							}
				
				?>
				<tr>
								<td><?php echo $Cod ?></td>
								<td><?php echo $Nombre ?></td>
								<td><?php echo $unidadDeMedidad ?></td>
								<td><?php echo number_format($Ponderado, 2, ".", "") ?></td>
								<td><?php echo number_format($Venta, 2, ".", "") ?></td>
								<td><?php echo number_format($Souivenirs, 2, ".", "") ?></td>
								<td><?php echo number_format($subtot, 2, ".", "") ?></td>
								 </tr>
				<?php
				
						}
					}

					elseif($Bodega==5){
						$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_LLEVA_EXISTENCIA=1");
						while($row1 = mysqli_fetch_array($NomTitulo))
								{
									$Cod = $row1["P_CODIGO"];
									$Nombre=$row1["P_NOMBRE"];
									$Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
									$Venta=$row1["P_PRECIO_VENTA"];
									$Souivenirs=$row1["P_EXISTENCIA_BODEGA"];
						
									$subtot=$row1["P_PRECIO_COMPRA_PONDERADO"]*$row1["P_EXISTENCIA_BODEGA"];
									$Total+=$subtot;
						
									$UM=$row1["UM_CODIGO"];

									$unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
									while($rowmedida = mysqli_fetch_array($unidadmedida))
									{
										$unidadDeMedidad=$rowmedida["UM_NOMBRE"];
										
									}
						
						?>
						<tr>
										<td><?php echo $Cod ?></td>
										<td><?php echo $Nombre ?></td>
										<td><?php echo $unidadDeMedidad ?></td>
										<td><?php echo number_format($Ponderado, 2, ".", "") ?></td>
										<td><?php echo number_format($Venta, 2, ".", "") ?></td>
										<td><?php echo number_format($Souivenirs, 2, ".", "") ?></td>
										<td><?php echo number_format($subtot, 2, ".", "") ?></td>
										 </tr>
						<?php
						
								}
							}

?>
		  <tr>
		    	<td align="center" colspan="6"><strong> TOTAL </strong></td>
				<td><?php echo number_format($Total, 2, ".", "") ?></td>
		   	  </tr>  
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
