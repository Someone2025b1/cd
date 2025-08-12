<?php
ob_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex2.php");
include("../../../../../Script/calendario/calendario.php");
include("encabezado.php");

//variables

$centinela=$_GET[centinela];
$cif=$_GET[cif];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<style type="text/css">
.letras_blancas {
	color: #FFF;
}
body {
	background-color: #FFF;
}
#form1 table .letras_blancas td div {
	font-weight: bold;
}
.letras_rojas {
	color: #F00;
	font-weight: bold;
}
</style>
<script language="JavaScript">
function validar_formulario() {
	var detalle_dos = document.getElementById('monto_maximo').value.length;
	if( detalle_dos == 0){ //si tiene caracter no lo hace
	alert ("Campo Obligatorio de llenar. ");	
		document.getElementById("monto_maximo").focus();
		return false;	
	} 
	var detalle_dos = document.getElementById('actividad_economica').value;
	if( detalle_dos == 0){ //si tiene caracter no lo hace
	alert ("Campo Obligatorio de llenar. ");	
		document.getElementById("actividad_economica").focus();
		return false;	
	} 




}//fin de la funcion

</script>
</head>

<body>
<form action="<?php echo $_SERVER['PHP_SELF'].'?centinela=1'?>" method="post" name="Buscar" id="Buscar">
<table width="35%" align="center" cellpadding="0" cellspacing="0" class="Tamano14" id="buscador">
  <tr align="center">
    <td nowrap><p>CIF o NOMBRE</p>
      <p>
        <input name="cif_asociado" type="text" autofocus id="cif_asociado" size="50">
        </p></td>
    </tr>
  <tr align="center">
    <td nowrap>&nbsp;</td>
  </tr>
  <tr align="center">
    <td nowrap><input type="submit" name="Buscar2" id="Buscar2" value="Buscar..."></td>
    </tr>
  <tr align="center">
    <td nowrap><hr /></td>
  </tr>
</table>
</form>
<?php if($centinela == 1 and $cif_asociado !=''){


	
$sql = mysqli_query($db, "SELECT * FROM info_bbdd.usuarios  WHERE id_user ='$cif_asociado' OR nombre  LIKE '%$cif_asociado%'  ") or die (mysqli_error())	;



	
	 ?>
<table width="75%" border="1" align="center" cellpadding="0" cellspacing="0" class="Tamano12">
  <tr bgcolor="#007336" class="LetraBlanca">
    <th colspan="4" bgcolor="#007336" class="letras_blancas">COLABORADORES</th>
  </tr>
  <tr bgcolor="#007336" class="LetraBlanca">
    <th><span class="letras_blancas">#</span></th>
    <th><span class="letras_blancas">CIF</span></th>
    <th><span class="letras_blancas">NOMBRE ASOCIADO</span></th>
    <th><span class="letras_blancas">VER</span></th>
  </tr>
	<?php
	$total_num = 0;
	$total_monto = 0.00;
	while ($row = mysqli_fetch_row($sql)) {
	?>
    <form action="estado_patrimonial_vista.php" method="post" target="_blank">
  <tr>
    <td><?php echo ++$total_num ?></td>
    <td><?php echo $row[0] ?></td>
    <td><?php echo $row[1] ?></td>
    <td ><div align="center">
      <input name="cif" type="hidden" id="cif" value="<?php echo $row[0] ?>" />
      <input type="submit" name="button" id="button" value="Ver Empleado" />
    </div></td>
  </tr>
  </form>
  	<?php
	}
	?>
  <tr align="center" class="Negrita">
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<?php } ?>
</body>
</html>