<?php 
	error_reporting(error_reporting() & ~E_NOTICE);
	$db = mysqli_connect("10.60.8.206", "root", "redhat12");
	$db1 = mysqli_connect("10.60.8.206", "root", "redhat12",false,131072);
	mysqli_set_charset('latin1');
//	mysqli_set_charset('UTF8');
	$base_asociados              = 'info_asociados';
	$base_general                = 'info_base';
	$bbdd_caja                   = 'coosajo_caja';
	$base_bbdd                   = 'info_bbdd';
	$base_colaboradores          = 'info_colaboradores';
	$bbdd_creditos               = 'creditos';
	$bbdd_formas                 = 'formas_en_blanco';
	$bbdd_normatividad           = 'normatividad';
	$bbdd_noticias               = 'coosajo_noticias';
	$bbdd_cumplimiento           = 'coosajo_supervision';
	$bbdd_desarrollo_humano      = 'coosajo_desarrollo_humano';
	$coosajo_control_comisiones  = 'coosajo_control_comisiones';
	$coosajo_analizando_acciones ="coosajo_analizando_acciones";
?>