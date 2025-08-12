<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php"); 
include("../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$MesF = $_GET["Mes"];
$Anio = $_GET["Anio"];
 
if (isset($MesF)) 
{
    $Filtro = "AND MONTH(a.Fecha) = '$MesF' AND YEAR(a.Fecha) = '$Anio'";
    $FiltroB = "AND MONTH(b.Fecha) = '$MesF' AND YEAR(b.Fecha) = '$Anio'";
    $FiltroTerminado = "WHERE MONTH(A.Fecha) = '$MesF' AND YEAR(A.Fecha) = '$Anio'";
}
else
{
    $Filtro = "";
    $FiltroB = "";
    $FiltroTerminado = "";
}
$MesD = nombre_mes($MesF);
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal Institucional Chatún</title>

    <!-- BEGIN META -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="your,keywords">
    <!-- END META -->

    <!-- BEGIN STYLESHEETS -->
    <script src="../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
    <script src="../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="../../../../js/libs/bootstrap/bootstrap.min.js"></script>
    <script src="../../../../js/libs/spin.js/spin.min.js"></script>
    <script src="../../../../js/libs/autosize/jquery.autosize.min.js"></script>
    <script src="../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
    <script src="../../../../js/core/source/App.js"></script>
    <script src="../../../../js/core/source/AppNavigation.js"></script>
    <script src="../../../../js/core/source/AppOffcanvas.js"></script>
    <script src="../../../../js/core/source/AppCard.js"></script>
    <script src="../../../../js/core/source/AppForm.js"></script>
    <script src="../../../../js/core/source/AppNavSearch.js"></script>
    <script src="../../../../js/core/source/AppVendor.js"></script>
    <script src="../../../../js/core/demo/Demo.js"></script>
    <script src="../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../../../../libs/alertify/js/alertify.js"></script>
    <script src="../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
    <!-- END JAVASCRIPT -->

    <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
    <link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
    <link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
 
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

    <?php include("../../../MenuTop.php") ?>

    <!-- BEGIN BASE-->
    <form action="Dashboard.php" method="GET">
        <div id="base">    
            <h1 class="text-center"><strong>Costo - Inventario de Concentrado Consumido</strong><br></h1>
            <br>
            <div class="row">
                <div class="col-xs-1"></div>
                    <div class="col-xs-10">
                    <div class="card">
                            <div class="card-head style-primary">
                                <h3 class="text-center"><strong>Resumen</strong></h3>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">  
                                    <div class="col-lg-5"> 
                                            <label for="Mes"><h3>Mes</h3></label>
                                            <select name="Mes" id="Mes" class="form-control">
                                                <option selected disabled>Seleccione</option>
                                                <?php 
                                                $Mes = mysqli_query($db, "SELECT *FROM info_base.lista_meses a ORDER BY a.id asc");
                                                while ($RowMes = mysqli_fetch_array($Mes)) { 
                                                ?>
                                                <option value="<?php echo $RowMes["id"]?>"><?php echo $RowMes["mes"] ?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select> 
                                    </div>
                                    <div class="col-lg-5"> 
                                            <label for="Anio"><h3>Año</h3></label>
                                             <select name="Anio" id="Anio" class="form-control">
                                                <option selected disabled>Seleccione</option>
                                                <?php 
                                                $ListAnio = mysqli_query($db, "SELECT *FROM info_base.lista_anios a ORDER BY a.id asc");
                                                while ($RowAnio = mysqli_fetch_array($ListAnio)) { 
                                                ?>
                                                <option value="<?php echo $RowAnio["anio"]?>"><?php echo $RowAnio["anio"] ?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select> 
                                    </div> 
                                    <div class="col-lg-2" id="divBoton"><br><br>
                                        <button type="submit" class="btn btn-info btn-circle"><i class="fa fa-check" ></i>
                                    </button>
                                    </div>
                                </div> 
                        <div align="center">
                            <img src="../../../../img/Preloader.gif" width="64" height="64" id="GifCargando" style="display: none">     
                        </div>                          
                    </div>
                </div> 
            </div>
        </div> 
<br>
         <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-xs-10">
            <div class="card">
                <div class="card-head style-primary">
                    <h4 class="text-center"><strong>Unidades <?php echo $MesD." - ".$Anio ?></strong></h4>  
                </div>
                <div class="card-body"> 
                     <?php 
                     $Estanques = mysqli_query($db, "SELECT a.IdEstanque, a.InventarioInicial  FROM Pisicultura.Estanque a  WHERE a.Estado = 1
                                    ORDER BY a.Correlativo ASC ");
                                   while ($RowA = mysqli_fetch_array($Estanques)) 
                                     {
                                        $Totales = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.UnidadesTraslado) AS Traslado, SUM(a.CantidadCompra) AS Compras, SUM(a.UnidadesMortalidad) AS Mortalidad, SUM(a.UnidadesTerminadas) AS Terminados, SUM(a.LibrasTerminadas) AS Libras FROM Bodega.CONTROL_PISICULTURA a 
                                        WHERE a.Estanque = '$RowA[IdEstanque]' $Filtro")); 
                                        $Traslado = $Totales["Traslado"] + $Totales["Compras"];
                                        $Mortalidad = $Totales["Mortalidad"];
                                        $Terminados = $Totales["Terminados"];
                                        $Peso = $Totales["Libras"];
                                        $Final = $RowA["InventarioInicial"] + $Traslado - $Mortalidad - $Terminados; 
                                        $chart_data3 .= "{country:'Estanque: ".$RowA["IdEstanque"]."', value:'".$Final."'}, "; 
                                        $Exist += $Final;
                                        $Mort += $Mortalidad;
                                    }
                                    $chart_data3 = substr($chart_data3, 0, -2); 
                                    $TerminadosU = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(A.UnidadesTerminadas) AS Terminados, SUM(A.LibrasTerminadas) AS Libras FROM Bodega.CONTROL_PISICULTURA A $FiltroTerminado"));
                                    $Uni = number_format($TerminadosU["Terminados"],2);
                                    $Libras = number_format($TerminadosU["Libras"],2);
                     ?>
                     <div id="chartdiv"></div> <br><br>
                     <div class="row">
                         <div class="col-lg-4">
                             <div class="alert alert-warning" role="alert">
                              <h2 class="text-center">Producción Terminados</h2> 
                              <h3><?php echo $Uni?> Unidades</h3>
                              <h3><?php echo $Libras?> Libras</h3>
                            </div>
                         </div>
                         <div class="col-lg-4">
                             <div class="alert alert-success" role="alert">
                              <h2 class="text-center">Existencia</h2> 
                              <h3 class="text-center"><?php echo $Exist?></h3>
                            </div>
                         </div>
                         <div class="col-lg-4">
                             <div class="alert alert-danger" role="alert"> 
                              <h2 class="text-center">Mortalidad</h2> 
                              <h3 class="text-center"><?php echo $Mort?></h3>
                              </div>
                            </div>
                         </div>
                     </div>     
                </div>
                </div>  
            </div>  
        <br>
        <div class="row">
            <div class="col-xs-1"></div>
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-head style-primary">
                        <h4 class="text-center"><strong>Costo - Inventario de Concentrado Consumido <br>
                        <?php echo $MesD." - ".$Anio ?></strong></h4>
                    </div>
                    <div class="card-body"> 
                        <div class="row text-center">   
                        <div class="row">
                            <table class="table table-hover table-condensed" id="table">
                                <tbody>
                                <tr bgcolor="#A4A9A4">
                                     <td> </td>
                                     <?php 
                                     $Alimento = mysqli_query($db, "SELECT * FROM Pisicultura.Producto_Pisicultura a WHERE a.Tipo = 1 and a.Estado = 1 ORDER BY a.IdProducto asc");
                                     while ($RowA = mysqli_fetch_array($Alimento)) 
                                     {
                                     ?>
                                     <td class="text-right"><b><?php echo $RowA["Descripcion"] ?></b></td>
                                     <?php 
                                     }
                                     ?>
                                     <td class="text-center"><b>TOTAL</b></td>
                                </tr>
                                <tr>
                                      <?php 
                                    $Inicial1 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.InventarioInicial) AS Cantidad FROM Pisicultura.Producto_Pisicultura a WHERE a.IdProducto = 1"));
                                    $Inicial2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.InventarioInicial) AS Cantidad FROM Pisicultura.Producto_Pisicultura a WHERE a.IdProducto = 2"));
                                    $Inicial3 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.InventarioInicial) AS Cantidad FROM Pisicultura.Producto_Pisicultura a WHERE a.IdProducto = 3"));
                                    $Inicial4 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.InventarioInicial) AS Cantidad FROM Pisicultura.Producto_Pisicultura a WHERE a.IdProducto = 4"));
                                    $TotalInicial = $Inicial1["Cantidad"] + $Inicial2["Cantidad"] + $Inicial3["Cantidad"] + $Inicial4["Cantidad"];
                                    ?>
                                     <td>Inicial</td>
                                     <td class="text-right"><?php echo number_format($Inicial1["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($Inicial2["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($Inicial3["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($Inicial4["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($TotalInicial,2); ?></td>
                                </tr>
                                 <tr>
                                    <?php 
                                    $Conc1 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Cantidad) AS Cantidad FROM Bodega.COMPRA_ALEVINES a WHERE a.Producto = 1 $Filtro "));
                                    $Conc2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Cantidad) AS Cantidad FROM Bodega.COMPRA_ALEVINES a WHERE a.Producto = 2 $Filtro "));
                                    $Conc3 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Cantidad) AS Cantidad FROM Bodega.COMPRA_ALEVINES a WHERE a.Producto = 3 $Filtro "));
                                    $Conc4 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Cantidad) AS Cantidad FROM Bodega.COMPRA_ALEVINES a WHERE a.Producto = 4 $Filtro "));
                                    $TotalConsumo = $Conc1["Cantidad"] + $Conc2["Cantidad"] + $Conc3["Cantidad"] + $Conc4["Cantidad"];
                                    ?>
                                     <td>Compras</td>
                                     <td class="text-right"><?php echo number_format($Conc1["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($Conc2["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($Conc3["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($Conc4["Cantidad"],2); ?></td>
                                     <td class="text-right"><?php echo number_format($TotalConsumo,2); ?></td>
                                </tr>
                                <tr bgcolor="#BCDEEE">
                                     <?php 
                                    $Cons1 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Cantidad FROM Bodega.ALIMENTACION_PECES a INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id WHERE a.TipoAlimento = 1 $FiltroB"));
                                    $Cons2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Cantidad FROM Bodega.ALIMENTACION_PECES a INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id WHERE a.TipoAlimento = 2 $FiltroB"));
                                    $Cons3 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Cantidad FROM Bodega.ALIMENTACION_PECES a INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id WHERE a.TipoAlimento = 3 $FiltroB"));
                                    $Cons4 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Cantidad FROM Bodega.ALIMENTACION_PECES a INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id WHERE a.TipoAlimento = 4 $FiltroB"));
                                    $TotalConsumoC = $Cons1["Cantidad"] + $Cons2["Cantidad"] + $Cons3["Cantidad"] + $Cons4["Cantidad"];
                                    ?>
                                     <td>Consumo</td>
                                     <td class="text-right"><?php echo number_format($Cons1["Cantidad"]/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($Cons2["Cantidad"]/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($Cons3["Cantidad"]/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($Cons4["Cantidad"]/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($TotalConsumoC/100,2); ?></td>
                                </tr>
                                <tr bgcolor="#4FDA2B">
                                    <?php 
                                    $InvCont1 = $Inicial1["Cantidad"] + $Conc1["Cantidad"] - ($Cons1["Cantidad"]/100);
                                    $InvCont2 = $Inicial2["Cantidad"] + $Conc2["Cantidad"] - ($Cons2["Cantidad"]/100);
                                    $InvCont3 = $Inicial3["Cantidad"] + $Conc3["Cantidad"] - ($Cons3["Cantidad"]/100);
                                    $InvCont4 = $Inicial4["Cantidad"] + $Conc4["Cantidad"] - ($Cons4["Cantidad"]/100);
                                    $TotalInvCont = $InvCont1 + $InvCont2 + $InvCont3 + $InvCont4;
                                    ?>
                                     <td>Inventario Final - Contabilidad</td>
                                     <td class="text-right"><?php echo number_format($InvCont1,2); ?></td>
                                     <td class="text-right"><?php echo number_format($InvCont2,2); ?></td>
                                     <td class="text-right"><?php echo number_format($InvCont3,2); ?></td>
                                     <td class="text-right"><?php echo number_format($InvCont4,2); ?></td>
                                     <td class="text-right"><?php echo number_format($TotalInvCont,2); ?></td>
                                </tr>
                                <tr bgcolor="#E0E327"> 
                                    <?php 
                                    $InvFinal1 = $Inicial1["Cantidad"] + $Conc1["Cantidad"] - $Cons1["Cantidad"];
                                    $InvFinal2 = $Inicial2["Cantidad"] + $Conc2["Cantidad"] - $Cons2["Cantidad"];
                                    $InvFinal3 = $Inicial3["Cantidad"] + $Conc3["Cantidad"] - $Cons3["Cantidad"];
                                    $InvFinal4 = $Inicial4["Cantidad"] + $Conc4["Cantidad"] - $Cons4["Cantidad"];
                                    $TotalInvFinal = $InvFinal1 + $InvFinal2 + $InvFinal3 + $InvFinal4;
                                    ?>
                                     <td>Inventario Final - Fisico</td>
                                     <td class="text-right"><?php echo number_format($InvFinal1/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($InvFinal2/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($InvFinal3/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($InvFinal4/100,2); ?></td>
                                     <td class="text-right"><?php echo number_format($TotalInvCont/100,2); ?></td>
                                </tr>
                                <tr bgcolor="#EE2413">
                                    <?php 
                                    $VariacionP1 = $InvCont1 - $InvFinal1;
                                    $VariacionP2 = $InvCont2 - $InvFinal2;
                                    $VariacionP3 = $InvCont3 - $InvFinal3;
                                    $VariacionP4 = $InvCont4 - $InvFinal4;
                                    $TotalVariacionP = $VariacionP1 + $VariacionP2 + $VariacionP3 + $VariacionP4;
                                    ?>
                                     <td><b>Variación de Producción</b></td>
                                     <td class="text-right"><b><?php echo number_format($VariacionP1,2); ?></b></td>
                                     <td class="text-right"><b><?php echo number_format($VariacionP2,2); ?></b></td>
                                     <td class="text-right"><b><?php echo number_format($VariacionP3,2); ?></b></td>
                                     <td class="text-right"><b><?php echo number_format($VariacionP4,2); ?></b></td>
                                     <td class="text-right"><b><?php echo number_format($TotalVariacionP,2); ?></b></td>
                                </tr>
                            <?php  
                            ?>
                                </tbody>
                                <tfoot>
                                    <tr bgcolor="#A4A9A4">
                                        <td align="center"><b>Total de Variacion (Q)</b></td>
                                        <td align="right"><b><?php echo number_format($CostoA,2) ?></b></td>
                                        <td align="right"><b><?php echo number_format($CostoUT,2) ?></b></td>
                                        <td align="right"><b><?php echo number_format($CostoLT,2) ?></b></td>  
                                        <td align="right"><b><?php echo number_format(1,2) ?></b></td>
                                        <td align="right"><b><?php echo number_format($CostoTR,2) ?></b></td>  
                                    </tr>
                                </tfoot>

                            </table>
                        </div>  
                    </div>
                </div>  
            </div>
            </div>
            <br> 
            <div class="row">
                <div class="col-xs-6">
                <div class="card">
                    <div class="card-head style-primary">
                        <h4 class="text-center"><strong>Consumo de Concentrado por Estanque (qq) <br>
                        <?php echo $MesD." - ".$Anio ?></strong></h4>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <table class="table table-hover table-condensed" id="table">
                                <tbody>
                                <tr bgcolor="#A4A9A4">
                                     <td class="text-center"><b>Tipo de Concentrado</b></td>
                                     <?php 
                                     $Alimento = mysqli_query($db, "SELECT * FROM Pisicultura.Producto_Pisicultura a WHERE a.Tipo = 1 and a.Estado = 1  ORDER BY a.IdProducto asc");
                                     while ($RowA = mysqli_fetch_array($Alimento)) 
                                     {
                                     ?>
                                     <td class="text-center"><b><?php echo $RowA["Descripcion"] ?></b></td>
                                     <?php 
                                     }
                                     ?>
                                     <td class="text-center"><b>TOTAL</b></td>
                                </tr>
                                <?php 
                                    $Estanques = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque a  WHERE a.Estado = 1 ORDER BY a.Correlativo ASC ");
                                   while ($RowA = mysqli_fetch_array($Estanques)) 
                                     {
                                        $Alimento1 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Libras FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 1 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB"));
                                        $Alimento2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Libras FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 2 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB"));
                                        $Alimento3 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Libras FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 3 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB"));
                                        $Alimento4 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CantidadLibras) AS Libras FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 4 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB"));
                                        $TotalLibras = $Alimento1["Libras"] + $Alimento2["Libras"] + $Alimento3["Libras"] + $Alimento4["Libras"];
                                        $Suma1 +=  $Alimento1["Libras"];
                                        $Suma2 +=  $Alimento2["Libras"]; 
                                        $Suma3 +=  $Alimento3["Libras"]; 
                                        $Suma4 +=  $Alimento4["Libras"]; 
                                ?>
                                <tr>  
                                     <td  style="font-size:80%;">Estanque: <?php echo $RowA["IdEstanque"]; ?></td> 
                                     <td class="text-center"><?php echo number_format($Alimento1["Libras"],2); ?></td>
                                     <td class="text-center"><?php echo number_format($Alimento2["Libras"],2); ?></td>
                                     <td class="text-center"><?php echo number_format($Alimento3["Libras"],2); ?></td>
                                     <td class="text-center"><?php echo number_format($Alimento4["Libras"],2); ?></td>
                                     <td class="text-center"><?php echo number_format($TotalLibras,2); ?></td>
                                </tr> 
                                <?php 
                                    }
                                    $TotalCon =  $Suma1 +  $Suma2 +  $Suma3 +  $Suma4;
                                ?>   
                                </tbody>
                                <tfoot>
                                    <tr bgcolor="#A4A9A4">
                                     <td><b>Total</b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma1,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma2,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma3,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma4,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($TotalCon,2); ?></b></td> 
                                    </tr>
                                    <tr bgcolor="#BCDEEE">
                                     <td><b>Sacos</b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma1/100,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma2/100,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma3/100,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($Suma4/100,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($TotalCon/100,2); ?></b></td> 
                                    </tr>
                                </tfoot> 
                                </table>
                            </div>  
                        </div>
                    </div>  
                </div>   
                <div class="col-xs-6">
                <div class="card">
                    <div class="card-head style-primary">
                        <h4 class="text-center"><strong>Unidades <?php echo $MesD." - ".$Anio ?></strong></h4>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <table class="table table-hover table-condensed" id="table">
                                <tbody>
                                <tr bgcolor="#A4A9A4"> 
                                     <td class="text-center"><b>Ubicación</b></td>
                                     <td class="text-center"><b>Inventario Inicial</b></td>
                                     <td class="text-center"><b>Compras/Traslados</b></td>
                                     <td class="text-center"><b>Mortalidad</b></td>
                                     <td class="text-center"><b>Productos Terminados</b></td>
                                     <td class="text-center"><b>Inventario Final PP</b></td>
                                     <td class="text-center"><b>Peso Libras</b></td>
                                </tr>
                                <?php  
                                    $Estanques = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque a WHERE a.Estado = 1
                                    ORDER BY a.Correlativo ASC ");
                                   while ($RowA = mysqli_fetch_array($Estanques)) 
                                     {

                                        $InicialEstanque = mysqli_fetch_array(mysqli_query($db, "SELECT a.CantidadInicial FROM Bodega.INVENTARIO_INICIAL_PECES a
                                        WHERE a.IdEstanque = '$RowA[IdEstanque]' AND a.Mes = $MesF AND a.Anio = $Anio"));
                                        $Totales = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.UnidadesTraslado) AS Traslado, SUM(a.CantidadCompra) AS Compras, SUM(a.UnidadesMortalidad) AS Mortalidad, SUM(a.UnidadesTerminadas) AS Terminados, SUM(a.LibrasTerminadas) AS Libras FROM Bodega.CONTROL_PISICULTURA a 
                                        WHERE a.Estanque = '$RowA[IdEstanque]' $Filtro")); 
                                        $Traslado = $Totales["Traslado"] + $Totales["Compras"];
                                        $Mortalidad = $Totales["Mortalidad"];
                                        $Terminados = $Totales["Terminados"];
                                        $Peso = $Totales["Libras"];
                                        $Final = $InicialEstanque["CantidadInicial"] + $Traslado - $Mortalidad - $Terminados;
                                        $TotalLibras = $Alimento1["Libras"] + $Alimento2["Libras"] + $Alimento3["Libras"] + $Alimento4["Libras"];
                                        $Suma1 +=  $Alimento1["Libras"];
                                        $Suma2 +=  $Alimento2["Libras"]; 
                                        $Suma3 +=  $Alimento3["Libras"]; 
                                        $Suma4 +=  $Alimento4["Libras"]; 
                                ?>
                                <tr>  
                                     <td style="font-size:80%;">Estanque: <?php echo $RowA["IdEstanque"]; ?></td> 
                                     <td class="text-center"><?php echo $InicialEstanque["CantidadInicial"]; ?></td>
                                     <td class="text-center"><?php echo number_format($Traslado,2); ?></td>
                                     <td class="text-center"><?php echo number_format($Mortalidad,2); ?></td>
                                     <td class="text-center"><?php echo number_format($Terminados,2); ?></td>
                                     <td class="text-center"><?php echo number_format($Final,2); ?></td>
                                     <td class="text-center"><?php echo number_format($Peso,2); ?></td>
                                </tr> 
                                <?php 
                                    $TotalPeso += $Peso;
                                    $Exist1 += $Final;
                                    $InicialT += $InicialEstanque["CantidadInicial"];
                                    $ComprasT += $Traslado;
                                    $MortT += $Mortalidad;
                                    $TerminadoT += $Terminados;
                                    }
                                  
                                ?>   
                                </tbody>
                                <tfoot>
                                    <tr bgcolor="#A4A9A4">
                                     <td><b>Total</b></td>
                                     <td class="text-center"><b><?php echo number_format($InicialT,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($ComprasT,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($MortT,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($TerminadoT,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($Exist1,2); ?></b></td>
                                     <td class="text-center"><b><?php echo number_format($TotalPeso,2); ?></b></td>  
                                    </tr>
                                    <tr bgcolor="#BCDEEE"> 
                                    </tr>
                                </tfoot> 
                                </table>
                            </div>  
                        </div>
                    </div>  
                </div> 
        </div>
         <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-head style-primary">
                        <h4 class="text-center"><strong>Costo en Unidades Monetarias <?php echo $MesD." - ".$Anio ?></strong></h4>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <table class="table table-hover table-condensed" id="table">
                                <tbody>
                                <tr bgcolor="#A4A9A4">
                                     <td class="text-center"><b>Tipo de Concentrado</b></td>
                                     <?php 
                                     $Alimento = mysqli_query($db, "SELECT * FROM Pisicultura.Producto_Pisicultura a WHERE a.Tipo = 1 and a.Estado = 1  ORDER BY a.IdProducto asc");
                                     while ($RowA = mysqli_fetch_array($Alimento)) 
                                     {
                                     ?>
                                     <td class="text-center"><b><?php echo $RowA["Descripcion"] ?></b></td>
                                     <?php 
                                     }
                                     ?>
                                     <td class="text-center"><b>TOTAL</b></td>
                                </tr>
                                <?php 
                                    $Estanques = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque a  WHERE a.Estado = 1 ORDER BY a.Correlativo ASC ");
                                   while ($RowA = mysqli_fetch_array($Estanques)) 
                                     {
                                        $Alimento1 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Costo) AS Costo FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 1 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB "));
                                        $Alimento2 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Costo) AS Costo FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 2 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB "));
                                        $Alimento3 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Costo) AS Costo FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 3 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB "));
                                        $Alimento4 = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Costo) AS Costo FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE a.TipoAlimento = 4 AND b.Estanque = '$RowA[IdEstanque]' $FiltroB "));
                                        $TotalLibras = $Alimento1["Costo"] + $Alimento2["Costo"] + $Alimento3["Costo"] + $Alimento4["Costo"];
                                        $SumaU1 +=  $Alimento1["Costo"];
                                        $SumaU2 +=  $Alimento2["Costo"]; 
                                        $SumaU3 +=  $Alimento3["Costo"]; 
                                        $SumaU4 +=  $Alimento4["Costo"]; 
                                ?>
                                <tr>  
                                     <td  style="font-size:80%;">Estanque: <?php echo $RowA["IdEstanque"]; ?></td> 
                                     <td class="text-center">Q. <?php echo number_format($Alimento1["Costo"],2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($Alimento2["Costo"],2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($Alimento3["Costo"],2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($Alimento4["Costo"],2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($TotalLibras,2); ?></td>
                                </tr> 
                                <?php 
                                    }
                                    $TotalUniM =  $SumaU1 +  $SumaU2 +  $SumaU3 +  $SumaU4;
                                ?>   
                                </tbody>
                                <tfoot>
                                    <tr bgcolor="#A4A9A4">
                                     <td><b>Total x Concentrado Costo</b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($SumaU1,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($SumaU2,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($SumaU3,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($SumaU4,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($TotalUniM,2); ?></b></td> 
                                    </tr> 
                                </tfoot>

                            </table>
                        </div>  
                    </div>
                </div>  
            </div>     
                <div class="col-xs-6">
                <div class="card">
                    <div class="card-head style-primary">
                        <h4 class="text-center"><strong>Costo en Unidades Monetarias <?php echo $MesD." - ".$Anio ?></strong></h4>
                    </div>
                    <div class="card-body"> 
                        <div class="row">
                            <table class="table table-hover table-condensed" id="table">
                                <tbody>
                                <tr bgcolor="#A4A9A4"> 
                                     <td class="text-center"><b>Ubicación</b></td>
                                     <td class="text-center"><b>Inventario Inicial</b></td>
                                     <td class="text-center"><b>Compras/Traslados</b></td>
                                     <td class="text-center"><b>Consumo de Concentrado</b></td>
                                     <td class="text-center"><b>Mortalidad</b></td>
                                     <td class="text-center"><b>Productos Terminados</b></td>
                                     <td class="text-center"><b>Inventario Final PP</b></td> 
                                </tr>
                                <?php  
                                    $Estanques = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque a WHERE a.Estado = 1
                                    ORDER BY a.Correlativo ASC ");
                                   while ($RowA = mysqli_fetch_array($Estanques)) 
                                     {

                                        $InicialEstanque1 = mysqli_fetch_array(mysqli_query($db, "SELECT a.CostoTotal FROM Bodega.INVENTARIO_INICIAL_PECES a
                                        WHERE a.IdEstanque = '$RowA[IdEstanque]' AND a.Mes = $MesF AND a.Anio = $Anio"));
                                        $Totales = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.CostoUTotalTraslado) AS Traslado, SUM(a.TotalCompra) AS Compras, SUM(a.CostoTotalMortalidad) AS Mortalidad, SUM(a.CostoTerminado) AS Terminados  FROM Bodega.CONTROL_PISICULTURA a 
                                        WHERE a.Estanque = '$RowA[IdEstanque]' $Filtro")); 
                                        $Alimentos = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.Costo) AS Costo FROM Bodega.ALIMENTACION_PECES a 
                                        INNER JOIN Bodega.CONTROL_PISICULTURA b ON a.IdControl = b.Id
                                        WHERE  b.Estanque = '$RowA[IdEstanque]' $FiltroB "));
                                        $AlimentoCosto = $Alimentos["Costo"];
                                        $Traslado = $Totales["Traslado"] + $Totales["Compras"];
                                        $Mortalidad = $Totales["Mortalidad"];
                                        $Terminados = $Totales["Terminados"];
                                        $Peso = $Totales["Libras"];
                                        $Final = $InicialEstanque1["CostoTotal"] + $Traslado - $Mortalidad - $Terminados;
                                        $TotalLibras = $Alimento1["Libras"] + $Alimento2["Libras"] + $Alimento3["Libras"] + $Alimento4["Libras"];
                                        $Suma1 +=  $Alimento1["Libras"];
                                        $Suma2 +=  $Alimento2["Libras"]; 
                                        $Suma3 +=  $Alimento3["Libras"]; 
                                        $Suma4 +=  $Alimento4["Libras"]; 
                                        
                                ?>
                                <tr>  
                                     <td style="font-size:80%;">Estanque: <?php echo $RowA["IdEstanque"]; ?></td> 
                                     <td class="text-center">Q. <?php echo number_format($InicialEstanque1["CostoTotal"],2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($Traslado,2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($AlimentoCosto,2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($Mortalidad,2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($Terminados,2); ?></td>
                                     <td class="text-center">Q. <?php echo number_format($Final,2); ?></td> 
                                </tr> 
                                <?php 
                                    $TotalPeso += $Peso;
                                    $Exist11 += $Final;
                                    $InicialT1 += $InicialEstanque1["CostoTotal"];
                                    $ComprasT += $Traslado;
                                    $MortT1 += $Mortalidad;
                                    $TerminadoT1 += $Terminados;
                                    $SumaAlim += $AlimentoCosto;
                                    }
                                  
                                ?>   
                                </tbody>
                                <tfoot>
                                    <tr bgcolor="#A4A9A4">
                                     <td><b>Total</b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($InicialT1,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($ComprasT,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($SumaAlim,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($MortT1,2); ?></b></td>  
                                     <td class="text-center"><b>Q. <?php echo number_format($TerminadoT1,2); ?></b></td>
                                     <td class="text-center"><b>Q. <?php echo number_format($Exist11,2); ?></b></td>  
                                    </tr>
                                    <tr bgcolor="#BCDEEE"> 
                                    </tr>
                                </tfoot> 
                                </table>
                            </div>  
                        </div>
                    </div>  
                </div> 
                 </div>   
        </div>  
        <!-- END CONTENT --> 
        <?php include("../MenuUsers.html"); ?>
 
    </form>
     
    <!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv", am4charts.PieChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.data = [<?php echo $chart_data3 ?>];
chart.radius = am4core.percent(70);
chart.innerRadius = am4core.percent(40);
chart.startAngle = 180;
chart.endAngle = 360;  

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "value";
series.dataFields.category = "country";

series.slices.template.cornerRadius = 10;
series.slices.template.innerCornerRadius = 7;
series.slices.template.draggable = true;
series.slices.template.inert = true;
series.alignLabels = false;

series.hiddenState.properties.startAngle = 90;
series.hiddenState.properties.endAngle = 90;

chart.legend = new am4charts.Legend();

}); // end am4core.ready()
</script>
 
    </body>
    </html>
