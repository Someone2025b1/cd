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
		$Query = mysqli_query($db, "SELECT a.H_CODIGO, a.H_NOMBRE, c.ATT_DEL, c.ATT_AL FROM Taquilla.HOTEL a  
INNER JOIN Taquilla.ASIGNACION_TALONARIO_TICKET c ON c.H_CODIGO = a.H_CODIGO 
WHERE c.ATT_FECHA BETWEEN '$fechaInicial' AND '$fechaFinal'
GROUP BY a.H_CODIGO
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
							<th><h5><strong>Hotel</strong></h5></th>
							<th><h5><strong>Vales Disponibles</strong></h5></th> 
						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Query))
							{
								if ($Disponible["Disponibles"]<10) 
									{
										$text = 'style="color: #ff0000; background: white;"';
									}
									else
									{
										$text = '';
									}
								 $Disponible = mysqli_fetch_array(mysqli_query($db, "SELECT COUNT(*) AS Disponibles FROM Taquilla.DETALLE_ASIGNACION_VALE a WHERE a.H_CODIGO = $Fila[H_CODIGO]  AND a.DAV_ESTADO = 1"));
								?>
									<tr <?php echo $text ?>>
										<td align="center"><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $Fila["H_NOMBRE"] ?></h6></td>  
										<td align="center"><h6><?php echo $Disponible["Disponibles"] ?></h6></td>      
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
 