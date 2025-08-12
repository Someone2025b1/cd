<!DOCTYPE html>

<html lang="en">



<?php

    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");
    //include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");

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

                                <h2 class="text-center">ACTUALIZACION DE DATOS</h2>

                            </div>

                            <div class="card-body collapse show">



                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <?php
        //include
        //aqui hacemos el include de los scrips
        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');

    ?>

</body>



</html>
