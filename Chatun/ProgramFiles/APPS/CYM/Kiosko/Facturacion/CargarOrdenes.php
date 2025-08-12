<?php
	include("../../../../../Script/seguridad.php");
	include("../../../../../Script/conex.php");
	
	$Sql_Mesas = mysqli_query($db, "SELECT A.*, B.*, CONCAT(C.primer_nombre,' ', C.primer_apellido) AS NOMBRE, IF(A.M_TIPO_ORDEN = 1, 'PARA COMER AQUÍ', IF(A.M_TIPO_ORDEN IS NULL, '', 'PARA LLEVAR')) AS TIPO_ORDEN
							FROM Bodega.MESA_CA AS A
							INNER JOIN Bodega.MESA_ESTADO AS B ON A.ME_CODIGO = B.ME_CODIGO
							LEFT JOIN info_colaboradores.Vista_Colaboradores_Nueva AS C ON A.M_CIF_ATIENDE = C.cif
							ORDER BY A.M_CODIGO");
	while($FilaMesa = mysqli_fetch_array($Sql_Mesas))
	{
		?>
			<a href="CrearOrdenNew.php?Mesa=<?php echo $FilaMesa["M_CODIGO"] ?>">
				<div class="col-md-4 col-sm-6">
					<div class="card">
						<div class="card-body no-padding">
							<div class="alert alert-callout alert-success no-margin">
								<h1 class="pull-right <?php if($FilaMesa["NOMBRE"] == ''){echo 'text-warning';}else{echo 'text-success';} ?>"></h1>
								<strong class="text-xxl"><b> <?php echo $FilaMesa["M_CODIGO"] ?></b></strong><br>
								<?php
									if($FilaMesa["ME_CODIGO"] != 1)
									{
										?>
											<span class="opacity-50"><strong><?php echo $FilaMesa["ME_ESTADO"] ?></strong></span>
											<br>
											<span class="opacity-50"><b><?php echo $FilaMesa["NOMBRE"] ?></b></span>
											<br>
											<span class="opacity-50"><b><?php echo $FilaMesa["TIPO_ORDEN"] ?></b></span>
										<?php
									}
									else
									{
										?>
											<span class="opacity-50"><strong><?php echo $FilaMesa["ME_ESTADO"]?></strong></span>
											<br>
											<span class="opacity-50"><b><?php echo $FilaMesa["TIPO_ORDEN"] ?></b></span>
										<?php
									}
								?>
							</div>
						</div><!--end .card-body -->
					</div><!--end .card -->
				</div>
			</a>
		<?php
	}
?>