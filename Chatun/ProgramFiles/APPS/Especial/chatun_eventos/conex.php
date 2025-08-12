<?php
error_reporting(error_reporting() & ~E_NOTICE);
ob_start();

register_globals();
// Conecto con la base de datos 
// Conexion con la base de datos
	$db = mysql_connect("10.60.8.207", "root","Sup3rAdm1n");
	if (!$db) {
		echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
		exit;
	}
	$db1 = mysql_connect("10.60.8.207", "root","Sup3rAdm1n",false,131072);
	$db2 = mysql_connect("10.60.8.207", "root","Sup3rAdm1n",false,131072);
	$db3 = mysql_connect("10.60.8.207", "root","Sup3rAdm1n",false,131072);
//defino tipo de caracteres a manejar.
	mysql_set_charset('latin1',$db);
//defino variables globales de las tablas
	$base_asociados = 'info_asociados';
	$base_general = 'info_base';
	$base_bbdd = 'info_bbdd';
	$base_colaboradores = 'info_colaboradores';
	$bbdd_creditos = 'creditos';
	$bbdd_formas = 'formas_en_blanco';
	$bbdd_normatividad = 'normatividad';
	$bbdd_noticias = 'coosajo_noticias';
	$bbdd_vehiculos = 'coosajo_supervision';
	$bbdd_cumplimiento = 'coosajo_supervision';
	$bbdd_desarrollo_humano = 'coosajo_desarrollo_humano';
	$bbdd_repositorio_gerencia = 'repositorio_gerencia';
	$bbdd_rti = 'coosajo_rti';
	$bbdd_inventario_idt = 'coosajo_inventario_idt';
	$bbdd_celulas_ahorros = "coosajo_celulas_captaciones";
	$bbdd_mega_ahorro = "coosajo_mega_ahorro";
	$bbdd_transaciones= "coosajo_transacciones";
	$bbdd_caja= "coosajo_caja";
	$bbdd_transtel= "transtel";
	$coosajo_analizando_acciones= "coosajo_analizando_acciones";
	$coosajo_gestion_crediticia= "coosajo_gestion_crediticia";
	$db_asociatividad= "coosajo_asociatividad_servicio";
	$db_autoregulacion= "coosajo_autoregulacion_administrativa";
	$iduser = $_SESSION["iduser"];
	$id_depto = $_SESSION["id_departamento"];


//defino variables globales para los log's
//ob_flush(); 
//

function register_globals($order = 'egpcs')
{
    // define a subroutine
    if(!function_exists('register_global_array'))
    {
        function register_global_array(array $superglobal)
        {
            foreach($superglobal as $varname => $value)
            {
                global $$varname;
                $$varname = $value;
            }
        }
    }
    
    $order = explode("\r\n", trim(chunk_split($order, 1)));
    foreach($order as $k)
    {
        switch(strtolower($k))
        {
            case 'e':    register_global_array($_ENV);        break;
            case 'g':    register_global_array($_GET);        break;
            case 'p':    register_global_array($_POST);        break;
            case 'c':    register_global_array($_COOKIE);    break;
            case 's':    register_global_array($_SERVER);    break;
        }
    }
}
?>