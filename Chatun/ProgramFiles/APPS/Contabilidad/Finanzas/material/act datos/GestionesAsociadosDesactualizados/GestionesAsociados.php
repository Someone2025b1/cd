<!DOCTYPE html>

<html lang="es">

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
      ?>





      <?php ///////// CARGAR EL REPORTE A LA BASE DE DATOS
        $subida = $_GET['subida'];
              IF($subida == 1){
                          $fname = $_FILES['inp_SelArchivo']['name'];
                          $chk_ext = explode(".",$fname);

                                    if(strtolower(end($chk_ext)) == "csv"){
                                        $filename = $_FILES['inp_SelArchivo']['tmp_name'];
                                        $handle = fopen($filename, "r");
                                              while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                                              //Insertamos los datos con los valores...
                                                  $Sql_Guardar_Cif = mysqli_query($db, $portal_coosajo_db2, "INSERT INTO coosajo_asociatividad.asociados_info_incorrecta(cif) values('$data[0]')");
                                              }


                                      //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
                                      fclose($handle);
                                      // echo "Importación exitosa!";
                                      $Importado = '1';


                }
                else
                {
                   //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para
       //ver si esta separado por " , "
                    echo "Archivo invalido!";
                }

            } /// FIN DE GUARDAR


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

                                <h2 class="text-center">GENERAR LA DATA DE ASOCIADOS DESACTUALIZADOS</h2>

                            </div>

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
                                                      <th data-sortable="true" data-field="NOMBRE_ASOCIADO" data-filter-control="select"><h6><strong>NOMBRE ASOCIADO</strong></h6></th>
                                                      <th data-sortable="true" data-field="SEXO" data-filter-control="select"><h6><strong>SEXO</strong></h6></th>
                                                      <th data-sortable="true" data-field="EDAD" data-filter-control="select"><h6><strong>EDAD</strong></h6></th>
                                                      <th data-sortable="true" data-field="FECHA_IVE" data-filter-control="select"><h6><strong>FECHA IVE</strong></h6></th>
                                                      <th data-sortable="true" data-field="OCUPACION" data-filter-control="select"><h6><strong>OCUPACION</strong></h6></th>
                                                      <th data-sortable="true" data-field="AGENCIA" data-filter-control="select"><h6><strong>AGENCIA</strong></h6></th>
                                                      <th data-sortable="true" data-field="ANTIGUEDAD" data-filter-control="select"><h6><strong>ANTIGUEDAD</strong></h6></th>
                                                      <th data-sortable="true" data-field="FORMULARIO_IR" data-filter-control="select"><h6><strong>FORMULARIO IR-01</strong></h6></th>
                                                      <th data-sortable="true" data-field="INGRESOS_MENSUALES" data-filter-control="select"><h6><strong>INGRESOS MENSUALES</strong></h6></th>
                                                      <th data-sortable="true" data-field="FRECUENCIA" data-filter-control="select"><h6><strong>FRECUENCIA</strong></h6></th>
                                                      <th data-sortable="true" data-field="NO_GESTIONES" data-filter-control="select"><h6><strong>NO GESTIONES</strong></h6></th>
                                                      <th data-sortable="true" data-field="ACTUALIZAR" data-filter-control="input"><h6><strong>ACTUALIZAR</strong></h6></th>

                                                  </tr>

                                              </thead>

                                              <tbody>

                                              <?php
                                                  $fecha1 = date('m-d');
                                                  $fecha2 = date('Y');
                                                  $fecha3 = $fecha2-1;
                                                  $fecha_busqueda = $fecha3.'-'.$fecha1;

                                                  $Sql_Consultar_Cif = mysqli_query($db, $portal_coosajo_db2, "SELECT * FROM coosajo_asociatividad.reporte_asociados_act_datos ");

                                                                        while($Fila_Consultar_Cif = mysqli_fetch_array($Sql_Consultar_Cif))

                                                                          {
                                                                              $contador3++;

                                                      ?>

                                                          <tr>

                                                              <td><?php echo $contador3 ?></h6></td>
                                                              <td><?php echo $Cif = $Fila_Consultar_Cif["cif"] ?></h6></td>
                                                              <td><?php echo utf8_encode($Fila_Consultar_Cif["nombre_asociado"]) ?></td>
                                                              <td><?php echo $Fila_Consultar_Cif["sexo"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["edad"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["fecha_ive"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["ocupacion"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["agencia"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["antiguedad"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["formulario_ir01"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["ingresos_mensuales"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["frecuencia"] ?></h6></td>
                                                              <td><?php echo $Fila_Consultar_Cif["no_gestiones"] ?></h6></td>
                                                                   <td aling="center">
                                                                        <?php $tiene_ir = $Fila_Consultar_Cif["formulario_ir01"];
                                                                          if($tiene_ir == 'NO'){
                                                                            $ir = '0';
                                                                          }else{
                                                                            $ir = '1';
                                                                          }
                                                                         ?>
                                                                        <a href="GestionActualizacion.php?Cif=<?php echo $Cif ?>&Ir=<?php echo $ir ?>" data-toggle="tooltip" data-original-title="Actualizar" target="_blank"> <i class="fa fa-edit text-warning"></i> </a>
                                                                   </h6></td>


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


    <div class="modal" tabindex="-1" role="dialog" id="myModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Carga Exitosa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Su archivo fue cargado exitosamente.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>



    <?php

        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');

    ?>

</body>
<script>
$(document).ready(function() {
  $('.dropify').dropify();
    });
</script>

<?php
$Importado;
IF($Importado == 1){

 ?>
<script language="javascript" type="text/javascript">

  $('#myModal').modal('show');

</script>
<?PHP
  }
 ?>

</html>
