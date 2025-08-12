<?php
include("../../../../../Script/funciones.php");
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

$Contador = 1;

?>

<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">

			<div class="card">
				<div class="card-body no-padding">
					<div class="margin-bottom-xxl">
						<h1 class="text-dark text-ultra-bold text-xxl text-light text-center no-margin">¡ORDENES LISTAS!</h1>
					</div>
					<ul class="list ui-sortable">
				
					<?php

					$QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_OBSERVACIONES
													FROM Bodega.FACTURA AS A 
													WHERE A.F_DESPACHADA <> 1
													AND A.F_REALIZADA = 1
													ORDER BY A.F_ORDEN ASC");
					while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
					{
						?>
							<li class="tile ui-sortable-handle text-center">
								<strong> <h3 class="text-warning text-xxxxl"><span class="text-warning fa fa-check"></span> ORDEN #<?php echo $FilaOrdenes["F_ORDEN"] ?></h3></strong>
							</li>
						<?php
					}

					$QueryOrdenes = mysqli_query($db,"SELECT A.F_CODIGO, A.F_ORDEN, A.F_OBSERVACIONES
													FROM Bodega.FACTURA_2 AS A 
													WHERE A.F_DESPACHADA <> 1
													AND A.F_REALIZADA = 1
													ORDER BY A.F_ORDEN ASC");
					while($FilaOrdenes = mysqli_fetch_array($QueryOrdenes))
					{
						?>
							<li class="tile ui-sortable-handle text-center">
								<strong> <h3 class="text-warning text-xxxxl"><span class="text-warning fa fa-check"></span> ORDEN #<?php echo $FilaOrdenes["F_ORDEN"] ?></h3></strong>
							</li>
						<?php
					}
					?>
					</ul>
				</div>
			</div>
		</div>
</div>