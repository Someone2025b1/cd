<?php
function cambio_fecha_gua($f) {
	$f = str_replace("/","-",$f);
	$desglose=split("-",$f);
	$resultado=$desglose[2]."-".$desglose[1]."-".$desglose[0];
	return $resultado;
}
function cambio_fecha_usa($f) {
	$f = str_replace("/","-",$f);
	$desglose=split("-",$f);
	$resultado=$desglose[2]."-".$desglose[1]."-".$desglose[0];
	return $resultado;
}
?>