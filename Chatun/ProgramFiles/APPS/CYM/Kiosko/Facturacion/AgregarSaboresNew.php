<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
	$Contado = $_POST["Cantidad"];

	$CodigoR = $_POST["CodigoR"];
	for($i=0; $i<$Contado; $i++)

	{
		$Sel .= "<div class='form-group'>";
		$Sel .= '<select name="SaborHelado[]" id="SaborHelado[]" class="form-control" required>';
		$Sel .= "<option value='' selected disabled>Seleccione una Opción</option>";


		$QueryS = "SELECT * FROM Productos.PRODUCTO WHERE P_NOMBRE LIKE '%CUBETA%' AND P_CAFE = 1 ORDER BY P_NOMBRE";
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