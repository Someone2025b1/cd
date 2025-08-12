<?php
function fecha_con_mes($f) {
	$mes = "";
	$g = str_replace("/", "-",$f);
	$desglose=explode("-", $g);
	switch($desglose[1]) {
		case 1:
			$mes = "Enero";
			break;
		case 2:
			$mes = "Febrero";
			break;
		case 3:
			$mes = "Marzo";
			break;
		case 4:
			$mes = "Abril";
			break;
		case 5:
			$mes = "Mayo";
			break;
		case 6:
			$mes = "Junio";
			break;
		case 7:
			$mes = "Julio";
			break;
		case 8:
			$mes = "Agosto";
			break;
		case 9:
			$mes = "Septiembre";  
			break;
		case 10:
			$mes = "Octubre";
			break;
		case 11:
			$mes = "Noviembre";
			break;
		case 12:
			$mes = "Diciembre";
			break;		
	}
	$resultado=$desglose[2]."-".$mes."-".$desglose[0];
	return $resultado;
}

function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}


function NombreProducto($IdProd) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT a.P_NOMBRE FROM Bodega.PRODUCTO a WHERE a.P_CODIGO = '$IdProd'"));
	$NombreP = $tmp_sql[0];
	return $NombreP;
}

function NombreCombo($IdProd) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT a.C_Nombre FROM Bodega.COMBO a WHERE a.C_Id = '$IdProd'"));
	$NombreP = $tmp_sql[0];
	return $NombreP;
}

function NombreEscala($IdProd) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT b.P_NOMBRE FROM Bodega.ESCALA_PRODUCTO a 
	INNER JOIN Bodega.PRODUCTO b ON a.P_CODIGO = b.P_CODIGO
	WHERE a.IdEscala = '$IdProd'"));
	$NombreP = $tmp_sql[0];
	return $NombreP;
}

function saber_nombre_asociado($cif_asociado) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.59.203", "userconex", "redhat12"), "SELECT cifnombreclie FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif_asociado'"));
	$nombre_asocido = $tmp_sql[0];
	return $nombre_asocido;
}

function diferencia_dias($fechainicio, $fechafin){
	$dias	= (strtotime($fechainicio)-strtotime($fechafin))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}

function CalculaEdad($fecha) {
   $fecha = str_replace("/","-",$fecha);
	list($d,$m,$Y) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function saber_pais($cod_pais) {
	if ($cod_pais > 0) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT pais FROM info_base.lista_paises_mundo WHERE id = $cod_pais "));
	$nombre_pais = $tmp_sql[0];
	return $nombre_pais;
	}
}

function saber_departamento($cod_depto) {
	if ($cod_depto > 0) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre_departamento FROM info_base.departamentos_guatemala WHERE id_departamento = $cod_depto "));
	$nombre_depto = $tmp_sql[0];
	return $nombre_depto;
	}
}

function saber_departamento_honduras($id_departamento) {
	if ($id_departamento > 0) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre_departamento from info_base.departamentos_honduras where id_departamento = $id_departamento "));
	$nombre_depto = $tmp_sql[0];
	return $nombre_depto;
	}
}

function saber_departamento_salvador($id_departamento) {
	if ($id_departamento > 0) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre_departamento from info_base.departamentos_el_salvador where id_departamento =  $id_departamento "));
	$nombre_depto = $tmp_sql[0];
	return $nombre_depto;
	}
}

function saber_municipio($cod_municipio, $cod_depto) {
	if ($cod_depto > 0) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = $cod_depto AND id_municipio = $cod_municipio "));
	$nombre_municipio = $tmp_sql[0];
	return $nombre_municipio;
	}
}
function saber_municipio_nombre($cod_municipio) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id = ".$cod_municipio));
	$nombre_municipio = $tmp_sql[0];
	return $nombre_municipio;
}

function saber_municipio_actu($cod_municipio, $cod_depto) {
	if ($cod_depto > 0) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = $cod_depto AND id = $cod_municipio "));
	$nombre_municipio = $tmp_sql[0];
	return $nombre_municipio;
	}
}

function saber_nacionalidad($cod_nacionalidad) {
	if ($cod_nacionalidad > 0) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nacionalidad FROM info_base.lista_nacionalidades WHERE id = $cod_nacionalidad "));
	$nombre_nacionalidad = $tmp_sql[0];
	return $nombre_nacionalidad;
	}
}

function saber_nombre_colaborador($cif_temp) {
	$tmp_sql1 = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre FROM info_bbdd.usuarios WHERE id_user = '$cif_temp'"));
	$nombre_colaborador = $tmp_sql1[0];
	return $nombre_colaborador;
}
function saber_agencia_colaborador($cif_temp) {
	$tmp_sql_agencia = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT num_agencia FROM info_bbdd.usuarios_general WHERE id ='$cif_temp'"));
	$agencia_colaborador = $tmp_sql_agencia[0];
	return $agencia_colaborador;
}

function saber_departamento_coosajo($cif_temp) {
	$tmp_sql1 = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT nombre_depto FROM info_base.departamentos, info_colaboradores.datos_laborales
WHERE departamentos.id_depto = datos_laborales.departamento
AND datos_laborales.cif = '$cif_temp'"));
	$nombre_depto_colaborador = $tmp_sql1[0];
	return $nombre_depto_colaborador;
}

function saber_departamentoid_coosajo($cif_temp) {
	$tmp_sql1 = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT id_depto FROM info_base.departamentos, info_colaboradores.datos_laborales
WHERE departamentos.id_depto = datos_laborales.departamento
AND datos_laborales.cif = '$cif_temp'"));
	$nombre_depto_colaborador = $tmp_sql1[0];
	return $nombre_depto_colaborador;
}

function saber_gerencia_coosajo($cif_temp) {
	$tmp_sql1 = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT gerencia FROM info_colaboradores.vista_colaboradores_idt WHERE cif = '$cif_temp'"));
	$nombre_gerencia_colaborador = $tmp_sql1[0];
	return $nombre_gerencia_colaborador;
}   

function saber_gerenciaid_coosajo($cif_temp) {
	$tmp_sql1 = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT gerencia FROM info_colaboradores.datos_laborales WHERE cif = '$cif_temp'"));
	$nombre_gerencia_colaborador = $tmp_sql1[0];
	return $nombre_gerencia_colaborador;
}  


function saber_nombre_agencia($id_agencia) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT agencia FROM info_base.agencias WHERE id_agencia = '$id_agencia'",mysqli_connect("10.138.41.61", "userconex", "@dm1n1tr@c10ndb.21")));
	$nombre_agencia = $tmp_sql[0];
	return $nombre_agencia;
}


function saber_puesto($cif_asociado) {

	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "select puesto from info_colaboradores.datos_laborales where cif = '$cif_asociado'"));
	$puesto_colaborador = $tmp_sql[0];
	return $puesto_colaborador;
}


function saber_puesto_nombre($cif_asociado) {

	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "select nombre_puesto from info_base.define_puestos where id_puesto = '$cif_asociado'"));
	$puesto_colaborador = $tmp_sql[0];
	return $puesto_colaborador;
}



function saber_nombre_bodega($bodega) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT B_NOMBRE FROM Bodega.BODEGA WHERE B_CODIGO = ".$bodega));
	$NombreBodega = $tmp_sql[0];
	return $NombreBodega;
}

function saber_nombre_producto($Producto) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT P_NOMBRE, CP_CODIGO FROM Bodega.PRODUCTO WHERE P_CODIGO = ".$Producto));
	$NombreProducto = $tmp_sql[0]." (".$tmp_sql[1].")";
	return $NombreProducto;
}

function saber_nombre_receta($Receta) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT A.RS_NOMBRE
FROM Bodega.RECETA_SUBRECETA AS A
WHERE A.RS_CODIGO = '".$Receta."'"));
	$NombreProducto = $tmp_sql[0];
	return $NombreProducto;
}

function getUltimoDiaMes($elAnio,$elMes) {
  return date("d",(mktime(0,0,0,$elMes+1,1,$elAnio)-1));
}

function fecha_para_contratos($fecha_contrato) {
	$g = str_replace("/", "-",$fecha_contrato);
	$desglose=explode("-", $g);

	switch($desglose[1]) {
		case 1:
			$mes = "Enero";
			break;
		case 2:
			$mes = "Febrero";
			break;
		case 3:
			$mes = "Marzo";
			break;
		case 4:
			$mes = "Abril";
			break;
		case 5:
			$mes = "Mayo";
			break;
		case 6:
			$mes = "Junio";
			break;
		case 7:
			$mes = "Julio";
			break;
		case 8:
			$mes = "Agosto";
			break;
		case 9:
			$mes = "Septiembre";  
			break;
		case 10:
			$mes = "Octubre";
			break;
		case 11:
			$mes = "Noviembre";
			break;
		case 12:
			$mes = "Diciembre";
			break;		
	}
	$resultado=$desglose[2]."-".$mes."-".$desglose[0];
	return $resultado;
}

function nombre_mes($mes) {

	switch($mes) {
		case 1:
			$NombreMes = "Enero";
			break;
		case 2:
			$NombreMes = "Febrero";
			break;
		case 3:
			$NombreMes = "Marzo";
			break;
		case 4:
			$NombreMes = "Abril";
			break;
		case 5:
			$NombreMes = "Mayo";
			break;
		case 6:
			$NombreMes = "Junio";
			break;
		case 7:
			$NombreMes = "Julio";
			break;
		case 8:
			$NombreMes = "Agosto";
			break;
		case 9:
			$NombreMes = "Septiembre";  
			break;
		case 10:
			$NombreMes = "Octubre";
			break;
		case 11:
			$NombreMes = "Noviembre";
			break;
		case 12:
			$NombreMes = "Diciembre";
			break;		
	}
	return $NombreMes;
}

function poner_comas($cantidad) {
	$desglose=explode(".",$cantidad);
	$n=$desglose[0];
	if ($desglose[1] == "") {
		$d="00";
	} else {
		$d=$desglose[1];
	}
	if (strlen($n) < 4) {
		$resultado=$n;
	} else {
		switch (strlen($n)) {
			case 4 :
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$resultado=$tmp_1.",".$tmp_2;
				break;
			case 5:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$resultado=$tmp_1.",".$tmp_2;
				break;
			case 6:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$resultado=$tmp_1.",".$tmp_2;
				break;
			case 7:
				$tmp_1=substr($n,0,1);
				$tmp_2=substr($n,1,3);
				$tmp_3=substr($n,4,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				break;
			case 8:
				$tmp_1=substr($n,0,2);
				$tmp_2=substr($n,2,3);
				$tmp_3=substr($n,5,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				break;
			case 9:
				$tmp_1=substr($n,0,3);
				$tmp_2=substr($n,3,3);
				$tmp_3=substr($n,6,3);
				$resultado=$tmp_1.",".$tmp_2.",".$tmp_3;
				break;
		} // end switch
	} // end if-else
	$resultado=$resultado.".".$d;		
	return $resultado;
}

function saber_nombre_asociado_orden($cif_asociado){ 
	include("conex_sql_server.php");
	$connectionInfo = array("UID"=>"aura","PWD"=>"aura","ColumnEncryption"=>"Enabled");
	$db_sql = sqlsrv_connect( $serverName, $connectionInfo);
	$params = array();
	$options =  array( 'Scrollable' => SQLSRV_CURSOR_KEYSET );

	

	$sql = 'SELECT "CIFCODCLIENTE", "CIFNOMBRECLIE", "CIFDOCIDENT02", "CIFDOCIDENT03", "CIFDOCIDENT06", "CIFSEXO" 
        FROM "Chatun"."dbo"."CIFGENERALES" 
        WHERE "CIFCODCLIENTE" = '.$cif_asociado;


	$prestamo1 = sqlsrv_query($db_sql, $sql, $params, $options) 
		or die("Error al buscar en Chatun directamente");
		$prestamo_result = sqlsrv_fetch_array($prestamo1);
		$nombre_asocido =$prestamo_result['CIFNOMBRECLIE'];
		return $nombre_asocido;
		
	}

	function saber_nombre_transaccion_contabilidad($Codigo) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT TT_NOMBRE FROM Contabilidad.TIPO_TRANSACCION WHERE TT_CODIGO = ".$Codigo,));
	$NombreTransaccion = $tmp_sql[0];
	return $NombreTransaccion;
}

function cambio_fecha($f) {
	$f = str_replace("/", "-",$f);
	$desglose=explode("-", $f);
	$resultado=$desglose[2]."-".$desglose[1]."-".$desglose[0];
	return $resultado;
}

function Saber_Edad_Asociado($cif) {
	$tmp_sql = mysqli_fetch_row(mysqli_query(mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"), "SELECT ciffecnacimie FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif'"));
	$FechaNacimiento = date('d-m-Y', strtotime($tmp_sql[0]));


	return CalculaEdad($FechaNacimiento);
}

function ObtenerMinimosMaximosSerie($Tipo, $Serie, $Fecha)
{
	if($Tipo == 'Del')
	{
		if($Serie == 'F1H')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA_HS AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
		elseif($Serie == 'F1R')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
		elseif($Serie == 'F1S')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA_SV AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
		elseif($Serie == 'F1K')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA_KS AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
		elseif($Serie == 'F1T')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA_TQ AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
		elseif($Serie == 'F1R2')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA_RS AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
		elseif($Serie == 'F1K2')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA_KS_2 AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
		elseif($Serie == 'F1K3')
		{
			$Query = mysqli_query("SELECT MIN(A.F_DTE) AS MINIMO
									FROM Bodega.FACTURA_EV AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MINIMO"];
		}
	}
	else
	{
		if($Serie == 'F1H')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA_HS AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}
		elseif($Serie == 'F1R')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}
		elseif($Serie == 'F1S')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA_SV AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}
		elseif($Serie == 'F1K')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA_KS AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}
		elseif($Serie == 'F1T')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA_TQ AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}
		elseif($Serie == 'F1R2')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA_RS AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}
		elseif($Serie == 'F1K2')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA_KS_2 AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}
		elseif($Serie == 'F1K3')
		{
			$Query = mysqli_query("SELECT MAX(A.F_DTE) AS MAXIMO
									FROM Bodega.FACTURA_EV AS A
									WHERE A.F_FECHA_TRANS = '".$Fecha."'", mysqli_connect("10.60.58.205", "userconex", "n6&xX50Iov@e"));
			$Fila = mysqli_fetch_array($Query);

			return $Fila["MAXIMO"];
		}	
	}
}
?>