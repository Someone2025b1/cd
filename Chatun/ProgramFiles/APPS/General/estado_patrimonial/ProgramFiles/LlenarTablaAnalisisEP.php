<?php
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");

$FechaInicio = date('Y/m/d', strtotime($_POST["FechaInicio"]));
$FechaFinal = date('Y/m/d', strtotime($_POST["FechaFinal"]));

$Hoy = date('Y-m-d', strtotime('now'));

//Obtener CIF de todos los colaboradores activos
$Consulta = "SELECT id FROM info_bbdd.usuarios_general WHERE estado=1 ORDER BY id";
$Resultado = mysqli_query($db, $Consulta);
while($row = mysqli_fetch_array($Resultado))
{
	$ID = $row["id"];

	//Saber la fecha más cercana a la fecha de inicio
	$Consulta1 = "SELECT fecha FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha BETWEEN '".$FechaInicio."' AND '".$FechaFinal."') AND (id = ".$ID.") ORDER BY fecha ASC LIMIT 1";
	$Resultado1 = mysqli_query($db, $Consulta1);
	while($row1 = mysqli_fetch_array($Resultado1))
	{
		$FechaI = $row1["fecha"];
	}  

	//Saber la fecha más cercana a la fecha final
	$Consulta2 = "SELECT fecha FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha BETWEEN '".$FechaInicio."' AND '".$FechaFinal."') AND (id = ".$ID.") ORDER BY fecha DESC LIMIT 1";
	$Resultado2 = mysqli_query($db, $Consulta2);
	while($row2 = mysqli_fetch_array($Resultado2))
	{
		$FechaF = $row2["fecha"];
	}    

	//Saber la fecha de ingreso del colaborador
	$ConsultaFechaIngreso  = "SELECT fecha_ingreso FROM info_colaboradores.datos_laborales WHERE cif = '".$ID."'";
	$ResultadoFechaIngreso = mysqli_query($db, $ConsultaFechaIngreso);
	while($Fila = mysqli_fetch_array($ResultadoFechaIngreso))
	{
		$FechaIngreso = $Fila["fecha_ingreso"];
	}

	//Si la fecha de ingreso es mayor que la fecha de inicio de los cálculos que despliege mensaje de no aplica
	if($FechaIngreso > $FechaInicio)
	{
		$Output .= '<tr>';
		$Output .= '<td style="font-size: 12px">'.$ID.'</td>';
		$Output .= '<td style="font-size: 12px">'.utf8_encode(saber_nombre_colaborador($ID)).'</td>';
		$Output .= '<td style="font-size: 12px">'.saber_puesto($ID).'</td>';
		$Output .= '<td style="font-size: 12px; background-color: #A9D0F5"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px; background-color: #A9D0F5"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px; background-color: #A9D0F5"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px; background-color: #A9F5BC"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px; background-color: #A9F5BC"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px; background-color: #A9F5BC"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px"><b>N/A FI<FV </b></td>';
		$Output .= '<td style="font-size: 12px"><b>N/A FI<FV </b></td>';
		$Output .= '</tr>';
	}
	//Si la fecha de ingreso es menor o igual a la fecha de inicio que realice los cálculos
	else
	{
		//Saber la cantidad de estados patrimoniales que ha registrado el colaborador
		$SqlRegistros  = "SELECT COUNT(id) AS CANTIDAD_RESGISTROS FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE id = '".$ID."' AND fecha BETWEEN '".$FechaI."' AND '".$FechaF."'";
		$ResultadoRegistros = mysqli_query($db, $SqlRegistros);
		while($FilaRegistros = mysqli_fetch_array($ResultadoRegistros))
		{
			$EstadosPatrimoniales = $FilaRegistros["CANTIDAD_RESGISTROS"];
		}

		//Si la cantidad de estados patrimoniales es mayor a 1 que realice todos los cálculos
		if($EstadosPatrimoniales > 1)
		{
			$Consulta3 = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha = '".$FechaI."') AND (id = ".$ID.") ORDER BY fecha ASC LIMIT 1";
			$Resultado3 = mysqli_query($db, $Consulta3);
			while($row3 = mysqli_fetch_array($Resultado3))
			{
				$RActivo1 = $row3["total_activo"];
				$RPasivo1 = $row3["total_pasivo"];
				$RPatrimonio1 = $row3["patrimonio"];

			}

			$Consulta4 = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha = '".$FechaF."') AND (id = ".$ID.") ORDER BY fecha DESC LIMIT 1";
			$Resultado4 = mysqli_query($db, $Consulta4);
			while($row4 = mysqli_fetch_array($Resultado4))
			{
				$RActivo2 = $row4["total_activo"];
				$RPasivo2 = $row4["total_pasivo"];
				$RPatrimonio2 = $row4["patrimonio"];

			}

			$IncreDecrePatrimonio = $RPatrimonio2 - $RPatrimonio1;

			if($IncreDecrePatrimonio >=500000)
			{  
				$NotaIncreDecrePatri=10; 
			}
			else
			{ 
				if($IncreDecrePatrimonio >=80000)
				{
					$NotaIncreDecrePatri=((500000 - 80000)*(10-2)) / (( 500000 - 80000) + 2);
				}
				else
				{  
					$NotaIncreDecrePatri=1; 
				}
			}

			if($RActivo1 != 0)
			{
				$ResultadoActivo = $RActivo2/$RActivo1;
			}

			if($ResultadoActivo > 2)
			{ 
				$NotaCrecimientos2=10; 
			}
			else
			{
				if($ResultadoActivo >=1.333)
				{ 
					$NotaCrecimientos2= (($ResultadoActivo -1)*10); 
				}
				else
				{  
					$NotaCrecimientos2=1;
				}
			}

			$TotalRiesgo = $NotaCrecimientos2 * $NotaIncreDecrePatri;

			$Nombre = saber_nombre_colaborador($ID);
			$Puesto = saber_puesto($ID);
			

			$Output .= '<tr>';
			$Output .= '<td style="font-size: 12px">'.$ID.'</td>';
			$Output .= '<td style="font-size: 12px">'.utf8_encode(saber_nombre_colaborador($ID)).'</td>';
			$Output .= '<td style="font-size: 12px">'.saber_puesto($ID).'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9D0F5">'.number_format($RActivo1, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9D0F5">'.number_format($RPasivo1, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9D0F5">'.number_format($RPatrimonio1, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9F5BC">'.number_format($RActivo2, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9F5BC">'.number_format($RPasivo2, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9F5BC">'.number_format($RPatrimonio2, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px">'.number_format($IncreDecrePatrimonio, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px">'.number_format($NotaIncreDecrePatri, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px">'.number_format($ResultadoActivo, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px">'.number_format($NotaCrecimientos2, 2, '.', ',').'</td>';
			if($TotalRiesgo >= 51)
			{
				$Output .= '<td class="label-danger" style="font-size: 12px">'.number_format($TotalRiesgo, 2, '.', ',').'</td>';

				$sql_id = "SELECT  max(id_alerta)as conteo FROM coosajo_rti.asignacion_tareas_alertas WHERE codigo_alerta=9995 limit 1  ";
				$result_id = mysqli_query($db, $sql_id) or die("109".mysqli_error());
				$row_id=mysqli_fetch_array($result_id);
				$conteo=$row_id[0]; 

				$conteo++;

				$Consulta5 = "SELECT COUNT(id_alerta) AS Alertas FROM coosajo_rti.asignacion_tareas_alertas WHERE (codigo_alerta = 9995) AND (fecha = '".$Hoy."') AND (cif_asociado = ".$ID.")";
				$Resultado5 = mysqli_query($db, $Consulta5);
				while($row5 = mysqli_fetch_array($Resultado5))
				{
					$Alertas = $row5["Alertas"];	
				}

				if($Alertas == 0)
				{
					$sql_gra_alerta    = "INSERT INTO coosajo_rti.asignacion_tareas_alertas VALUES (NULL, 13418, 9995, now(), 1, '0000-00-00', 'Cif:', '$ID', 'Nombre: ', '$Nombre', 'Puesto: ', '$Puesto', 'Tipo de Alerta  :', 'ESTADO PATRIMONIAL', 'Total de Riesgo:', '$TotalRiesgo', 'Perido A', '$FechaInicio', 'Periodo B', '$FechaFinal', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',   NULL, NULL, $ID);";
					$result_gra_alerta = mysqli_query($db, $sql_gra_alerta) or die("289".mysqli_error());
					
					$sql_reporte       = "INSERT INTO Estado_Patrimonial.reporte_empleados_riesgo (id, cif, nombre, puesto, total_riesgo, fecha, periodo_a, periodo_b , colaborador ) VALUES (NULL, '$ID', '$Nombre', '$Puesto', '$TotalRiesgo', now(), '$FechaInicio', '$FechaFinal', $ID)ON DUPLICATE KEY UPDATE total_riesgo='$TotalRiesgo';";  
					$result_reporte    = mysqli_query($db, $sql_reporte) or die("293".mysqli_error());
				}
			}
			elseif($TotalRiesgo >= 31 && $TotalRiesgo <= 50)
			{
				$Output .= '<td class="label-warning" style="font-size: 12px">'.number_format($TotalRiesgo, 2, '.', ',').'</td>';
			}
			elseif($TotalRiesgo >= 0 && $TotalRiesgo <= 30)
			{
				$Output .= '<td style="font-size: 12px">'.number_format($TotalRiesgo, 2, '.', ',').'</td>';
			}
			
			$Output .= '</tr>';
			
		}
		else
		{
			$Consulta4 = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.estado_patrimonial_detalle WHERE (fecha = '".$FechaF."') AND (id = ".$ID.") ORDER BY fecha DESC LIMIT 1";
			$Resultado4 = mysqli_query($db, $Consulta4);
			while($row4 = mysqli_fetch_array($Resultado4))
			{
				$RActivo2 = $row4["total_activo"];
				$RPasivo2 = $row4["total_pasivo"];
				$RPatrimonio2 = $row4["patrimonio"];

			}
			
			$Output .= '<tr>';
			$Output .= '<td style="font-size: 12px">'.$ID.'</td>';
			$Output .= '<td style="font-size: 12px">'.utf8_encode(saber_nombre_colaborador($ID)).'</td>';
			$Output .= '<td style="font-size: 12px">'.saber_puesto($ID).'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9D0F5"><b>N/A EP<1 </b></td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9D0F5"><b>N/A EP<1 </b></td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9D0F5"><b>N/A EP<1 </b></td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9F5BC">'.number_format($RActivo2, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9F5BC">'.number_format($RPasivo2, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px; background-color: #A9F5BC">'.number_format($RPatrimonio2, 2, '.', ',').'</td>';
			$Output .= '<td style="font-size: 12px"><b>N/A EP<1 </b></td>';
			$Output .= '<td style="font-size: 12px"><b>N/A EP<1 </b></td>';
			$Output .= '<td style="font-size: 12px"><b>N/A EP<1 </b></td>';
			$Output .= '<td style="font-size: 12px"><b>N/A EP<1 </b></td>';
			$Output .= '<td style="font-size: 12px"><b>N/A EP<1 </b></td>';
			$Output .= '</tr>';
		}

	}


}

echo $Output;

?>