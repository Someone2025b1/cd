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
  <!-- FIN DEL ENCABEZADO DE LA TARJETA --> 
    <div class="container"> 
                <div class="card">
                    <div class="card-head style-primary">
                       <h2 class="text-center text-white"></h2>
                    </div>
                    <div class="card-body"> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                     <h2 class="text-center text-white">LISTADO DE DISTRIBUCIONES PENDIENTES</h2>
                                    <div class="form-body">
                                     <div class="table-responsive m-t-40">
            <div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="myTable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info">
                                                <thead>     
                                               
                                                <tr>
                                                    <th data-sortable="true" data-field="NO." data-filter-control="input"><h6><strong>No.</strong></h6></th>
                                                    <th data-sortable="true" data-field="Capacidad" data-filter-control="input"><h6><strong>Descripción</strong></h6></th> 
                                                    <th data-sortable="true" data-field="FechaCreacion" data-filter-control="input"><h6><strong>Cantidad</strong></h6></th>
                                                    <th data-sortable="true" data-field="Estado" data-filter-control="input"><h6><strong>Operar</strong></h6></th>  
                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?php

                                                $Sql_Ges_Creadas = mysqli_query($db, "SELECT b.Tipo, a.Id, b.Descripcion, SUM(a.Cantidad) AS Cantidad, a.Producto, a.TRA_CODIGO  FROM Bodega.COMPRA_ALEVINES a 
                                                INNER JOIN Pisicultura.Producto_Pisicultura b ON a.Producto = b.IdProducto
                                                WHERE a.Estado = 1 GROUP BY a.TRA_CODIGO"); 
                                              while($Fila_Ges_Creadas = mysqli_fetch_array($Sql_Ges_Creadas)) 
                                                {
                                                    $contador++; 
                                                    if ($Fila_Ges_Creadas["Tipo"]==3) 
                                                    {
                                                        $Name = "Alevines";
                                                        $Direccion = "Distribuir";
                                                    }
                                                    else
                                                    {
                                                        $Direccion = "Validar";
                                                        $Name = "Insumos";
                                                    }
                                                    ?> 
                                                        <tr>
                                                            <td><?php echo $contador; ?></td>
                                                            <td><?php echo "Compra ".$Name ?></h6></td>
                                                            <td><?php echo number_format($Fila_Ges_Creadas["Cantidad"],2) ?></h6></td> 
                                                            <td>   
                                                              <a href="<?php echo $Direccion?>.php?Id=<?php echo $Fila_Ges_Creadas["TRA_CODIGO"] ?>"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-check"></i> </button></a>  
                                                            </td> 
                                                        </tr>

                                                    <?php

                                                }

                                            ?>

                                            </tbody>

                                        </table> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 

        <!-- END CONTENT -->
        
        <?php include("../../MenuUsers.html"); ?>

    </div><!--end #base-->
    <!-- END BASE -->

    <!-- BEGIN JAVASCRIPT --> 
 
    <!-- END JAVASCRIPT -->
    <script>
        
   function GuardarEstanque(){

    var FormCrearEstanque = $('#FormEstanque').serialize(); 
    $.ajax({
        url: 'AJAX/GuardarEstanque.php',
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
                  //
                 } 
            }) 
               

}
    </script>   
    </body>
    </html>
