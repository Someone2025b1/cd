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

                                                  </tr>

                                              </thead>

                                              <tbody>

                                              <?php
                                                  $fecha1 = date('m-d');
                                                  $fecha2 = date('Y');
                                                  $fecha3 = $fecha2-1;
                                                  $fecha_busqueda = $fecha3.'-'.$fecha1;

                                                  $Sql_Consultar_Cif = mysqli_query($db, $portal_coosajo_db2, "SELECT a.cif, date(b.ciffchactive) as fecha_ive from coosajo_asociatividad.asociados_info_incorrecta as a
                                                                                                          inner join bankworks.cif_generales as b
                                                                                                          on b.cifcodcliente = a.cif
                                                                                                          where date(b.ciffchactive) <= '$fecha_busqueda' order by a.cif asc");

                                                                        while($Fila_Consultar_Cif = mysqli_fetch_array($Sql_Consultar_Cif))

                                                                          {
                                                                              $contador3++;

                                                      ?>

                                                          <tr>

                                                              <td><?php echo $contador3 ?></h6></td>
                                                              <td><?php echo $Cif = $Fila_Consultar_Cif["cif"] ?></h6></td>
                                                              <td><?php echo $nombre_asociado = utf8_encode(saber_nombre_asociado_orden($Cif)) ?></td>
                                                              <td><?php
                                                                      $Sql_Datos = mysqli_query($db, $portal_coosajo_db2, "SELECT cifsexo, ciffecnacimie, ciffchactive, cifcodocupaci, cifcodareafin, ciffechaingre FROM bankworks.cif_generales as a
                                                                                                                                where a.cifcodcliente = '$Cif'");
                                                                      $Rw_Datos = mysqli_fetch_array($Sql_Datos);
                                                                      echo $Txt_Sexo = $Rw_Datos["cifsexo"];
                                                                    ?>
                                                              </td>
                                                              <td><?php echo $edad_asociado = Saber_Edad_Asociado($fecha_nacimiento  = $Cif); ?></h6></td>
                                                              <td><?php echo $fecha_ive = quitar_hora_fecha($Rw_Datos['ciffchactive']);   ?></h6></td>
                                                              <td><?php echo $ocupacion = saber_ocupacion_bankworks($Rw_Datos['cifcodocupaci']);   ?></h6></td>
                                                              <td><?php echo $agencia = utf8_encode(saber_nombre_agencia($Rw_Datos['cifcodareafin']));   ?></h6></td>
                                                              <td><?php $fecha_ingreso = quitar_hora_fecha($Rw_Datos['ciffechaingre']); echo $antiguedad = CalculaEdad($fecha_ingreso); ?></h6></td>
                                                              <td><?php
                                                                        $Sql_Ir = mysqli_query($db, $portal_coosajo_db2, "SELECT a.fecha from coosajo_gestion_documental.archivos as a
                                                                        where a.cuenta = '$Cif' and a.id_documento = 335 order by a.id desc limit 1");
                                                                        $Rw_Ir = mysqli_fetch_array($Sql_Ir);
                                                                        $ir = $Rw_Ir['fecha'];

                                                                                    if($ir <> NULL){
                                                                                      $tiene_ir = '1';
                                                                                      $ir_asociado = cambio_fecha(quitar_hora_fecha($ir));
                                                                                      echo $ir_asociado;
                                                                                    } else {
                                                                                      $tiene_ir = '0';
                                                                                      echo $ir_asociado = 'NO';
                                                                                    }
                                                                    ?>
                                                                </h6></td>
                                                                <td><?php
                                                                          $Sql_Ingresos = mysqli_query($db, $portal_coosajo_db2, "SELECT (CIFINGRERELDEP + CIFINGRENEGPR + CIFREMFMONTO + CIFOTRFUEINGR) as total  from bankworks.cif_generales as a where a.cifcodcliente =  '$Cif'");
                                                                          $Rw_Ingresos = mysqli_fetch_array($Sql_Ingresos);
                                                                          echo $ingresos = number_format($Rw_Ingresos['total'],2);
                                                                      ?>
                                                                 </h6></td>
                                                                 <td><?php
                                                                          $fecha_inicio = date('Y-m').'-01';
                                                                          $fecha_final = date('Y-m').'-31';
                                                                          $Sql_Frecuencia = mysqli_query($db, $portal_coosajo_db2, "SELECT sum(total) AS SUMAT
                                                                                                                        from (select count(*) as total
                                                                                                                        from bankworks.transacciones as t
                                                                                                                        where date(t.fecha) between '$fecha_inicio' and '$fecha_final'
                                                                                                                        and t.cif_asociado = '$Cif'
                                                                                                                        group  by  t.cif_asociado,date(t.fecha)) as Frecuencia");
                                                                          $Rw_Frecuencia = mysqli_fetch_array($Sql_Frecuencia);
                                                                          echo $frecuencia = $Rw_Frecuencia['SUMAT'];
                                                                      ?>
                                                                  </h6></td>
                                                                  <td><?php
                                                                           $fecha_inicio = date('Y-m').'-01';
                                                                           $fecha_final = date('Y-m').'-31';
                                                                           $Sql_Gestiones = mysqli_query($db, $portal_coosajo_db2, "SELECT count(id) as no_gestiones FROM `coosajo_asociatividad`.`gestion_actualizacion` AS A WHERE A.cif = '$Cif'");
                                                                           $Rw_Gestiones = mysqli_fetch_array($Sql_Gestiones);
                                                                           echo $no_gestiones = $Rw_Gestiones['no_gestiones'];


                                                                           $nombre_asociado_exp2 = str_replace(',',' ',$nombre_asociado);
                                                                           $nombre_asociado_exp = str_replace("'",'',$nombre_asociado_exp2);
                                                                           $ingresos;
                                                                           $Sql_Guardar_Cif = mysqli_query($db, $portal_coosajo_db2, "REPLACE INTO coosajo_asociatividad.reporte_asociados_act_datos (cif, nombre_asociado, sexo, edad, fecha_ive, ocupacion, agencia, antiguedad, formulario_ir01, ingresos_mensuales, frecuencia, no_gestiones)
                                                                                                                                                                                         VALUES ('$Cif', '$nombre_asociado_exp', '$Txt_Sexo', '$edad_asociado', '$fecha_ive', '$ocupacion', '$agencia', '$antiguedad', '$ir_asociado', '$ingresos', '$frecuencia', '$no_gestiones')");
                                                                           //mysqli_query($db, "REPLACE INTO coosajo_asociatividad.reporte_asociados_act_datos (cif, nombre_asociado, sexo, edad, fecha_ive, ocupacion, agencia, antiguedad, formulario_ir01, ingresos_mensuales, frecuencia, no_gestiones) VALUES ('$cif', '$nombre_asociado_exp', '$sexo', '$edad_asociado', '$fecha_ive', '$ocupacion', '$agencia', '$antiguedad', '$ir_asociado', '$ingresos', '$frecuencia', '$no_gestiones')") or die (mysqli_error()) ;
                                                                       ?>
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
