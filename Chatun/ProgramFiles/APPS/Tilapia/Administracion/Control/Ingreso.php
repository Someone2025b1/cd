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

    <style type="text/css">
        
        .suggest-element{
            margin-left:5px;
            margin-top:5px;
            width:350px;
            cursor:pointer;
        }
        #suggestions {
            width:auto;
            height:auto;
            overflow: auto;
        }
    </style>
<body class="menubar-hoverable header-fixed menubar-pin ">

    <?php include("../../../../MenuTop.php") ?>

    <!-- BEGIN BASE-->
    <div id="base"> 
        <div class="container"> <br><br><br>
                    <div class="col-lg-12">
                        <div class="panel-group" id="accordion6">
                            <div class="card panel">
                                <div class="card-head style-primary collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-1" aria-expanded="show">
                                    <header>Ingreso de Información</header> 
                                </div>
                                <form class="form" id="FormInfo" enctype="multipart/form-data">
                                    <div id="accordion6-1"  aria-expanded="true" style="height: 0px;">
                                        <div class="card-body">
                                         <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">Fecha</label>
                                                    <input  class="form-control" type="date" value="<?php echo date('Y-m-d') ?>" name="Fecha" id="Fecha" /> 
                                                </div>
                                            </div>
                                          </div> 
                                            <div class="row p-t-20">
                                                 <div class="col-md-6">
                                                         <div class="form-group">
                                                            <?php 
                                                             $Sql_EstanqueCt = mysqli_query($db, "SELECT a.IdEstanque FROM Pisicultura.Estanque as a order by a.Correlativo"); 
                                                            ?>
                                                                <label class="control-label">No. Estanque</label>
                                                                <select name="NoEstanque" id="NoEstanque" class="form-control" onchange="SaberProduccion(this.value)" ="">
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
                                                    <div class="col-lg-12">
                                                        <div class="form-group floating-label">
                                                            <input class="form-control" type="text" name="Observaciones" id="Observaciones" />
                                                            <label for="Observaciones">Observaciones</label>
                                                        </div>
                                                    </div>
                                                </div> 
                                        </div>
                                    </div>
                            </div><!--end .panel -->
                            <div class="card panel">
                                <div class="card-head style-warning collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-2" aria-expanded="false">
                                    <header>Alimentación</header>
                                    <div class="tools">
                                        <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                                    </div>
                                </div>
                                <div id="accordion6-2" class="collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="card-body">
                                        <h3 class="text-center">Peso en Libras</h3>
                                        <div class="row p-t-20">  
                                                <?php 
                                                 $Sql_EstanqueCt = mysqli_query($db, "SELECT a.IdProducto, a.Descripcion FROM Pisicultura.Producto_Pisicultura AS a WHERE a.Tipo = 1"); 
                                                ?>    
                                                <?php 
                                                while ($Fila_Alimento = mysqli_fetch_array($Sql_EstanqueCt)) 
                                                {
                                                    $Alimento = $Fila_Alimento['Descripcion']
                                                   ?>
                                                   <div class="col-md-3">
                                                        <div class="card">
                                                            <div class="card-head style-warning">
                                                                <h4 class="text-center"><strong><?php echo $Alimento ?></label></strong></h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="hidden" class="form-control" value="<?php echo $Fila_Alimento['IdProducto']?>" id="IdAlimento" name="IdAlimento[]">
                                                                <input type="text" class="form-control" placeholder="Lb" id="Alimento" name="Alimento[]">
                                                            </div> 
                                                         </div>      
                                                    </div> 
                                                   <?php 
                                                }
                                                ?>     
                                        </div>
                                    </div>
                                </div>
                            </div><!--end .panel -->
                            <div class="card panel">
                                <div class="card-head style-accent collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-3" aria-expanded="false">
                                    <header>Terminados</header>
                                    <div class="tools">
                                        <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                                    </div>
                                </div>
                                <div id="accordion6-3" class="collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="card-body">
                                       <div id="DivProduccion"></div> 
                                    </div>
                                </div>
                            </div><!--end .panel -->
                            <div class="card panel">
                                <div class="card-head style-success collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-4" aria-expanded="false">
                                    <header>Traslados (+ & -)</header>
                                    <div class="tools">
                                        <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                                    </div>
                                </div>
                                <div id="accordion6-4" class="collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="card-body">
                                        <div class="row">
                                            <table class="table table-hover table-condensed" id="tabla">
                                        <thead>
                                            <tr> 
                                                <th>
                                                    <h6><b>Traslados</b></h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <tr class="fila-base"> 
                                                <td>
                                                    <div class="form-group">
                                                        <label for="Capacidad">Unidades Traslado</label>
                                                        <input value="0" class="form-control" type="number"  name="UniTraslado[]" id="UniTraslado" onchange="CalcularTraslado()" /> 
                                                     </div>
                                                </td> 
                                                <td>
                                                    <div class="form-group">
                                                        <label for="Capacidad">Tipo Traslado</label>
                                                        <select name="TipoTraslado[]" id="TipoTraslado" class="form-control">
                                                            <option value="1">Entrada</option>
                                                            <option value="2">Salida</option>
                                                        </select> 
                                                     </div>
                                                </td>  
                                                <td> 
                                                    <div class="form-group">
                                                        <label for="Capacidad">Estanque Traslado</label>
                                                        <select name="EstanqueTraslado[]" id="EstanqueTraslado" class="form-control">
                                                            <option value="" disabled selected>Seleccione un Estanque</option>
                                                            <?php
                                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                            $query = "SELECT a.IdEstanque FROM Pisicultura.Estanque AS a WHERE a.Estado = 1";
                                                            $result = mysqli_query($db,$query);
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                                echo '<option value="'.$row["IdEstanque"].'"> Estanque '.$row["IdEstanque"].'</option>';
                                                            }

                                                            ?>
                                                        </select>
                                                    </div> 
                                                </td>
                                                <td class="eliminar">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr> 
                                        </tbody>
                                        <tfoot>
                                            <tr> 
                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="TotalTraslado" name="TotalTraslado" value="0.00" readonly></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div> 
                                    </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="card panel">
                                <div class="card-head style-danger collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-5" aria-expanded="false">
                                    <header>Mortalidad</header>
                                    <div class="tools">
                                        <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                                    </div>
                                </div>
                                <div id="accordion6-5" class="collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="card-body">
                                        <div class="row">
                                            <table class="table table-hover table-condensed" id="tabla2">
                                        <thead>
                                            <tr> 
                                                <th>
                                                    <h6><b>Mortalidad</b></h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <tr class="fila-base2"> 
                                                <td>
                                                    <div class="form-group">
                                                        <label for="Capacidad">Unidades</label>
                                                        <input value="0" class="form-control" type="number"  name="UniMortalidad[]" id="UniMortalidad" onchange="CalcularMortalidad()" /> 
                                                     </div>
                                                </td> 
                                                <td>
                                                    <div class="form-group">
                                                       <label for="Capacidad">Peso</label>
                                                        <input placeholder="Lb" class="form-control" type="number" step="any" name="Peso[]" id="Peso" onchange="CalcularMortalidad()" />
                                                     </div>
                                                </td>  
                                                <td> 
                                                    <div class="form-group">
                                                        <label for="Capacidad">Talla</label>
                                                        <input placeholder="Cm" class="form-control" type="number" step="any" name="Talla[]" id="Talla" onchange="CalcularMortalidad()" />
                                                    </div> 
                                                </td>
                                                <td> 
                                                    <div class="form-group">
                                                        <label for="Capacidad">Causa</label>
                                                        <input placeholder="Describa..." class="form-control" type="text"  name="Causa[]" id="Causa" />
                                                    </div> 
                                                </td>
                                                <td class="eliminar2">
                                                    <button type="button" class="btn btn-danger btn-xs">
                                                        <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                                                    </button>
                                                </td>
                                            </tr> 
                                        </tbody>
                                        <tfoot>
                                            <tr> 
                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="TotalMortalidad" name="TotalMortalidad" value="0.00" readonly></td>
                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="TotalPeso" name="TotalPeso" value="0.00" readonly></td>
                                                <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="TotalTalla" name="TotalTalla" value="0.00" readonly></td> 
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="col-lg-12" align="left">
                                        <button type="button" class="btn btn-success btn-xs" id="agregar2">
                                            <span class="glyphicon glyphicon-plus"></span> Agregar
                                        </button>
                                    </div> 
                                    </div> <br>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="form-group ">
                                                <label for="Capacidad">Fotografía</label>
                                                <input class="form-control" type="file"  name="file" id="file" /> 
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="card panel">
                                <div class="card-head style-info collapsed" data-toggle="collapse" data-parent="#accordion6" data-target="#accordion6-6" aria-expanded="false">
                                    <header>Muestreo</header>
                                    <div class="tools">
                                        <a class="btn btn-icon-toggle"><i class="fa fa-angle-down"></i></a>
                                    </div>
                                </div>
                                <div id="accordion6-6" class="collapse" aria-expanded="false" style="height: 0px;">
                                    <div class="card-body">
                                         <div class="row">
                                            <table class="table table-hover table-condensed" id="tabla1">
                                        <thead>
                                            <tr> 
                                                <th>
                                                    <h6><b>Medicamentos</b></h6>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                             <tr class="fila-base1">  
                                                <td> 
                                                    <div class="form-group">
                                                        <label for="Capacidad">Medicamento</label>
                                                        <select name="TipoMedicamento[]" id="TipoMedicamento" class="form-control">
                                                            <option value="" disabled selected>Seleccione un medicamento</option>
                                                            <?php
                                                                    //Select para obtener los tipos de falta de la base de datos y creación de las opciones del input select
                                                            $query = "SELECT * FROM Pisicultura.Producto_Pisicultura WHERE Estado = 1 AND Tipo = 2";
                                                            $result = mysqli_query($db,$query);
                                                            while($row = mysqli_fetch_array($result))
                                                            {
                                                                echo '<option value="'.$row["IdProducto"].'">'.$row["Descripcion"].'</option>';
                                                            }

                                                            ?>
                                                        </select>
                                                    </div> 
                                                </td>
                                                <td> 
                                                    <div class="form-group">
                                                        <label for="Capacidad">Cantidad</label>
                                                        <input placeholder=" " class="form-control" type="number"  name="Cantidad[]" id="Cantidad" />
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
                                    </div>
                                    <br>
                                       <div class="row p-t-20">    
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">Tamaño Muestra</label>
                                                    <input class="form-control" type="number"  name="Tamanio" id="Tamanio" value="0" /> 
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">Oxígeno</label>
                                                    <input class="form-control" type="number"  name="Oxigeno" id="Oxigeno" placeholder="ppm" /> 
                                                </div>
                                            </div> 
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">PH</label>
                                                    <input class="form-control" type="number"  name="Ph" id="Ph"  placeholder="PH"  /> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">Temperatura</label>
                                                    <input placeholder="ºC" class="form-control" type="number"  name="Temperatura" id="Temperatura" /> 
                                                </div>
                                            </div> 
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">Amonio</label>
                                                    <input value="0" class="form-control" type="number"  name="Amonio" id="Amonio" /> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">Peso (Lb)</label>
                                                    <input value="0" class="form-control" type="number"  name="Peso" id="Peso" /> 
                                                </div>
                                            </div> 
                                            <div class="col-lg-3">
                                                <div class="form-group ">
                                                    <label for="Capacidad">Talla (Cm)</label>
                                                    <input value="0" class="form-control" type="number"  name="Talla" id="Talla" /> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div><!--end .panel --><br>
                            <div class="col-lg-12" align="center">
                                <div class="form-group">
                                       <button type="submit" class="btn ink-reaction btn-raised btn-warning" id="btnGuardarPartida" >Enviar</button> 
                                </div>
                            </div> 
                        </div>
                    </div> 
                </form>
            </div>
        </div>
  
        <?php include("../../MenuUsers.html"); ?>

 
    <!-- END BASE -->

    <!-- BEGIN JAVASCRIPT --> 
 
    <!-- END JAVASCRIPT -->
    <script>
    $(function(){
        $("#FormInfo").on("submit", function(e){ 
        	console.log("listo");
            e.preventDefault(); 
            var f = $(this);
            var formData = new FormData(document.getElementById("FormInfo")); 
            $.ajax({
                url: 'AJAX/GuardarControl.php',
                type: "post",
                dataType: "html",
                data: formData,
                 success: function (data) 
		        {
		            if (data==1) 
	                {
	                alertify.success("Se ha almacenado correctamente."); 
	               // location.reload(); 
	                }
	                else
	                {
	                   alertify.error("Llene los campos"); 
	                } 
		        },
                cache: false,
                contentType: false,
	     processData: false
            })
                .done(function(res){
                    $("#mensaje").html("Respuesta: " + res);
                });
        });
    });

        
    $(function(){
        
            // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar").on('click', function(){
                $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });

             // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
            $("#agregar1").on('click', function(){
                $("#tabla1 tbody tr:eq(0)").clone().removeClass('fila-base1').appendTo("#tabla1 tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar1",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });

            $("#agregar2").on('click', function(){
                $("#tabla2 tbody tr:eq(0)").clone().removeClass('fila-base2').appendTo("#tabla2 tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar2",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
        });

   function GuardarControl(){

    var FormCrearEstanque = $('#FormInfo').serialize();
      $.ajax({
        url: 'AJAX/GuardarControl.php',
        type: 'POST',
        data: FormCrearEstanque, 
        success: function(data){ 
                if (data==1) 
                {
                alertify.success("Se ha almacenado correctamente."); 
                location.reload(); 
                }
                else
                {
                   alertify.error("Llene los campos"); 
                } 
            } 
       })  
    }

    function SaberProduccion(Estanque)
    {
        var Fecha = $("#Fecha").val();
        $.ajax({
            url: 'AJAX/ValoresProduccion.php',
            type: 'POST',
            dataType: 'html',
            data: {Estanque:Estanque, Fecha:Fecha},
            success : function(data)
            {
                $("#DivProduccion").html(data);
            }
        })  
    }

    function CalcularTraslado()
        {
            var UniTraslado = document.getElementsByName('UniTraslado[]');
            var Total = 0; 
            for(i = 0; i < UniTraslado.length; i++)
            { 
                Total = Total + parseFloat(UniTraslado[i].value);
            }
            $('#TotalTraslado').val(Total.toFixed(2)); 
        }

    function CalcularMortalidad()
        {
            var UniMortalidad = document.getElementsByName('UniMortalidad[]');
            var Peso = document.getElementsByName('Peso[]');
            var Talla = document.getElementsByName('Talla[]');
            
            var TotalMor = 0; 
            var TotalPeso = 0; 
            var TotalTalla = 0; 
            for(i = 0; i < UniMortalidad.length; i++)
            { 
                TotalMor = TotalMor + parseFloat(UniMortalidad[i].value);
                TotalPeso = TotalPeso + parseFloat(Peso[i].value);
                TotalTalla = TotalTalla + parseFloat(Talla[i].value);
            }
            $('#TotalMortalidad').val(TotalMor.toFixed(2)); 
            $('#TotalPeso').val((TotalPeso / (UniMortalidad.length)).toFixed(2)); 
            $('#TotalTalla').val((TotalTalla / (UniMortalidad.length)).toFixed(2)); 
        }

        
    </script>   
    </body>
    </html>
