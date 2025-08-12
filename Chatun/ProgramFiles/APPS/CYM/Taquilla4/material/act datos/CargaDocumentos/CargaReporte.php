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

          //include($_SERVER["DOCUMENT_ROOT"].'/includes/Head.php');
          //include($_SERVER["DOCUMENT_ROOT"]."/App/253_ActualizacionDatos/Menu/Menu.php");
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
                                              $sql = "INSERT into coosajo_asociatividad.asociados_info_incorrecta(cif) values('$data[0]')";
                                              mysqli_query($db, $sql) or die('Error: '.mysqli_error());
                                              }
                                      //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
                                      fclose($handle);
                                      // echo "Importación exitosa!";
        ?>
                    <table align="center">
                      <tr>
                        <td align="center">
                          ¡Importación Exitosa!
                        </td>
                      </tr>
                      <tr>
                        <td align="center">
                        <img src="up_ok.png"  />
                        </td>
                      </tr>
                    </table>
                    <?php
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

                                <h2 class="text-center">CARGAR LA DATA DE ASOCIADOS DESACTUALIZADOS</h2>

                            </div>

                            <div class="card-body collapse show">


                                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">CARGA DE ARCHIVO</h4>
                                <h6 class="card-subtitle"><!-- Just add <code>form-material</code> class to the form that's it. --></h6>
                                <form action='CargaReporte.php?subida=1' method='post' enctype="multipart/form-data">
                                   <div class="row">
                                     <div class="form-group col-md-4">
                                     </div>
                                    <div class="form-group col-md-6">
                                        <label>Seleccionar Archivo: </label>
                                        <input type="file" class="form-control form-control-line"  id="inp_SelArchivo" name="inp_SelArchivo" >
                                     </div>
                                  </div>


                                    <div class="form-group">
                                        <!-- <label>Helping text</label>
                                        <input type="text" class="form-control form-control-line"> <span class="help-block text-muted"><small>A block of help text that breaks onto a new line and may extend beyond one line.</small></span>  -->
                                     <button class="btn btn-success btn-lg" type="submit"><span class="mdi mdi-upload"></span>CARGAR REPORTE</button>
                                    </div>
                                </form>



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

</body>



</html>
