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
                <h1 class="text-center"><strong>Ingreso Limpieza</strong><br></h1>
                <br>
                <form class="form" id="FormProduccion" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-head style-primary">
                                <h4 class="text-center"><strong>Ingreso Limpieza</strong></h4>
                            </div> 
                            <div class="card-body">
                                <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group ">
                                        <label for="Capacidad">Fecha</label>
                                        <input onchange="FechaVal()" class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="Fecha" id="Fecha" required/> 
                                    </div>
                                </div>
                              </div>  
                            <div id="Detalle"></div>
            </div>   
        <!-- END CONTENT -->
         
        <?php include("../../MenuUsers.html"); ?>
    </div><!--end #base-->
    <!-- END BASE -->
</form> 
    <!-- BEGIN JAVASCRIPT --> 
 
    <!-- END JAVASCRIPT -->
    <script> 
     $(document).ready(function() {
    FechaVal();
    });
    function FechaVal()
    {
        var Fecha = $("#Fecha").val();
        $.ajax({
            url: 'AJAX/DetalleLimp.php',
            type: 'POST',
            dataType: 'html',
            data: {Fecha: Fecha},
            success: function(data){ 
                $("#Detalle").html(data);
            }
        }) 
        
    }

   function Guardar(){
 
    var FormProduccion = $('#FormProduccion').serialize();
    var Fecha = $("#Fecha").val(); 
    $.ajax({
        url: 'AJAX/GuardarLimpieza.php',
        type: 'POST',
        data: FormProduccion, 
        success: function(data){ 
            if (data==1) 
            {
                 $(document).ready(function() { 
                        var formData = new FormData();
                        var files = $('#image')[0].files[0];
                        formData.append('file',files);
                        $.ajax({
                            url: 'AJAX/CargarImagen.php',
                            type: 'post',
                            data: formData,
                            contentType: false,
                            processData: false, 
                        });
                        return false; 
                }); 

            alertify.success("Se ha almacenado correctamente.");
            $("#FormProduccion")[0].reset();
            setTimeout(function(){location.href="IngresoLimpieza.php?Fecha="+Fecha} , 1000);   
            }
            else
            {
               alertify.error("Ya realizo el ingreso!"); 
            } 
             } 
            })   
        }
 
function EnviarProd(){
    var Fecha = $("#Fecha").val();
    $.ajax({
        url: 'AJAX/EnviarLimpieza.php',
        type: 'POST',
        data: {Fecha:Fecha}, 
        success: function(data){ 
            if (data==1) 
            {
            alertify.success("Se ha enviado correctamente."); 
            setTimeout(function(){location.href="IngresoLimpieza.php?Fecha="+Fecha} , 1000);   
            }
            else
            {
               alertify.error("Ha ocurrido un error!"); 
            }
                  //
                 } 
            }) 
    }   
 
    $(function(){
    $("#agregar3").on('click', function(){
                $("#tabla3 tbody tr:eq(0)").clone().removeClass('fila-base3').appendTo("#tabla3 tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar3",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
 });

 function CalcularUni()
        {
            var Unidades = document.getElementsByName('UnidadesDa[]');
            var Libras = document.getElementsByName('LibrasDa[]'); 
            var Total = 0; 
            var TotalLi = 0;  
            for(i = 0; i < Unidades.length; i++)
            { 
                Total = Total + parseFloat(Unidades[i].value); 
                TotalLi = TotalLi + parseFloat(Libras[i].value); 
            }
            $('#TotalidadDa').val(Total.toFixed(2)); 
            $('#TotalidadDaLibr').val(TotalLi.toFixed(2));   
             ValidarProduccion();
        }

 function ValidarProduccion(){
    var UniTerminadas = $("#UniTerminadas").val();
    var Estanque = $("#NoEstanque").val();
    var Fecha = $("#Fecha").val();
    var UniDa = $('#TotalidadDa').val();
    $.ajax({
        url: 'AJAX/ValidarProdLimpieza.php',
        type: 'POST',
        data: {UniTerminadas: UniTerminadas, Estanque:Estanque, Fecha:Fecha, UniDa:UniDa}, 
        success: function(data){ 
                $("#Validacion").html(data); 
         } 
    })  
}
    </script>   
    </body>
    </html>
