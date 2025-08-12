<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$codigo = $_POST['Codigo'];

$acompaniante = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_NO_ASOCIADO_TEMPORAL where INAT_CIF_COLABORADOR = $id_user") or die("error en select asoc temporal".mysqli_error()); 

?>

<div class="container-fluid">
	<table class="table table-hover">
	    <thead>
	      <tr>
	        <th>Código de Ingreso</th>
	        <th>Colaborador Ingreso</th>
	        <th>Fecha de Ingreso</th>
	        <th>Pais</th>
	        <th>Municipio</th>
	        <th>Adultos</th>
	        <th>Niños</th>
	        <th>Menor de 5 años</th>
	      </tr>
	    </thead>
	    <tbody>
	    <?php
	    	while($acompaniante_result = mysqli_fetch_array($acompaniante)){
	    ?>
	      <tr>
	        <td><?php echo $acompaniante_result[INAT_CODIGO]?></td>
	        <td><?php echo saber_nombre_asociado_orden($acompaniante_result[INAT_CIF_COLABORADOR]) ?></td>
	        <td><?php echo saber_pais($acompaniante_result[INAT_FECHA_INGRESO])?></td>
	        <td><?php echo saber_departamento($acompaniante_result[INAT_PAIS])?></td>
	        <td><?php echo saber_municipio($acompaniante_result[INAT_DEPARTAMENTO], $acompaniante_result[INAT_MUNICIPIO]) ?></td>
	        <td><?php echo $acompaniante_result[INAT_ADULTO]?></td>
	       	<td><?php echo $acompaniante_result[INAT_NINIO]?></td>
	       	<td><?php echo $acompaniante_result[INAT_NINIO_MENOR_5]?></td>
	      </tr>
	     <?php 
	     	}
	     ?>
	    </tbody>
	  </table>
	  <div align="center">
	  	<button class="btn btn-success" id="BtnGuardarIngresoNoAsociado">Ingresar</button>
	  </div>
  </div>