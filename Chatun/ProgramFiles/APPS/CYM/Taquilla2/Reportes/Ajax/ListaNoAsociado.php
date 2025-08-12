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
	$filtro = "MONTH(A.INA_FECHA_INGRESO) = $mesSelect AND YEAR(A.INA_FECHA_INGRESO) = $year";
	$texto = "Del mes ".$mesSelect." y del año ".$year;
}
elseif ($anio!="") 
{
	$filtro = "YEAR(A.INA_FECHA_INGRESO) = $anio";
	$texto = "Del año ".$anio;
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "A.INA_FECHA_INGRESO BETWEEN '$fechaInicial' AND '$fechaFinal'";
	$texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
}
elseif ($dia!="") 
{
	$filtro = "A.INA_FECHA_INGRESO = '$dia'";
	$texto = "Del día ".cambio_fecha($dia);
}
?>

<title>Ingreso de No Asociados 
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
FROM Taquilla.INGRESO_NO_ASOCIADO AS A
WHERE $filtro
ORDER BY A.INA_NOMBRE DESC");
		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?> 
				<center>
				<h4>Ingreso de No Asociados 
				<?php echo $texto ?></h4>
			</center>
			<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					    <thead>
					      <tr>
					        <th>#</th>
					        <th>Nombre</th>
					        <th>Pais</th>
					        <th>Departamento</th>
					        <th>Municipio</th>
					        <th>Teléfono</th>
					        <th>Fecha Ingreso</th> 
					      </tr>
					    </thead>
					    <tbody>
					    <?php 
					    	$contador =1 ;
					    	while($NoAsociadoResult = mysqli_fetch_array($Query))
					    	{
					    		$ExistenNoAsociados = $NoAsociadoResult['INA_CODIGO'];
					    		if($NoAsociadoResult['INA_PAIS'] == 79)
					    		{
					    			$SaberDepartamento = saber_departamento_honduras($NoAsociadoResult['INA_DEPARTAMENTO']);
					    			$SaberMunicipio = "";
					    		}
					    		if($NoAsociadoResult['INA_PAIS'] == 73)
					    		{
					    			$SaberDepartamento = saber_departamento($NoAsociadoResult['INA_DEPARTAMENTO']);
					    			$SaberMunicipio = saber_municipio_nombre($NoAsociadoResult['INA_MUNICIPIO']);
					    		}
					    		if($NoAsociadoResult['INA_PAIS'] == 54)
					    		{
					    			$SaberDepartamento = saber_departamento_salvador($NoAsociadoResult['INA_DEPARTAMENTO']);
					    			$SaberMunicipio = "";
					    		}
 
					    			
					    ?>
						   	<tr>
						   		<td><?php echo $contador++?></td>
						   		<td><?php echo $NoAsociadoResult['INA_NOMBRE']?></td>
						   		<td><?php echo saber_pais($NoAsociadoResult['INA_PAIS'])?></td>
						   		<td><?php echo $SaberDepartamento?></td>
						   		<td><?php echo $SaberMunicipio?></td> 
						   		<td class="text-center"><?php echo $NoAsociadoResult['INA_TELEFONO']?></td> 
						   		<td class="text-center"><?php echo cambio_fecha($NoAsociadoResult['INA_FECHA_INGRESO'])?></td>
						   	</tr>
					   <?php 
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
 