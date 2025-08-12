<!DOCTYPE html>

<html lang="en">

<?php


    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");

    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");

    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

    include($_SERVER["DOCUMENT_ROOT"]."/includes/Header.php");

?>



<body class="fix-header card-no-border">



    <div id="main-wrapper">

        <?php
        include($_SERVER["DOCUMENT_ROOT"].'/includes/Head.php');
        include($_SERVER["DOCUMENT_ROOT"]."/App/253_ActualizacionDatos/Menu/Menu.php");

        $cif = $_GET['Cif'];
        $SQL_Informacion = mysqli_query($db, $portal_coosajo_db2, "SELECT a.cifcodcliente, a.cifnombreclie, a.ciftelefonos, a.ciftelcelular, a.ciftelefonoalter, a.ciffechactu,
          a.cifrefperso01, a.cifmovperso01,  a.cifrefperso02, a.cifmovperso02, a.ciffchultmodi, a.cifdiredomici,
          a.cifdir2domici, a.cifdiredomici, a.cifdir2domici, a.cifreffam01, a.cifmovfam01, a.cifreffam02, a.cifmovfam02
        FROM bankworks.cif_generales as a
        where a.cifcodcliente = '$cif'");
        $Row_Informacion=mysqli_fetch_array($SQL_Informacion);

        ///////////////////////GUARDAR LA GESTION EN LA BASE DE DATOS //////////////////////
        if($_GET['SV'] == 1)
          {
                $respondio  = $_POST['Slt_Respondio'];
                $tipo_gestion  = $_POST['Slt_TipoGestion'];
                $observaciones  = $_POST['Txt_Observaciones'];
                $ref_per1  = $_POST['Ch_RefPer1'];
                $ref_per2  = $_POST['Ch_RefPer2'];
                $ref_fam1  = $_POST['Ch_RefFam1'];
                $ref_fam2  = $_POST['Ch_RefFam2'];
                $cif_colaborador = $_SESSION['CIF'];

                $Sql_Datos_Perfil = mysqli_query($db, $portal_coosajo_db2, "INSERT INTO `coosajo_asociatividad`.`gestion_actualizacion`(`cif` ,`respondio` ,`tipo_gestion` ,`observaciones` ,`cif_responsable` ,`ref_per1` ,`ref_per2` ,`ref_fam1` ,`ref_fam2`)
                                                                   VALUES ('$cif', '$respondio','$tipo_gestion','$observaciones','$cif_colaborador' ,'$ref_per1' ,'$ref_per2' ,'$ref_fam1' ,'$ref_fam2')");


          }////////// FIN DE GUARDAR

        ?>

        <div class="page-wrapper">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-12">

                        <div class="card">

                            <div class="card-header">

                                <div class="card-actions">

                                    <a class="" data-action="collapse"><i class="ti-minus"></i></a>

                                    <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>

                                </div>

                                <h2 class="text-center">ACTUALIZACION DE INFORMACION DE ASOCIADOS</h2>

                            </div>

                            <div class="card-body collapse show">


                                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Información del Asociado</h4>
                                <h6 class="card-subtitle"><!-- Just add <code>form-material</code> class to the form that's it. --></h6>
                                <form class="form-material m-t-40" id="Frm_ActDatos" name="Frm_ActDatos" method="post" action="GestionActualizacion.php?Cif=<?php echo $cif ?>&SV=1">
                                  <div class="row">
                                      <div class="form-group col-md-6">
                                        <a href="http://10.60.8.209/portal/ProgramFiles/APPS/Gerencia_Negocios/actualizacion_datos/consulta_ive.php?cif=<?php echo $cif ?>&centinela=1" class="btn btn-primary" target="_blank"><i class="fa fa-user-circle"></i>CONSULTAR PERFIL</a>
                                      </div>
                                  </div>
                                   <div class="row">
                                        <div class="form-group col-md-3">
                                              <label>Cif Asociado: </label>
                                              <input type="number" class="form-control form-control-line" value="<?php echo $cif ?>" id="Txt_CifAsociado" name="Txt_CifAsociado" readonly="readonly" >
                                        </div>
                                        <div class="form-group col-md-6">
                                              <label for="example-email">Nombre Asociado:</label>
                                              <input type="text" id="Txt_NombreAsociado" name="Txt_NombreAsociado" class="form-control" required="required"  value="<?php echo saber_nombre_asociado_orden($cif) ?>"  readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="row">
                                         <div class="form-group col-md-3">
                                               <label>Celular: </label>
                                               <input type="number" class="form-control form-control-line" value="<?php echo $Row_Informacion["ciftelcelular"]; ?>" id="Txt_Celular" name="Txt_Celular" readonly="readonly" >
                                         </div>
                                         <div class="form-group col-md-6">
                                               <label for="example-email">Dirección:</label>
                                               <input type="text" id="Txt_Direccion" name="Txt_Direccion" class="form-control" required="required"  value="<?php echo $Row_Informacion["cifdiredomici"]; ?>"  readonly="readonly">
                                         </div>
                                     </div>
                                     <div class="row">
                                          <div class="form-group col-md-3">
                                                <label>Otros Teléfonos: </label>
                                                <input type="text" class="form-control form-control-line" value="<?php echo $Row_Informacion["ciftelefonos"]." - ".$Row_Informacion['ciftelefonoalter'];  ?>" id="Txt_Otros_telefonos" name="Txt_Otros_telefonos" readonly="readonly" >
                                          </div>
                                          <div class="form-group col-md-6">
                                                <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#add-contact" onclick="referencia();">Consultar Referencias</button>
                                          </div>
                                      </div>
                                      <div class="row">
                                           <div class="form-group col-md-3">
                                                 <label>Fecha IVE: </label>
                                                 <input type="text" class="form-control form-control-line" value="<?php echo cambio_fecha(quitar_hora_fecha(cambio_fecha_hora($Row_Informacion['ciffchultmodi']))); ?>" id="Txt_FechaIve" name="Txt_FechaIve" readonly="readonly" >
                                           </div>
                                           <div class="form-group col-md-6">
                                                 <label for="example-email">Respondió:</label>
                                                 <select class="form-control" name="Slt_Respondio" id="Slt_Respondio" >
                                                    <option value="0">N/R</option>
                                                    <option value="1">Titular</option>
                                                    <option value="2">Referencias Personales</option>
                                                    <option value="3">Referencias Familiares</option>
                                                    <option value="4">Asociado Fallecido</option>
                                                    <option value="5">Dejo de ser Asociado</option>
                                                    <option value="6">Socio Único</option>
                                                 </select>
                                           </div>
                                       </div>
                                       <div class="row">
                                            <div class="form-group col-md-6">
                                                  <label for="example-email">Tipo de Gestión:</label>
                                                  <?php $Ir = $_GET["Ir"];
                                                    if($Ir == '1'){
                                                    ?>
                                                    <select class="form-control" name="Slt_TipoGestion" id="Slt_TipoGestion"  onchange="abrirLink(this.value)" >
                                                       <option value="0">--Seleccione--</option>
                                                       <option value="1">Constancia de Revision</option>
                                                       <option value="2">Actualizacion de IR</option>
                                                       <option value="3">Actualizacion con Cambios</option>
                                                       <option value="4">Actualizacion sin Cambios</option>
                                                       <option value="5">Devolver LLamada</option>
                                                     </select>
                                                    <?php
                                                  }else{
                                                  ?>
                                                  <select class="form-control" name="Slt_TipoGestion" id="Slt_TipoGestion"  onchange="abrirLink(this.value)" >
                                                     <option value="0">--Seleccione--</option>
                                                     <option value="2">Actualizacion de IR</option>
                                                     <option value="5">Devolver LLamada</option>
                                                   </select>
                                                 <?php } ?>
                                            </div>
                                        </div>





                                    <div class="form-group">
                                        <label>Observaciones:</label>

                                                <textarea class="form-control" id="Txt_Observaciones" name="Txt_Observaciones" rows="3" placeholder="Aqui escriba observaciones..." name="Txt_Observaciones" ></textarea>

                                    </div>
                                    <div class="form-group">
                                        <!-- <label>Helping text</label>
                                        <input type="text" class="form-control form-control-line"> <span class="help-block text-muted"><small>A block of help text that breaks onto a new line and may extend beyond one line.</small></span>  -->
                                     <button class="btn btn-success btn-md" type="submit" ><span class="mdi mdi-content-save"></span>Guardar Gestión</button>

                                                                        <!-- MODAL PARA LAS REFERENCIAS -->
                                                                        <div id="Md_Referencias" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h4 class="modal-title" id="myModalLabel">REFRERENCIAS DEL ASOCIADO</h4>
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <from class="form-horizontal form-material">
                                                                                            <div class="form-group">
                                                                                                <div class="col-md-12 m-b-20">
                                                                                                    <div class="switch">
                                                                                                        <label><input type="checkbox" name="Ch_RefPer1" id="Ch_RefPer1" value="1"><span class="lever switch-col-light-blue"></span></label>
                                                                                                    </div>
                                                                                                    <label>Referencia Personal 1: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_RefPer1" value="<?php echo $Row_Informacion['cifrefperso01'];  ?>" readonly>
                                                                                                </div>
                                                                                                <div class="col-md-6 m-b-20">
                                                                                                    <label>Tel. Referencia 1: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_TelRefPer1"  value="<?php echo $Row_Informacion['cifmovperso01'];  ?>" readonly>
                                                                                                </div>
                                                                                                <div class="col-md-12 m-b-20">
                                                                                                    <div class="switch">
                                                                                                        <label><input type="checkbox" name="Ch_RefPer2" id="Ch_RefPer2" value="1" ><span class="lever switch-col-light-blue"></span></label>
                                                                                                    </div>
                                                                                                    <label>Referencia Personal 2: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_RefPer2"  value="<?php echo $Row_Informacion['cifrefperso02'];  ?>" readonly>
                                                                                                </div>
                                                                                                <div class="col-md-6 m-b-20">
                                                                                                    <label>Tel. Referencia 2: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_TelRefPer2"  value="<?php echo $Row_Informacion['cifmovperso02'];  ?>" readonly>
                                                                                                </div>
                                                                                                <div class="col-md-12 m-b-20">
                                                                                                    <div class="switch">
                                                                                                        <label><input type="checkbox" name="Ch_RefFam1" id="Ch_RefFam1" value="1"  ><span class="lever switch-col-light-blue"></span></label>
                                                                                                    </div>
                                                                                                    <label>Referencia Familiar 1: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_RefFam1"   value="<?php echo $Row_Informacion['cifrefperso01'];  ?>" readonly>
                                                                                                </div>
                                                                                                <div class="col-md-6 m-b-20">
                                                                                                    <label>Tel. familiar 1: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_TelRefFam1"  value="<?php echo $Row_Informacion['cifmovfam01'];  ?>" readonly>
                                                                                                </div>
                                                                                                <div class="col-md-12 m-b-20">
                                                                                                    <div class="switch">
                                                                                                        <label><input type="checkbox" name="Ch_RefFam2" id="Ch_RefFam2" value="1" ><span class="lever switch-col-light-blue"></span></label>
                                                                                                    </div>
                                                                                                    <label>Referencia Familiar 2: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_RefFam2"  value="<?php echo $Row_Informacion['cifreffam02'];  ?>" readonly>
                                                                                                </div>
                                                                                                <div class="col-md-6 m-b-20">
                                                                                                    <label>Tel. familiar 2: </label>
                                                                                                    <input type="text" class="form-control" name="Txt_TelRefFam2"  value="<?php echo $Row_Informacion['cifmovfam02'];  ?>" readonly>
                                                                                                </div>
                                                                                            </div>
                                                                                        </from>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">GUARDAR</button>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.modal-content -->
                                                                            </div>
                                                                            <!-- FIN DE LA MODAL DE REFERENCIAS -->
                                                    </div>
                                    </div>

                                </form>



                            </div>
                        </div>
                        <!-- FIN DEL DIV DE LA INFORMACION DEL ASOCIADO -->


  <!-- DIV PARA LAS GESTIONES QUE SE HAN REALIZADO -->

  <!-- INICIO DEL ENCABEZADO DE LA TARJETA -->
  <div class="card-header">

      <div class="card-actions">

          <a class="" data-action="collapse"><i class="ti-minus"></i></a>

          <a class="btn-minimize" data-action="expand"><i class="mdi mdi-arrow-expand"></i></a>

      </div>

      <h2 class="text-center">LISTADO DE GESTIONES REALIZADAS</h2>

  </div>
  <!-- FIN DEL ENCABEZADO DE LA TARJETA -->
        <div class="card-body collapse show">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"></h4>
                            <h6 class="card-subtitle"><!-- Just add <code>form-material</code> class to the form that's it. --></h6>

                                                        <div class="card-body collapse show">

                                                          <div class="card-body collapse show">

                                                              <div class="row">

                                                                  <div class="col-md-12">

                                                                      <table id="TableMenu" class="table table-hover table-condensed"

                                                                              data-toggle="table"

                                                                              data-toolbar="#toolbar"

                                                                              data-show-export="false"

                                                                              data-icons-prefix="fa"

                                                                              data-icons="icons"

                                                                              data-pagination="true"

                                                                              data-sortable="true"

                                                                              data-search="true"

                                                                              data-filter-control="true">

                                                                          <thead>

                                                                              <tr>

                                                                                  <th data-sortable="true" data-field="NO." data-filter-control="input"><h6><strong>NO.</strong></h6></th>
                                                                                  <th data-sortable="true" data-field="CIF" data-filter-control="input"><h6><strong>CIF</strong></h6></th>
                                                                                  <th data-sortable="true" data-field="NOMBRE_ASOCIADO" data-filter-control="input"><h6><strong>NOMBRE ASOCIADO</strong></h6></th>
                                                                                  <th data-sortable="true" data-field="QUIEN_RESPONDIO" data-filter-control="input"><h6><strong>QUIEN RESPONDIO</strong></h6></th>
                                                                                  <th data-sortable="true" data-field="TIPO_GESTION" data-filter-control="input"><h6><strong>TIPO DE GESTION</strong></h6></th>
                                                                                  <th data-sortable="true" data-field="OBSERVACIONES" data-filter-control="input"><h6><strong>OBSERVACIONES</strong></h6></th>
                                                                                  <th data-sortable="true" data-field="RESPONSABLE" data-filter-control="input"><h6><strong>RESPONSABLE</strong></h6></th>
                                                                                  <th data-sortable="true" data-field="FECHA_ACT" data-filter-control="input"><h6><strong>FECHA ACTUALIZACION</strong></h6></th>


                                                                              </tr>

                                                                          </thead>

                                                                          <tbody>

                                                                          <?php

                                                                              $Sql_Ges_Creadas = mysqli_query($db, $portal_coosajo_db2, "SELECT * from coosajo_asociatividad.gestion_actualizacion
                                                                                                                                      where cif = '$cif' order by id  desc");

                                                                                                    while($Fila_Ges_Creadas = mysqli_fetch_array($Sql_Ges_Creadas))

                                                                                                      {
                                                                                                          $contador3++;

                                                                                  ?>

                                                                                      <tr>

                                                                                          <td><?php echo $contador3 ?></h6></td>
                                                                                          <td><?php echo $Cif = $Fila_Ges_Creadas["cif"] ?></h6></td>
                                                                                          <td><?php echo utf8_decode(saber_nombre_asociado_orden($Cif))  ?></h6></td>
                                                                                          <td><?php $quien_respondio = $Fila_Ges_Creadas["respondio"];
                                                                                                      if($quien_respondio == 0){
                                                                                                      echo "N/R";
                                                                                                        }
                                                                                                      if($quien_respondio == 1){
                                                                                                          echo "Titular";
                                                                                                        }
                                                                                                      if($quien_respondio == 2){
                                                                                                          echo "Referencias Personales";
                                                                                                        }
                                                                                                      if($quien_respondio == 3){
                                                                                                          echo "Referencias Familiares";
                                                                                                        }
                                                                                                      if($quien_respondio == 4){
                                                                                                          echo "Asociado Fallecido";
                                                                                                        }
                                                                                                      if($quien_respondio == 5){
                                                                                                          echo "Dejo de ser Asociado";
                                                                                                        }
                                                                                                      if($quien_respondio == 6){
                                                                                                          echo "Socio Único";
                                                                                                        }
                                                                                                ?></h6></td>
                                                                                                <td><?php $tipo_gestion = $Fila_Ges_Creadas["tipo_gestion"];
                                                                                                      if($tipo_gestion == 1){
                                                                                                          echo "Constancia de Revision";
                                                                                                        }
                                                                                                      if($tipo_gestion == 2){
                                                                                                          echo "Actualizacion de IR";
                                                                                                        }
                                                                                                      if($tipo_gestion == 3){
                                                                                                          echo "Actualizacion con Cambios";
                                                                                                        }
                                                                                                      if($tipo_gestion == 4){
                                                                                                          echo "Actualizacion sin Cambios";
                                                                                                        }
                                                                                                        if($tipo_gestion == 5){
                                                                                                          echo "Devolver LLamada";
                                                                                                        }
                                                                                                  ?></h6></td>
                                                                                                  <td><?php echo $Cif = $Fila_Ges_Creadas["observaciones"] ?></h6></td>
                                                                                                  <td><?php echo utf8_decode(saber_nombre_asociado_orden($Fila_Ges_Creadas["cif_responsable"])) ?></h6></td>
                                                                                                  <td><?php echo cambio_fecha_hora($Fila_Ges_Creadas["fecha_gestion"]) ?></h6></td>

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

                        </div>

                    </div>

                </div>

            </div>

        </div>

  </div>

    <?php

        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');

    ?>


</html>
<script>



function GuardarNegociacionTasa(){

    var FormNegociacioTasa = $('#Frm_NegociacionTasa').serialize();
    var inpObj1 = document.getElementById('Frm_NegociacionTasa');
 if(inpObj1.checkValidity() == true)
            {

    $.ajax({
        url: 'ajax/GuardarNegociacionTasa.php',
        type: 'POST',
        data: FormNegociacioTasa,
              beforeSend: function(){

                            },
              success: function(data){
                            Swal.fire(
                              'Se ha Guardado Correctamente...',
                              'You clicked the button!',
                              'success'
                            )
                         }
    })

            }else{

                 Swal.fire({
                      title: 'Campos Requeridos...',
                      text: 'Favor de Llenar informacion que hace falta...',
                      type: 'warning',
                      confirmButtonText: 'Aceptar'
                    })


            }

}

function referencia()
{
    $('#Md_Referencias').modal('show');

}


function abrirLink(IdGestion)
{
 if(IdGestion == 1)
 {
   window.open('http://10.60.8.209/portal/ProgramFiles/APPS/Caja/adm_doc/documentos/rev_sin_cambios.php?cif_asociado=<?php echo $cif ?>', '_blank');
 }

 if(IdGestion == 2)
{
  Swal.fire({
  title: 'DIRIGETE A BANKWORKS Y ACTUALIZA INFORMACION DESDE PLATAFORMA',
  animation: false,
  customClass: 'animated tada'
})
}

 if(IdGestion == 3)
 {
   window.open('http://10.60.8.209/portal/ProgramFiles/APPS/Caja/adm_doc/documentos/FO-CAJ-018-1.php?cif=<?php echo $cif ?>&accion=10', '_blank');
 }

 if(IdGestion == 4)
 {
   window.open('http://10.60.8.209/portal/ProgramFiles/APPS/Caja/adm_doc/documentos/gestion_sin_cambios.php?cif_asociado=<?php echo $cif ?>', '_blank');
 }

}

</script>
