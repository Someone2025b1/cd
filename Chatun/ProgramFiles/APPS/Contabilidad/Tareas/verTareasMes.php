<?php 
include ("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$id_user = $_SESSION["iduser"];
$query = "SELECT * FROM tareas.editar_tareas GROUP BY MES";
$respuesta = mysqli_query($db, $query);
?>

<?php $query = "SELECT * FROM tareas.editar_tareas GROUP BY YEA";
$respuesta_yea = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista Tareas</title>

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="Datatables/DataTables-1.10.25/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" type="text/css" href="Datatables/Buttons-1.7.1/css/buttons.bootstrap4.min.css" />

<script src="jquery/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="Datatables/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="Datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="Datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="Datatables/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="Datatables/DataTables-1.10.25/js/dataTables.bootstrap4.min.js"></script>
<!-- <script type="text/javascript" src="Datatables/Buttons-1.7.1/js/dataTables.buttons.min.js"></script> -->
<!-- habilita botones -->
<script type="text/javascript" src="Datatables/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="Datatables/Buttons-1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="Datatables/Buttons-1.7.1/js/buttons.print.min.js"></script>

<?php $count = 1 ?>
<?php $count_2 = 1 ?>

</head>

<body>


<div class="container ">
<div class="row">
<div class="col-sm-6">
<div class="card ">
    <div class="card-header  text-white" style="background-color: #1174A0;">Tareas Auxiliar Contable </div>
    <div class="card body mt-2">
        <form action="verTareasMes.php" name="ver_tareas" method="POST">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-control" name="MES" id="" required>
                                <option value="">Mes</option>
                                <?php while ($row = mysqli_fetch_array($respuesta)) { ?> <option value="<?php echo $row['MES'] ?>"><?php echo $row['MES'] ?></option> <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select name="YEA" id="" required class="form-control">
                                <option value="">Year</option>
                                <?php while ($row = mysqli_fetch_array($respuesta_yea)) { ?> <option value="<?php echo $row['YEA'] ?>"><?php echo $row['YEA'] ?></option><?php } ?>
                            </select>
                        </td>
                        <td><button class="btn btn-success btn-sm " type="submit" style="margin-left:1cm; margin-right: 3cm;">Ver Tareas</button>
                        </td>
                        <td><a href="main.php" class="btn btn-danger btn-sm ">Ir a Principal</a></td>
                        
                    </tr>
                   
                </tbody>
            </table>
            <table class="table" id="example" style="font-size:1px">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tarea</th>
                        <th scope="col">Estatus</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (isset($_POST['MES'])) {
                        $MES = $_POST['MES'];
                        $YEA =  $_POST['YEA'];
                    ?>
                    <?php $query = "SELECT * FROM tareas.editar_tareas where MES = '$MES' AND YEA = '$YEA' and Id_usuario = $id_user  ";
                        $respuesta = mysqli_query($db, $query);
                    }
                    ?>
                    <?php while ($row = mysqli_fetch_array($respuesta)) { ?>
                        <tr style="font-size:small">
                            <td><?php echo $count ?></td>
                            <td>
                                <?php echo $row['NOMBRE_TAREA'] ?>
                            </td>
                            <td>
                                <input onchange="Guardar('<?php echo $row['Id_edition'] ?>', '<?php echo $row['ESTATUS'] ?>')" class="form-check-input" type="checkbox" <?php
                                                                        $eleccion = $row['ESTATUS'];

                                                                        if ($eleccion == 1) {
                                                                            echo "checked";
                                                                        }
                                                                        ?>>
                                <label class="form-check-label" for="flexCheckDefault">
                                    Marcar
                                </label>
                            </td>
                        </tr>
                    <?php $count++;
                    } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="card-footer bg-dark text-white">
    <tr>
        <td> <?php if (isset($_POST['MES'])) {
                    echo $MES;
                }  ?> </td>

        <td> <?php if (isset($YEA)) {
                    echo $YEA;
                } ?> </td>
        <td>
            <div id="progress_bar">

            </div>
        </td>
    </tr>
</div>


</div> <!-- Segunda tabla  -->
<div class="col-sm-6">
<div class="card ">
    <div class="card-header  text-white" style="background-color: #FF5733;">Tareas Auxiliar Contable Pendientes</div>
    <div class="card body mt-2">
        <form action="verTareasMes.php" name="ver_tareas" method="POST">
            <table>
               
            </table>
            <table class="table" id="example" style="font-size:1px">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tarea</th>
                        <th scope="col">Estatus</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    if (isset($_POST['MES'])) {
                        $MES = $_POST['MES'];
                        $YEA =  $_POST['YEA'];
                    ?>
                    <?php $query = "SELECT * FROM tareas.editar_tareas where MES = '$MES' AND YEA = '$YEA' AND ESTATUS = 0 and Id_usuario = $id_user   ";
                        $respuesta = mysqli_query($db, $query);
                    }
                    ?>
                    <?php while ($row = mysqli_fetch_array($respuesta)) { ?>
                        <tr style="font-size:small">
                            <td style="color:red;"><?php echo $count_2 ?></td>
                            <td style="color:red;">
                                <?php echo $row['NOMBRE_TAREA'] ?>
                            </td>
<td>
<input onchange="Guardar('<?php echo $row['Id_edition'] ?>', '<?php echo $row['ESTATUS'] ?>')" class="form-check-input" type="checkbox" <?php
$eleccion = $row['ESTATUS'];

if ($eleccion == 1) {
    echo "checked";
}
?>>
<label class="form-check-label" for="flexCheckDefault">
                                    Marcar
                                </label>
                            </td>
                        </tr>
                    <?php $count_2++;
                    } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>

<div class="card-footer bg-dark text-white">
    <tr>
        <td> <?php if (isset($_POST['MES'])) {
                    echo $MES;
                }  ?> </td>

        <td> <?php if (isset($YEA)) {
                    echo $YEA;
                } ?> </td>
        <td>
            <div id="progress_bar">

            </div>
        </td>
    </tr>
</div>


</div>
</div>

</div>
</body>
<script>
$(document).ready(function() {
$('#example').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
});
</script>
<html>
<script>
$(document).ready(function() {
barra();
});

function Guardar(Id, estado) {

$.ajax({
    url: 'actualizar_tareas.php',
    type: 'POST',
    dataType: 'html',
    data: {
        Id: Id,
        estado: estado

    },
    success: function(data) {
        location.reload();
        /* alert("datos"); */
        /* location.reload(); */
    }
})
}

function barra() {
var MES = "<?php echo $MES ?>";
var YEA = "<?php echo $YEA ?>";
$.ajax({
    url: 'barra.php',
    type: 'POST',
    dataType: 'html',
    data: {

        MES: MES,
        YEA: YEA,
    },
    success: function(data) {
        $("#progress_bar").html(data);
        /* alert("datos"); */

    }
})
}
</script>