<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php"); 
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"]; 
$Fecha = $_POST["Fecha"]; 
?> 
  <div class="container">
     <div class="row"> 
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-head style-primary">
                       <h2 class="text-center text-white">LISTADO DE PRODUCCIÓN</h2>
                    </div>
                    <div class="card-body"> 
                            <div class="row"> 
                                <div class="col-md-12"> 
                                    <div class="form-body">
                                     <div class="table-responsive m-t-40">
                                        <div id="myTable_wrapper" class="dataTables_wrapper no-footer"> 
                                            <table id="myTable" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info">
                                                <thead>     
                                               
                                                <tr>
                                                    <th data-sortable="true" data-field="NO." data-filter-control="input"><h6><strong>Estanque</strong></h6></th>
                                                    <th data-sortable="true" data-field="Capacidad" data-filter-control="input"><h6><strong>Unidades Terminadas</strong></h6></th>
                                                    <th data-sortable="true" data-field="Capacidad" data-filter-control="input"><h6><strong>Libras Terminadas</strong></h6></th> 
                                                    <th data-sortable="true" data-field="Estado" data-filter-control="input"><h6><strong>Observaciones</strong></h6></th>
                                                    


                                                </tr>

                                            </thead>

                                            <tbody>

                                            <?php 
                                                $Sql_Ges_Creadas = mysqli_query($db, "SELECT a.Id, a.Estanque, a.ObservacionProd, a.UnidadesTerminadas, a.LibrasTerminadas FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' AND a.Estado = 1");

                                                                      while($Fila_Ges_Creadas = mysqli_fetch_array($Sql_Ges_Creadas))

                                                                        {
                                                                            $contador++;

                                                    ?>

                                                        <tr>

                                                            <td><?php echo $Fila_Ges_Creadas["Estanque"] ?></h6></td>
                                                            <td><?php echo number_format($Fila_Ges_Creadas["UnidadesTerminadas"],2) ?></h6></td> 
                                                            <td><?php echo number_format($Fila_Ges_Creadas["LibrasTerminadas"],2) ?></h6></td> 
                                                            <td><?php echo $Fila_Ges_Creadas["ObservacionProd"] ?></h6></td> 
                                                            <td> 
                                                               <button onclick="Eliminar('<?php echo $Fila_Ges_Creadas["Id"] ?>')" type="button" class="btn btn-danger btn-circle"><i class="fa fa-close"></i> </button>
                                                            </td> 

                                                        </tr>

                                                    <?php

                                                }

                                            ?>

                                            </tbody>

                                        </table> 
                                        </div> 
                                    </div>
                                    <div class="row" align="center">
                                          <button type="button" class="btn ink-reaction btn-raised btn-warning" id="btnGuardarPartida" data-toggle="modal" data-target="#ModalFacturas">ENVIAR</button> 
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div>
            </div>  
         </div> 
    </div>

<div class="modal fade" tabindex="-1" role="dialog" id="ModalFacturas" >
  <div class="modal-dialog modal-xs" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Credenciales de inicio de sesión</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
             <div class="form-group">
              <div class="col-xs-6">
                <input required="" class="form-control" type="text" required="" placeholder="Usuario" name="username" id="username">
              </div>
              </div> 
        </div>
        <div class="row">
            <div class="form-group ">
              <div class="col-xs-6">
                <input required="" class="form-control" type="password" required="" placeholder="Contraseña" id="password" name="password" required>
              </div>
            </div> 
        </div> 
      </div> 
      <div id="mensaje" style="display: none" align="center">
            <h3>Cargando...</h3>
            <img src="loading.gif" alt="" width="300" height="100">         
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="ValidarCredenciales()">Validar</button>
      </div>
    </div>
  </div>
</div>
<script>
     function ValidarCredenciales()
        {
            var Usuario = $("#username").val();
            var Password = $("#password").val();
            $.ajax({
                url: 'AJAX/ComprobarUsuario.php',
                type: 'POST',
                dataType: 'html',
                data: {Usuario:Usuario, Password:Password},
                success:function(data)
                {
                    if (data==2) 
                    {
                        alertify.error("No tiene permisos...");
                    } 
                    else 
                    {  
                       EnviarProd();    
                    } 
            }
        })
    }

    function Eliminar(Id)
        {
          var Fecha = '<?php echo $Fecha?>';
           $.ajax({
                url: 'AJAX/EliminarProd.php',
                type: 'POST',
                dataType: 'html',
                data: {Id:Id},
                success:function(data)
                {
                    if (data==1) 
                    {
                        setTimeout(function(){location.href="IngresoProduccion.php?Fecha="+Fecha} , 1000);  
                    } 
                    else 
                    {  
                     alertify.error("Error");   
                    } 
            }
        })
    }
</script>