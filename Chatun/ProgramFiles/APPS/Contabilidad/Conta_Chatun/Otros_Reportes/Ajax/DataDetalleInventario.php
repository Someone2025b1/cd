<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$FechaInicio = $_POST["fechaInicial"];
$FechaFin = $_POST["fechaFinal"]; 
$Total = 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">

	<style type="text/css">
        .well{
        	 background: rgb(134, 192, 72);
        }

        table th {
	  color: #fff;
	  background-color: #f00;
	}
    </style>

</head>


<div align="left">
		<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel">Exportar Excel</button>
	</div> <br>
	<br>
	<div style="overflow-x:auto;">
		<table class="table table-hover" id="TblTicketsHotel">
		    <thead>
        
		    </thead>
		    <tbody> 
            <tr>
            <td align="center" colspan="6" ><b>REPORTE FINANCIERO</b></td>
          </tr>
          <tr>
            <td><b>Cuenta</b></td>
            <td><b>Nombre</b></td>
            <td><b>Total</b></td>
            <td><b>Debe</b></td>
            <td><b>Haber</b></td>
            <td><b>Saldo</b></td>
            <td><b>Auxiliar</b></td>
          </tr>

<?php
$tipoac="";

$query = "SELECT ACTIVO_FIJO.*, AREA_GASTO.AG_NOMBRE, TIPO_ACTIVO.TA_NOMBRE
FROM Contabilidad.ACTIVO_FIJO, Contabilidad.AREA_GASTO, Contabilidad.TIPO_ACTIVO 
WHERE ACTIVO_FIJO.AF_AREA = AREA_GASTO.AG_CODIGO
AND ACTIVO_FIJO.TA_CODIGO = TIPO_ACTIVO.TA_CODIGO
ORDER BY ACTIVO_FIJO.TA_CODIGO
";
$result = mysqli_query($db,$query);
while($row = mysqli_fetch_array($result))
{
  if($row["TA_NOMBRE"]==$tipoac){

  
    
    ?>
    <tr>
        <td></td>
        <td><h6><?php echo $row["AF_NOMBRE"]; ?></h6></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><h6><?php echo number_format($row["AF_VALOR"], 2, '.', ',') ?></h6></td>
    </tr>
    <?php
$Total+=$row["AF_VALOR"];
$TotalGeneral+=$row["AF_VALOR"];
  }else{
    $tipoac=$row["TA_NOMBRE"];
    if($Total>0){

    
    ?>
    <tr>
        <td></td>
        <td><h6>TOTAL TIPO ACTIVO</h6></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><h6><?php echo number_format($Total, 2, '.', ',') ?></h6></td>
    </tr>
    <?php
    }
    ?>
    <tr>
        <td colspan="7"><?php echo $tipoac; ?></td>
    </tr>
    <tr>
        <td></td>
        <td><h6><?php echo $row["AF_NOMBRE"]; ?></h6></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><h6><?php echo number_format($row["AF_VALOR"], 2, '.', ',') ?></h6></td>
    </tr>
    <?php
    $Total=0;
$Total+=$row["AF_VALOR"];
$TotalGeneral+=$row["AF_VALOR"];
  }
}
?>
<tr>
        <td></td>
        <td><h6>TOTAL TIPO ACTIVO</h6></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><h6><?php echo number_format($Total, 2, '.', ',') ?></h6></td>
    </tr>

<tr>
        <td></td>
        <td><h6>TOTAL</h6></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><h6><?php echo number_format($TotalGeneral, 2, '.', ',') ?></h6></td>
    </tr>
         </tbody>
		  </table>
	</div>
	<script>
		 $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

	 
	</script>		    		
</html>
