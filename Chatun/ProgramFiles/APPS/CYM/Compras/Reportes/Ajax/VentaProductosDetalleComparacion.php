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
	$filtro = "MONTH(B.TRA_FECHA_TRANS) = $mesSelect AND YEAR(B.TRA_FECHA_TRANS) = $year";
	$texto = "Del mes ".$mesSelect." y del año ".$year;
}
elseif ($anio!="") 
{
	$filtro = "YEAR(B.TRA_FECHA_TRANS) = $anio";
	$texto = "Del año ".$anio;
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "B.TRA_FECHA_TRANS BETWEEN '$fechaInicial' AND '$fechaFinal'";
	$texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
}
elseif ($dia!="") 
{
	$filtro = "B.TRA_FECHA_TRANS = '$dia'";
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
	
		$Query = mysqli_query($db, "SELECT sum(TRAD_CARGO_PRODUCTO) as CANTIDAD, sum(TRAD_ABONO_PRODUCTO) as SALE, A.*, C.P_NOMBRE, C.UM_CODIGO
		FROM Bodega.TRANSACCION_DETALLE AS A
		JOIN Bodega.TRANSACCION AS B ON  B.TRA_CODIGO = A.TRA_CODIGO
		JOIN Bodega.PRODUCTO AS C ON  C.P_CODIGO = A.P_CODIGO
		WHERE $filtro
		AND B.TT_CODIGO IN (1,5,9,10,11,14,15)
		GROUP BY A.P_CODIGO
		");
	



		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?> 
			<center><h4>Venta de Proiductos 
<?php echo $texto ?></h4></center>
				<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th>
							<th><h5><strong>CODIGO</strong></h5></th>
							<th><h5><strong>NOMBRE PRODUCTO</strong></h5></th>
							<th><h5><strong>UNIDAD DE MEDIDA</strong></h5></th>
							<th><h5><strong>PRECIO</strong></h5></th>
							<th><h5><strong>CANTIDAD COMPRADA</strong></h5></th>
							<th><h5><strong>CANTIDAD VENDIDA</strong></h5></th>
							<th><h5><strong>DIFERENCIA</strong></h5></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Query))
							{
	
								$Codigo=$Fila["P_CODIGO"];
								$Conteo=$Fila["CANTIDAD"];
								$Sale=$Fila["SALE"];
								$Nombre=$Fila["P_NOMBRE"];
								$Costo=$Fila["FD_PRECIO_UNITARIO"];
								$Diferencia=$Conteo-$Sale;
								$Total=$Conteo*$Costo;
								$sumaConteo += $Conteo;
								$sumaSale+=$Sale;
								$UM=$Fila["UM_CODIGO"];

								$query = "SELECT * FROM Bodega.UNIDAD_MEDIDA WHERE UNIDAD_MEDIDA.UM_CODIGO=".$UM;
								$result = mysqli_query($db, $query);
								while($rowm = mysqli_fetch_array($result))
								{
									$UnidadM=$rowm["UM_NOMBRE"];
								}

								 if($Conteo>0 | $Conteo!=""){
								?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $Codigo ?></h6></td>
										<td><h6><?php echo $Nombre ?></h6></td>	 
										<td><h6><?php echo $UnidadM ?></h6></td>	 
										<td class="text-center"><h6><?php echo $Costo ?></h6></td>
										<td class="text-center"><h6><?php echo $Conteo ?></h6></td>
										<td class="text-center"><h6><?php echo $Sale ?></h6></td>
										<td class="text-center"><h6><?php echo $Diferencia ?></h6></td>
									</tr>
								<?php
								
								$sumaConteotO += $Total;
								$Contador++;
								 }
								
							}
							
							
						?>
						
						<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><h3>Total</h3></td>
							<td align="center"><h3><?php echo $sumaConteo ?></h3></td>
							<td align="center"><h3><?php echo $sumaSale ?></h3></td>
							<td></td>
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
 