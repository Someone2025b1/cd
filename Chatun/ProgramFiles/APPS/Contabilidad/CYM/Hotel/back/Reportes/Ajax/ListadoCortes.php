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
	$Filtro = "AND  A.CH_Fecha BETWEEN '$fechaInicial' AND '$fechaFinal'";
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
		$Query = mysqli_query($db, "SELECT A.CH_Id, DATE(A.CH_Fecha) AS FECHA, A.CH_Total FROM Taquilla.CORTE_HOTEL A
		WHERE CH_Estado = 2 $Filtro
 ");
		$Registros = mysqli_num_rows($Query);

		if($Registros > 0)
		{
			?> 
			<center><h4>Inventario <?php echo $texto ?></h4></center>
				<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th> 
							<th><h5><strong>Identificador Corte</strong></h5></th>
							<th><h5><strong>Fecha Corte</strong></h5></th>
							<th><h5><strong>Total Corte</strong></h5></th>  
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
										<td><a target="_blank" href="../ImprimirCorte.php?Id=<?php echo $Fila[CH_Id]?>"><h6><?php echo $Fila["CH_Id"] ?></h6></a></td>  
										<td align="center"><h6><?php echo cambio_fecha($Fila["FECHA"]) ?></h6></td> 
										<td><h6>Q. <?php echo $Fila["CH_Total"] ?></h6></td>     
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
	$('#TblTicketsHotel1').DataTable({
        dom: 'Bfrtip',
        buttons: [
             'excel', 'pdf', 'print'
        ]
    }); 
	 
</script>