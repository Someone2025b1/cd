<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$CIF = $_POST[CIF];

$Mes = date('m', strtotime(now));
$Anho = date('Y', strtotime(now));

$Query = mysqli_query($db, "SELECT A.IAT_CIF_ASOCIADO, A.IA_FECHA_INGRESO, A.IA_HORA_INGRESO, (SELECT COUNT(*) FROM Taquilla.INGRESO_ACOMPANIANTE AS B WHERE B.IA_REFERENCIA = A.IA_REFERENCIA) AS ACOMPANIANTES
						FROM Taquilla.INGRESO_ASOCIADO AS A
						WHERE MONTH(A.IA_FECHA_INGRESO) = ".$Mes." 
						AND YEAR(A.IA_FECHA_INGRESO) = ".$Anho."
						AND A.IAT_CIF_ASOCIADO = ".$CIF);
$Registros = mysqli_num_rows($Query);

if($Registros > 0)
{
	?>
		<table class="table table-hover table-condensed">
			<thead>
				<tr>
					<th>FECHA INGRESO</th>
					<th>ACOMPAÑANTES</th>
				</tr>
			</thead>
			<tbody>
			<?php
				while($Fila = mysqli_fetch_array($Query))
				{
					?>
						<tr>
							<td><?php echo date('d-m-Y', strtotime($Fila[IA_FECHA_INGRESO])).' '.$Fila[IA_HORA_INGRESO] ?></td>
							<td><?php echo $Fila[ACOMPANIANTES] ?></td>
						</tr>
					<?php
				}
			?>
			</tbody>
		</table>
	<?php
}
else
{
	?>
		<div class="alert alert-warning texxt-center">
			<strong>El asociado no ha tenido ingresos en el mes</strong>
		</div>
	<?php
}
?>
