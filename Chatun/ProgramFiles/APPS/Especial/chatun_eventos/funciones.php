<?php
function saber_nombre_asociado_orden($cif_asociado){
	
	$tmp_sql2 = mysql_fetch_row(mysql_query("SELECT cifprimnomb,cifsegunomb, cifternombre, cifprimapell ,cifseguapell, cifapecasada FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif_asociado'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	
	if($tmp_sql2[2]=='NULL'){
		$tercero='';
		}else
		{$tercero=$tmp_sql2[2];}
		if($tmp_sql2[1]=='NULL'){
		$segundo='';
		}else
		{$segundo=$tmp_sql2[1];}
		
		if($tmp_sql2[4]=='NULL'){
		$apellido_segundo='';
		}else
		{$apellido_segundo=$tmp_sql2[4];}

		if($tmp_sql2[5]=='NULL' || $tmp_sql2[5]==''){
		$apellido_casada='';
		}else
		{$apellido_casada=' '.$tmp_sql2[5];}
		
	$nombre_asocido = $tmp_sql2[0]." ".$segundo." ".$tercero." ".$tmp_sql2[3]." ".$apellido_segundo." ".$apellido_casada;
	return $nombre_asocido;
	}
function saber_puestoid($cif_asociado) {

	$tmp_sql = mysql_fetch_row(mysql_query("select c.puesto as puesto 
											from info_colaboradores.vista_colaboradores_idt as c
											where c.cif = '$cif_asociado'", mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$puesto_colaborador = $tmp_sql[0];
	return $puesto_colaborador;
}
function saber_puesto_colaborador($cif_colaborador) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT puesto FROM info_colaboradores.datos_laborales  WHERE cif = '$cif_colaborador'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$puesto_colaborador = $tmp_sql[0];
	return $puesto_colaborador;
}



function saber_puesto_nombre($Puesto) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nombre_puesto FROM info_base.define_puestos WHERE id_puesto = '$Puesto'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$puesto_colaborador = $tmp_sql[0];
	return $puesto_colaborador;
}

function saber_nombre_asociado($cif_asociado) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT cifnombreclie FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif_asociado'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_asocido = $tmp_sql[0];
	return $nombre_asocido;
}
function saber_nombre_asociado_tildes($cif_asociado) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nombre_completo FROM coosajo_gestion_crediticia.solicitudes  WHERE cif = '$cif_asociado' order by id_solicitud desc",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_asocido = $tmp_sql[0];
	return $nombre_asocido;
}
function saber_nombre_operador($operador) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nombre FROM bankworks.operadores_bankworks   WHERE operador = '$operador'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_operador = $tmp_sql[0];
	return $nombre_operador;
}

function nombre_completo($nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $apellido_casada) {
	if ($nombre3 != '') {
		$nombres = $nombre1.' '.$nombre2.' '.$nombre3;
	} elseif ($nombre2 != '') {
		$nombres = $nombre1.' '.$nombre2;
	} else {
		$nombres = $nombre1;
	}
	
	if ($apellido2 != '') {
		$apellidos = $apellido1.' '.$apellido2;
	} else {
	$apellidos = $apellido1;	
	}
	
	if (strlen($apellido_casada) >= 2) {
		$apellidos = $apellidos.' '.$apellido_casada;
	}
	$resultado = $nombres.' '.$apellidos;
	return $resultado;
}

function nombre_completo_minuscula($nombre1, $nombre2, $nombre3, $apellido1, $apellido2, $apellido_casada) {
	if ($nombre3 != '') {
		$nombres = $nombre1.' '.$nombre2.' '.$nombre3;
	} elseif ($nombre2 != '') {
		$nombres = $nombre1.' '.$nombre2;
	} else {
		$nombres = $nombre1;
	}
	
	if ($apellido2 != '') {
		$apellidos = $apellido1.' '.$apellido2;
	} else {
	$apellidos = $apellido1;	
	}
	
	if (strlen($apellido_casada) >= 2) {
		$apellidos = $apellidos.' de '.$apellido_casada;
	}
	$resultado = $nombres.' '.$apellidos;
	return $resultado;
}

function direccion_completa ($direccion, $zona, $municipio, $departamento) {
	$resultado = $direccion.' ZONA '.$zona.', '.$municipio.', '.$departamento;
	return $resultado;
}

function direccion_completa_residencia ($direccion, $zona, $municipio, $departamento) {
	$resultado = $direccion.' Zona '.$zona.', del Municipio de '.$municipio.', Departamento de '.$departamento;
	return $resultado;
}

function cambio_fecha($f) {
	$f = str_replace("/", "-",$f);
	$desglose=explode("-", $f);
	$resultado=$desglose[2]."-".$desglose[1]."-".$desglose[0];
	return $resultado;
}

function cambio_fecha_usa($f) {
	$f = str_replace("/", "-",$f);
	$desglose=explode("-", $f);
	$resultado=$desglose[2]."-".$desglose[0]."-".$desglose[1];
	return $resultado;
}

function cambio_fechalarga($f) {
	$f = str_replace("/", "-",$f);
	$desglose=explode("-", $f);
	if ($desglose[2] < 99 and $desglose[2] > 30) {
		$desglose[2] = $desglose[2] + 1900;
	}
	$resultado=$desglose[2]."-".$desglose[1]."-".$desglose[0];
	return $resultado;
}

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
	$resultado=$desglose[2]." de ".$mes." de ".$desglose[0];
	return $resultado;
}

function fecha_ive($f) {
	$mes = "";
	$g = str_replace("/", "-",$f);
	$desglose=explode("-", $g);
	switch($desglose[1]) {
		case 01:
			$mes = "Enero";
			break;
		case 02:
			$mes = "Febrero";
			break;
		case 03:
			$mes = "Marzo";
			break;
		case 04:
			$mes = "Abril";
			break;
		case 05:
			$mes = "Mayo";
			break;
		case 06:
			$mes = "Junio";
			break;
		case 07:
			$mes = "Julio";
			break;
		case 08:
			$mes = "Agosto";
			break;
		case 09:
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
	$resultado=$desglose[2]." de ".$mes." de ".$desglose[0];
	return $resultado;
}

function Saber_Genero_Asociado($cif)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT cifsexo FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Genero = utf8_encode($tmp_sql[0]);

	return $Genero;
}

function saber_sobrenombre($Genero)
{
	if($Genero == 'F')
	{
		$Sexo = 'de la Señora';
	}
	else
	{
		$Sexo = 'del Señor';
	}

	return $Sexo;
}

function fecha_con_mes_hora($f) {
	$mes = "";
	$hora = "";
	$b = explode(" ", $f);
	$g = $b[0];
	$g = str_replace("/", "-",$g);
	$desglose=explode("-", $g);
	switch(intval($desglose[1])) {
		case '01':
			$mes = "Enero";
			break;
		case '02':
			$mes = "Febrero";
			break;
		case '03':
			$mes = "Marzo";
			break;
		case '04':
			$mes = "Abril";
			break;
		case '05':
			$mes = "Mayo";
			break;
		case '06':
			$mes = "Junio";
			break;
		case '07':
			$mes = "Julio";
			break;
		case '08':
			$mes = "Agosto";
			break;
		case '09':
			$mes = "Septiembre";
			break;
		case '10':
			$mes = "Octubre";
			break;
		case '11':
			$mes = "Noviembre";
			break;
		case '12':
			$mes = "Diciembre";
			break;		
	}
	$resultado=$desglose[2]."-".$mes."-".$desglose[0]." ".$b[1];
	return $resultado;
}

function cambio_fecha_hora($f) {
	$mes = "";
	$hora = "";
	$b = explode(" ", $f);
	$g = $b[0];
	$g = str_replace("/", "-",$g);
	$desglose=explode("-", $g);
	$resultado=$desglose[2]."-".$desglose[1]."-".$desglose[0]." ".$b[1];
	return $resultado;
}

function quitar_hora_fecha($f) {
	$b = explode(" ", $f);
	$solo_fecha = cambio_fecha($b[0]);
	return $solo_fecha;
}

function fecha_corta($f) {
	$g = str_replace("/", "-",$f);
	$desglose=explode("-", $g);
	$resultado=$desglose[0]."-".$desglose[1]."-". substr($desglose[2],2,4);
	return $resultado;
}

function hora_normal($f) {
	$b = explode(":", $f);
	return $b[0].":".$b[1];
}

function php_focus($a) {
	echo '<script language="javascript"> document.getElementById("'.$a.'").focus(); </script>';
}

function php_select($a) {
	echo '<script language="javascript"> document.getElementById("'.$a.'").selected(); </script>';
}

function redondeado ($numero, $decimales) { 
	$factor = pow(10, $decimales);
	return (round($numero*$factor)/$factor);
}

function dateDiff($start, $end) { 
	$start_ts = strtotime($start); 
	$end_ts = strtotime($end); 
	$diff = $end_ts - $start_ts; 
	return round($diff / 86400); 
} 

function saber_mes($mes) { 
	switch($mes) {
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
	return $mes;
}

function quitar_comas($a) {
	$b = explode(",",$a);
	$c = $b[0].$b[1].$b[2].$b[3].$b[4];
	return $c;
}

function buscar_variable_get($variable_a_buscar, $cadena_desencriptado) {
	$tmp = explode("&",$cadena_desencriptado);
	foreach($tmp as $arreglo) {
		$tmp1 = explode("=",$arreglo);
		if ($tmp1[0] == $variable_a_buscar) {
			$a = $tmp1[1];	
		}
	}  
	return $a;
}

function extendido_dpi($variable_dpi) {
	$extrae_departamento = substr($variable_dpi,-4,2);
	$extrae_municipio = substr($variable_dpi,-2,2);
	$sql_1 = mysql_query("SELECT nombre_departamento FROM info_base.departamentos_guatemala WHERE id_departamento = '$extrae_departamento'", mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n"));
	$departamento = mysql_fetch_row($sql_1);
	$sql_2 = mysql_query("SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = '$extrae_departamento' AND id_municipio = '$extrae_municipio'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n"));
	$municipio = mysql_fetch_row($sql_2);
	$z = $municipio[0].", ".$departamento[0];
	return $z;
}   

//sumar dias a la fecha
function DiasFecha($fecha,$dias) {
		$nuevafecha = strtotime ($dias." day" , strtotime ( $fecha ) ); 
		$nuevafecha = date ('j-m-Y' , $nuevafecha ); //formatea nueva fecha 
		return $nuevafecha; //retorna valor de la fecha 
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
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT pais FROM info_base.lista_paises_bankworks WHERE id = $cod_pais ",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_pais = $tmp_sql[0];
	return $nombre_pais;
	}
}


function saber_pais_mundo($cod_pais) {
	if ($cod_pais > 0) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT pais FROM info_base.lista_paises_mundo WHERE id = $cod_pais ",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_pais = $tmp_sql[0];
	return $nombre_pais;
	}
}

function saber_departamento($cod_depto) {
	if ($cod_depto > 0) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nombre_departamento FROM info_base.departamentos_guatemala WHERE id_departamento = $cod_depto ",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_depto = $tmp_sql[0];
	return $nombre_depto;
	}
}

function saber_municipio($cod_municipio, $cod_depto) {
	if ($cod_depto > 0) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id_departamento = $cod_depto AND id_municipio = $cod_municipio ",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_municipio = $tmp_sql[0];
	return $nombre_municipio;
	}
}

function saber_nacionalidad($cod_nacionalidad) {
	if ($cod_nacionalidad > 0) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nacionalidad FROM bankworks.lista_nacionalidades WHERE id = $cod_nacionalidad ",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_nacionalidad = $tmp_sql[0];
	return $nombre_nacionalidad;
	}
}

function saber_nombre_colaborador($cif_temp) {
	$tmp_sql1 = mysql_fetch_row(mysql_query("SELECT nombre FROM info_bbdd.usuarios WHERE id_user = '$cif_temp'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_colaborador = $tmp_sql1[0];
	return $nombre_colaborador;
}

function saber_departamento_coosajo($cif_temp) {
	$tmp_sql1 = mysql_fetch_row(mysql_query("SELECT nombre_depto FROM info_colaboradores.vista_colaboradores_idt WHERE cif = '$cif_temp'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_depto_colaborador = $tmp_sql1[0];
	return $nombre_depto_colaborador;
}

function saber_gerencia_coosajo($cif_temp) {
	$tmp_sql1 = mysql_fetch_row(mysql_query("SELECT gerencia FROM info_colaboradores.vista_colaboradores_idt WHERE cif = '$cif_temp'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_gerencia_colaborador = $tmp_sql1[0];
	return $nombre_gerencia_colaborador;
}   
function saber_agencia_colaborador($cif_temp) {
	$tmp_sql_agencia = mysql_fetch_row(mysql_query("SELECT num_agencia FROM info_bbdd.usuarios_general WHERE id ='$cif_temp'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$agencia_colaborador = $tmp_sql_agencia[0];
	return $agencia_colaborador;
}
function trimestre($mes=null) {
$mes = is_null($mes) ? date('m') : $mes;
$trim=floor(($mes-1) / 3)+1;
return $trim;
}

function saber_ejecutivo($cif_colaborador) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT codigo_ejecutivo FROM info_bbdd.usuarios WHERE id_user = '$cif_colaborador'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$ejecutivo_colaborador = $tmp_sql[0];
	return $ejecutivo_colaborador;
}

function saber_nombre_ejecutivo($ejecutivo) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nombre FROM info_bbdd.usuarios WHERE codigo_ejecutivo = '$ejecutivo'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_colaborador = $tmp_sql[0];
	return $nombre_colaborador;
}

function saber_ejecutivo_tarjeta($tarjeta){
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT ejecutivo_cobranza FROM transtel.ejecutivo_cuenta WHERE cuenta_visa = '$tarjeta'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Ejecutivo = $tmp_sql[0];
	return saber_nombre_ejecutivo($Ejecutivo);
}

function saber_instrumento_captaciones($instrumento) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT descripcion FROM bankworks.lista_instrumento_captaciones WHERE id = '$instrumento'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$descripcion_instrumento = $tmp_sql[0];
	return $descripcion_instrumento;
}

function saber_nombre_agencia($id_agencia) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT agencia FROM info_base.agencias WHERE id_agencia = '$id_agencia'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_agencia = $tmp_sql[0];
	return $nombre_agencia;
}

function dias_transcurridos($fecha_i,$fecha_f) {
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}

function saber_profesion_bankworks($profesion) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT descripcion FROM bankworks.lista_profesion WHERE id = '$profesion'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_profesion = $tmp_sql[0];
	return $nombre_profesion;
}

function saber_ocupacion_bankworks($ocupacion) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT descripcion FROM bankworks.lista_ocupacion WHERE id = '$ocupacion'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_ocupacion = $tmp_sql[0];
	return $nombre_ocupacion;
}

function saber_instrumento_bankworks($instrumento) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT descripcion, moneda FROM bankworks.lista_instrumento_captaciones  WHERE id = '$instrumento'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_intrumento = $tmp_sql[0]." ".$tmp_sql[1];
	return $nombre_intrumento;
}

function saber_pais_bankworks($codigo_pais) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT pais FROM bankworks.lista_paises WHERE id = '$codigo_pais'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	
	return $tmp_sql[0];
}

function saber_estado_tarje_visa($estado) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT descripcion FROM transtel.lista_estado_visa  WHERE id = '$estado'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$estado_derscri = $tmp_sql[0];
	return $estado_derscri;
}

function sacar_dias_mes($month, $year) { 
// calculate number of days in a month 
return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
} 


function separar_dpi($dpi) {
	$primer_grupo = substr($dpi,0,4);
	$segundo_grupo = substr($dpi,4,5);
	$tercer_grupo = substr($dpi,9,4);
	$dpi_separado = $primer_grupo."-".$segundo_grupo."-".$tercer_grupo;
	return $dpi_separado;
}

function convertir_dpi_letras($dpi) {
	$dpi_con_separadores = separar_dpi($dpi);
	$dpi_grupo = explode("-", $dpi_con_separadores);
	$a = 0;
	$b = 0;
	while ($a < 3) {
		$dpi_individual = $dpi_grupo[$a];
		$b=0;
		if ($dpi_individual[$b] == 0) {
			$lleva_ceros = '';
			while ($dpi_individual[$b] == 0) {
				$lleva_ceros = $lleva_ceros."cero ";
				$b++;	
			}
			$texto = $texto.$lleva_ceros.num2letras($dpi_grupo[$a],false);	
		} else {
			$texto = $texto.num2letras($dpi_grupo[$a],false);	
		}
		$a++;
		if ($a < 3) {
			$texto = $texto." guion ";
		}
	}
	return ucfirst(strtolower($texto));
}

function convertir_cedula_letras_backup($cedula) {
	$cedula_orden = substr($cedula, 0,3);
	$cedula_registro = substr($cedula, 3, 10);
	$cedula_orden_depto = substr($cedula_orden, 1, 10);
	$texto = utf8_decode("Número de Orden ").$cedula_orden[0].utf8_decode(" guión ").strtolower(num2letras($cedula_orden_depto))." y de registro ".strtolower(num2letras($cedula_registro));
	return $texto;
}

function separar_celular($no_celular) {
	$celular = substr($no_celular,0,4)."-".substr($no_celular,4,8);
	return $celular;
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

function saber_sistema_operativo_cliente() {
$useragent= strtolower($_SERVER['HTTP_USER_AGENT']);
if (strpos($useragent, 'windows nt 5.1') !== FALSE) {
	return 'Windows XP';
} elseif (strpos($useragent, 'windows nt 5.2') !== FALSE) {
return 'Windows 2003';
} elseif (strpos($useragent, 'windows nt 6.3') !== FALSE) {
return 'Windows 8.1';
} elseif (strpos($useragent, 'windows nt 6.2') !== FALSE) {
return 'Windows 8';
} elseif (strpos($useragent, 'windows nt 6.1') !== FALSE) {
return 'Windows 7';
} elseif (strpos($useragent, 'windows nt 6.0') !== FALSE) {
return 'Windows Vista';
} elseif (strpos($useragent, 'windows 98') !== FALSE) {
return 'Windows 98';
} elseif (strpos($useragent, 'windows nt 5.0') !== FALSE) {
return 'Windows 2000';
} elseif (strpos($useragent, 'windows nt 5.2') !== FALSE) {
return 'Windows 2003 Server';
} elseif (strpos($useragent, 'windows nt') !== FALSE) {
return 'Windows NT';
} elseif (strpos($useragent, 'win 9x 4.90') !== FALSE && strpos($useragent, 'win me')) {
return 'Windows ME';
} elseif (strpos($useragent, 'win ce') !== FALSE) {
return 'Windows CE';
} elseif (strpos($useragent, 'win 9x 4.90') !== FALSE) {
return 'Windows ME';
} elseif (strpos($useragent, 'windows phone') !== FALSE) {
return 'Windows Phone';
} elseif (strpos($useragent, 'iphone') !== FALSE) {
return 'iPhone';
} elseif (strpos($useragent, 'ipad') !== FALSE) {
return 'iPad';
} elseif (strpos($useragent, 'webos') !== FALSE) {
return 'webOS';
} elseif (strpos($useragent, 'symbian') !== FALSE) {
return 'Symbian';
} elseif (strpos($useragent, 'android') !== FALSE) {
return 'Android';
} elseif (strpos($useragent, 'blackberry') !== FALSE) {
return 'Blackberry';
} elseif (strpos($useragent, 'mac os x') !== FALSE) {
return 'Mac OS X';
} elseif (strpos($useragent, 'macintosh') !== FALSE) {
return 'Macintosh';
} elseif (strpos($useragent, 'linux') !== FALSE) {
return 'Linux';
} elseif (strpos($useragent, 'freebsd') !== FALSE) {
return 'Free BSD';
} elseif (strpos($useragent, 'symbian') !== FALSE) {
return 'Symbian';
} else {
	return 'Desconocido';
}
}

function timequery()	{
	static $querytime_begin;
	list($usec, $sec) = explode(' ',microtime());
	if(!isset($querytime_begin)) {   
		$querytime_begin= ((float)$usec + (float)$sec);
	} else {
		$querytime = (((float)$usec + (float)$sec)) - $querytime_begin;
		echo sprintf('<br />La consulta tardo %01.5f segundos. <br />', $querytime);
	}
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
///////////////////////OBTENER NAVEGADOR////////////////////////
function ObtenerNavegador($user_agent) {
	$navegadores = array(
         'Opera' => 'Opera',
          'Mozilla Firefox'=> '(Firebird)|(Firefox)',
          'Galeon' => 'Galeon',
          'Mozilla'=>'Gecko',
          'MyIE'=>'MyIE',
          'Lynx' => 'Lynx',
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
          'Konqueror'=>'Konqueror',
          'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
          'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
          'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
          'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
);
foreach($navegadores as $navegador=>$pattern){
       if (eregi($pattern, $user_agent))
       return $navegador;
    }
return 'Desconocido';
}

function saber_mes_abreviado($mes) {
	switch($mes) {
		case 1:
			$mes = "Ene";
			break;
		case 2:
			$mes = "Feb";
			break;
		case 3:
			$mes = "Mar";
			break;
		case 4:
			$mes = "Abr";
			break;
		case 5:
			$mes = "May";
			break;
		case 6:
			$mes = "Jun";
			break;
		case 7:
			$mes = "Jul";
			break;
		case 8:
			$mes = "Agos";
			break;
		case 9:
			$mes = "Sep";  
			break;
		case 10:
			$mes = "Oct";
			break;
		case 11:
			$mes = "Nov";
			break;
		case 12:
			$mes = "Dic";
			break;		
	}
	return $mes;
}

function saber_departamentoid_coosajo($cif_temp) {
	$tmp_sql1 = mysql_fetch_row(mysql_query("SELECT departamento FROM info_colaboradores.vista_colaboradores_idt WHERE cif = '$cif_temp'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_depto_colaborador = $tmp_sql1[0];
	return $nombre_depto_colaborador;
}

function saber_puesto($cif_asociado) {
	$tmp_sql = mysql_fetch_row(mysql_query("select c.nombre_puesto as puesto 
											from info_colaboradores.vista_colaboradores_idt as c
											where c.cif = '$cif_asociado'", mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$puesto_colaborador = $tmp_sql[0];
	return $puesto_colaborador;
}

function saber_gerenciaid_coosajo($cif_temp) {
	$tmp_sql1 = mysql_fetch_row(mysql_query("SELECT gerencia FROM info_colaboradores.datos_laborales WHERE cif = '$cif_temp'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$nombre_gerencia_colaborador = $tmp_sql1[0];
	return $nombre_gerencia_colaborador;
} 

function fecha_con_mes2($f) {
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
	$resultado=$desglose[0]." ".$mes." ".$desglose[2];
	return $resultado;
}

function saber_rango_ingresos_egresos($id_rango_ingresos_egresos) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT valor FROM bankworks.lista_rango_ingresos_egresos WHERE id = '$id_rango_ingresos_egresos'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$rango_ingresos_egresos = $tmp_sql[0];
	return $rango_ingresos_egresos;
}

function cambiar_fecha($f) {
	$desglose=split("-",$f);
	$resultado=$desglose[2]."-".$desglose[1]."-".$desglose[0];
	return $resultado;
}
function obtenerFechaEnLetra($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $dia.', '.$num.' de '.$mes.' del '.$anno;
}
 
function conocerDiaSemanaFecha($fecha) {
    $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $dia = $dias[date('w', strtotime($fecha))];
    return $dia;
}

function valorEnLetras($x) 
{ 
if ($x<0) { $signo = "menos ";} 
else      { $signo = "";} 
$x = abs ($x); 
$C1 = $x; 

$G6 = floor($x/(1000000));  // 7 y mas 

$E7 = floor($x/(100000)); 
$G7 = $E7-$G6*10;   // 6 

$E8 = floor($x/1000); 
$G8 = $E8-$E7*100;   // 5 y 4 

$E9 = floor($x/100); 
$G9 = $E9-$E8*10;  //  3 

$E10 = floor($x); 
$G10 = $E10-$E9*100;  // 2 y 1 


$G11 = round(($x-$E10)*100,0);  // Decimales 
////////////////////// 

$H6 = unidadesFecha($G6); 

if($G7==1 AND $G8==0) { $H7 = "Cien "; } 
else {    $H7 = decenas($G7); } 

$H8 = unidadesFecha($G8); 

if($G9==1 AND $G10==0) { $H9 = "Cien "; } 
else {    $H9 = decenas($G9); } 

$H10 = unidadesFecha($G10); 

if($G11 < 10) { $H11 = "0".$G11; } 
else { $H11 = $G11; } 

///////////////////////////// 
    if($G6==0) { $I6=" "; } 
elseif($G6==1) { $I6="Millón "; } 
         else { $I6="Millones "; } 
          
if ($G8==0 AND $G7==0) { $I8=" "; } 
         else { $I8="Mil "; } 
          
$I11 = "/100"; 

$C3 = $signo.$H6.$I6.$H7.$I7.$H8.$I8.$H9.$I9.$H10.$I10; 

return $C3; //Retornar el resultado 

} 

function valorEnLetrasQuetzales($x) 
{ 
if ($x<0) { $signo = "menos ";} 
else      { $signo = "";} 
$x = abs ($x); 
$C1 = $x; 

$G6 = floor($x/(1000000));  // 7 y mas 

$E7 = floor($x/(100000)); 
$G7 = $E7-$G6*10;   // 6 

$E8 = floor($x/1000); 
$G8 = $E8-$E7*100;   // 5 y 4 

$E9 = floor($x/100); 
$G9 = $E9-$E8*10;  //  3 

$E10 = floor($x); 
$G10 = $E10-$E9*100;  // 2 y 1 


$G11 = round(($x-$E10)*100,0);  // Decimales 
////////////////////// 

$H6 = unidades($G6); 

if($G7==1 AND $G8==0) { $H7 = "Cien "; } 
else {    $H7 = decenas($G7); } 

$H8 = unidades($G8); 

if($G9==1 AND $G10==0) { $H9 = "Cien "; } 
else {    $H9 = decenas($G9); } 

$H10 = unidades($G10); 

if($G11 < 10) { $H11 = "0".$G11; } 
else { $H11 = $G11; } 

///////////////////////////// 
    if($G6==0) { $I6=" "; } 
elseif($G6==1) { $I6="Millón "; } 
         else { $I6="Millones "; } 
          
if ($G8==0 AND $G7==0) { $I8=" "; } 
         else { $I8="Mil "; } 
          
$I11 = "/100"; 

$C3 = $signo.$H6.$I6.$H7.$I7.$H8.$I8.$H9.$I9.$H10.$I10.' Quetzales ';

if($H11 == 0)
{
	$C3 .= 'Exactos';
} 
else
{
	$C3 .= 'Con '.valorEnLetras($H11).' Centavos';
}

return $C3; //Retornar el resultado 

} 

function unidades($u) 
{ 
    if ($u==0)  {$ru = " ";} 
elseif ($u==1)  {$ru = "Un ";} 
elseif ($u==2)  {$ru = "Dos ";} 
elseif ($u==3)  {$ru = "Tres ";} 
elseif ($u==4)  {$ru = "Cuatro ";} 
elseif ($u==5)  {$ru = "Cinco ";} 
elseif ($u==6)  {$ru = "Seis ";} 
elseif ($u==7)  {$ru = "Siete ";} 
elseif ($u==8)  {$ru = "Ocho ";} 
elseif ($u==9)  {$ru = "Nueve ";} 
elseif ($u==10) {$ru = "Diez ";} 

elseif ($u==11) {$ru = "Once ";} 
elseif ($u==12) {$ru = "Doce ";} 
elseif ($u==13) {$ru = "Trece ";} 
elseif ($u==14) {$ru = "Catorce ";} 
elseif ($u==15) {$ru = "Quince ";} 
elseif ($u==16) {$ru = "Dieciseis ";} 
elseif ($u==17) {$ru = "Diecisiete ";} 
elseif ($u==18) {$ru = "Dieciocho ";} 
elseif ($u==19) {$ru = "Diecinueve ";} 
elseif ($u==20) {$ru = "Veinte ";} 

elseif ($u==21) {$ru = "Veintiun ";} 
elseif ($u==22) {$ru = "Veintidos ";} 
elseif ($u==23) {$ru = "Veintitres ";} 
elseif ($u==24) {$ru = "Veinticuatro ";} 
elseif ($u==25) {$ru = "Veinticinco ";} 
elseif ($u==26) {$ru = "Veintiseis ";} 
elseif ($u==27) {$ru = "Veintisiete ";} 
elseif ($u==28) {$ru = "Veintiocho ";} 
elseif ($u==29) {$ru = "Veintinueve ";} 
elseif ($u==30) {$ru = "Treinta ";} 

elseif ($u==31) {$ru = "Treinta y Un ";} 
elseif ($u==32) {$ru = "Treinta y Dos ";} 
elseif ($u==33) {$ru = "Treinta y Tres ";} 
elseif ($u==34) {$ru = "Treinta y Cuatro ";} 
elseif ($u==35) {$ru = "Treinta y Cinco ";} 
elseif ($u==36) {$ru = "Treinta y Seis ";} 
elseif ($u==37) {$ru = "Treinta y Siete ";} 
elseif ($u==38) {$ru = "Treinta y Ocho ";} 
elseif ($u==39) {$ru = "Treinta y Nueve ";} 
elseif ($u==40) {$ru = "Cuarenta ";} 

elseif ($u==41) {$ru = "Cuarenta y Uno ";} 
elseif ($u==42) {$ru = "Cuarenta y Dos ";} 
elseif ($u==43) {$ru = "Cuarenta y Tres ";} 
elseif ($u==44) {$ru = "Cuarenta y Cuatro ";} 
elseif ($u==45) {$ru = "Cuarenta y Cinco ";} 
elseif ($u==46) {$ru = "Cuarenta y Seis ";} 
elseif ($u==47) {$ru = "Cuarenta y Siete ";} 
elseif ($u==48) {$ru = "Cuarenta y Ocho ";} 
elseif ($u==49) {$ru = "Cuarenta y Nueve ";} 
elseif ($u==50) {$ru = "Cincuenta ";} 

elseif ($u==51) {$ru = "Cincuenta y Un ";} 
elseif ($u==52) {$ru = "Cincuenta y Dos ";} 
elseif ($u==53) {$ru = "Cincuenta y Tres ";} 
elseif ($u==54) {$ru = "Cincuenta y Cuatro ";} 
elseif ($u==55) {$ru = "Cincuenta y Cinco ";} 
elseif ($u==56) {$ru = "Cincuenta y Seis ";} 
elseif ($u==57) {$ru = "Cincuenta y Siete ";} 
elseif ($u==58) {$ru = "Cincuenta y Ocho ";} 
elseif ($u==59) {$ru = "Cincuenta y Nueve ";} 
elseif ($u==60) {$ru = "Sesenta ";} 

elseif ($u==61) {$ru = "Sesenta y Un ";} 
elseif ($u==62) {$ru = "Sesenta y Dos ";} 
elseif ($u==63) {$ru = "Sesenta y Tres ";} 
elseif ($u==64) {$ru = "Sesenta y Cuatro ";} 
elseif ($u==65) {$ru = "Sesenta y Cinco ";} 
elseif ($u==66) {$ru = "Sesenta y Seis ";} 
elseif ($u==67) {$ru = "Sesenta y Siete ";} 
elseif ($u==68) {$ru = "Sesenta y Ocho ";} 
elseif ($u==69) {$ru = "Sesenta y Nueve ";} 
elseif ($u==70) {$ru = "Setenta ";} 

elseif ($u==71) {$ru = "Setenta y Un ";} 
elseif ($u==72) {$ru = "Setenta y Dos ";} 
elseif ($u==73) {$ru = "Setenta y Tres ";} 
elseif ($u==74) {$ru = "Setenta y Cuatro ";} 
elseif ($u==75) {$ru = "Setenta y Cinco ";} 
elseif ($u==76) {$ru = "Setenta y Seis ";} 
elseif ($u==77) {$ru = "Setenta y Siete ";} 
elseif ($u==78) {$ru = "Setenta y Ocho ";} 
elseif ($u==79) {$ru = "Setenta y Nueve ";} 
elseif ($u==80) {$ru = "Ochenta ";} 

elseif ($u==81) {$ru = "Ochenta y Un ";} 
elseif ($u==82) {$ru = "Ochenta y Dos ";} 
elseif ($u==83) {$ru = "Ochenta y Tres ";} 
elseif ($u==84) {$ru = "Ochenta y Cuatro ";} 
elseif ($u==85) {$ru = "Ochenta y Cinco ";} 
elseif ($u==86) {$ru = "Ochenta y Seis ";} 
elseif ($u==87) {$ru = "Ochenta y Siete ";} 
elseif ($u==88) {$ru = "Ochenta y Ocho ";} 
elseif ($u==89) {$ru = "Ochenta y Nueve ";} 
elseif ($u==90) {$ru = "Noventa ";} 

elseif ($u==91) {$ru = "Noventa y Un ";} 
elseif ($u==92) {$ru = "Noventa y Dos ";} 
elseif ($u==93) {$ru = "Noventa y Tres ";} 
elseif ($u==94) {$ru = "Noventa y Cuatro ";} 
elseif ($u==95) {$ru = "Noventa y Cinco ";} 
elseif ($u==96) {$ru = "Noventa y Seis ";} 
elseif ($u==97) {$ru = "Noventa y Siete ";} 
elseif ($u==98) {$ru = "Noventa y Ocho ";} 
else            {$ru = "Noventa y Nueve ";} 
return $ru; //Retornar el resultado 
} 

function unidadesFecha($u) 
{ 
    if ($u==0)  {$ru = " ";} 
elseif ($u==1)  {$ru = "Uno ";} 
elseif ($u==2)  {$ru = "Dos ";} 
elseif ($u==3)  {$ru = "Tres ";} 
elseif ($u==4)  {$ru = "Cuatro ";} 
elseif ($u==5)  {$ru = "Cinco ";} 
elseif ($u==6)  {$ru = "Seis ";} 
elseif ($u==7)  {$ru = "Siete ";} 
elseif ($u==8)  {$ru = "Ocho ";} 
elseif ($u==9)  {$ru = "Nueve ";} 
elseif ($u==10) {$ru = "Diez ";} 

elseif ($u==11) {$ru = "Once ";} 
elseif ($u==12) {$ru = "Doce ";} 
elseif ($u==13) {$ru = "Trece ";} 
elseif ($u==14) {$ru = "Catorce ";} 
elseif ($u==15) {$ru = "Quince ";} 
elseif ($u==16) {$ru = "Dieciseis ";} 
elseif ($u==17) {$ru = "Diecisiete ";} 
elseif ($u==18) {$ru = "Dieciocho ";} 
elseif ($u==19) {$ru = "Diecinueve ";} 
elseif ($u==20) {$ru = "Veinte ";} 

elseif ($u==21) {$ru = "Veintiuno ";} 
elseif ($u==22) {$ru = "Veintidos ";} 
elseif ($u==23) {$ru = "Veintitres ";} 
elseif ($u==24) {$ru = "Veinticuatro ";} 
elseif ($u==25) {$ru = "Veinticinco ";} 
elseif ($u==26) {$ru = "Veintiseis ";} 
elseif ($u==27) {$ru = "Veintisiete ";} 
elseif ($u==28) {$ru = "Veintiocho ";} 
elseif ($u==29) {$ru = "Veintinueve ";} 
elseif ($u==30) {$ru = "Treinta ";} 

elseif ($u==31) {$ru = "Treinta y Un ";} 
elseif ($u==32) {$ru = "Treinta y Dos ";} 
elseif ($u==33) {$ru = "Treinta y Tres ";} 
elseif ($u==34) {$ru = "Treinta y Cuatro ";} 
elseif ($u==35) {$ru = "Treinta y Cinco ";} 
elseif ($u==36) {$ru = "Treinta y Seis ";} 
elseif ($u==37) {$ru = "Treinta y Siete ";} 
elseif ($u==38) {$ru = "Treinta y Ocho ";} 
elseif ($u==39) {$ru = "Treinta y Nueve ";} 
elseif ($u==40) {$ru = "Cuarenta ";} 

elseif ($u==41) {$ru = "Cuarenta y Uno ";} 
elseif ($u==42) {$ru = "Cuarenta y Dos ";} 
elseif ($u==43) {$ru = "Cuarenta y Tres ";} 
elseif ($u==44) {$ru = "Cuarenta y Cuatro ";} 
elseif ($u==45) {$ru = "Cuarenta y Cinco ";} 
elseif ($u==46) {$ru = "Cuarenta y Seis ";} 
elseif ($u==47) {$ru = "Cuarenta y Siete ";} 
elseif ($u==48) {$ru = "Cuarenta y Ocho ";} 
elseif ($u==49) {$ru = "Cuarenta y Nueve ";} 
elseif ($u==50) {$ru = "Cincuenta ";} 

elseif ($u==51) {$ru = "Cincuenta y Un ";} 
elseif ($u==52) {$ru = "Cincuenta y Dos ";} 
elseif ($u==53) {$ru = "Cincuenta y Tres ";} 
elseif ($u==54) {$ru = "Cincuenta y Cuatro ";} 
elseif ($u==55) {$ru = "Cincuenta y Cinco ";} 
elseif ($u==56) {$ru = "Cincuenta y Seis ";} 
elseif ($u==57) {$ru = "Cincuenta y Siete ";} 
elseif ($u==58) {$ru = "Cincuenta y Ocho ";} 
elseif ($u==59) {$ru = "Cincuenta y Nueve ";} 
elseif ($u==60) {$ru = "Sesenta ";} 

elseif ($u==61) {$ru = "Sesenta y Un ";} 
elseif ($u==62) {$ru = "Sesenta y Dos ";} 
elseif ($u==63) {$ru = "Sesenta y Tres ";} 
elseif ($u==64) {$ru = "Sesenta y Cuatro ";} 
elseif ($u==65) {$ru = "Sesenta y Cinco ";} 
elseif ($u==66) {$ru = "Sesenta y Seis ";} 
elseif ($u==67) {$ru = "Sesenta y Siete ";} 
elseif ($u==68) {$ru = "Sesenta y Ocho ";} 
elseif ($u==69) {$ru = "Sesenta y Nueve ";} 
elseif ($u==70) {$ru = "Setenta ";} 

elseif ($u==71) {$ru = "Setenta y Un ";} 
elseif ($u==72) {$ru = "Setenta y Dos ";} 
elseif ($u==73) {$ru = "Setenta y Tres ";} 
elseif ($u==74) {$ru = "Setenta y Cuatro ";} 
elseif ($u==75) {$ru = "Setenta y Cinco ";} 
elseif ($u==76) {$ru = "Setenta y Seis ";} 
elseif ($u==77) {$ru = "Setenta y Siete ";} 
elseif ($u==78) {$ru = "Setenta y Ocho ";} 
elseif ($u==79) {$ru = "Setenta y Nueve ";} 
elseif ($u==80) {$ru = "Ochenta ";} 

elseif ($u==81) {$ru = "Ochenta y Un ";} 
elseif ($u==82) {$ru = "Ochenta y Dos ";} 
elseif ($u==83) {$ru = "Ochenta y Tres ";} 
elseif ($u==84) {$ru = "Ochenta y Cuatro ";} 
elseif ($u==85) {$ru = "Ochenta y Cinco ";} 
elseif ($u==86) {$ru = "Ochenta y Seis ";} 
elseif ($u==87) {$ru = "Ochenta y Siete ";} 
elseif ($u==88) {$ru = "Ochenta y Ocho ";} 
elseif ($u==89) {$ru = "Ochenta y Nueve ";} 
elseif ($u==90) {$ru = "Noventa ";} 

elseif ($u==91) {$ru = "Noventa y Un ";} 
elseif ($u==92) {$ru = "Noventa y Dos ";} 
elseif ($u==93) {$ru = "Noventa y Tres ";} 
elseif ($u==94) {$ru = "Noventa y Cuatro ";} 
elseif ($u==95) {$ru = "Noventa y Cinco ";} 
elseif ($u==96) {$ru = "Noventa y Seis ";} 
elseif ($u==97) {$ru = "Noventa y Siete ";} 
elseif ($u==98) {$ru = "Noventa y Ocho ";} 
else            {$ru = "Noventa y Nueve ";} 
return $ru; //Retornar el resultado 
} 

function decenas($d) 
{ 
    if ($d==0)  {$rd = "";} 
elseif ($d==1)  {$rd = "Ciento ";} 
elseif ($d==2)  {$rd = "Doscientos ";} 
elseif ($d==3)  {$rd = "Trescientos ";} 
elseif ($d==4)  {$rd = "Cuatrocientos ";} 
elseif ($d==5)  {$rd = "Quinientos ";} 
elseif ($d==6)  {$rd = "Seiscientos ";} 
elseif ($d==7)  {$rd = "Setecientos ";} 
elseif ($d==8)  {$rd = "Ochocientos ";} 
else            {$rd = "Novecientos ";} 
return $rd; //Retornar el resultado 
} 


function valorEnLetras1($x) 
{ 
if ($x<0) { $signo = "menos ";} 
else      { $signo = "";} 
$x = abs ($x); 
$C1 = $x; 

$G6 = floor($x/(1000000));  // 7 y mas 

$E7 = floor($x/(100000)); 
$G7 = $E7-$G6*10;   // 6 

$E8 = floor($x/1000); 
$G8 = $E8-$E7*100;   // 5 y 4 

$E9 = floor($x/100); 
$G9 = $E9-$E8*10;  //  3 

$E10 = floor($x); 
$G10 = $E10-$E9*100;  // 2 y 1 


$G11 = round(($x-$E10)*100,0);  // Decimales 
////////////////////// 

$H6 = unidades1($G6); 

if($G7==1 AND $G8==0) { $H7 = "Cien "; } 
else {    $H7 = decenas1($G7); } 

$H8 = unidades1($G8); 

if($G9==1 AND $G10==0) { $H9 = "Cien "; } 
else {    $H9 = decenas1($G9); } 

$H10 = unidades1($G10); 

if($G11 < 10) { $H11 = "0".$G11; } 
else { $H11 = $G11; } 

///////////////////////////// 
    if($G6==0) { $I6=" "; } 
elseif($G6==1) { $I6="Millón "; } 
         else { $I6="Millones "; } 
          
if ($G8==0 AND $G7==0) { $I8=" "; } 
         else { $I8="Mil "; } 
          
$I11 = "/100"; 

$C3 = $signo.$H6.$I6.$H7.$I7.$H8.$I8.$H9.$I9.$H10.$I10; 

return $C3; //Retornar el resultado 

}


function unidades1($u) 
{ 
    if ($u==0)  {$ru = " ";} 
elseif ($u==1)  {$ru = " ";} 
elseif ($u==2)  {$ru = "Dos ";} 
elseif ($u==3)  {$ru = "Tres ";} 
elseif ($u==4)  {$ru = "Cuatro ";} 
elseif ($u==5)  {$ru = "Cinco ";} 
elseif ($u==6)  {$ru = "Seis ";} 
elseif ($u==7)  {$ru = "Siete ";} 
elseif ($u==8)  {$ru = "Ocho ";} 
elseif ($u==9)  {$ru = "Nueve ";} 
elseif ($u==10) {$ru = "Diez ";} 

elseif ($u==11) {$ru = "Once ";} 
elseif ($u==12) {$ru = "Doce ";} 
elseif ($u==13) {$ru = "Trece ";} 
elseif ($u==14) {$ru = "Catorce ";} 
elseif ($u==15) {$ru = "Quince ";} 
elseif ($u==16) {$ru = "Dieciseis ";} 
elseif ($u==17) {$ru = "Diecisiete ";} 
elseif ($u==18) {$ru = "Dieciocho ";} 
elseif ($u==19) {$ru = "Diecinueve ";} 
elseif ($u==20) {$ru = "Veinte ";} 

elseif ($u==21) {$ru = "Veintiuno ";} 
elseif ($u==22) {$ru = "Veintidos ";} 
elseif ($u==23) {$ru = "Veintitres ";} 
elseif ($u==24) {$ru = "Veinticuatro ";} 
elseif ($u==25) {$ru = "Veinticinco ";} 
elseif ($u==26) {$ru = "Veintiseis ";} 
elseif ($u==27) {$ru = "Veintisiete ";} 
elseif ($u==28) {$ru = "Veintiocho ";} 
elseif ($u==29) {$ru = "Veintinueve ";} 
elseif ($u==30) {$ru = "Treinta ";} 

elseif ($u==31) {$ru = "Treinta y Un ";} 
elseif ($u==32) {$ru = "Treinta y Dos ";} 
elseif ($u==33) {$ru = "Treinta y Tres ";} 
elseif ($u==34) {$ru = "Treinta y Cuatro ";} 
elseif ($u==35) {$ru = "Treinta y Cinco ";} 
elseif ($u==36) {$ru = "Treinta y Seis ";} 
elseif ($u==37) {$ru = "Treinta y Siete ";} 
elseif ($u==38) {$ru = "Treinta y Ocho ";} 
elseif ($u==39) {$ru = "Treinta y Nueve ";} 
elseif ($u==40) {$ru = "Cuarenta ";} 

elseif ($u==41) {$ru = "Cuarenta y Un ";} 
elseif ($u==42) {$ru = "Cuarenta y Dos ";} 
elseif ($u==43) {$ru = "Cuarenta y Tres ";} 
elseif ($u==44) {$ru = "Cuarenta y Cuatro ";} 
elseif ($u==45) {$ru = "Cuarenta y Cinco ";} 
elseif ($u==46) {$ru = "Cuarenta y Seis ";} 
elseif ($u==47) {$ru = "Cuarenta y Siete ";} 
elseif ($u==48) {$ru = "Cuarenta y Ocho ";} 
elseif ($u==49) {$ru = "Cuarenta y Nueve ";} 
elseif ($u==50) {$ru = "Cincuenta ";} 

elseif ($u==51) {$ru = "Cincuenta y Un ";} 
elseif ($u==52) {$ru = "Cincuenta y Dos ";} 
elseif ($u==53) {$ru = "Cincuenta y Tres ";} 
elseif ($u==54) {$ru = "Cincuenta y Cuatro ";} 
elseif ($u==55) {$ru = "Cincuenta y Cinco ";} 
elseif ($u==56) {$ru = "Cincuenta y Seis ";} 
elseif ($u==57) {$ru = "Cincuenta y Siete ";} 
elseif ($u==58) {$ru = "Cincuenta y Ocho ";} 
elseif ($u==59) {$ru = "Cincuenta y Nueve ";} 
elseif ($u==60) {$ru = "Sesenta ";} 

elseif ($u==61) {$ru = "Sesenta y Un ";} 
elseif ($u==62) {$ru = "Sesenta y Dos ";} 
elseif ($u==63) {$ru = "Sesenta y Tres ";} 
elseif ($u==64) {$ru = "Sesenta y Cuatro ";} 
elseif ($u==65) {$ru = "Sesenta y Cinco ";} 
elseif ($u==66) {$ru = "Sesenta y Seis ";} 
elseif ($u==67) {$ru = "Sesenta y Siete ";} 
elseif ($u==68) {$ru = "Sesenta y Ocho ";} 
elseif ($u==69) {$ru = "Sesenta y Nueve ";} 
elseif ($u==70) {$ru = "Setenta ";} 

elseif ($u==71) {$ru = "Setenta y Un ";} 
elseif ($u==72) {$ru = "Setenta y Dos ";} 
elseif ($u==73) {$ru = "Setenta y Tres ";} 
elseif ($u==74) {$ru = "Setenta y Cuatro ";} 
elseif ($u==75) {$ru = "Setenta y Cinco ";} 
elseif ($u==76) {$ru = "Setenta y Seis ";} 
elseif ($u==77) {$ru = "Setenta y Siete ";} 
elseif ($u==78) {$ru = "Setenta y Ocho ";} 
elseif ($u==79) {$ru = "Setenta y Nueve ";} 
elseif ($u==80) {$ru = "Ochenta ";} 

elseif ($u==81) {$ru = "Ochenta y Un ";} 
elseif ($u==82) {$ru = "Ochenta y Dos ";} 
elseif ($u==83) {$ru = "Ochenta y Tres ";} 
elseif ($u==84) {$ru = "Ochenta y Cuatro ";} 
elseif ($u==85) {$ru = "Ochenta y Cinco ";} 
elseif ($u==86) {$ru = "Ochenta y Seis ";} 
elseif ($u==87) {$ru = "Ochenta y Siete ";} 
elseif ($u==88) {$ru = "Ochenta y Ocho ";} 
elseif ($u==89) {$ru = "Ochenta y Nueve ";} 
elseif ($u==90) {$ru = "Noventa ";} 

elseif ($u==91) {$ru = "Noventa y Un ";} 
elseif ($u==92) {$ru = "Noventa y Dos ";} 
elseif ($u==93) {$ru = "Noventa y Tres ";} 
elseif ($u==94) {$ru = "Noventa y Cuatro ";} 
elseif ($u==95) {$ru = "Noventa y Cinco ";} 
elseif ($u==96) {$ru = "Noventa y Seis ";} 
elseif ($u==97) {$ru = "Noventa y Siete ";} 
elseif ($u==98) {$ru = "Noventa y Ocho ";} 
else            {$ru = "Noventa y Nueve ";} 
return $ru; //Retornar el resultado 
} 

function decenas1($d) 
{ 
    if ($d==0)  {$rd = "";} 
elseif ($d==1)  {$rd = "Ciento ";} 
elseif ($d==2)  {$rd = "Doscientos ";} 
elseif ($d==3)  {$rd = "Trescientos ";} 
elseif ($d==4)  {$rd = "Cuatrocientos ";} 
elseif ($d==5)  {$rd = "Quinientos ";} 
elseif ($d==6)  {$rd = "Seiscientos ";} 
elseif ($d==7)  {$rd = "Setecientos ";} 
elseif ($d==8)  {$rd = "Ochocientos ";} 
else            {$rd = "Novecientos ";} 
return $rd; //Retornar el resultado 
} 

function NombreEstadoInterno($Estado)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT ETI_NOMBRE FROM coosajo_gestion_crediticia.estado_tarea_interna WHERE ETI_CODIGO = '".$Estado."'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Nombre = $tmp_sql[0];
	return $Nombre;
}
function NombreEstadoExterno($Estado)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT ETE_NOMBRE FROM coosajo_gestion_crediticia.estado_tarea_externa WHERE ETE_CODIGO = '".$Estado."'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Nombre = $tmp_sql[0];
	return $Nombre;
}

function saber_nombre_notario($Notario)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT CONCAT(N_PRIMER_NOMBRE,' ',N_SEGUNDO_NOMBRE,' ',N_TERCER_NOMBRE,' ',N_PRIMER_APELLIDO,' ',N_SEGUNDO_APELLIDO), N_APELLIDO_CASADA FROM coosajo_gestion_crediticia.notario WHERE N_CODIGO = '".$Notario."'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));

	if($tmp_sql[1] == '')
	{
		$Nombre = $tmp_sql[0];	
	}
	else
	{
		$Nombre = $tmp_sql[0].' DE '.$tmp_sql[1];
	}
	
	return $Nombre;
}

function convertir_dpi_letras_espacios($dpi) {
	$dpi_con_separadores = separar_dpi($dpi);
	$dpi_grupo = explode("-", $dpi_con_separadores);
	$a = 0;
	$b = 0;
	while ($a < 3) {
		$dpi_individual = $dpi_grupo[$a];
		$b=0;
		if ($dpi_individual[$b] == 0) {
			$lleva_ceros = '';
			while ($dpi_individual[$b] == 0) {
				$lleva_ceros = $lleva_ceros."cero ";
				$b++;	
			}
			$texto = $texto.$lleva_ceros.num2letras($dpi_grupo[$a],false);	
		} else {
			$texto = $texto.num2letras($dpi_grupo[$a],false);	
		}
		$a++;
		if ($a < 3) {
			$texto = $texto." espacio ";
		}
	}
	return ucfirst(strtolower($texto));
}

function numero_dpi_con_espacios($dpi)
{
	$Primero = $dpi[0].$dpi[1].$dpi[2].$dpi[3];
	$Segundo = $dpi[4].$dpi[5].$dpi[6].$dpi[7].$dpi[8];
	$Tercero = $dpi[9].$dpi[10].$dpi[11].$dpi[12].$dpi[13];

	$TextoCompleto = $Primero." ".$Segundo." ".$Tercero;

	return $TextoCompleto;
}	

function Saber_DPI_Asociado($cif)
{
	$sql= mssql_query("SELECT CIFDOCIDENT06 AS DPI FROM [BANKWORKS]..[SOFTWORKSR2].[CIFGENERALES] WHERE [CIFCODCLIENTE] = '$cif'", mssql_connect("10.60.8.210", "aura", "aura"));
	$row = mssql_fetch_array($sql);
	$CIF = $row["DPI"];
	return $CIF;
}

function Saber_Pasaporte_Asociado($cif)
{
	$sql= mssql_query("SELECT CIFDOCIDENT03 AS DPI FROM [BANKWORKS]..[SOFTWORKSR2].[CIFGENERALES] WHERE [CIFCODCLIENTE] = '$cif'", $db_sql);
	$row = mssql_fetch_array($sql);
	$CIF = $row["DPI"];
	return $CIF;
}

function Saber_DPI_Asociado_Local($cif) {
	$tmp_sql = mysql_fetch_array(mysql_query("SELECT cifdocident06 FROM bankworks.cif_generales WHERE cifcodcliente = $cif ",mysql_connect("10.60.8.207", "funciones", "Sup3radm1n")));
	$nombre_municipio = $tmp_sql['cifdocident06'];
	return $nombre_municipio;
}

function saber_municipio_actu($cod_municipio) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT nombre_municipio FROM info_base.municipios_guatemala WHERE id = $cod_municipio ",mysql_connect("10.60.8.207", "funciones", "Sup3radm1n")));
	$nombre_municipio = $tmp_sql[0];
	return $nombre_municipio;
}

function obtenerFechaEnLetraContratos($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = valorEnLetras(date("j", strtotime($fecha)));
    $anno = valorEnLetras(date("Y", strtotime($fecha)));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' de '.$mes.' de '.$anno;
}

function obtenerFechaEnLetraContratosDias($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = valorEnLetras(date("j", strtotime($fecha)));
    $anno = valorEnLetras(date("Y", strtotime($fecha)));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' días de '.$mes.' de '.$anno;
}

function obtenerFechaEnLetraContratosDias1($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = valorEnLetras(date("j", strtotime($fecha)));
    $anno = valorEnLetras(date("Y", strtotime($fecha)));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' de '.$mes.' de '.$anno;
}
function DiaPagoContrato($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = valorEnLetras(date("j", strtotime($fecha)));
    return $num;
}

function obtenerFechaEnLetraContratosDias2($fecha){
    $dia= conocerDiaSemanaFecha($fecha);
    $num = valorEnLetras(date("j", strtotime($fecha)));
    $anno = valorEnLetras(date("Y", strtotime($fecha)));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' de '.$mes.' de '.trim($anno);
}

function PuntosGarantias($Numero)
{
	if($Numero == 1)
	{
		$Nombre = 'Primera';
	}
	elseif($Numero == 2)
	{
		$Nombre = 'Segunda';
	}
	elseif($Numero == 3)
	{
		$Nombre = 'Tercera';
	}
	elseif($Numero == 4)
	{
		$Nombre = 'Cuarta';
	}
	elseif($Numero == 5)
	{
		$Nombre = 'Quinta';
	}
	elseif($Numero == 6)
	{
		$Nombre = 'Sexta';
	}
	elseif($Numero == 7)
	{
		$Nombre = 'Séptima';
	}
	elseif($Numero == 8)
	{
		$Nombre = 'Octava';
	}
	elseif($Numero == 9)
	{
		$Nombre = 'Novena';
	}
	elseif($Numero == 10)
	{
		$Nombre = 'Décima';
	}

	return $Nombre;
}

function PuntosActa($Numero)
{
	if($Numero == 1)
	{
		$Nombre = 'PRIMERO';
	}
	elseif($Numero == 2)
	{
		$Nombre = 'SEGUNDO';
	}
	elseif($Numero == 3)
	{
		$Nombre = 'TERCERO';
	}
	elseif($Numero == 4)
	{
		$Nombre = 'CUARTO';
	}
	elseif($Numero == 5)
	{
		$Nombre = 'QUINTO';
	}
	elseif($Numero ==6)
	{
		$Nombre = 'SEXTO';
	}
	elseif($Numero == 7)
	{
		$Nombre = 'SEPTIMO';
	}
	elseif($Numero == 8)
	{
		$Nombre = 'OCTAVO';
	}
	elseif($Numero == 9)
	{
		$Nombre = 'NOVENO';
	}
	elseif($Numero == 10)
	{
		$Nombre = 'DECIMO';
	}

	return $Nombre;
}

function ExtendidoPasaporte($Nacionalidad)
{
	if($Nacionalidad == 'Estadounidense')
	{
		$Extendido = 'Estados Unidos';
	}
	elseif($Nacionalidad == 'Hondureño(a)')
	{
		$Extendido = 'Honduras';
	}
	elseif($Nacionalidad == 'Salvadoreño(a)')
	{
		$Extendido = 'El Salvador';
	}
	elseif($Nacionalidad == 'Mexicano(a)')
	{
		$Extendido = 'México';
	}
	elseif($Nacionalidad == 'Nicaragüense')
	{
		$Extendido = 'Nicaragua';
	}
	elseif($Nacionalidad == 'Costarricense')
	{
		$Extendido = 'Costa Rica';
	}
	elseif($Nacionalidad == 'Panameño(a)')
	{
		$Extendido = 'Panamá';
	}
	elseif($Nacionalidad == 'Guatemalteco(a)')
	{
		$Extendido = 'Guatemala';
	}
	elseif($Nacionalidad == 'Ecuatoriano(a)')
	{
		$Extendido = 'Ecuador';
	}


	return $Extendido;
}

function saber_tipo_credito($TipoCredito)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT linea_credito FROM coosajo_gestion_crediticia.linea_creditos WHERE id =  '$TipoCredito'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Nombre = $tmp_sql[0];
	return $Nombre;
}

function Estado_Civil_Letras($Estado, $Sexo)
{
	if($Sexo == 'M')
	{
		if($Estado == 'S')
		{
			$EstadoCivil = 'Soltero';
		}
		elseif($Estado == 'SC')
		{
			$EstadoCivil = 'Soltero';
		}
		elseif($Estado == 'C')
		{
			$EstadoCivil = 'Casado';
		}
		elseif($Estado == 'V')
		{
			$EstadoCivil = 'Viudo';
		}
		elseif($Estado == 'U')
		{
			$EstadoCivil = 'Soltero';
		}
	}
	elseif($Sexo == 'F')
	{
		if($Estado == 'S')
		{
			$EstadoCivil = 'Soltera';
		}
		elseif($Estado == 'SC')
		{
			$EstadoCivil = 'Soltera';
		}
		elseif($Estado == 'C')
		{
			$EstadoCivil = 'Casada';
		}
		elseif($Estado == 'V')
		{
			$EstadoCivil = 'Viuda';
		}
		elseif($Estado == 'U')
		{
			$EstadoCivil = 'Soltera';
		}
	}

	return $EstadoCivil;
}

function Estado_Civil_Numeros($Estado, $Sexo)
{
	if($Sexo == 'M')
	{
		if($Estado == 3)
		{
			$EstadoCivil = 'Soltero';
		}
		elseif($Estado == 2)
		{
			$EstadoCivil = 'Soltero';
		}
		elseif($Estado == 1)
		{
			$EstadoCivil = 'Casado';
		}
		elseif($Estado == 4)
		{
			$EstadoCivil = 'Viudo';
		}
	}
	elseif($Sexo == 'F')
	{
		if($Estado == 3)
		{
			$EstadoCivil = 'Soltera';
		}
		elseif($Estado == 2)
		{
			$EstadoCivil = 'Soltera';
		}
		elseif($Estado == 1)
		{
			$EstadoCivil = 'Casada';
		}
		elseif($Estado == 4)
		{
			$EstadoCivil = 'Viuda';
		}
	}

	return $EstadoCivil;
}

function Nacionalidad_Masculino_Femenino($Nacionalidad, $Sexo)
{
	if($Sexo == 'M')
	{
		$Longitud = strlen($Nacionalidad);
		$Longitud = $Longitud - 4;
		for($i = 0; $i < $Longitud; $i++)
		{
			$Nacionalidad1 .= $Nacionalidad[$i];
		}

		$Nacionalidad1 = $Nacionalidad1.'o';
	}
	elseif($Sexo == 'F')
	{
		$Longitud = strlen($Nacionalidad);
		$Longitud = $Longitud - 4;
		for($i = 0; $i < $Longitud; $i++)
		{
			$Nacionalidad1 .= $Nacionalidad[$i];
		}

		$Nacionalidad1 = $Nacionalidad1.'a';
	}

	return $Nacionalidad1;
}


function Convertir_Acta_Letras($Acta)
{
	$ActaExplotada = explode("-", $Acta);

	$Primero = num2letras($ActaExplotada[0]);
	$Segundo = num2letras($ActaExplotada[1]);

	$Completo = $Primero.' Guión '.$Segundo;

	return $Completo;
}

function Punto_Acta_Letras($Punto)
{
	if($Punto == 1)
	{
		$PuntoLetra = 'Primero (1ro.)';
	}
	elseif($Punto == 2)
	{
		$PuntoLetra = 'Segundo (2do.)';
	}
	elseif($Punto == 3)
	{
		$PuntoLetra = 'Tercero (3ro.)';
	}
	elseif($Punto == 4)
	{
		$PuntoLetra = 'Cuarto (4to.)';
	}
	elseif($Punto == 5)
	{
		$PuntoLetra = 'Quinto (5to.)';
	}
	elseif($Punto == 6)
	{
		$PuntoLetra = 'Sexto (6to.)';
	}
	elseif($Punto == 7)
	{
		$PuntoLetra = 'Séptimo (7mo.)';
	}
	elseif($Punto == 8)
	{
		$PuntoLetra = 'Octavo (8vo.)';
	}
	elseif($Punto == 9)
	{
		$PuntoLetra = 'Noveno (9no.)';
	}
	elseif($Punto == 10)
	{
		$PuntoLetra = 'Décimo (10mo.)';
	}

	return $PuntoLetra;
}


function saber_inciso($i)
{
	if($i == 1)
	{
		$inciso = 'a) ';
	}
	elseif($i == 2)
	{
		$inciso = 'b) ';
	}
	elseif($i == 3)
	{
		$inciso = 'c) ';
	}
	elseif($i == 4)
	{
		$inciso = 'd) ';
	}
	elseif($i == 5)
	{
		$inciso = 'e) ';
	}
	elseif($i == 6)
	{
		$inciso = 'f) ';
	}
	elseif($i == 7)
	{
		$inciso = 'g) ';
	}
	elseif($i == 8)
	{
		$inciso = 'h) ';
	}
	elseif($i == 9)
	{
		$inciso = 'i) ';
	}
	elseif($i == 10)
	{
		$inciso = 'j) ';
	}

	return $inciso;
}

function Direccion_Fiador($cif)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT cifdomicizona, cifdiredomici, cifpaisdomici, cifdeptdomici FROM bankworks.cif_generales WHERE cifcodcliente =  ".$cif,mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	if($tmp_sql[0] != 0)
	{
		$Direccion = $tmp_sql[1]." ZONA ".$tmp_sql[0].", municipio de ".saber_municipio($tmp_sql[2], $tmp_sql[3]).", departamento de ".saber_departamento($tmp_sql[3]);
	}
	else
	{
		$Direccion = $tmp_sql[1].", municipio de ".saber_municipio($tmp_sql[2], $tmp_sql[3]).", departamento de ".saber_departamento($tmp_sql[3]);
	}
	
	return $Direccion;
}

function saber_tipo_garantia($Garantia)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT tipo_garantia FROM coosajo_gestion_crediticia.garantia_inmobiliaria WHERE id_garantia_inmobiliaria =  '$Garantia'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$TipoGarantia = $tmp_sql[0];
	if($TipoGarantia == 1)
	{
		$Nombre = 'Hipotecaria';
	}
	else
	{
		$Nombre = 'Derecho de Poseción';
	}
	return $Nombre;
}


function ExtendidoPasaporteRepublica($Nacionalidad)
{
	if($Nacionalidad == 29)
	{
		$Extendido = 'DE LOS ESTADOS UNIDOS DE AMÉRICA';
	}
	elseif($Nacionalidad == 39)
	{
		$Extendido = 'DE LA REPÚBLICA DE HONDURAS';
	}
	elseif($Nacionalidad == 25)
	{
		$Extendido = 'DE LA REPÚBLICA DE EL SALVADOR';
	}
	elseif($Nacionalidad == 61)
	{
		$Extendido = 'DE LOS ESTADOS UNIDOS MEXICANOS';
	}
	elseif($Nacionalidad == 66)
	{
		$Extendido = 'DE LA REPÚBLICA DE NICARAGUA';
	}
	elseif($Nacionalidad == 21)
	{
		$Extendido = 'DE LA REPÚBLICA DE COSTA RICA';
	}
	elseif($Nacionalidad == 71)
	{
		$Extendido = 'DE LA REPÚBLICA DE PANAMÁ';
	}
	elseif($Nacionalidad == 35)
	{
		$Extendido = 'DE LA REPÚBLICA DE GUATEMALA';
	}
	elseif($Nacionalidad == 23)
	{
		$Extendido = 'DE LA REPÚBLICA DEL ECUADOR';
	}


	return $Extendido;
}

function NombreFiduciario($Solicitud, $CIF)
{
	$tmp_sql = mysql_fetch_array(mysql_query("SELECT nombre_completo FROM coosajo_gestion_crediticia.garantia_fiduciaria WHERE cif = $CIF AND id_solicitud = $Solicitud",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Nombre = $tmp_sql["nombre_completo"];
	
	return $Nombre;
}

function PasaporteEnLetras($Pasaporte)
{
    	//Comprobar si existen letras en el pasaporte
	if (ctype_digit($Pasaporte))
	{
		$ExistenLetras = 1;
	}
	else
	{
		$ExistenLetras = 0;
	}

    //Si el Pasaporte no contiene Letras
	if($ExistenLetras == 1)
	{
		$PasaporteLetras = valorEnLetras($Pasaporte);
		return $PasaporteLetras;
	}
	else
	{	
		if(ctype_digit($Pasaporte[1]))
		{
			$Posicion = 0;
		}
		else
		{
			$Posicion = 1;
		}
		
		$Contador = strlen($Pasaporte);
		$PosicionNueva = $Posicion + 2;

		for($i=$PosicionNueva; $i<=$Contador; $i++)
		{
			$j = $i-1;
			$CadenaNueva .= $Pasaporte[$j];
		}

		for($x= 0; $x<=$Posicion; $x++)
		{
			$Letras .= $Pasaporte[$x];
		}

		if($Pasaporte[1] == 0)
		{
			$Cero = 'Cero';
		}
		else
		{
			$Cero = '';
		}

		$Numeros = valorEnLetras($CadenaNueva);

		$PasaporteLetras = $Letras." ".$Cero." ".$Numeros;

		return $PasaporteLetras;
	}

}
function fecha_ultimo_avaluo($Garantia)
    {
    	$tmp_sql = mysql_fetch_array(mysql_query("SELECT A_FECHA_AVALUO_FISICO
					FROM coosajo_gestion_crediticia.avaluo
					WHERE A_GARANTIA = $Garantia
					ORDER BY A_FECHA_AVALUO_FISICO DESC 
					LIMIT 1", mysql_connect("10.60.8.207", "root", "Sup3rAdm1n")));
		$Fecha = $tmp_sql["A_FECHA_AVALUO_FISICO"];
		if($Fecha == '')
		{
			return 'No posee avalúo registrado en el sistema';
		}
		else
		{
			return date('d-m-Y', strtotime($Fecha));
		}
		
    }

    function fecha_ultimo_avaluo_actualizado($Garantia)
    {
    	$tmp_sql = mysql_fetch_array(mysql_query("SELECT A_FECHA_AVALUO_FISICO
					FROM coosajo_gestion_crediticia.avaluo
					WHERE A_GARANTIA = $Garantia
					ORDER BY A_FECHA_AVALUO_FISICO DESC 
					LIMIT 1", mysql_connect("10.60.8.207", "root", "Sup3rAdm1n")));
		$Fecha = $tmp_sql["A_FECHA_AVALUO_FISICO"];
		if($Fecha == '')
		{
			return 'Primer Avalúo';
		}
		else
		{
			return 'Actualización de Garantía';
		}
		
    }
    function saber_direccion_asociado($cif)
    {
    	$tmp_sql = mysql_fetch_array(mysql_query("SELECT cifdiredomici, cifciuddomici, cifdeptdomici FROM bankworks.cif_generales WHERE cifcodcliente = '".$cif."'", mysql_connect("10.60.8.207", "root", "Sup3rAdm1n")));
		$Nombre = $tmp_sql["cifdiredomici"].", ".saber_municipio($tmp_sql["cifciuddomici"], $tmp_sql["cifdeptdomici"]).", ".saber_departamento($tmp_sql["cifdeptdomici"]);
		return $Nombre;
    }

    function saber_linea_credito($cod)
    {
    	$tmp_sql = mysql_fetch_array(mysql_query("SELECT descripcion 
					FROM  bankworks.lista_instrumento_colocaciones 
					WHERE id = $cod", mysql_connect("10.60.8.207", "root", "Sup3rAdm1n")));
		$Nombre = $tmp_sql["descripcion"];

		return $Nombre;
    }

    function saber_si_es_colaborador($cif)
    {
    	$tmp_sql = mysql_num_rows(mysql_query("SELECT cif
			FROM info_colaboradores.vista_colaboradores_idt
			WHERE (estado =  'Activo' OR estado = 'usr Portal')
			AND cif = ".$cif, mysql_connect("10.60.8.207", "root", "Sup3rAdm1n")));

    	if($tmp_sql > 0)
    	{
    		return 1;
    	}
    	else
    	{
    		return 0;
    	}
    }

    function Saber_Edad_Asociado($cif) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT ciffecnacimie FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$FechaNacimiento = date('d-m-Y', strtotime($tmp_sql[0]));


	return CalculaEdad($FechaNacimiento);
}

function Saber_Nacionalidad_Asociado($cif) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT cifcodnaciona FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Nacionalidad = $tmp_sql[0];


	return saber_nacionalidad($Nacionalidad);
}

function Saber_Estado_Civil_Asociado($cif) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT cifstatcivil FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$EstadoCivil = $tmp_sql[0];


	return Estado_Civil_Letras($EstadoCivil, 'M');
}

function Saber_Profesion_Asociaod($cif) {
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT cifcodprofesi FROM bankworks.cif_generales  WHERE cifcodcliente = '$cif'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Profesion = $tmp_sql[0];


	return saber_profesion_bankworks($Profesion);
}

function Img_Resize($path) {

           $x = getimagesize($path);            
           $width  = $x['0'];
           $height = $x['1'];

           $rs_width  = $width / 2;//resize to half of the original width.
           $rs_height = $height / 2;//resize to half of the original height.

           switch ($x['mime']) {
              case "image/gif":
                 $img = imagecreatefromgif($path);
                 break;
              case "image/jpeg":
                 $img = imagecreatefromjpeg($path);
                 break;
              case "image/png":
                 $img = imagecreatefrompng($path);
                 break;
           }

           $img_base = imagecreatetruecolor($rs_width, $rs_height);
           imagecopyresized($img_base, $img, 0, 0, 0, 0, $rs_width, $rs_height, $width, $height);

           $path_info = pathinfo($path);    
           switch ($path_info['extension']) {
              case "gif":
                 imagegif($img_base, $path);  
                 break;
              case "jpeg":
                 imagejpeg($img_base, $path);  
                 break;
              case "png":
                 imagepng($img_base, $path);  
                 break;
           }
          }
function Saber_Telefono_Asociado($CIF)
{
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT ciftelperso01, ciftelperso02, ciftelcelular FROM bankworks.cif_generales  WHERE cifcodcliente = '$CIF'",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$Telefonos = $tmp_sql[0].', '.$tmp_sql[1].', '.$tmp_sql[2];
	
	return $Telefonos;
}

function saber_correo_colaborador($cif){
	
	$tmp_sql = mysql_fetch_row(mysql_query("SELECT * FROM info_colaboradores.datos_correos
where cif = '$cif' ",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$correo = $tmp_sql[0]."@micoope.coosajo.com";

	return $correo;
}

function saber_codigo_ive($cif_tmp){

	$tmp_sql = mysql_fetch_array(mysql_query("SELECT codigo_ive FROM info_bbdd.usuarios 
where id_user = $cif_tmp",mysql_connect("10.60.8.207", "funciones", "Sup3rAdm1n")));
	$codigo_ive = $tmp_sql["codigo_ive"];
	
	return $codigo_ive;
}
?>