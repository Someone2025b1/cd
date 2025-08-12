<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../libs/ezpdf/class.ezpdf.php");

$Username = $_SESSION["iduser"];
$FechaHoy = date('d-m-Y H:i:s', strtotime('now'));
$MesC = $_GET["Mes"];
$Anho = $_GET["anho"];
$ListMes = mysqli_fetch_array(mysqli_query($db, "SELECT *FROM info_base.lista_meses a WHERE a.id = $MesC"));
$Mes = $ListMes["mes"];
$pdf = new Cezpdf('letter','Landscape');
$pdf->selectFont('../../../../../libs/fonts/Helvetica.afm');
$pdf->ezText(utf8_decode("Asociación para el Crecimiento Educativo Reg."),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("Cooperativo y Apoyo Turístico de Esquipulas"),20,array('justification'=>'center'));
$pdf->ezText(utf8_decode("-ACERCATE-"),22,array('justification'=>'center'));
$pdf->ezText("Libro de Ventas Detallado",16,array('justification'=>'center'));
$pdf->ezText($Mes." del ".$Anho,14,array('justification'=>'center'));
$pdf->ezText($Username." ".$FechaHoy,8,array('justification'=>'right'));
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo = array('col1'=>'Fecha', 'col2'=>'Cliente', 'col3'=>'Nit', 'col4'=>'Documento',  'col5'=>'Serie', 'col6'=>'Autorizacion', 'col7'=>'Bienes', 'col8'=>'Servicios', 'col9'=>'Exportaciones', 'col10'=>'IVA', 'col11'=>'Impuestos', 'col12'=>'Excento', 'col13'=>'Total' );
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones = array('fontSize'=>8, 'width'=>'750', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
/*FIN OPCIONES*/
 $QueryDetalle = mysqli_query($db, "SELECT * FROM(SELECT A.TT_CODIGO, A.TRA_CODIGO, A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'FAC' AS TIPO, A.TRA_SERIE, A.TRA_CAE, A.TRA_DTE, (A.TRA_TOTAL/1.12) AS 'BIENES', 0 AS 'SERVICIOS', ((A.TRA_TOTAL / 1.12) * .12) AS IVA,
(A.TRA_TOTAL- ROUND(((A.TRA_TOTAL / 1.12) * .12), 2)) AS NETO,  A.TRA_TOTAL AS 'SALDO'
FROM Contabilidad.TRANSACCION AS A
WHERE A.TT_CODIGO IN (7,15,8,6,20)
AND MONTH(A.TRA_FECHA_TRANS) = $MesC
AND YEAR(A.TRA_FECHA_TRANS) = $Anho
AND A.E_CODIGO = 2
AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
UNION ALL 
SELECT A.TT_CODIGO, A.TRA_CODIGO, A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'FAC' AS TIPO, A.TRA_SERIE, A.TRA_CAE, A.TRA_DTE, 0 AS 'BIENES', (A.TRA_TOTAL/1.12) AS 'SERVICIOS', ((A.TRA_TOTAL / 1.12) * .12) AS IVA,
(A.TRA_TOTAL- ROUND(((A.TRA_TOTAL / 1.12) * .12), 2)) AS NETO,  A.TRA_TOTAL AS 'SALDO'
FROM Contabilidad.TRANSACCION AS A
WHERE A.TT_CODIGO IN (3,4,5,9,21,22)
AND MONTH(A.TRA_FECHA_TRANS) = $MesC
AND YEAR(A.TRA_FECHA_TRANS) = $Anho
AND A.E_CODIGO = 2
AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
UNION ALL
SELECT A.TT_CODIGO, A.TRA_CODIGO, A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'NC' AS TIPO, A.TRA_SERIE, A.TRA_CAE, A.TRA_DTE, 0 AS 'BIENES', (A.TRA_TOTAL/1.12)*-1 AS 'SERVICIOS', ((A.TRA_TOTAL / 1.12) * .12)*-1 AS IVA,
(A.TRA_TOTAL- ROUND(((A.TRA_TOTAL / 1.12) * .12), 2))*-1 AS NETO,  A.TRA_TOTAL*-1 AS 'SALDO'
FROM Contabilidad.TRANSACCION AS A
WHERE A.TT_CODIGO IN (17)
AND MONTH(A.TRA_FECHA_TRANS) = $MesC
AND YEAR(A.TRA_FECHA_TRANS) = $Anho
AND A.E_CODIGO = 2
AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
UNION ALL
SELECT A.TT_CODIGO, A.TRA_CODIGO, A.TRA_FECHA_TRANS, 'CLIENTES VARIOS' CLIENTE, 'CF' AS NIT, 'NC' AS TIPO, A.TRA_SERIE, A.TRA_CAE, A.TRA_DTE, 0 AS 'BIENES', (A.TRA_TOTAL/1.12) AS 'SERVICIOS', ((A.TRA_TOTAL / 1.12) * .12) AS IVA,
(A.TRA_TOTAL- ROUND(((A.TRA_TOTAL / 1.12) * .12), 2)) AS NETO,  A.TRA_TOTAL AS 'SALDO'
FROM Contabilidad.TRANSACCION AS A
WHERE A.TT_CODIGO IN (18)
AND MONTH(A.TRA_FECHA_TRANS) = $MesC
AND YEAR(A.TRA_FECHA_TRANS) = $Anho
AND A.E_CODIGO = 2
AND (A.TRA_CONCEPTO <> 'FACTURA ANULADA' AND A.TRA_CONCEPTO <> 'PÓLIZA ANULADA') AND A.TRA_ESTADO = 1
 )dum
 ORDER BY TRA_FECHA_TRANS
 ");

 $Conteo = mysqli_num_rows($QueryDetalle);
                                            while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
                                            {
                                                if ($FilaDetalle["TT_CODIGO"]==6) 
                                                {
                                                    $Punto = 'FACTURA_HS';
                                                }
                                                elseif ($FilaDetalle["TT_CODIGO"]==15)
                                                { 
                                                    $Punto = 'FACTURA_KS';
                                                }
                                                elseif ($FilaDetalle["TT_CODIGO"]==15)
                                                {
                                                    $Punto = 'FACTURA_KS_2';
                                                }
                                                elseif ($FilaDetalle["TT_CODIGO"]==9)
                                                { 
                                                    $Punto = 'FACTURA_TQ';
                                                }
                                                elseif ($FilaDetalle["TT_CODIGO"]==8)
                                                { 
                                                    $Punto = 'FACTURA_SV';
                                                }
                                                elseif ($FilaDetalle["TT_CODIGO"]==7)
                                                { 
                                                    $Punto = 'FACTURA';
                                                }
                                                elseif ($FilaDetalle["TT_CODIGO"]==22)
                                                { 
                                                    $Punto = 'FACTURA_HC';
                                                }
                                                 elseif ($FilaDetalle["TT_CODIGO"]==20)
                                                { 
                                                    $Punto = 'FACTURA_RS';
                                                }
                                                  elseif ($FilaDetalle["TT_CODIGO"]==21)
                                                { 
                                                    $Punto = 'FACTURA_EV';
                                                }

                                                $SerieCae = mysqli_fetch_array(mysqli_query($db, "SELECT A.F_SERIE, A.F_CAE, A.F_DTE FROM Bodega.$Punto A WHERE A.F_CODIGO = '$FilaDetalle[TRA_CODIGO]'"));
                                                $SerieCae1 = mysqli_fetch_array(mysqli_query($db, "SELECT A.F_SERIE, A.F_CAE, A.F_DTE FROM Bodega.FACTURA_KS_2 A WHERE A.F_CODIGO = '$FilaDetalle[TRA_CODIGO]'"));
                                                $Fecha = date('d-m-Y', strtotime($FilaDetalle["TRA_FECHA_TRANS"]));
                                                $Cliente = $FilaDetalle['CLIENTE'];
                                                $NIT = $FilaDetalle['NIT'];
                                                $Documento = $FilaDetalle['TIPO'];
                                                if($FilaDetalle["TT_CODIGO"]==17)
                                                {   
                                                 $Serie = $FilaDetalle['TRA_CAE'];
                                                 $Autorizacion = $FilaDetalle['TRA_DTE'];
                                                }
                                                else
                                                { 
                                                $Serie = $SerieCae['F_SERIE'];
                                                $Autorizacion = $SerieCae['F_CAE'].$SerieCae1['F_CAE'];
                                                }
                                              
 
                                                // if($FilaDetalle['TRA_SERIE'] == 'D' || $FilaDetalle['TRA_SERIE'] == 'E' || $FilaDetalle['TRA_SERIE'] == 'F' || $FilaDetalle['TRA_SERIE'] == 'I' || $FilaDetalle['TRA_SERIE'] == 'L')
                                                // {
                                                //     $Bienes = $FilaDetalle['NETO'];
                                                //     $Servicios = 0;

                                                //     $BienesMostrar = number_format($FilaDetalle['NETO'], 2);
                                                //     $ServiciosMostrar = number_format(0, 2);
                                                // }
                                                // else
                                                // {
                                                //     $Bienes = 0;
                                                //     $Servicios = $FilaDetalle['NETO'];

                                                //     $BienesMostrar = number_format(0, 2);
                                                //     $ServiciosMostrar = number_format($FilaDetalle['NETO'], 2);
                                                // }

                                                $Bienes = $FilaDetalle['BIENES'];
                                                $Servicios = $FilaDetalle['SERVICIOS'];

                                                $ExportacionesMostrar = number_format(0, 2);

                                                $Iva = $FilaDetalle['IVA'];
                                                $Total = $FilaDetalle['SALDO'];

                                                $IVAMostrar = number_format($FilaDetalle['IVA'], 2);
                                                $TotalMostrar = number_format($FilaDetalle['SALDO'], 2);
                                                $Cliente = $FilaDetalle['CLIENTE'];

                                                $BienesTotal = $BienesTotal + $Bienes;
                                                $ServiciosTotal = $ServiciosTotal + $Servicios;
                                                $IvaTotal = $IvaTotal + $Iva;
                                                $TotalTotal = $TotalTotal + $Total;

                        
            $Data[] = array('col1'=>$Fecha, 'col2'=>$Cliente, 'col3'=>$NIT, 'col4'=>$Documento, 'col5'=>$Serie, 'col6'=>$Autorizacion,  'col7'=>number_format($Bienes,2), 'col8'=>number_format($Servicios,2), 'col9'=>$ExportacionesMostrar, 'col10'=>$IVAMostrar, 'col11'=>0.00, 'col12'=>0.00, 'col13'=>$TotalMostrar);

            
     
}

$BienesMostrarTotal = number_format($BienesTotal, 2);
$ServiciosMostrarTotal = number_format($ServiciosTotal, 2);
$ExportacionesMostrar = number_format(0, 2);
$IVAMostrarTotal = number_format($IvaTotal, 2);
$TotalMostrarTotal = number_format($TotalTotal, 2);

$BienesI = $BienesTotal*0.12;
$ServiciosI = $ServiciosTotal*0.12;
$TotalI = $BienesI + $ServiciosI;

$TotBien = $BienesTotal + $BienesI;
$TotServicios = $ServiciosTotal + $ServiciosI;
$TotT = $TotBien + $TotServicios;

$TotalSub = $BienesTotal + $ServiciosTotal;
$Data[] = array('col7'=>$BienesMostrarTotal, 'col8'=>$ServiciosMostrarTotal, 'col9'=>$ExportacionesMostrar, 'col10'=>$IVAMostrarTotal,'col13'=>$TotalMostrarTotal, 'col1'=>'', 'col1'=>'TOTALES');

$pdf->ezTable($Data, $Titulo,'', $Opciones);
$pdf->ezText("", 14);

/*TITULOS*/
    $Titulo2 = array('col1'=>'',  'col2'=>'', 'col3'=>'Recuento de '.number_format($Conteo).' documentos', 'col4'=>'', 'col5'=>'', 'col6'=>'' );
/*TITULOS*/
    $Data1[]= array('col1'=>'Descripcion', 'col2'=>'Bienes', 'col3'=>'Servicios', 'col4'=>'Exportaciones', 'col5'=>'Excento', 'col6'=>'Total' );
/*FIN TITULOS*/

/*OPCIONES*/
    $Opciones1 = array('fontSize'=>8, 'width'=>'300', 'shaded'=>1, 'shadeHeadingCol'=>array(0.6,0.6,0.5));
 
$Data1[] = array('col1'=>'Sub-Total', 'col2'=>'Q. '.$BienesMostrarTotal, 'col3'=>'Q. '.$ServiciosMostrarTotal, 'col4'=>'Q. '.'0.00','col5'=>'Q. '.'0.00', 'col6'=>'Q. '.number_format($TotalSub,2));
 
$Data1[] = array('col1'=>'Debito Fiscal', 'col2'=>'Q. '.number_format($BienesI,2), 'col3'=>'Q. '.number_format($ServiciosI,2), 'col4'=>'Q. '.'0.00','col5'=>'Q. '.'0.00', 'col6'=>'Q. '.number_format($TotalI,2));

 
$Data1[] = array('col1'=>'Gran Total', 'col2'=>'Q. '.number_format($TotBien,2), 'col3'=>'Q. '.number_format($TotServicios,2), 'col4'=>'Q. '.'0.00','col5'=>'Q. '.'0.00', 'col6'=>'Q. '.number_format($TotT,2));

 
$pdf->ezTable($Data1, $Titulo2, $Opciones1);

ob_clean();
$pdf->ezStream();
?>