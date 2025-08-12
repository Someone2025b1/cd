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
if ($fechaInicial!="" && $fechaFinal!="") 
{ 
	$texto = "de la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
} 
?>
<title>Detalle de Ventas 
<?php echo $texto ?></title>
<div class="row">
<br>
<br>
<br>
</div>
<div class="row">
<div class="col-lg-12">
	<?php
		$Query = mysqli_query($db, "SELECT b.DC_Adultos, b.DC_TotalAdulto, b.DC_Ninos, b.DC_TotalNino, b.DC_TotalMonto, c.H_NOMBRE
FROM Taquilla.CORTE_HOTEL a
INNER JOIN Taquilla.DETALLE_CORTE b ON a.CH_Id = b.CH_Id
INNER JOIN Taquilla.HOTEL c ON c.H_CODIGO = b.H_CODIGO
WHERE DATE(a.CH_Fecha) BETWEEN '$fechaInicial' AND '$fechaFinal' AND a.CH_Estado = 2");
		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?> 
			<center><h4>Detalle de Ventas <?php echo $texto ?></h4></center>
				<div id="myTable_wrapper" class="dataTables_wrapper "> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th> 
							<th><h5><strong>Hotel</strong></h5></th>
							<th><h5><strong>Total Adultos</strong></h5></th>
							<th><h5><strong>Total Q.</strong></h5></th>  
							<th><h5><strong>Total Niños</strong></h5></th>
							<th><h5><strong>Total Q.</strong></h5></th>  
							<th><h5><strong>Total Corte Q.</strong></h5></th> 
						</tr>
					</thead>
					<tbody>

						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Query))
							{
								 
								?>
									<tr>
										<td align="center"><h6><?php echo $Contador ?></h6></td>
										<td align="center"><h6><?php echo $Fila["H_NOMBRE"] ?></h6></td>  
										<td align="center"><h6><?php echo $Fila["DC_Adultos"] ?></h6></td>  
										<td align="center"><h6>Q. <?php echo $Fila["DC_TotalAdulto"] ?></h6></td>  
										<td align="center"><h6><?php echo $Fila["DC_Ninos"] ?></h6></td>  
										<td align="center"><h6>Q. <?php echo $Fila["DC_TotalNino"] ?></h6></td>  
										<td align="center"><h6>Q. <?php echo $Fila["DC_TotalMonto"] ?></h6></td>  
									</tr>
								<?php
								$sumaConteoN += $Fila["DC_TotalNino"];
								$sumaConteoA += $Fila["DC_TotalAdulto"];
								$sumaConteo += $Fila["DC_TotalMonto"];
								$Contador++;
							}
						?> 
						<tr>
							<td></td> 
							<td><h3>Total</h3></td>
							<td></td> 
							<td align="center"><h4>Q. <?php echo number_format($sumaConteoA,2)?></h4></td> 
							<td></td> 
							<td align="center"><h4>Q. <?php echo number_format($sumaConteoN,2)?></h4></td>
							<td align="center"><h4>Q. <?php echo number_format($sumaConteo,2)?></h4></td>
						</tr>
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
	$('#TblTicketsHotel1').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    }); 
	 
</script>