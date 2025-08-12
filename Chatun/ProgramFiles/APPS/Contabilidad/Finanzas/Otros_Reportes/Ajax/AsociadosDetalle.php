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

$ciftemp=-1;
$conteo =0;
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
		$Query = mysqli_query($db, "SELECT COUNT(*) AS CONT, A.*
FROM Taquilla.INGRESO_ASOCIADO AS A
WHERE $filtro
GROUP BY A.IAT_CIF_ASOCIADO, A.IA_FECHA_INGRESO
ORDER BY  A.IAT_CIF_ASOCIADO");
		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?> 
			<center><h4>Ingreso Asociados 
<?php echo $texto ?></h4></center>
				<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th>
							<th><h5><strong>CIF</strong></h5></th>
							<th><h5><strong>NOMBRE</strong></h5></th>
							<th><h5><strong>TOTAL VISITAS</strong></h5></th>
							<th><h5><strong>TOTAL ACOMPAÑANTES</strong></h5></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Query))
							{
								if($ciftemp==-1){
									$ciftemp=$Fila["IAT_CIF_ASOCIADO"];
								}

								if($ciftemp== $Fila["IAT_CIF_ASOCIADO"]){
									$conteo +=1;
								}else{

									$QueryAco = mysqli_query($db, "SELECT COUNT(*) AS CONTA
									FROM Taquilla.INGRESO_ACOMPANIANTE AS A
									WHERE $filtro
									AND IAT_CIF_ASOCIADO = ".$ciftemp);
									$rowret=mysqli_fetch_array($QueryAco);

									$contAc=$rowret["CONTA"];
								 
								?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $ciftemp ?></h6></td>
										<td><h6><?php echo utf8_encode(saber_nombre_asociado_orden($ciftemp)) ?></h6></td>	 
										<td class="text-center"><h6><?php echo $conteo ?></h6></td>
										<td class="text-center"><h6><?php echo $contAc ?></h6></td>
									</tr>
								<?php
								$sumaConteo += $conteo;
								$sumaConteoAcom += $contAc;
								$conteo=0;
								$conteo +=1;
								$ciftemp=$Fila["IAT_CIF_ASOCIADO"];
								$Contador++;
								}
							}
							
							$QueryAco = mysqli_query($db, "SELECT COUNT(*) AS CONTA
							FROM Taquilla.INGRESO_ACOMPANIANTE AS A
							WHERE $filtro
							AND IAT_CIF_ASOCIADO = ".$ciftemp);
							$rowret=mysqli_fetch_array($QueryAco);

							$contAc=$rowret["CONTA"];
							?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $ciftemp ?></h6></td>
										<td><h6><?php echo utf8_encode(saber_nombre_asociado_orden($ciftemp)) ?></h6></td>	 
										<td class="text-center"><h6><?php echo $conteo ?></h6></td>
										<td class="text-center"><h6><?php echo $contAc ?></h6></td>
									</tr>
								<?php
								$sumaConteo += $conteo;
								$sumaConteoAcom += $contAc;
								$conteo=0;
								$Contador++;
						?>
						
						<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td><h3>Total</h3></td>
							<td align="center"><h3><?php echo $sumaConteo ?></h3></td>
							<td align="center"><h3><?php echo $sumaConteoAcom ?></h3></td>
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
 