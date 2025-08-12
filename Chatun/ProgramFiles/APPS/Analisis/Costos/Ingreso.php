<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php"); 
include("../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
 
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
    <div id="base"> 
            <div class="container">
                <h1 class="text-center"><strong> </strong><br></h1>
                <br>
                <form class="form" id="Form">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-head style-primary">
                                <h4 class="text-center"><strong>Análisis de Costos</strong></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                     <div class="col-md-3">
                                        <label for="Anio">Años</label>
                                            <select class="selectpicker" multiple data-live-search="true" id="Anio" name="Anio[]">
                                              <?php 
                                              $Anios = mysqli_query($db, "SELECT id, anio FROM info_base.lista_anios order by anio desc");
                                              while ($RowAnio = mysqli_fetch_array($Anios)) 
                                              {
                                                $Anio = $RowAnio["anio"];
                                               ?>
                                                <option value="<?php echo $Anio?>"><?php echo $Anio?></option>
                                               <?php 
                                              }
                                              ?> 
                                            </select>
                                      </div> 
                                      <div class="col-md-3">
                                        <label for="Producto">Productos</label>
                                            <select class="selectpicker" multiple data-live-search="true" id="Producto" name="Producto[]"> 
                                              <?php 
                                              $Producto = mysqli_query($db, "SELECT P_CODIGO, P_NOMBRE FROM Bodega.PRODUCTO");
                                              while ($RowProducto = mysqli_fetch_array($Producto)) 
                                              {
                                                $Id = $RowProducto["P_CODIGO"];
                                                $Nombre = $RowProducto["P_NOMBRE"];
                                               ?>
                                                <option value="<?php echo $Id?>"><?php echo $Nombre?></option>
                                               <?php 
                                              }
                                              ?> 
                                            </select>
                                      </div> 
                                      <div class="col-md-3">
                                        <label for="Tipo">Tipo Costo</label>
                                            <select class="form-control" id="Tipo" name="Tipo"> 
                                                <option selected disabled>Promedio</option> 
                                            </select>
                                      </div> 
                                      <div class="col-md-3">
                                         <button type="button" class="btn btn-success" onclick="VerDetalle()">Ver</button>
                                         <button type="button" class="btn btn-info" onclick="Limpiar()">Limpiar</button>
                                      </div> 
                                </div> <br><br>
                                <div id="DivCargando" style="display: none;"><img src="progress.gif" alt=""></div>
                                <div id="Detalle"></div>
                                </form>  
                            </div>
                        </div>
                    </div>  
            </div>   
   
        <!-- END CONTENT --> 
        <?php include("../MenuUsers.html"); ?> 
    </div><!--end #base-->
    <!-- END BASE -->

    <!-- BEGIN JAVASCRIPT --> 
 
    <!-- END JAVASCRIPT -->
    <script>
        
   function VerDetalle(){ 
    var FormAnalisis = $('#Form').serialize(); 
    $.ajax({
        url: 'Ajax/VerDetalle.php',
        type: 'POST',
        data: FormAnalisis, 
        beforeSend: function() { 
        $("#DivCargando").show();
        },
        success: function(data){ 
        $("#DivCargando").hide();
        $("#Detalle").html(data); 
     } 
    })  
    }

    function Limpiar()
    {
      $(".selectpicker").selectpicker('val', ''); 
    }
    </script>   
    </body>
    </html>
