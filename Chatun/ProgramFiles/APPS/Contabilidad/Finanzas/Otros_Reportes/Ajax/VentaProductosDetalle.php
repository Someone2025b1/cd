<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mes = $_POST["mes"];
$anio = $_POST["anio"];
$fechaInicial = $_POST["fechaInicial"];
$fechaFinal = $_POST["fechaFinal"];
$dia = $_POST["dia"];
$punto=$_POST["punto"];
if ($mes!="") 
{
	$mesSelect = date("m",strtotime($mes));
	$year = date("Y",strtotime($mes));
	$filtro = "MONTH(B.F_FECHA_TRANS) = $mesSelect AND YEAR(B.F_FECHA_TRANS) = $year";
	$texto = "Del mes ".$mesSelect." y del año ".$year;
}
elseif ($anio!="") 
{
	$filtro = "YEAR(B.F_FECHA_TRANS) = $anio";
	$texto = "Del año ".$anio;
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "B.F_FECHA_TRANS BETWEEN '$fechaInicial' AND '$fechaFinal'";
	$texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
}
elseif ($dia!="") 
{
	$filtro = "B.F_FECHA_TRANS = '$dia'";
	$texto = "Del día ".cambio_fecha($dia);
}


?>
<title>Venta de Proiductos 
<?php echo $texto ?></title>
<div class="row">
<br>
<br>
<br>
</div>
<div class="row">
<div class="col-lg-12">
	<?php
	if($punto==1){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_DETALLE AS A
		JOIN Bodega.FACTURA AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro


		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_2_DETALLE AS A
		JOIN Bodega.FACTURA_2 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_DETALLE AS A
		JOIN Bodega.FACTURA AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==2){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_RS_DETALLE AS A
		JOIN Bodega.FACTURA_RS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_RS_DETALLE AS A
		JOIN Bodega.FACTURA_RS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==13){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_PIZZA_DETALLE AS A
		JOIN Bodega.FACTURA_PIZZA AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_PIZZA_DETALLE AS A
		JOIN Bodega.FACTURA_PIZZA AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==3){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_HS_DETALLE AS A
		JOIN Bodega.FACTURA_HS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_HS_DETALLE AS A
		JOIN Bodega.FACTURA_HS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}
	if($punto==4){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_DETALLE AS A
		JOIN Bodega.FACTURA_KS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_DETALLE AS A
		JOIN Bodega.FACTURA_KS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}
	if($punto==5){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_2_DETALLE AS A
		JOIN Bodega.FACTURA_KS_2 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_2_DETALLE AS A
		JOIN Bodega.FACTURA_KS_2 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}
	if($punto==6){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_3_DETALLE AS A
		JOIN Bodega.FACTURA_KS_3 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_3_DETALLE AS A
		JOIN Bodega.FACTURA_KS_3 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}
	if($punto==7){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_4_DETALLE AS A
		JOIN Bodega.FACTURA_KS_4 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_4_DETALLE AS A
		JOIN Bodega.FACTURA_KS_4 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==9){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.P_CODIGO AS RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_SV_DETALLE AS A
		JOIN Bodega.FACTURA_SV AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.P_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.P_CODIGO AS RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_SV_2_DETALLE AS A
		JOIN Bodega.FACTURA_SV_2 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.P_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==11){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_EV_DETALLE AS A
		JOIN Bodega.FACTURA_EV AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_EV_DETALLE AS A
		JOIN Bodega.FACTURA_EV AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==12){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_TQ_DETALLE AS A
		JOIN Bodega.FACTURA_TQ AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_TQ_3_DETALLE AS A
		JOIN Bodega.FACTURA_TQ_3 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_TQ_4_DETALLE AS A
		JOIN Bodega.FACTURA_TQ_4 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_TQ_2_DETALLE AS A
		JOIN Bodega.FACTURA_TQ_2 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==8){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_DETALLE AS A
		JOIN Bodega.FACTURA AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_RS_DETALLE AS A
		JOIN Bodega.FACTURA_RS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_2_DETALLE AS A
		JOIN Bodega.FACTURA_KS_2 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro
		
		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_DETALLE AS A
		JOIN Bodega.FACTURA_KS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro
		
		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_3_DETALLE AS A
		JOIN Bodega.FACTURA_KS_3 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL
 
		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_4_DETALLE AS A
		JOIN Bodega.FACTURA_KS_4 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro
		
		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_HS_DETALLE AS A
		JOIN Bodega.FACTURA_HS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Bodega.RECETA_SUBRECETA AS C ON  C.RS_CODIGO = A.RS_CODIGO
		WHERE $filtro

		
		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_DETALLE AS A
		JOIN Bodega.FACTURA AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro


		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_RS_DETALLE AS A
		JOIN Bodega.FACTURA_RS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_HS_DETALLE AS A
		JOIN Bodega.FACTURA_HS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_DETALLE AS A
		JOIN Bodega.FACTURA_KS AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_2_DETALLE AS A
		JOIN Bodega.FACTURA_KS_2 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_3_DETALLE AS A
		JOIN Bodega.FACTURA_KS_3 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_KS_4_DETALLE AS A
		JOIN Bodega.FACTURA_KS_4 AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro

		UNION ALL

		SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, C.P_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_PIZZA_DETALLE AS A
		JOIN Bodega.FACTURA_PIZZA AS B ON  B.F_CODIGO = A.F_CODIGO
		JOIN Productos.PRODUCTO AS C ON  C.P_CODIGO = A.RS_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}

	if($punto==10){
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, NOMBREP, RS_CODIGO, FD_PRECIO_UNITARIO, sum(FD_CANTIDAD) as CANTIDAD
		FROM (SELECT A.FD_CANTIDAD, A.RS_CODIGO, A.FD_PRECIO_UNITARIO, A.RS_NOMBRE AS NOMBREP
		FROM Bodega.FACTURA_JG_DETALLE AS A
		JOIN Bodega.FACTURA_JG AS B ON  B.F_CODIGO = A.F_CODIGO
		WHERE $filtro) PRODUCTOS
		GROUP BY RS_CODIGO
		ORDER BY CONT DESC");
	}


		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?> 
			<center><h4>Venta de Productos 
<?php echo $texto ?></h4></center>
				<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th>
							<th><h5><strong>CODIGO</strong></h5></th>
							<th><h5><strong>NOMBRE PRODUCTO</strong></h5></th>
							<th><h5><strong>PRECIO</strong></h5></th>
							<th><h5><strong>CANTIDAD</strong></h5></th>
							<th><h5><strong>TOTAL</strong></h5></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Query))
							{
	
								$Codigo=$Fila["RS_CODIGO"];
								$Conteo=$Fila["CANTIDAD"];
								$Nombre=$Fila["NOMBREP"];
								$Costo=$Fila["FD_PRECIO_UNITARIO"];
								$Total=$Conteo*$Costo;
								$sumaConteo += $Conteo;

								 
								?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $Codigo ?></h6></td>
										<td><h6><?php echo $Nombre ?></h6></td>	 
										<td class="text-center"><h6><?php echo $Costo ?></h6></td>
										<td class="text-center"><h6><?php echo $Conteo ?></h6></td>
										<td class="text-center"><h6><?php echo $Total ?></h6></td>
									</tr>
								<?php
								
								$sumaConteotO += $Total;
								$Contador++;
								
							}
							
							
						?>
						
						<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><h3>Total</h3></td>
							<td align="center"><h3><?php echo $sumaConteo ?></h3></td>
							<td align="center"><h3><?php echo $sumaConteotO ?></h3></td>
						</tr>
						</tfoot>
					</tbody>
				</table>
			<?php
		}
		else
		{
			?>
				<div class="row text-center">
					<div class="alert alert-warning">
						<strong>No existen registros para las fechas ingresadas</strong>
					</div>
				</div>
			<?php
		}
	?>
</div>
</div>
</div>
</div>
</div>
 