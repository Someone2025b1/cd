<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$CodigoTalonario = $_POST['CodigoTalonario'];
$TalonarioHotel = mysqli_fetch_array(mysqli_query($db, "SELECT A.*, B.H_NOMBRE FROM Taquilla.ASIGNACION_TALONARIO_TICKET AS A 
													INNER JOIN Taquilla.HOTEL AS B
													ON A.H_CODIGO = B.H_CODIGO WHERE A.ATT_CODIGO = '$CodigoTalonario' "));
if($TalonarioHotel[ATT_TIPO_TALONARIO] == 1)
	{
		$TipoTalonario = "Tickets para Niño Menor a 5 Años";
	}
if($TalonarioHotel[ATT_TIPO_TALONARIO] == 2)
	{
		$TipoTalonario = "Tickets para Niño";
	}
if($TalonarioHotel[ATT_TIPO_TALONARIO] == 3)
	{
		$TipoTalonario = "Tickets para Adulto";
	}

$TicketsRebajadas = mysqli_fetch_array(mysqli_query($db, "SELECT sum(ATT_REBAJAR_TICKET) as TicketsRebajadas FROM Taquilla.DETALLE_REBAJO_TICKET WHERE ATT_CODIGO = '$TalonarioHotel[ATT_CODIGO]' "));

$TotalTicket = $TalonarioHotel[ATT_AL] - $TalonarioHotel[ATT_DEL] - $TicketsRebajadas[TicketsRebajadas];

if($TotalTicket == 0)
	{
		mysqli_query($db, "UPDATE Taquilla.ASIGNACION_TALONARIO_TICKET SET ATT_ESTADO = 0, ATT_RAZON_BAJA = 'Talonario entregado en su totalidad' where ATT_CODIGO = '$TalonarioHotel[ATT_CODIGO]' ");	
	}
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
    </style>

</head>	
					    		
	<div class="row">
		<?php 
		if($TotalTicket == 0)
			{ 
		?>
			<div class="alert alert-warning" align="center">
				<b>Atención!</b> Las tickets ya han sido entregadas...
			</div>
		<?php 
			}
		 ?>
		<div class="col-lg-1"></div>
		<div class="col-lg-5">
			<div class="form-group">
				<input type="hidden" name="CodigoTalonario" id="CodigoTalonario" value="<?php echo $TalonarioHotel[ATT_CODIGO]?>">
				<input type="text" class="form-control" value="<?php echo $TalonarioHotel[H_NOMBRE] ?>" readonly>
				<label for="Hotel">Hotel <?php echo $TicketsRebajadas[TicketsRebajadas] ?></label>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" value="<?php echo $TalonarioHotel[ATT_DEL]?>" readonly>
				<label for="Hotel">Del</label>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" value="<?php echo $TalonarioHotel[ATT_AL]?>" readonly>
				<label for="Hotel">Al</label>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="form-group">
				<input type="text" class="form-control" value="<?php echo $TipoTalonario?>" readonly>
				<label for="Hotel">Tipo Talonario</label>
			</div>
			<div class="form-group">
				<input type="text" id="TotalTickets" class="form-control" value="<?php echo $TotalTicket?>" readonly>
				<label for="Hotel">Total Tickets</label>
			</div>
			<div class="form-group">
				<input type="text" id="RebajarTicket" min="0" class="form-control" php onkeyup="ValidarTransaccion()">
				<label for="Hotel">Rebajar</label>
			</div>
		</div>
	</div>


<script>

</script>
</html>
