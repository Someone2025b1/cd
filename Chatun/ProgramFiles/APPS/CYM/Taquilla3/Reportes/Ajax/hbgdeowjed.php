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
}
elseif ($anio!="") 
{
	$filtro = "YEAR(A.IA_FECHA_INGRESO) = $year";
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "A.IA_FECHA_INGRESO BETWEEN '$fechaInicial' AND '$fechaFinal'";
}
elseif ($dia!="") 
{
	$filtro = "A.IA_FECHA_INGRESO = '$dia'";
}
?>
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
			<div align="center">
				<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar</button>
			</div>
			<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 	<thead>
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
										<td><h6><?php echo saber_nombre_asociado_orden($Fila["IAT_CIF_ASOCIADO"]) ?></h6></td>	 
										<td><h6><?php echo cambio_fecha($Fila["IA_FECHA_INGRESO"]) ?></h6></td>
										<td><h6><?php echo cambio_fecha($Fila["IA_HORA_INGRESO"]) ?></h6></td>
									</tr>
								<?php
								$Contador++;
							}
						?>
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
<script>
	 $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 $('#TblTicketsHotel').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    });
</script>