<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Contador = 1;

$QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_OBSERVACIONES
								FROM Bodega.FACTURA AS A 
								WHERE A.F_REALIZADA = 0
								ORDER BY A.F_ORDEN ASC
								LIMIT 8");
while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
{
	if($Contador == 1)
	{
		?>
		<div class="row">
		<?php
	}
	?>
		<div class="col-lg-3">
			<div class="card">
				<div class="card-head">
					<header><strong>ORDEN #<?php echo $FilaOrdenes["F_ORDEN"] ?></strong></header>
				</div>
				<div class="card-body text-default-light">
					<ul class="list">
						<?php
							$QueryDetalle = mysqli_query($db,"SELECT A.FD_CANTIDAD, B.P_NOMBRE
															FROM Bodega.FACTURA_DETALLE AS A
															INNER JOIN Productos.PRODUCTO AS B ON A.RS_CODIGO = B.P_CODIGO
															WHERE A.F_CODIGO = '".$FilaOrdenes[F_CODIGO]."'");
							while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
							{
								?>
									<li class="tile">
										<a class="tile-content ink-reaction">
											<div class="tile-text"><b><?php echo number_format($FilaDetalle['FD_CANTIDAD'], 0).' - '.$FilaDetalle['P_NOMBRE'] ?></b></div>
										</a>
									</li>				
								<?php
							}
						?>
					</ul>
					<hr>
					<p><?php echo $FilaOrdenes['F_OBSERVACIONES'] ?></p>
				</div><!--end .card-body -->
				<div class="card-actionbar">
					<div class="card-actionbar-row">
						<button value="<?php echo $FilaOrdenes[F_CODIGO] ?>" onclick="Realizar(this.value)" type="button" class="btn ink-reaction btn-floating-action btn-lg btn-primary"><i class="fa fa-check"></i></button>
					</div>
				</div><!--end .card-actionbar -->
			</div>
		</div>
	<?php
	if($Contador == 4)
	{
		?>
		</div>
		<?php
		$Contador = 0;
	}

	$Contador++;
}
?>