<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
#include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$Mes = date('m', strtotime(now));
$Anho = date('Y', strtotime(now));



$i = 1;
$query = mysqli_query($db, "SELECT * FROM Taquilla.INGRESO_ASOCIADO_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user) or die("error".mysqli_error());
$RegistrosAsociados = mysqli_num_rows($query);
if($RegistrosAsociados > 0)
{
	while($fila = mysqli_fetch_array($query))
	{
		$PuntosDisponibles = 0;
		
		$Codigo = $fila["IAT_CODIGO"];
		$CIF_ASOCIADO = $fila["IAT_CIF_ASOCIADO"];


		$params = array();
		$options =  array( 'Scrollable' => SQLSRV_CURSOR_KEYSET );
		#$QueryAhorros = sqlsrv_query($db_sql, "SELECT * FROM OPENQUERY(BANKWORKS, 'SELECT CAPSALDACTUAL FROM CAPCUENTAS WHERE CAPCODCLIENTE = ''".$CIF_ASOCIADO."'' GROUP BY CAPSALDACTUAL HAVING SUM(CAPSALDACTUAL) >= 1000')", $params, $options);
		$RegistrosAhorros = sqlsrv_num_rows($QueryAhorros);

		// $QueryAhorros = mysqli_query($dbc, "SELECT capsaldactual FROM bankworks.capcuentas WHERE capcodcliente = '".$CIF_ASOCIADO."' GROUP BY capsaldactual HAVING SUM(capsaldactual) >= 500");
		//$RegistrosAhorros = mysqli_num_rows($QueryAhorros);

		//AHORROS
		
		$sql = 'SELECT SUM("CAPSALDACTUAL") AS SaldoTotal
        FROM "Chatun"."dbo"."CAPCUENTAS"
        WHERE "CAPCODCLIENTE" = '. $CIF_ASOCIADO;

			$resultado = sqlsrv_query($db_sql, $sql);

			if ($resultado === false) {
				die(print_r(sqlsrv_errors(), true));
			}

			$fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
			$suma = floatval($fila['SaldoTotal']);

			if ($suma > 1000) {
				$PuntosDisponibles =$PuntosDisponibles + 4;
			}

// CREDITO

$sqlC = 'SELECT SUM("COLDIASMORA") AS DiasTotal
        FROM "Chatun"."dbo"."COLDOCUMENTO"
        WHERE "COLCODCLIENTE" = ' . $CIF_ASOCIADO;

			$resultadoC = sqlsrv_query($db_sql, $sqlC);

			if ($resultadoC === false) {
				die(print_r(sqlsrv_errors(), true));
			}
			
			$fila = sqlsrv_fetch_array($resultadoC, SQLSRV_FETCH_ASSOC);

			if ($fila && isset($fila['DiasTotal']) && $fila['DiasTotal'] !== null) {
				$DiasMora = floatval($fila['DiasTotal']);
				
				if ($DiasMora == 0) {
					$PuntosDisponibles += 4;
				}
			}
			
		

		#$QueryColocaciones = sqlsrv_query($db_sql, "SELECT * FROM OPENQUERY(BANKWORKS, 'SELECT COLCODCLIENTE, COLDIASMORA FROM COLDOCUMENTO WHERE COLCODCLIENTE = ".$CIF_ASOCIADO." AND COLESTADODOC = ''A''')", $params, $options);
		#$RegistrosColocaciones = sqlsrv_num_rows($QueryColocaciones);

		// $QueryColocaciones = mysqli_query($dbc, "SELECT colcodcliente FROM bankworks.coldocumento WHERE colcodcliente = ".$CIF_ASOCIADO." AND colestadodoc = 'A'");
		// $RegistrosColocaciones = mysqli_num_rows($QueryColocaciones);
		#if($RegistrosColocaciones > 0)
		#{
			#$FilaColocaciones = mysqli_fetch_array($QueryColocaciones);



			#if($FilaColocaciones["coldiasmora"] == 0)
			#{
			#	$PuntosDisponibles += 6;
			#}
			#else
			#{
			#	$PuntosDisponibles += 0;
		#	}

		#}
		#$Name = mysqli_query($dbc, "SELECT a.cifcodcliente, a.cifdocident02, a.cifsexo, a.cifdocident06, a.cifdocident03 FROM bankworks.cif_generales a WHERE a.cifcodcliente = '$Criterio'") or die("error en buscar cif en condiciones diarias");
		#$NameResul = mysqli_fetch_array($Name);

		$QueryTotalIngresosMes = mysqli_query($db, "SELECT COUNT(*) AS TOTAL FROM Taquilla.INGRESO_ACOMPANIANTE WHERE MONTH(IA_FECHA_INGRESO) = ".$Mes." AND YEAR(IA_FECHA_INGRESO) = ".$Anho." AND IAT_CIF_ASOCIADO = ".$CIF_ASOCIADO);
		$FilaTotalIngresos = mysqli_fetch_array($QueryTotalIngresosMes);
		$IngresosMes = $FilaTotalIngresos["TOTAL"];

		$QueryIngresosTemporales = mysqli_query($db, "SELECT COUNT(*) AS TOTAL FROM Taquilla.INGRESO_ACOMPANIANTE_TEMPORAL WHERE IAT_CIF_COLABORADOR = ".$id_user." AND IAT_CIF_ASOCIADO = ".$CIF_ASOCIADO);
		$FilaIngresosTemporales = mysqli_fetch_array($QueryIngresosTemporales);
		$IngresoTemporal = $FilaIngresosTemporales["TOTAL"];

		$PuntosDisponibles = ($PuntosDisponibles - $IngresosMes) - $IngresoTemporal;
		$Observaciones = mysqli_fetch_array(mysqli_query($db, "SELECT a.IA_OBSERVACIONES FROM Taquilla.INGRESO_ASOCIADO a WHERE a.IAT_CIF_ASOCIADO =  $CIF_ASOCIADO"));
		$Obser = $Observaciones["IA_OBSERVACIONES"];

		#Lista Negra Parcial
		$QueryLN2 = mysqli_query($db, "SELECT * FROM Taquilla.LISTA_NEGRA WHERE LN_ESTADO = 1 AND LN_TIPO ='P' AND LN_CIF_ASOCIADO = ".$CIF_ASOCIADO);
			$RegistrosLN2 = mysqli_num_rows($QueryLN2);

			if($RegistrosLN2 > 0)
			{
				$PuntosDisponibles = 0;
				$Obser = "El Asociado esta en Lista Negra Parcial, Membrecia Inhabilitada (solo el puede ingresar)";
			}


		$Variable .= '<tr>';
			$Variable .= '<td>'.$i.'</td>';
			$Variable .= '<td>'.$CIF_ASOCIADO.'</td>';
			$Variable .= '<td>'.saber_nombre_asociado($fila['IAT_CIF_ASOCIADO']).'</td>';
			$Variable .= '<td align="left" style="font-size: 20px"><input type="hidden"  id="InputPUntosDisponibles" value="'.$PuntosDisponibles.'"></input><span class="label label-success" id="LabelPuntosDisponibles">'.$PuntosDisponibles.'</span></td>';
			if($PuntosDisponibles == 0)
			{
				$Variable .= '<td align="left"><button class="btn btn-success btn-sm"  value="'.$CIF_ASOCIADO.'" disabled><span class="fa fa-group"></span></button></td>';	
				$Variable .= '<td align="left"><button class="btn btn-success btn-sm"  value="'.$CIF_ASOCIADO.'" onclick="AgregarAcompananteMenor(this.value)"><span class="bi bi-balloon-fill"></span></button></td>';
				$Variable .= '<td align="center"><button class="btn btn-info btn-sm" value="'.$Codigo.'" disabled><span class="glyphicon glyphicon-eye-open"></span></button></td>';
				$Variable .= '<td align="center"><button class="btn btn-danger btn-sm" value="'.$Codigo.'" onclick="EliminarAsociado(this.value)"><span class="glyphicon glyphicon-remove"></span></button></td>';
			}
			elseif($PuntosDisponibles > 0)
			{
				$Variable .= '<td align="left"><button class="btn btn-success btn-sm"  value="'.$CIF_ASOCIADO.'" onclick="AgregarAcompanante(this.value)"><span class="fa fa-group"></span></button></td>';
				$Variable .= '<td align="left"><button class="btn btn-success btn-sm"  value="'.$CIF_ASOCIADO.'" onclick="AgregarAcompananteMenor(this.value)"><span class="bi bi-balloon-fill"></span></button></td>';
				$Variable .= '<td align="center"><button class="btn btn-info btn-sm" value="'.$Codigo.'" onclick="MostrarAcompaniante(this.value)"><span class="glyphicon glyphicon-eye-open"></span></button></td>';
				$Variable .= '<td align="center"><button class="btn btn-danger btn-sm" value="'.$Codigo.'" onclick="EliminarAsociado(this.value,'.$CIF_ASOCIADO.')"><span class="glyphicon glyphicon-remove"></span></button></td>';
			}
			$Variable .= '<td align="center"><button class="btn btn-warning btn-sm" value="'.$CIF_ASOCIADO.'" onclick="VerIngresosActual(this.value)"><span class="glyphicon glyphicon-search"></span></button></td>';
			$Variable .= '<td align="center"><textarea name="observaciones" id="observaciones" cols="30" rows="5" placeholder="Describa una observación" class="form-control">'.$Obser.'</textarea></td>';
			 
		$Variable .= '</tr>';
		$i++;
	}
}
else
{
	$Variable .= '<tr><td colspan="7"><div class="alert alert-warning text-center">
		<strong>No existen Asociados Agregados!</strong>
	</div></td></tr>';
}
echo $Variable;


?>
