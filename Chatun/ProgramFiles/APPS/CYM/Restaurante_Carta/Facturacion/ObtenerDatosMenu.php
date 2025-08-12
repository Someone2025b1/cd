<?php
include("../../../../../Script/conex.php");

	$query = "SELECT CATEGORIA_MENU.CM_NOMBRE, CATEGORIA_MENU.CM_CODIGO 
																FROM Bodega.CATEGORIA_MENU, Bodega.RECETA_SUBRECETA
																WHERE CATEGORIA_MENU.CM_CODIGO = RECETA_SUBRECETA.CM_CODIGO
																AND RECETA_SUBRECETA.RS_TIPO = 1
																AND RECETA_SUBRECETA.RS_BODEGA = 'TR'
																GROUP BY RECETA_SUBRECETA.CM_CODIGO";
	$result = mysqli_query($db, $query);
	while($row = mysqli_fetch_array($result))
	{
		?>
			<div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <a onClick="AbrirModalResultados(<?php echo $row["CM_CODIGO"]; ?>)" style="text-decoration: none; cursor: pointer"><div><?php echo $row["CM_NOMBRE"] ?></div></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		<?php
	}
?>
