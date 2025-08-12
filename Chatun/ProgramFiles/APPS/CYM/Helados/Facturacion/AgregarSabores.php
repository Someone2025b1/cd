<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
	$Contado = $_POST["Cantidad"];
	$Fila = $_POST["Fila"];
	for($i=0; $i<$Contado; $i++)

	{
		$Sel .= "<div class='form-group'>";
		$Sel .= '<select name="SaborHelado[]" id="SaborHelado[]" data="'.$Fila.'" class="form-control" required onchange="AgregarNombreSabor(this)">';
		$Sel .= "<option value='' selected disabled>Seleccione una Opción</option>";


		$QueryS = "SELECT * FROM Bodega.PRODUCTO WHERE P_NOMBRE LIKE '%CUBETA%' AND CP_CODIGO = 'HS' ORDER BY P_NOMBRE";
		$ResultS = mysqli_query($db, $QueryS);
		while($FilaS = mysqli_fetch_array($ResultS))
		{
			$Nombre = str_replace('CUBETA', '', $FilaS["P_NOMBRE"]);
			$Sel .= '<option value="'.$FilaS["P_CODIGO"].'">'.$Nombre.'</option>';
		}

		$Sel .= "</select>";
		$Sel .= "<label>Sabor de Bola No. ".($i + 1);
		$Sel .= "</div>";
	}

	echo $Sel;
?>