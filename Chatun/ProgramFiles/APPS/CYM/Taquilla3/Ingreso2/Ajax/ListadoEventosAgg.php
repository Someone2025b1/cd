<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$eventoRealizar = mysqli_query($db, "SELECT e.E_DESCRIPCION, a.* FROM Taquilla.INGRESO_EVENTO a 
INNER JOIN Taquilla.EVENTO e ON a.E_ID = e.E_ID
WHERE a.IE_ESTADO = 1");
$eventoRow = mysqli_fetch_row($eventoRealizar);
if ($eventoRow>1) 
{
while($eventoRealizar_result = mysqli_fetch_array($eventoRealizar))                                      
{

    ?>
        <div class="row">
            <div class="col-lg-12">
            <div class="card">
                    <div class="card-head style-primary">
                        <h4 class="text-center"><strong>Evento: <?php echo $eventoRealizar_result["E_DESCRIPCION"] ?></strong></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                <label for="cantPersonas">Dueño del evento</label>
                                <input type="text" readonly class="form-control" value="<?php echo $eventoRealizar_result[IE_DUENO_EVENTO] ?>">
                                </div>
                                <div class="form-group">
                                <label for="cantPersonas">Personas en el evento</label>
                                <input type="number" readonly class="form-control" value="<?php echo $eventoRealizar_result[IE_CANTIDAD_PERSONAS] ?>" id="personasEvento" name="personasEvento">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="cantPersonas">Agregar personas</label>
                                            <input placeholder="Presione TAB para guardar" type="number" class="form-control" id="agregarPersonas" name="agregarPersonas" onblur="agregarPersonasEvento(this.value, '<?php echo $eventoRealizar_result[IE_ID] ?>')">
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="form-group">
                                <label for="cantPersonas">Cerrar Evento</label> 
                                <button type="button" onclick="cerrarEvento('<?php echo $eventoRealizar_result[IE_ID] ?>')" class="btn btn-danger btn-circle btn-lg"><i class="fa fa-times"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            </div>
        </div>
    <?php 
    }
}
else
{
?>
<div class="alert alert-danger">No hay eventos en curso. </div>
<?php 
}?>
<script>
    function agregarPersonasEvento(agregarPersonas, idEvento)
    {  
        var total = parseInt(agregarPersonas);
        $.ajax({
            url: 'Ajax/AgregarPersonas.php',
            type: 'POST',
            dataType: 'html',
            data: {total: total, idEvento:idEvento},
            success: function(data)
            {
                if (data==1) 
                {
                    alertify.success("Se ha almacenado");
                    verListaEventos();
                }
            }
        })
               
    }

    function cerrarEvento(idEvento)
    {
       $.ajax({
            url: 'Ajax/CerrarEvento.php',
            type: 'POST',
            dataType: 'html',
            data: {idEvento:idEvento},
            success: function(data)
            {
                if (data==1) 
                { 
                    verListaEventos();
                }
            }
        })
               
    }
</script>