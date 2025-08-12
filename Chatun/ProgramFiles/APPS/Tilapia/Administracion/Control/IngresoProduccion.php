<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
if ($_GET['Fecha']=="") {
$Fecha = date('Y-m-d');
}
else
{
$Fecha = $_GET['Fecha'];
}
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
                <h1 class="text-center"><strong>Ingreso Producción</strong><br></h1>
                <br>
                <form class="form" id="FormProduccion">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-head style-primary">
                                <h4 class="text-center"><strong>Ingreso Producción</strong></h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group ">
                                        <label for="Capacidad">Fecha</label>
                                        <input onchange="FechaVal()" class="form-control" type="date" value="<?php echo $Fecha?>" name="Fecha" id="Fecha" required/> 
                                    </div>
                                </div>
                              </div> 
                               <div class="row p-t-20">
                                     <div class="col-md-6">
                                             <div class="form-group">
                                                <?php 
                                                 $Sql_EstanqueCt = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque as a order by Correlativo asc"); 
                                                ?>
                                                    <label class="control-label">No. Estanque</label>
                                                    <select name="NoEstanque" id="NoEstanque" class="form-control" required="">
                                                        <option selected="" disabled="">Seleccione</option>
                                                        <?php 
                                                        while ($Fila_EstanqueCt = mysqli_fetch_array($Sql_EstanqueCt)) 
                                                        {
                                                            $EstanqueSig = $Fila_EstanqueCt['IdEstanque']
                                                           ?>
                                                           <option value="<?php echo $EstanqueSig?>">No. <?php echo $EstanqueSig?></option>
                                                           <?php 
                                                        }
                                                        ?>                                                        
                                                    </select>
                                             </div> 
                                        </div>  
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group ">
                                            <label for="Capacidad">Unidades terminadas</label>
                                            <input value="0" class="form-control" type="number" min="1" name="UniTerminadas" id="UniTerminadas" required/> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group ">
                                            <label for="Capacidad">Libras</label>
                                            <input value="0" class="form-control" step="any" type="number" min="1" name="LibrasTerminadas" id="LibrasTerminadas" required/> 
                                        </div>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group ">
                                            <label for="Observaciones">Observaciones</label>
                                            <textarea placeholder="Describa una observación..." name="Observaciones" id="Observaciones" cols="30" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>  
                                 <div class="row">
                                    <div class="col-lg-3"> 
                                            <label for="Entrego">Entrego a:</label>
                                            <select name="Entrego" id="Entrego" class="form-control selectpicker" required data-live-search="true" >
                                                <option selected disabled>Seleccione</option>
                                                <?php 
                                                $Colaborador = mysqli_query($db, "SELECT  a.id_user, a.nombre FROM info_bbdd.usuarios a");
                                                while ($Row = mysqli_fetch_array($Colaborador)) 
                                                {
                                                  ?>
                                                  <option value="<?php echo $Row['id_user']?>"><?php echo $Row["nombre"]?></option>
                                                  <?php 
                                                }
                                                ?>
                                            </select> 
                                    </div>
                                </div> 
                                <div class="col-lg-12" align="center">
                                    <button type="button" onclick="GuardarProduccion()" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                    </form> 
            </div>   

             <!-- FIN DEL ENCABEZADO DE LA TARJETA --> 
        <div id="Detalle"></div>
        <!-- END CONTENT -->
        
        <?php include("../../MenuUsers.html"); ?>
    </div><!--end #base-->


    <!-- END BASE --> 
    <script>
    $(document).ready(function() {
        FechaVal();
    });
        
    
   function GuardarProduccion(){

    var FormProduccion = $('#FormProduccion').serialize();
    var Fecha = $("#Fecha").val();
    if($('#FormProduccion')[0].checkValidity()){
    $.ajax({
        url: 'AJAX/GuardarProduccion.php',
        type: 'POST',
        data: FormProduccion, 
        success: function(data){ 
            if (data==1) 
            {
            alertify.success("Se ha almacenado correctamente.");
            $("#FormProduccion")[0].reset();
            setTimeout(function(){location.href="IngresoProduccion.php?Fecha="+Fecha} , 1000);   
            }
            else
            {
               alertify.error("Ya realizo el ingreso!"); 
            }
                  //
                 } 
            }) 
              }  else {
            $('#BotonGuardar').click();
           }

        }

    function EnviarProd(){
    var Fecha = $("#Fecha").val();
    $.ajax({
        url: 'AJAX/EnviarProduccion.php',
        type: 'POST',
        data: {Fecha:Fecha}, 
        success: function(data){ 
            if (data==1) 
            {
            alertify.success("Se ha enviado correctamente."); 
            setTimeout(function(){location.href="IngresoProduccion.php?Fecha="+Fecha} , 1000);   
            }
            else
            {
               alertify.error("Ha ocurrido un error!"); 
            }
                  //
                 } 
            }) 
    }   

    function FechaVal()
    {
        var Fecha = $("#Fecha").val();
        $.ajax({
            url: 'AJAX/DetalleProd.php',
            type: 'POST',
            dataType: 'html',
            data: {Fecha: Fecha},
            success: function(data){ 
                $("#Detalle").html(data);
            }
        })   
    }
    </script>   
    </body>
    </html>
