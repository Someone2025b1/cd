<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php"); 
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"]; 
$Fecha = $_POST["Fecha"]; 
?> 
 <?php 
        $Contador = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' and a.Estado = 2"));
        $Contador2 = mysqli_num_rows(mysqli_query($db, "SELECT *FROM Bodega.LIMPIEZA_TILAPIA a WHERE a.Fecha = '$Fecha'"));
        if ($Contador>0 && $Contador2 == 0) {
            
        ?>
          <h4 class="text-left">Unidades Limpieza</h4>
          <div class="row">
                <div class="col-lg-6">
                    <div class="form-group ">
                        <label for="Capacidad">Unidades terminadas</label>
                        <input value="0" class="form-control" type="number" min="1" name="UniTerminadas" id="UniTerminadas" required/> 
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group ">
                        <label for="Capacidad">Libras</label>
                        <input  value="0" onblur="ValidarProduccion()" class="form-control" step="any" type="number" min="1" name="LibrasTerminadas" id="LibrasTerminadas" required/> 
                    </div>
                </div>
            </div>
            <h4 class="text-left">Unidades Dañadas</h4> 
            <div class="row">
                <table class="table table-hover table-condensed" id="tabla3"> 
                <tbody>
                     <tr class="fila-base3"> 
                        <td>
                            <div class="form-group">
                                <label for="Capacidad">Unidades</label>
                                <input value="0" class="form-control" type="number" min="1" name="UnidadesDa[]" id="UnidadesDa" onchange="CalcularUni();ValidarProduccion()" required/> 
                             </div>
                        </td>  
                        <td>
                            <div class="form-group">
                                <label for="Capacidad">Libras</label>
                                <input value="0" class="form-control" type="number" min="1" name="LibrasDa[]" id="LibrasDa" onchange="CalcularUni()" required/> 
                             </div>
                        </td>  
                        <td> 
                            <div class="form-group">
                                <label for="Capacidad">Explicación</label>
                                <input placeholder="Describa..." class="form-control" type="text"  name="CausaDa[]" id="CausaDa" required/>
                            </div> 
                        </td>
                        <td class="eliminar3">
                            <button type="button" class="btn btn-danger btn-xs">
                                <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                            </button>
                        </td>
                    </tr> 
                    <input class="form-control" type="hidden" id="TotalidadDa" name="TotalidadDa" value="0.00" readonly>
                    <input class="form-control" type="hidden" id="TotalidadDaLibr" name="TotalidadDaLibr" value="0.00" readonly>
                </tbody> 
                </table>
                <div class="col-lg-12" align="left">
                <button type="button" class="btn btn-success btn-xs" id="agregar3">
                    <span class="glyphicon glyphicon-plus"></span> Agregar
                </button>
                </div> 
            </div> <br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group ">
                        <label for="Foto">Fotografía dañados</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group ">
                        <label for="Observaciones">Observaciones</label>
                        <textarea onblur="ValidarProduccion()" placeholder="Describa una observación..." name="Observaciones" id="Observaciones" cols="30" rows="3" class="form-control"></textarea>
                    </div>
                </div>
            </div>  
            <div id="Validacion"></div>
            <div class="col-lg-12" align="center">
                <button type="button" disabled class="btn ink-reaction btn-raised btn-primary" id="BtmGuardar" data-toggle="modal" data-target="#ModalFacturas">Guardar</button>
            </div>
        </div>
    </div>
</div> 

<?php 
}
 elseif ($Contador==0 && $Contador2 == 0) {
   
  ?>
  <div class="alert alert-danger" role="alert">
    <h2 class="text-center">No hay producción ingresada el día seleccionado...</h2>
  </div>
  <?php   
} 
 if ($Contador>0 && $Contador2 > 0) {
   
  ?>
  <div class="alert alert-danger" role="alert">
    <h2 class="text-center">Ya realizo el ingreso del día seleccionado...</h2>
  </div>
  <?php   
} 
 ?>
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
                       Guardar();
                    } 
            }
        })
    }
</script>