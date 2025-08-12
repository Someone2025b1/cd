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
	$filtro = "MONTH(REQUISICION.R_FECHA) = $mesSelect AND YEAR(REQUISICION.R_FECHA) = $year";
	$texto = "Del mes ".$mesSelect." y del año ".$year;
}
elseif ($anio!="") 
{
	$filtro = "YEAR(REQUISICION.R_FECHA) = $anio";
	$texto = "Del año ".$anio;
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "REQUISICION.R_FECHA BETWEEN '$fechaInicial' AND '$fechaFinal'";
	$texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
}
elseif ($dia!="") 
{
	$filtro = "REQUISICION.R_FECHA = '$dia'";
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
	
	$Query = "SELECT REQUISICION.*
		FROM CompraVenta.REQUISICION
		WHERE $filtro
		ORDER BY REQUISICION.R_CODIGO";


	

		$Result = mysqli_query($db, $Query);
		$Registros = mysqli_num_rows($Result);

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
							while($Fila = mysqli_fetch_array($Result))
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
 