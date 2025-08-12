<?php 
include ("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");?>
<?php include("app/header2.php") ?> 


<?php $query = "SELECT * FROM tareas.meses_year";
$respuesta = mysqli_query($db, $query);
?>




<div>
    <div class="container w-50">
        <div class="card">
            <div class="card-header bg-success text-white">Habilitar Mes</div>
            <div class="card body">
                <form action="habilitar_tareas_mes.php" method="POST">
                    <table class="table">

                        <tbody>
                            <tr>
                                <td>
                                    <label for="">Mes
                                        <select name="mes1" id="" class="form-control">
                                            <option selected disabled="true" value="">Mes</option>
                                            <?php while ($row = mysqli_fetch_array($respuesta)) { ?> <option value="<?php echo $row['MES'] ?>"><?php echo $row['MES'] ?></option> <?php } ?>
                                        </select>
                                    </label>
                                </td>

                                <?php $query = "SELECT * FROM tareas.year1";
                                $respuesta_year = mysqli_query($db, $query);
                                ?>

                                <td><label for=""> Year
                                        <select name="year1" id="" class="form-control">
                                            <option selected disabled="true" value="">year</option>
                                            <?php while ($row = mysqli_fetch_array($respuesta_year)) { ?> <option value="<?php echo $row['AN'] ?>"><?php echo $row['AN'] ?></option> <?php } ?>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <button class="btn btn-success mt-4" type="submit">
                                        Habilitar
                                    </button>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                </form>

            </div>


        </div>


    </div>



</div>
<!-- <script>
   function respuesta() {
       var theObjet =  new XMLHttpRequest();
       theObjet.open('GET', 'respuesta.php', true);
       theObjet.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
       theObjet.onreadystatechange = function (){
           document.getElementById('Prueba').innerHTML = theObjet.responseText;

       }
       theObjet.send();
   }
</script> -->

<?php include('app/footer2.php') ?>