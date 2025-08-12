<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php"); 
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$Estanque = $_POST["Estanque"];
$Fecha = $_POST["Fecha"];
$UniTerminadas = $_POST["UniTerminadas"];
$UniDa = $_POST["UniDa"];
$Uni = $UniTerminadas+$UniDa;
$Info = mysqli_fetch_array(mysqli_query($db, "SELECT SUM(a.UnidadesTerminadas) AS UNIDADES  FROM Bodega.CONTROL_PISICULTURA a WHERE a.Fecha = '$Fecha' and a.Estado = 2"));
if ($Info['UNIDADES']!=$Uni) {
 $Total = $Uni - $Info['UNIDADES'];
 $Total2 = abs($Total);
 $Val = 1; 
?> 
<div class="alert alert-danger" role="alert">
  Usted ingreso una cantidad distinta a la de producción, diferencia (<?php echo $Total?> Unidades). 
  <br>Por favor ingresar una explicación en el espacio correspondiente:
  <div class="row">
	    <table class="table table-hover table-condensed" id="tabla2"> 
		<tbody>
		     <tr class="fila-base2"> 
		        <td>
		            <div class="form-group">
		                <label for="Capacidad">Unidades</label>
		                <input value="0" class="form-control" type="number" min="1" name="Unidades[]" id="Unidades" onchange="Calcular()" required/> 
		             </div>
		        </td>  
		        <td> 
		            <div class="form-group">
		                <label for="Capacidad">Explicación</label>
		                <input placeholder="Describa..." class="form-control" type="text"  name="Causa[]" id="Causa" required/>
		            </div> 
		        </td>
		        <td class="eliminar2">
		            <button type="button" class="btn btn-danger btn-xs">
		                <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
		            </button>
		        </td>
		    </tr> 
		</tbody>
		<tfoot>
		    <tr> 
		        <td style="text-align: left; vertical-align: text-top; font-size: 20px"><input class="form-control" type="text" id="Totalidad" name="Totalidad" value="0.00" readonly></td> 
		    </tr>
		</tfoot>
		</table>
		<div class="col-lg-12" align="left">
		<button type="button" class="btn btn-success btn-xs" id="agregar2">
		    <span class="glyphicon glyphicon-plus"></span> Agregar
		</button>
		</div> 
	</div>
</div> 
<input type="hidden" value="1" id="Control" name="Control">
<?php 
}
else
{
	$Val = 0;
}
?>
<script>
$(document).ready(function() {
	var Val = '<?php echo $Val?>';
	if (Val==0) 
	{
		 $("#BtmGuardar").removeAttr('disabled');
	}
});
$(function(){
	$("#agregar2").on('click', function(){
                $("#tabla2 tbody tr:eq(0)").clone().removeClass('fila-base2').appendTo("#tabla2 tbody");
            });

            // Evento que selecciona la fila y la elimina
            $(document).on("click",".eliminar2",function(){
                var parent = $(this).parents().get(0);
                $(parent).remove();
            });
 });

 function Calcular()
        {
            var Unidades = document.getElementsByName('Unidades[]');
            var TotalDif = '<?php echo $Total2?>';
            var Total = 0;  
            for(i = 0; i < Unidades.length; i++)
            { 
                Total = Total + parseFloat(Unidades[i].value); 
            }
            $('#Totalidad').val(Total.toFixed(2));  
     
            if (Total == TotalDif) 
            { 
            $("#BtmGuardar").removeAttr('disabled');
            }
            else
            {
            	$("#BtmGuardar").attr('disabled','disabled');
            }
        }
</script>