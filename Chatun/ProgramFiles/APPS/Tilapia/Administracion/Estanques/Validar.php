<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
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
    <script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
    <script src="../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="../../../../../js/libs/bootstrap/bootstrap.min.js"></script>
    <script src="../../../../../js/libs/spin.js/spin.min.js"></script>
    <script src="../../../../../js/libs/autosize/jquery.autosize.min.js"></script>
    <script src="../../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
    <script src="../../../../../js/core/source/App.js"></script>
    <script src="../../../../../js/core/source/AppNavigation.js"></script>
    <script src="../../../../../js/core/source/AppOffcanvas.js"></script>
    <script src="../../../../../js/core/source/AppCard.js"></script>
    <script src="../../../../../js/core/source/AppForm.js"></script>
    <script src="../../../../../js/core/source/AppNavSearch.js"></script>
    <script src="../../../../../js/core/source/AppVendor.js"></script>
    <script src="../../../../../js/core/demo/Demo.js"></script>
    <script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../../../../../libs/alertify/js/alertify.js"></script>
    <script src="../../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
    <!-- END JAVASCRIPT -->

    <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
    <link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
    <link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="../../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
 
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

    <?php include("../../../../MenuTop.php") ?>

    <!-- BEGIN BASE-->
    <div id="base"> 
        <div class="container">
            <h1 class="text-center"><strong>Administración Alevines</strong><br></h1>
            <br>
            <form class="form" id="FormEstanque">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-head style-primary">
                            <h4 class="text-center"><strong>Compra de Insumos</strong></h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="Id" name="Id" value="<?php echo $_GET['Id']?>">  
                              <table class="table table-hover table-condensed" id="tabla1"> 
                                        <tbody>
                                            <?php
                                            $Query = mysqli_query($db, "SELECT  a.Cantidad, b.Descripcion FROM Bodega.COMPRA_ALEVINES a
                                            INNER JOIN Pisicultura.Producto_Pisicultura b ON a.Producto = b.IdProducto 
                                            WHERE a.TRA_CODIGO = '".$_GET['Id']."'");
                                            while ($Row = mysqli_fetch_array($Query)) 
                                            { 
                                                $Cantidad = number_format($Row["Cantidad"],2);
                                                $Producto = $Row["Descripcion"];
                                            ?>
                                             <tr>  
                                                <td>  
                                                    <input readonly type="text" value="<?php echo $Producto ?>" class="form-control"> 
                                                </td>
                                                 <td>  
                                                    <input readonly type="text" value="<?php echo $Cantidad ?>" class="form-control"> 
                                                </td>   
                                            </tr> 
                                            <?php 
                                            }
                                            ?>
                                        </tbody>
                                    </table> 
                                    <div class="row">
                                    <div class="form-group">
                                        <label for="">Observaciones</label>
                                        <textarea name="Observaciones" id="Observaciones" cols="30" rows="3" class="form-control" placeholder="Describa una observación..."></textarea>
                                    </div> 
                                    </div>
                            <div class="col-lg-12" align="center">
                                <button id="BtmGuardar" type="button" onclick="Guardar()" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
                            </div>
                        </div> 
                    </div>
                </div> 
               </form> 
         </div> 
   </div> 

        <!-- END CONTENT -->
        
        <?php include("../../MenuUsers.html"); ?>
 
    <!-- END JAVASCRIPT -->
    <script>
    
   function Guardar(){

    var FormCrearEstanque = $('#FormEstanque').serialize(); 
    $.ajax({
        url: 'AJAX/GuardarAprobacion.php',
        type: 'POST',
        data: FormCrearEstanque, 
        success: function(data){ 
            if (data==1) 
            {
            setTimeout(function(){location.href="DistribucionTilapia.php"} , 1000);   
            }
            else
            {
               alertify.error("Llene los campos"); 
            }
                  //
                 } 
            })   
}
 
    </script>   
    </body>
    </html>
