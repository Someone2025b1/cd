<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Select = mysqli_fetch_array(mysqli_query($db, "SELECT  SUM(a.Cantidad) AS Cantidad, a.Producto FROM Bodega.COMPRA_ALEVINES a  
WHERE a.TRA_CODIGO = '".$_GET['Id']."'"));
$Cantidad = number_format($Select["Cantidad"],0);
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
                            <h4 class="text-center"><strong>Distribución Alevines</strong></h4>
                        </div>
                        <div class="card-body">
                            <input type="hidden" id="Id" name="Id" value="<?php echo $_GET['Id']?>"> 
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="Disponible" id="Disponible" readonly value="<?php echo $Cantidad ?>" />
                                        <label for="Disponible">Disponible</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input class="form-control" type="date" name="Fecha" id="Fecha" value="<?php echo date('Y-m-d') ?>" />
                                        <label for="Fecha">Fecha Ingreso</label>
                                    </div>
                                </div>
                            </div>
                              <table class="table table-hover table-condensed" id="tabla1"> 
                                        <tbody>
                                             <tr class="fila-base1">  
                                                <td> 
                                                    <div class="form-group">
                                                        <label for="Capacidad">Estanque</label>
                                                        <select name="Estanque[]" id="Estanque" class="form-control">
                                                            <option value="" disabled selected>Seleccione un Estanque</option>
                                                            <?php
                                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                            $query = "SELECT * FROM Pisicultura.Estanque WHERE Estado = 1 order by Correlativo ASC";
                                                            $result = mysqli_query($db,$query);
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                                echo '<option value="'.$row["IdEstanque"].'"> No. '.$row["IdEstanque"].'</option>';
                                                            }

                                                            ?>
                                                        </select>
                                                    </div> 
                                                </td>
                                                <td> 
                                                    <div class="form-group">
                                                        <label for="Capacidad">Cantidad</label>
                                                        <input placeholder=" " class="form-control" onblur="CalcularUni()" type="number" min="1" name="Cantidad[]" id="Cantidad" required/>
                                                    </div> 
                                                </td>
                                                <td class="eliminar1">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr> 
                                        </tbody>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar1">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div>  
                            <div class="col-lg-12" align="center">
                                <button id="BtmGuardar" type="button" onclick="GuardarEstanque()" disabled class="btn ink-reaction btn-raised btn-primary">Guardar</button>
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
    
    function CalcularUni()
        {
            var Disponible = '<?php echo $Select['Cantidad']?>';
            var Cantidad = document.getElementsByName('Cantidad[]');
            var Total = 0; 
            for(i = 0; i < Cantidad.length; i++)
            { 
                Total = Total + parseFloat(Cantidad[i].value);  
            } 
            if (Total==Disponible) 
            { 
            $("#BtmGuardar").removeAttr('disabled');
            }
            else
            {
                $("#BtmGuardar").attr('disabled','disabled');
            }
        }

   function GuardarEstanque(){

    var FormCrearEstanque = $('#FormEstanque').serialize(); 
    $.ajax({
        url: 'AJAX/GuardarDistribucion.php',
        type: 'POST',
        data: FormCrearEstanque, 
        success: function(data){ 
            if (data==1) 
            {
            alertify.success("Se ha almacenado correctamente.");
            setTimeout(function(){location.href="DistribucionTilapia.php"} , 500);  
            }
            else
            {
               alertify.error("Llene los campos"); 
            }
                  //
                 } 
            }) 
               

}

    $(function(){ 
             // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar1").on('click', function(){
                $("#tabla1 tbody tr:eq(0)").clone().removeClass('fila-base1').appendTo("#tabla1 tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar1",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            }); 
        });
    </script>   
    </body>
    </html>
