<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$CodigoHotel = $_POST['CodigoHotel'];

$TipoTalonario = mysqli_query($db, "SELECT ATT_CODIGO, H_CODIGO, ATT_TIPO_TALONARIO from Taquilla.ASIGNACION_TALONARIO_TICKET WHERE H_CODIGO = $CodigoHotel");

echo "<option selected disabled>Tipo de Talonario</option>";
while($TipoTalonarioResult = mysqli_fetch_array($TipoTalonario))
		{
			if($TipoTalonarioResult[ATT_TIPO_TALONARIO] == 1)
				{
					$Tipo = "Tickets para Niño Menor a 5 Años";
				}
			if($TipoTalonarioResult[ATT_TIPO_TALONARIO] == 2)
				{
					$Tipo = "Tickets para Niño";
				}
			if($TipoTalonarioResult[ATT_TIPO_TALONARIO] == 3)
				{
					$Tipo = "Tickets para Adulto";
				}
?>	
	<option value="<?php echo $TipoTalonarioResult[ATT_CODIGO]?>"><?php echo $Tipo?></option>

<?php 
		}
 ?>