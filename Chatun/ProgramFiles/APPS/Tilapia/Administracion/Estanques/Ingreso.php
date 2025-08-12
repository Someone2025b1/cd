<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
if (isset($_GET['Acc'])) 
{
    $Upd = mysqli_fetch_array(mysqli_query($db, "UPDATE Pisicultura.Estanque SET Estado = $_GET[Acc] WHERE IdEstanque = '".$_GET["IdEstanqueMod"]."'"));
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
                <h1 class="text-center"><strong>Administración Estanques</strong><br></h1>
                <br>
                <form class="form" id="FormEstanque">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-head style-primary">
                                <h4 class="text-center"><strong>Administración Estanques</strong></h4>
                            </div>
                            <div class="card-body">
                                <div class="row p-t-20">
                                     <div class="col-md-6">
                                             <div class="form-group">
                                                <?php 
                                                              $Sql_EstanqueCt = mysqli_query($db, "SELECT COUNT(a.IdEstanque) AS Cuenta FROM Pisicultura.Estanque as a ");
                                                              $Fila_EstanqueCt = mysqli_fetch_array($Sql_EstanqueCt);
                                                              $EstanqueSig = $Fila_EstanqueCt['Cuenta'] + 1;
                                                ?>
                                                    <label class="control-label">No. Estanque</label>
                                                    <input type="text" id="NoEstanque" name="NoEstanque" value="<?php echo $EstanqueSig ?>" class="form-control" >
                                             </div> 
                                      </div> 
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group floating-label">
                                            <input required="" class="form-control" type="number" step="any" name="Capacidad" id="Capacidad" required/>
                                            <label for="Capacidad">Capacidad de Peces</label>
                                        </div>
                                    </div>
                                </div>  
                                 <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group floating-label">
                                            <input required="" class="form-control" type="number" step="any" name="Inicial" id="Inicial"  />
                                            <label for="Capacidad">Inventario Inicial</label>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group floating-label">
                                            <input required="" class="form-control" type="number" step="any" name="CostoTotal" id="CostoTotal"  />
                                            <label for="Capacidad">Costo Total</label>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group floating-label">
                                            <input required="" class="form-control" type="number" step="any" name="Metros" id="Metros"  />
                                            <label for="Metros">Metros</label>
                                        </div>
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group floating-label">
                                            <input class="form-control" type="text" name="Observaciones" id="Observaciones"  />
                                            <label for="Observaciones">Observaciones</label>
                                        </div>
                                    </div>
                                </div> 
                                  </form>  
                                <div class="col-lg-12" align="center">
                                    <button type="button" onclick="GuardarEstanque()" class="btn ink-reaction btn-raised btn-primary">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <br>
                    <br> 
            </div> <br><br>
  <!-- FIN DEL ENCABEZADO DE LA TARJETA --> 
    <div class="container">
     <div class="row"> 
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-head style-primary">
                       <h2 class="text-center text-white">LISTADO DE ESTANQUES CREADOS</h2>
                    </div>
                    <div class="card-body"> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <div class="form-body">
                                     <div class="table-responsive m-t-40">
            <div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="myTable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info">
                                                <thead>     
                                               
                                                <tr>
                                                    <th data-sortable="true" data-field="NO." data-filter-control="input"><h6><strong>No.</strong></h6></th>
                                                    <th data-sortable="true" data-field="Capacidad" data-filter-control="input"><h6><strong>Capacidad</strong></h6></th>
                                                    <th data-sortable="true" data-field="Capacidad" data-filter-control="input"><h6><strong>Inventario Inicial</strong></h6></th>
                                                    <th data-sortable="true" data-field="Capacidad" data-filter-control="input"><h6><strong>Costo Unitario</strong></h6></th>
                                                    <th data-sortable="true" data-field="Capacidad" data-filter-control="input"><h6><strong>Costo Total</strong></h6></th>
                                                    <th data-sortable="true" data-field="FechaCreacion" data-filter-control="input"><h6><strong>Fecha Creación</strong></h6></th>
                                                    <th data-sortable="true" data-field="Estado" data-filter-control="input"><h6><strong>Estado</strong></h6></th>
                                                    


                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?php

                                                $Sql_Ges_Creadas = mysqli_query($db, "SELECT * FROM Pisicultura.Estanque order by Correlativo ASC");

                                                                      while($Fila_Ges_Creadas = mysqli_fetch_array($Sql_Ges_Creadas))

                                                                        {
                                                                            $contador++;

                                                    ?>

                                                        <tr>

                                                            <td><?php echo $Fila_Ges_Creadas["IdEstanque"] ?></h6></td>
                                                            <td><?php echo $Fila_Ges_Creadas["Capacidad"] ?></h6></td>
                                                            <td><?php echo $Fila_Ges_Creadas["InventarioInicial"] ?></h6></td>
                                                            <td><?php echo $Fila_Ges_Creadas["CostoUnitario"] ?></h6></td>
                                                            <td><?php echo $Fila_Ges_Creadas["CostoTotal"] ?></h6></td>
                                                            <td><?php echo cambio_fecha($Fila_Ges_Creadas["FechaCreacion"]) ?></h6></td>
                                                            <td><?php      $Estado = $Fila_Ges_Creadas["Estado"];
                                                             if($Estado == 1){
                                                              ?>
                                                              <a href="Ingreso.php?IdEstanqueMod=<?php echo $Fila_Ges_Creadas["IdEstanque"] ?>&Acc=<?php echo 0 ?>"><button type="button" class="btn btn-info btn-circle"><i class="fa fa-check"></i> </button></a> 
                                                                
                                                              <?php
                                                             } else { ?>
                                                              <a href="Ingreso.php?IdEstanqueMod=<?php echo $Fila_Ges_Creadas["IdEstanque"] ?>&Acc=<?php echo 1 ?>"><button type="button" class="btn btn-warning btn-circle"><i class="fa fa-times"></i> </button></a> 
                                                             <?php
                                                             }
                                                             ?> 
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
