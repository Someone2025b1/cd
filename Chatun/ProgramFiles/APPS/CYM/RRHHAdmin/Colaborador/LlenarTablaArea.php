<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];






$Aspecto = "SELECT * FROM RRHH.ASPECTOS_EVALUAR WHERE ASPECTOS_EVALUAR.AR_CODIGO = 8 AND ASPECTOS_EVALUAR.A_CODIGO = ".$_POST["id"]." ORDER BY AR_CODIGO";
$resultAs = mysqli_query($db, $Aspecto);
while($roweas = mysqli_fetch_array($resultAs))
{
	$NombreAspecto=$roweas["ARE_NOMBRE"];
	$CodigoAspecto=$roweas["ARE_CODIGO"];
	$CodArea=8;
	


		$Variable .= '<tr>';
		
			$Variable .= '<td><h6><input type="Text" class="form-control" name="Aspecto8[]" id="Aspecto8[]"  style="width: 800px" value="'.$NombreAspecto.'"></h6></td>';
			$Variable .= '<input type="hidden" class="form-control" name="CodigoAspecto8[]" id="CodigoAspecto8[]" value="'.$CodigoAspecto.'">';
			$Variable .= ' <td><h6><input type="number" class="form-control" name="Punteo8[]" id="Punteo8[]" style="width: 50px" value="0" max="100" min="0" onChange="CalcularTotal('.$CodArea.')"></h6></td>';
			 
		$Variable .= '</tr>';
	}



echo $Variable;

?>
