<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");

include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$codigo = $_POST['Codigo'];

$acompaniante = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL where IAT_CIF_COLABORADOR = $id_user") or die("error en select asoc temporal".mysqli_error()); 

?>

<div class="container-fluid">
	<table class="table table-hover">
	    <thead>
	      <tr>
	        <th>Código de Ingreso</th>
	        <th>Pais</th>
	        <th>Departamento</th>
	        <th>Municipio</th>
	        <th>Enterado</th>
	        <th>Frecuencia</th>
	        <th>Busca</th>
	        <th>Télefono</th>
	        <th>Eliminar</th>
	      </tr>
	    </thead>
	    <tbody>
	    <?php
		    while($acompaniante_result = mysqli_fetch_array($acompaniante))
		    {
		    	if($acompaniante_result[IAT_DATOS] == 1)
		    	{
		    		if($acompaniante_result[IAT_ENTERADO] == 1)
		    		{
		    			$Enterado = 'Amigos o Familiares';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 2)
		    		{
		    			$Enterado = 'Radio';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 3)
		    		{
		    			$Enterado = 'Vallas Publicitarias';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 4)
		    		{
		    			$Enterado = 'Televisión';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 5)
		    		{
		    			$Enterado = 'Volantes';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 6)
		    		{
		    			$Enterado = 'Afiches';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 7)
		    		{
		    			$Enterado = 'Unidad Móvil';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 8)
		    		{
		    			$Enterado = 'Redes Sociales';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 9)
		    		{
		    			$Enterado = 'Página Web';
		    		}
		    		elseif($acompaniante_result[IAT_ENTERADO] == 10)
		    		{
		    			$Enterado = 'Otros';
		    		}

		    		if($acompaniante_result[IAT_FRECUENCIA_VISITA] == 1)
		    		{
		    			$Frecuencia = 'Semanal';
		    		}
		    		elseif($acompaniante_result[IAT_FRECUENCIA_VISITA] == 2)
		    		{
		    			$Frecuencia = 'Quincenal';
		    		}
		    		elseif($acompaniante_result[IAT_FRECUENCIA_VISITA] == 3)
		    		{
		    			$Frecuencia = 'Mensual';
		    		}
		    		elseif($acompaniante_result[IAT_FRECUENCIA_VISITA] == 4)
		    		{
		    			$Frecuencia = 'Trimestral';
		    		}
		    		elseif($acompaniante_result[IAT_FRECUENCIA_VISITA] == 5)
		    		{
		    			$Frecuencia = 'Semestral';
		    		}
		    		elseif($acompaniante_result[IAT_FRECUENCIA_VISITA] == 6)
		    		{
		    			$Frecuencia = 'Anual';
		    		}
		    		elseif($acompaniante_result[IAT_FRECUENCIA_VISITA] == 7)
		    		{
		    			$Frecuencia = 'Otros';
		    		}

		    		if($acompaniante_result[IAT_BUSQUEDA_CENTRO] == 1)
		    		{
		    			$Busca = 'Piscinas';
		    		}
		    		elseif($acompaniante_result[IAT_BUSQUEDA_CENTRO] == 2)
		    		{
		    			$Busca = 'Área Verde';
		    		}
		    		elseif($acompaniante_result[IAT_BUSQUEDA_CENTRO] == 3)
		    		{
		    			$Busca = 'Juegos Extremos';
		    		}
		    		elseif($acompaniante_result[IAT_BUSQUEDA_CENTRO] == 4)
		    		{
		    			$Busca = 'Tranquilidad';
		    		}
		    		elseif($acompaniante_result[IAT_BUSQUEDA_CENTRO] == 5)
		    		{
		    			$Busca = 'Área Deportiva';
		    		}
		    		elseif($acompaniante_result[IAT_BUSQUEDA_CENTRO] == 6)
		    		{
		    			$Busca = 'Amplitud';
		    		}
		    		elseif($acompaniante_result[IAT_BUSQUEDA_CENTRO] == 7)
		    		{
		    			$Busca = 'Otros';
		    		}
				    ?>
				      <tr>
				        <td><?php echo $acompaniante_result[IAT_CODIGO]?></td>
				        <td><?php echo saber_pais($acompaniante_result[IAT_SELECT_PAIS])?></td>
				        <td><?php echo saber_departamento($acompaniante_result[IAT_SELECT_DEPARTAMENTO])?></td>
				        <td><?php echo saber_municipio_nombre($acompaniante_result[IAT_SELECT_MUNICIPIO]) ?></td>
				        <td><?php echo $Enterado ?></td>
				        <td><?php echo $Frecuencia ?></td>
				        <td><?php echo $Busca ?></td>
				        <td><?php echo $acompaniante_result[IAT_TELEFONO]?></td>
				        <td><button type="button" class="btn btn-danger btn-sm" onclick="EliminarAcompanante(this.value)" value="<?php echo $acompaniante_result[IAT_CODIGO] ?>"><span class="glyphicon glyphicon-remove"></span></button></td>
				      </tr>
				     <?php 
		     	}
		     	else
		     	{
		     		?>
				      <tr>
				        <td><?php echo $acompaniante_result[IAT_CODIGO]?></td>
				        <td>---</td>
				        <td>---</td>
				        <td>---</td>
				        <td>---</td>
				        <td>---</td>
				        <td>---</td>
				        <td>---</td>
				        <td><button type="button" class="btn btn-danger btn-sm" onclick="EliminarAcompanante(this.value)" value="<?php echo $acompaniante_result[IAT_CODIGO] ?>"><span class="glyphicon glyphicon-remove"></span></button></td>
				      </tr>
				     <?php 
		     	}
		     }
	     ?>
	    </tbody>
	  </table>
  </div>