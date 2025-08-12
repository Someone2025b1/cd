<?php
include("../../../../../Script/conex.php");

$QueryFacturasRestaurante = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasRestaurante = mysqli_fetch_array($QueryFacturasRestaurante))
{
	$QueryUnoRestaurante = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA 
										WHERE FACTURA.F_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosRestaurante = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_DETALLE
										WHERE FACTURA_DETALLE.F_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasRestaurante2 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_2 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasRestaurante2 = mysqli_fetch_array($QueryFacturasRestaurante2))
{
	$QueryUnoRestaurante2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_2 
										WHERE FACTURA_2.F_CODIGO = '".$FilaFacturasRestaurante2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosRestaurante2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_2_DETALLE
										WHERE FACTURA_2_DETALLE.F_CODIGO = '".$FilaFacturasRestaurante2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresRestaurante2 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasRestaurante2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroRestaurante2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasRestaurante2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoRestaurante2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasRestaurante2["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasHelados = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_HS AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasHelados = mysqli_fetch_array($QueryFacturasHelados))
{
	$QueryUnoHelados = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_HS 
										WHERE FACTURA_HS.F_CODIGO = '".$FilaFacturasHelados["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosHelados = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_HS_DETALLE
										WHERE FACTURA_HS_DETALLE.F_CODIGO = '".$FilaFacturasHelados["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresHelados = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasHelados["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroHelados = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasHelados["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoHelados = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasHelados["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasSouvenirs = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_SV AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasSouvenirs = mysqli_fetch_array($QueryFacturasSouvenirs))
{
	$QueryUnoSouvenirs = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_SV 
										WHERE FACTURA_SV.F_CODIGO = '".$FilaFacturasSouvenirs["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosSouvenirs = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_SV_DETALLE
										WHERE FACTURA_SV_DETALLE.F_CODIGO = '".$FilaFacturasSouvenirs["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresSouvenirs = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasSouvenirs["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroSouvenirs = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasSouvenirs["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoSouvenirs = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasSouvenirs["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasSouvenirs2 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_SV_2 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasSouvenirs2 = mysqli_fetch_array($QueryFacturasSouvenirs2))
{
	$QueryUnoSouvenirs2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_SV_2 
										WHERE FACTURA_SV_2.F_CODIGO = '".$FilaFacturasSouvenirs2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosSouvenirs2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_SV_2_DETALLE
										WHERE FACTURA_SV_2_DETALLE.F_CODIGO = '".$FilaFacturasSouvenirs2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresSouvenirs2 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasSouvenirs2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroSouvenirs2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasSouvenirs2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoSouvenirs2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasSouvenirs2["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasTaquilla = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_TQ AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasTaquilla = mysqli_fetch_array($QueryFacturasTaquilla))
{
	$QueryUnoTaquilla = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ 
										WHERE FACTURA_TQ.F_CODIGO = '".$FilaFacturasTaquilla["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosTaquilla = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ_DETALLE
										WHERE FACTURA_TQ_DETALLE.F_CODIGO = '".$FilaFacturasTaquilla["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresTaquilla = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasTaquilla["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroTaquilla = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasTaquilla["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoTaquilla = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasTaquilla["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasTaquilla2 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_TQ_2 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasTaquilla2 = mysqli_fetch_array($QueryFacturasTaquilla2))
{
	$QueryUnoTaquilla2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ_2 
										WHERE FACTURA_TQ_2.F_CODIGO = '".$FilaFacturasTaquilla2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosTaquilla2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ_2_DETALLE
										WHERE FACTURA_TQ_2_DETALLE.F_CODIGO = '".$FilaFacturasTaquilla2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresTaquilla2 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasTaquilla2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroTaquilla2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasTaquilla2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoTaquilla2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasTaquilla2["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasTaquilla3 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_TQ_3 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasTaquilla3 = mysqli_fetch_array($QueryFacturasTaquilla3))
{
	$QueryUnoTaquilla3 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ_3 
										WHERE FACTURA_TQ_3.F_CODIGO = '".$FilaFacturasTaquilla3["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosTaquilla3 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ_3_DETALLE
										WHERE FACTURA_TQ_3_DETALLE.F_CODIGO = '".$FilaFacturasTaquilla3["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresTaquilla3 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasTaquilla3["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroTaquilla3 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasTaquilla3["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoTaquilla3 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasTaquilla3["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasTaquilla4 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_TQ_4 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasTaquilla4 = mysqli_fetch_array($QueryFacturasTaquilla4))
{
	$QueryUnoTaquilla4 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ_4 
										WHERE FACTURA_TQ_4.F_CODIGO = '".$FilaFacturasTaquilla4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosTaquilla4 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_TQ_4_DETALLE
										WHERE FACTURA_TQ_4_DETALLE.F_CODIGO = '".$FilaFacturasTaquilla4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresTaquilla4 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasTaquilla4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroTaquilla4 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasTaquilla4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoTaquilla4 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasTaquilla4["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasKiosko = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_KS AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasKiosko = mysqli_fetch_array($QueryFacturasKiosko))
{
	$QueryUnoKiosko = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS 
										WHERE FACTURA_KS.F_CODIGO = '".$FilaFacturasKiosko["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosKiosko = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS_DETALLE
										WHERE FACTURA_KS_DETALLE.F_CODIGO = '".$FilaFacturasKiosko["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresKiosko = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasKiosko["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroKiosko = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasKiosko["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoKiosko = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasKiosko["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasKiosko2 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_KS_2 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasKiosko2 = mysqli_fetch_array($QueryFacturasKiosko2))
{
	$QueryUnoKiosko2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS_2 
										WHERE FACTURA_KS_2.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosKiosko2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS_2_DETALLE
										WHERE FACTURA_KS_2_DETALLE.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresKiosko2 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroKiosko2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoKiosko2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());
}



$QueryFacturasRestaurante = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_RS AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasRestaurante = mysqli_fetch_array($QueryFacturasRestaurante))
{
	$QueryUnoRestaurante = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_RS 
										WHERE FACTURA_RS.F_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosRestaurante = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_RS_DETALLE
										WHERE FACTURA_RS_DETALLE.F_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresRestaurante = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoRestaurante = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasRestaurante["F_CODIGO"]."'")or die(mysqli_error());
}




$QueryFacturasEvento = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_EV AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasEvento = mysqli_fetch_array($QueryFacturasEvento))
{
	$QueryUnoEvento = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_EV 
										WHERE FACTURA_EV.F_CODIGO = '".$FilaFacturasEvento["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosEvento = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_EV_DETALLE
										WHERE FACTURA_EV_DETALLE.F_CODIGO = '".$FilaFacturasEvento["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresEvento = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasEvento["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroEvento = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasEvento["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoEvento = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasEvento["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturashOTEL = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_HC AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturashOTEL = mysqli_fetch_array($QueryFacturashOTEL))
{
	$QueryUnoEvento = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_HC 
										WHERE FACTURA_HC.F_CODIGO = '".$FilaFacturashOTEL["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosEvento = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_HC_DETALLE
										WHERE FACTURA_HC_DETALLE.F_CODIGO = '".$FilaFacturashOTEL["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresEvento = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturashOTEL["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroEvento = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturashOTEL["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoEvento = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturashOTEL["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasPesca = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_PS AS A
										WHERE A.F_FECHA_TRANS > '2021-05-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasPesca = mysqli_fetch_array($QueryFacturasPesca))
{
	$QueryUnoEvento = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_PS 
										WHERE FACTURA_PS.F_CODIGO = '".$FilaFacturasPesca["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosEvento = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_PS_DETALLE
										WHERE FACTURA_PS_DETALLE.F_CODIGO = '".$FilaFacturasPesca["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresEvento = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasPesca["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroEvento = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasPesca["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoEvento = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasPesca["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasKiosko3 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_KS_3 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasKiosko2 = mysqli_fetch_array($QueryFacturasKiosko3))
{
	$QueryUnoKiosko2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS_3 
										WHERE FACTURA_KS_3.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosKiosko2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS_3_DETALLE
										WHERE FACTURA_KS_3_DETALLE.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresKiosko2 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroKiosko2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoKiosko2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasKiosko4 = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_KS_4 AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasKiosko4 = mysqli_fetch_array($QueryFacturasKiosko4))
{
	$QueryUnoKiosko4 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS_4 
										WHERE FACTURA_KS_4.F_CODIGO = '".$FilaFacturasKiosko4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosKiosko4 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_KS_4_DETALLE
										WHERE FACTURA_KS_4_DETALLE.F_CODIGO = '".$FilaFacturasKiosko4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresKiosko4 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasKiosko4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroKiosko4 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasKiosko4["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoKiosko4 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasKiosko4["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasjg = mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_JG AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasKiosko2 = mysqli_fetch_array($QueryFacturasjg))
{
	$QueryUnoKiosko2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_JG 
										WHERE FACTURA_JG.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosKiosko2 = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_JG_DETALLE
										WHERE FACTURA_JG_DETALLE.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresKiosko2 = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroKiosko2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoKiosko2 = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasKiosko2["F_CODIGO"]."'")or die(mysqli_error());
}

$QueryFacturasPizza= mysqli_query($db, "SELECT A.F_CODIGO
										FROM Bodega.FACTURA_PIZZA AS A
										WHERE A.F_FECHA_TRANS > '2018-10-11'
										AND (A.F_CAE = '' or A.F_CAE is null)")or die(mysqli_error());
while($FilaFacturasPizza = mysqli_fetch_array($QueryFacturasPizza))
{
	$QueryUnoKiosko = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_PIZZA 
										WHERE FACTURA_PIZZA.F_CODIGO = '".$FilaFacturasPizza["F_CODIGO"]."'")or die(mysqli_error());

	$QueryDosKiosko = mysqli_query($db, "DELETE 
										FROM Bodega.FACTURA_PIZZA_DETALLE
										WHERE FACTURA_PIZZA_DETALLE.F_CODIGO = '".$FilaFacturasPizza["F_CODIGO"]."'")or die(mysqli_error());

	$QueryTresKiosko = mysqli_query($db, "DELETE Bodega.TRANSACCION.*, Bodega.TRANSACCION_DETALLE.*
										FROM Bodega.TRANSACCION 
										INNER JOIN Bodega.TRANSACCION_DETALLE ON TRANSACCION.TRA_CODIGO = TRANSACCION_DETALLE.TRA_CODIGO 
										WHERE TRANSACCION.F_CODIGO = '".$FilaFacturasPizza["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCuatroKiosko = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION 
											WHERE TRANSACCION.TRA_CODIGO = '".$FilaFacturasPizza["F_CODIGO"]."'")or die(mysqli_error());

	$QueryCincoKiosko = mysqli_query($db, "DELETE FROM Contabilidad.TRANSACCION_DETALLE
											WHERE TRANSACCION_DETALLE.TRA_CODIGO = '".$FilaFacturasPizza["F_CODIGO"]."'")or die(mysqli_error());
}

?>
