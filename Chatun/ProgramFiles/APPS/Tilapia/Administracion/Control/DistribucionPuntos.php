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
                <h1 class="text-center"><strong>Distribución Tilapia</strong><br></h1>
                <br>
                <form class="form" id="FormProduccion">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-head style-primary">
                                <h4 class="text-center"><strong>Distribución Tilapia</strong></h4>
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
                              <div id="Detalle">
                              <div id="DivTotal"></div>
                               <div class="row p-t-20">
                                <table class="table table-hover table-condensed" id="tabla3"> 
                                    <tbody>
                                         <tr class="fila-base3"> 
                                            <td>
                                                <div class="form-group">
                                                <?php 
                                                 $Sql = mysqli_query($db, "SELECT a.Id, a.Descripcion FROM Bodega.PUNTOS_VENTA as a WHERE Estado = 1"); 
                                                ?>
                                                    <label class="control-label">Punto de Venta</label>
                                                    <select name="PuntoVenta[]" id="PuntoVenta" class="form-control" required="">
                                                        <option selected="" disabled="">Seleccione</option>
                                                        <?php 
                                                        while ($Fila = mysqli_fetch_array($Sql)) 
                                                        {
                                                            $Id = $Fila['Id']
                                                           ?>
                                                           <option value="<?php echo $Id?>"><?php echo $Fila["Descripcion"]?></option>
                                                           <?php 
                                                        }
                                                        ?>                                                        
                                                    </select>
                                                </div> 
                                            </td>
                                            <td>
                                                 <div class="form-group ">
                                                    <label for="Capacidad">Unidades terminadas</label>
                                                    <input onchange="CalcularUni()" value="0" class="form-control" type="number" min="1" name="UniTerminadas[]" id="UniTerminadas" required/> 
                                                </div>
                                            </td>  
                                            <td>
                                                <div class="form-group ">
                                                    <label for="Capacidad">Libras</label>
                                                    <input onchange="CalcularUni()" value="0" class="form-control" step="any" type="number" min="1" name="LibrasTerminadas[]" id="LibrasTerminadas" required/> 
                                                </div>
                                            </td>  
                                            <td>
                                            <div class="form-group ">
                                            <label for="Entrego">Entrego a:</label>
                                            <select name="Entrego[]" id="Entrego" class="form-control" required >
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
                                            </td>  
                                            <td> 
                                                <div class="form-group ">
                                                    <label for="Observaciones">Observaciones</label>
                                                    <textarea placeholder="Describa una observación..." name="Observaciones[]" id="Observaciones" cols="20" rows="2" class="form-control"></textarea>
                                                </div>
                                            </td>
                                            <td class="eliminar3">
                                                <button type="button" class="btn btn-danger btn-xs">
                                                    <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                </button>
                                            </td>
                                        </tr> 
                                        <input class="form-control" type="hidden" id="TotalidadDa" name="TotalidadDa" value="0.00" readonly> 
                                    </tbody> 
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar3">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>  
                                </div>     
                                <div class="col-lg-12" align="center">
                                    <button type="button" disabled="" id="BtmGuardar" onclick="GuardarDistribucion()" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div> 
                    </form> 
            </div>    
        <!-- END CONTENT -->
        <div id="NoProd" style="display: none">
            <div class="alert alert-danger" role="alert">
             <h2 class="text-center">Ya realizo el ingreso del día seleccionado...</h2>
            </div>
        </div>
        <?php include("../../MenuUsers.html"); ?>
    </div><!--end #base-->
    <!-- END BASE --> 
    <script>
    $(document).ready(function() {
        FechaVal(); 
    });

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
   function GuardarDistribucion(){

    var FormProduccion = $('#FormProduccion').serialize();
    var Fecha = $("#Fecha").val();
    if($('#FormProduccion')[0].checkValidity()){
    $.ajax({
        url: 'AJAX/GuardarDistribucion.php',
        type: 'POST',
        data: FormProduccion, 
        success: function(data){ 
            if (data==1) 
            {
            alertify.success("Se ha almacenado correctamente.");
            $("#FormProduccion")[0].reset();
            setTimeout(function(){location.href="DistribucionPuntos.php?Fecha="+Fecha} , 1000);   
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
 
    function FechaVal()
    {
        var Fecha = $("#Fecha").val();
        $.ajax({
            url: 'AJAX/DetalleDistribucion.php',
            type: 'POST',
            dataType: 'html',
            data: {Fecha: Fecha},
            success: function(data){ 
                if (data>0) 
                {
                    $("#Detalle").hide();
                    $("#NoProd").show();
                }
                else
                {
                    $("#Detalle").show();
                    $("#NoProd").hide();
                }
                
            }
        }) 
        TotalDisponible();
    }

    function TotalDisponible()
    {
        var Fecha = $("#Fecha").val();
        $.ajax({
            url: 'AJAX/TotalLimpieza.php',
            type: 'POST',
            dataType: 'html',
            data: {Fecha: Fecha},
            success: function(data){ 
                $("#DivTotal").html(data);
            }
        }) 
        
    }

     function CalcularUni()
        {

            var Unidades = document.getElementsByName('UniTerminadas[]');
            var Libras = document.getElementsByName('LibrasTerminadas[]'); 
            var Total = 0;   
            var Disponible = parseFloat($("#Disponible").val());
            var Arrastre = parseFloat($("#Arrastre").val());
            if (Arrastre>0) 
            {
                Arrastre = Arrastre;
            }
            else
            {
                Arrastre = 0;
            }
            var Final = Disponible + Arrastre; 
            for(i = 0; i < Unidades.length; i++)
            { 
                Total = Total + parseFloat(Unidades[i].value);  
            }
            $('#TotalidadDa').val(Total.toFixed(2));   
            if (Total == Final) 
            { 
            $("#BtmGuardar").removeAttr('disabled');
            }
            else
            {
                $("#BtmGuardar").attr('disabled','disabled');
            }  
        }
    </script>   
    </body>
    </html>
