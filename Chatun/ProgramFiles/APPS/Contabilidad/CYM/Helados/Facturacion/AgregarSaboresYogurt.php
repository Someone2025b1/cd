<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
	
	$Contado = 1;
	$Contado1 = $_POST["Cantidad"];
	$Fila = $_POST["Fila"];
	$CodigoR = $_POST["CodigoR"];
	
	for($i=0; $i<$Contado; $i++)

	{
		$Sel .= "<div class='form-group'>";
		$Sel .= '<select name="TipoYogurt[]" id="TipoYogurt[]" data="'.$Fila.'" class="form-control" required onchange="AgregarNombreYogurt(this)">';
		$Sel .= "<option value='' selected disabled>Seleccione una Opción</option>";


		$QueryS = "SELECT * FROM Productos.PRODUCTO WHERE P_NOMBRE LIKE '%BARRA%' AND P_HELADOS = 1 ORDER BY P_NOMBRE";
		$ResultS = mysqli_query($db, $QueryS);
		while($FilaS = mysqli_fetch_array($ResultS))
		{
			$Nombre =$FilaS["P_NOMBRE"];
			$Sel .= '<option value="'.$FilaS["P_CODIGO"].'">'.$Nombre.'</option>';
		}

		$Sel .= "</select>";
		$Sel .= "<label>Seleccione Tipo de Yogurt";
		$Sel .= "</div>";
	}

	for($i=0; $i<$Contado1; $i++)

	{
		$Sel .= "<div class='form-group'>";
		$Sel .= '<select name="TipoYogurt[]" id="TipoYogurt[]" data="'.$Fila.'" class="form-control" required onchange="AgregarNombreYogurt(this)">';
		$Sel .= "<option value='' selected disabled>Seleccione una Opción</option>";


		$QueryS = "SELECT * FROM Productos.PRODUCTO WHERE P_NOMBRE LIKE '%FRUTA SARITA%' AND P_HELADOS = 1 ORDER BY P_NOMBRE";
		$ResultS = mysqli_query($db, $QueryS);
		while($FilaS = mysqli_fetch_array($ResultS))
		{
			$Nombre = str_replace('FRUTA SARITA', '', $FilaS["P_NOMBRE"]);
			$Sel .= '<option value="'.$FilaS["P_CODIGO"].'">'.$Nombre.'</option>';
		}

		$Sel .= "</select>";
		$Sel .= "<label>Seleccione Tipo de Fruta";
		$Sel .= "</div>";
	}

	echo $Sel;
?>