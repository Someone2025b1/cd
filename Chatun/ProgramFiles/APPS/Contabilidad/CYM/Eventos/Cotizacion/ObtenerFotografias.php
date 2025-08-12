<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

?>
	<div id="myCarousel" class="carousel slide" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
	    <?php
	    	for ($i=0; $i < $Registros ; $i++) 
	    	{ 
	    		?>
					<li data-target="#myCarousel" data-slide-to="<?php echo $i ?>"></li>
	    		<?php		
	    	}
	    ?>
	  </ol>
	<div class="carousel-inner">
<?php

$Codigo =  $_POST[Codigo];

$Query = mysqli_query($db, "SELECT A.FR_OBSERVACIONES, A.FR_RUTA
						FROM Bodega.FOTOGRAFIA_RANCHO AS A
						INNER JOIN Bodega.RANCHO AS B ON A.R_REFERENCIA = B.R_REFERENCIA
						WHERE B.R_CODIGO = ".$Codigo);

$Registros = mysqli_num_rows($Query);
$Contador = 1;

while($Fila = mysqli_fetch_array($Query))
{
	if($Contador == 1)
	{
		$Texto = 'active';
	}
	else
	{
		$Texto = '';
	}
	?>
		<div class="item <?php echo $Texto ?>">
	      <img src="<?php echo '../Mantenimiento/'.$Fila[FR_RUTA] ?>">
	      <div class="carousel-caption">
	        <h3><?php echo $Fila[FR_OBSERVACIONES] ?></h3>
	      </div>
	    </div>
	<?php
	$Contador++;
}

?>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previa</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Siguiente</span>
  </a>
</div>
