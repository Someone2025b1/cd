<?php include_once("app/header2.php"); ?>
<?php include('conexion.php') ?>

<div class="container aling-center " style="margin-left:3.5cm;">
    <div class="card  shadow h-100  w-75">
        <div class="card-header text-white text-center" style="background-color:#33D033;">
            <h7>REGISTRAR TAREA </h7>
        </div>
        <div class="card-body">
            <form id="tareas" name="tareas" method="">
                <!--   inicia formulario de registro cuentas bancarias proveedor-->
                <div class="card ">

                    <div class="card-body class row g-12">
                        <table class="table" id="tabla" name="tabla">
                            <thead class="">
                                <tr>
                                    <th scope="col">Tarea</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="tabla" name="tabla">
                                <tr class="fila-base">
                                    <td>
                                        <div class="col-md-12">
                                            <input type="text" class="form-control" id="Tarea" name="tarea[]" value=""
                                                required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-md-10">

                                            <select type="text" class="form-control" id="Tipo_tarea" name="Tipo_tarea[]"
                                                value="" required>
                                                <option selected disabled="true" value="">Tipo De Tarea</option>
                                                <option value="Conciliaciones">Conciliaciones</option>
                                                <option value="Integraciones">Integraciones</option>
                                                <option value="Facturas">Facturas</option>
                                                <option value="Cajas">Cajas</option>
                                                <option value="Ajustes">Ajustes</option>
                                                <option value="Ajustes">Libros Contables</option>
                                                <option value="Ajustes">Polizas</option>
                                            </select>

                                        </div>
                                    </td>
                                    <?php $query = "SELECT * FROM usuarios";
                                $respuesta_year = mysqli_query($conn, $query);
                                ?>
                                     
                                    <td class="eliminar">
                                        <button type="button" class="btn btn-danger btn-sm mt">Eliminar </button>
                                    </td>
                                </tr>

                            </tbody>

                        </table> <!--  finaliza formulario de registro nombre proveedor-->

                        <div class="col-lg-12" align="left">
                            <button type="button" class="btn  btn-sm text-white" id="agregar" name="agregar"
                                style="background-color:#33D033; "> Agregar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12  mt-2" style="margin-left: 10cm;">
                    <button class="btn btn-primary " onclick="Guardar()" type="button" type="submit">Registrar</button>
                </div>
            </form>
        </div>

    </div>


</div>
<!-- <style type= "text/css">
.fila-base {
  display : none;
}

</style> -->

<script>
$(function() {

    // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
    $("#agregar").on('click', function() {
        $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
    });



    // Evento que selecciona la fila y la elimina
    $(document).on("click", ".eliminar", function() {
        var parent = $(this).parents().get(0);
        $(parent).remove();
    });
});

function Guardar() {
    var validate = $('#Tarea').val();
    var Tipo = $('#Tipo_tarea').val();

    if (validate === '') {
        alert('Ingrese una tarea');
        return false
    } else if (Tipo == null) {
        alert('Ingrese un tipo de tarea');
        return false;
    } else {

        var FormTareas = $("#tareas").serialize();
        $.ajax({
            url: 'guardarTareas.php',
            type: 'POST',
            dataType: 'html',
            data: FormTareas,

            success: function(data) {

                /*  alert("datos"); */
                if (data == 1) {
                    alert("TAREA REGISTRADA CON EXITO");
                    location.reload();

                } else {
                    alert("No guardado");
                }

            }

        })
    }

}
</script>


<?php include_once("app/footer2.php"); ?>