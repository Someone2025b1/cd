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
if ($mes!="") 
{
	$mesSelect = date("m",strtotime($mes));
	$year = date("Y",strtotime($mes));
	$filtro = "MONTH(A.IA_FECHA_INGRESO) = $mesSelect AND YEAR(A.IA_FECHA_INGRESO) = $year";
	$texto = "Del mes ".$mesSelect." y del año ".$year;
}
elseif ($anio!="") 
{
	$filtro = "YEAR(A.IA_FECHA_INGRESO) = $anio";
	$texto = "Del año ".$anio;
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "A.IA_FECHA_INGRESO BETWEEN '$fechaInicial' AND '$fechaFinal'";
	$texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
}
elseif ($dia!="") 
{
	$filtro = "A.IA_FECHA_INGRESO = '$dia'";
	$texto = "Del día ".cambio_fecha($dia);
}
?>
<title>Ingreso Asociados 
<?php echo $texto ?></title>
<div class="row">
<br>
<br>
<br>
</div>
<div class="row">
<div class="col-lg-12">
	<?php
		$Query = mysqli_query($db, "SELECT  A.*
FROM Taquilla.INGRESO_ASOCIADO AS A
WHERE $filtro 
ORDER BY IAT_CIF_ASOCIADO DESC");
		 
		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?>
			 <center>
				<h4>Ingreso Asociados 
				<?php echo $texto ?></h4>
			</center>
			<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel3" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 	<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th>
							<th><h5><strong>CIF</strong></h5></th>
							<th><h5><strong>NOMBRE</strong></h5></th>
							<th><h5><strong>FECHA INGRESO</strong></h5></th>
							<th><h5><strong>HORA INGRESO</strong></h5></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Query))
							{
								 
								?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $Fila["IAT_CIF_ASOCIADO"] ?></h6></td>
										<td><h6><?php echo utf8_encode(saber_nombre_asociado_orden($Fila["IAT_CIF_ASOCIADO"])) ?></h6></td>	 
										<td><h6><?php echo cambio_fecha($Fila["IA_FECHA_INGRESO"]) ?></h6></td>
										<td><h6><?php echo $Fila["IA_HORA_INGRESO"] ?></h6></td>
									</tr>
								<?php
								$Contador++;
							}
						?>
					</tbody>
				</table>
			</div>
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
<script>
	
</script>