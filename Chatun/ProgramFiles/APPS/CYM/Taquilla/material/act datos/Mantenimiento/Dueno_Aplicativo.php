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

            $Sql_Limpiar_Temporales = mysqli_query($db, $portal_coosajo_db, "DELETE FROM portal_coosajo_db.DUENO_APLICATIVO WHERE DA_ESTADO = 0 AND DA_COLABORADOR_AGREGA = ".$_SESSION['CIF']);
        ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="card-body collapse show">
                    <div class="row" id="validation">
                        <div class="col-12">
                            <div class="card wizard-content">
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <form class="form" id="FRMAgregarDueno">
                                                    <input type="hidden" name="ReferenciaAplicacion" id="ReferenciaAplicacion" value="<?php echo $Referencia_Aplicacion_Menu ?>">
                                                    <div class="form-group col-md-12">
                                                        <label for="ColaboradorDueno">Colaborador</label>
                                                        <select class="form-control selectpicker" data-live-search="true" id="ColaboradorDueno" name="ColaboradorDueno" required>
                                                            <option value="" disabled selected>SELECCIONE UN COLABORADOR</option>
                                                            <?php
                                                                $Sql_Colaborador = mysqli_query($db, $portal_coosajo_db, "SELECT A.cif, A.Nombres_Completos
                                                                                                                    FROM info_colaboradores.vista_colaboradores_idt AS A
                                                                                                                    WHERE A.estado = 'Activo'
                                                                                                                    AND A.cif NOT IN (SELECT DA_COLABORADOR FROM portal_coosajo_db.DUENO_APLICATIVO WHERE A_REFERENCIA = '".$$Referencia_Aplicacion_Menu."')
                                                                                                                    ORDER BY A.Nombres_Completos");
                                                                while($Fila_Colaborador = mysqli_fetch_array($Sql_Colaborador))
                                                                {
                                                                    ?>
                                                                        <option value="<?php echo $Fila_Colaborador['cif'] ?>"><?php echo $Fila_Colaborador['Nombres_Completos'] ?></option>
                                                                    <?php
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-12 text-center">
                                                        <button type="button" class="btn btn-primary" onclick="GuardarDuenoAplicativo()">Guardar</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-lg-6">
                                                <?php
                                                    $Sql_DuenosAplicativo = mysqli_query($db, $portal_coosajo_db, "SELECT * FROM portal_coosajo_db.DUENO_APLICATIVO WHERE A_REFERENCIA = '".$Referencia_Aplicacion_Menu."'");
                                                ?>
                                                <caption class="text-center"><strong>Lista Dueños de Aplicativo</strong></caption>
                                                <table class="table table-hover table-condensed">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>CIF</th>
                                                            <th>COLABORADOR</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $Correlativo = 1;
                                                        while($Fila = mysqli_fetch_array($Sql_DuenosAplicativo))
                                                        {
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $Correlativo ?></td>
                                                                    <td><?php echo $Fila['DA_COLABORADOR'] ?></td>
                                                                    <td><?php echo saber_nombre_asociado_orden($Fila['DA_COLABORADOR']) ?></td>
                                                                    <td><a data-toggle="tooltip" data-original-title="Eliminar" data-codigo="<?php echo $Fila['DA_CODIGO'] ?>" onclick="EliminarDueno(this)"> <i class="fa fa-close text-danger"></i> </a></td>
                                                                </tr>
                                                            <?php
                                                            $Correlativo++;
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
    <?php
        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');
    ?>
    
</body>

<script>
    function GuardarDuenoAplicativo()
    {
        if($('#FRMAgregarDueno')[0].checkValidity())
        {
            var FRMSerializado = $('#FRMAgregarDueno').serialize();
            $.ajax({
                    url: 'Ajax/GuardarDuenoAplicativo.php',
                    type: 'post',
                    data: FRMSerializado,
                    success: function (data) {
                        if(data == 1)
                        {
                            window.location.reload();
                        }
                        else
                        {
                            Swal({
                              type: 'error',
                              title: 'Error',
                              text: 'Hubo un error al tratar de agregar el colaborador como dueño del aplicativo, comuníquese con IDT'
                            })
                        }
                    }
                });
        }
        else
        {
            Swal({
              type: 'error',
              title: 'Error',
              text: 'Antes de continuar debe seleccionar un colaborador'
            })
        }
    }
    function EliminarDueno(x)
        {
            var CodigoDueno = $(x).attr('data-codigo');

            const swalWithBootstrapButtons = swal.mixin({
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger',
              buttonsStyling: false,
            })

            $.ajax({
                    url: '../Ajax/EliminarDueno.php',
                    type: 'post',
                    data: 'Codigo='+CodigoDueno,
                    success: function (data) {
                        if(data == 1)
                        {
                            window.location.reload();
                        }
                        else
                        {
                            swalWithBootstrapButtons(
                              'Error!',
                              'No se pudo eliminar el dueñol aplicativo. Comuníquese con IDT',
                              'error'
                            )
                        }
                    }
                });
        }
</script>

</html>
