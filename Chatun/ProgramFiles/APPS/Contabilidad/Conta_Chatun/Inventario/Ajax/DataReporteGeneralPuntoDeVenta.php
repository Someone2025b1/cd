<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Bodega = $_POST["Bodega"];
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
		<a type="button" href="Ajax/ExistenciaPuntolPDF.php?Bodega=<?php echo $Bodega?>&Fecha=<?php echo $FechaFin?>" target="_blank" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar PDF</a>
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
/*
if($Bodega==1){

$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_TERRAZAS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");

}
elseif($Bodega==2){

$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_SOUVENIRS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
}
elseif($Bodega==3){
		$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_HELADOS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
		}
elseif($Bodega==4){
	$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_CAFE=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");
}

elseif($Bodega==5){
	$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_LLEVA_EXISTENCIA=1");
}

if($Bodega==6){

$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_TERRAZAS=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");

}

if($Bodega==8){

$NomTitulo = mysqli_query($db, "SELECT * FROM Productos.PRODUCTO WHERE PRODUCTO.P_PIZZERIA=1 AND PRODUCTO.P_LLEVA_EXISTENCIA=1");

}
*/

while($row1 = mysqli_fetch_array($NomTitulo))
        {
            $Producto = $row1["P_CODIGO"];
            $Nombre=$row1["P_NOMBRE"];
            $Ponderado=$row1["P_PRECIO_COMPRA_PONDERADO"];
            $Venta=$row1["P_PRECIO_VENTA"];
            $Souivenirs=$row1["P_EXISTENCIA_SOUVENIRS"];

			$UM=$row1["UM_CODIGO"];


			$unidadmedida = mysqli_query($db, "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM);
			while($rowmedida = mysqli_fetch_array($unidadmedida))
			{
				$unidadDeMedidad=$rowmedida["UM_NOMBRE"];
				
			}

	$EXIS = mysqli_query($db, "SELECT * FROM Productos.KARDEX
	WHERE KARDEX.K_FECHA <= '$FechaFin'
	AND KARDEX.K_PUNTO_VENTA =".$Bodega."
	AND KARDEX.P_CODIGO = ".$Producto."
	ORDER BY KARDEX.K_FECHA DESC
	LIMIT 1");
	while($rowEX = mysqli_fetch_array($EXIS))
			{
				$Existencias = $rowEX["K_EXISTENCIA_ACTUAL_PUNTO"];
	
				$subtot=$Ponderado*$Existencias;
				$Total+=$subtot;

				$HAY=1;

			}

	if($HAY==0){

		/* CODIGO PARA REGISTRAR EL INICIO DE LOS PRODUCTOS
		if($Bodega==1){
			$Existencias = $row1["P_EXISTENCIA_TERRAZAS"];
			}
			elseif($Bodega==2){
				$Existencias = $row1["P_EXISTENCIA_SOUVENIRS"];
			}
			elseif($Bodega==3){
				$Existencias = $row1["P_EXISTENCIA_HELADOS"];
					}
			elseif($Bodega==4){
				$Existencias = $row1["P_EXISTENCIA_CAFE"];
			}
			elseif($Bodega==5){
				$Existencias = $row1["P_EXISTENCIA_BODEGA"];
			}

			$EXistenciGe=$row1["P_EXISTENCIA_GENERAL"];

			$querykardex = mysqli_query($db, "INSERT INTO Productos.KARDEX (K_CODIGO, TRA_CODIGO, P_CODIGO, K_FECHA, K_HORA, K_DESCRPCION, K_EXISTENCIA_ANTERIOR, K_EXISTENCIA_ACTUAL, K_PUNTO_VENTA, K_EXISTENCIA_ANTERIOR_PUNTO, K_EXISTENCIA_ACTUAL_PUNTO)
						VALUES('".$KCod."', '".$Uid."', '".$Producto."', '2023-02-01', CURRENT_TIMESTAMP(), 'Registro Inicial ', '".$EXistenciGe."', '".$EXistenciGe."', '".$Bodega."', '".$Existencias."', '".$Existencias."')");
			*/
			$Existencias =0.0;
				$subtot=$Ponderado*$Existencias;
				$Total+=$subtot;
			}

			

			
			?>
			<tr>
							<td><?php echo $Producto ?></td>
							<td><?php echo $Nombre ?></td>
							<td><?php echo $unidadDeMedidad ?></td>
							<td><?php echo number_format($Ponderado, 3, ".", "") ?></td>
							<td><?php echo number_format($Venta, 3, ".", "") ?></td>
							<td><?php echo number_format($Existencias, 3, ".", "") ?></td>
							<td><?php echo number_format($subtot, 2, ".", "") ?></td>
							 </tr>
			<?php
			
			
		$HAY=0;

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
