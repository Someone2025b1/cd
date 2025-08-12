<?php
ob_start();
session_start();
// Conecto con la base de datos 
// Conexion con la base de datos
	
	$db = mysqli_connect("localhost", "admin","redhat12");
	if (!$db) {
  	echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
 	 exit;
	}
	$db1 = mysqli_connect("localhost", "admin","redhat12",false,131072);
	$db2 = mysqli_connect("localhost", "admin","redhat12",false,131072);
	$db3 = mysqli_connect("localhost", "admin","redhat12",false,131072);
//defino tipo de caracteres a manejar.
	mysqli_set_charset('latin1');
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
	$bbdd_transaciones="coosajo_transacciones";
	$bbdd_caja="coosajo_caja";
	$bbdd_transtel="transtel";
	$coosajo_analizando_acciones="coosajo_analizando_acciones";
	$coosajo_gestion_crediticia="coosajo_gestion_crediticia";
	$db_asociatividad="coosajo_asociatividad_servicio";
	$db_autoregulacion="coosajo_autoregulacion_administrativa";


//defino variables globales para los log's
//ob_flush(); 
?>