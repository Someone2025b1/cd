<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$grup=$HTTP_GET_VARS["gp"]; 
$si=$HTTP_GET_VARS["s"]; 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
body {
	background-image: url(../../../IDT/imagenes/background_052.gif);
}
.letras_blancas {
	color: #FFF;
	font-weight: bold;
}
</style>
</head>

<body>
<?php 

$sql2 = "SELECT * FROM grupos WHERE nombre_grupo LIKE  '$grup' or id_grupos = '$grup' "; 
$result_n2 = mysqli_query($db, $sql2);
$row2=mysqli_fetch_array($result_n2)
?>
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#00CCCC"><div align="center" class="letras_blancas">Asignación de Base Datos en el Grupo</div></td>
    </tr>
  <tr>
    <td>Nombre del Grupo</td>
    <td><label for="nombre_gru"></label>
      <input name="nombre_gru" type="text" id="nombre_gru" value="<?php echo $row2["nombre_grupo"] ?>" readonly /></td>
    </tr>
  <tr>
    <td>Comentario</td>
    <td><label for="comentario"></label>
    <textarea name="comentario" cols="45" rows="2" readonly id="comentario"><?php echo $row2["comentario"] ?></textarea></td>
    </tr>
  <tr>
    <td>Nivel</td>
    <td><label for="nivel"></label>
    <input name="nivel" type="text" id="nivel" value="<?php echo $row2["nivel"] ?>" readonly></td>
    </tr>
 
</table>
<form action="gp_ingresodetallegrupo.php" method="get">
  <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><label for="bases"></label>
        <select name="bases" id="bases">
          <option>--SELECIONE UNA BASE DATOS --</option>
          <?php  $sql = "SELECT * FROM coosajo_base_bbdd.bbdd WHERE estado = 1 ";
	  $result_n = mysqli_query($db, $sql);
	  
	  ?>
        <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
        <option value="<?php echo $row["id_base"] ?>"><?php echo $row["nombre"] ?> </option>
        <?php }
	   ?>
      </select>
      <input name="idgru" type="hidden" id="idgru" value="<?php echo $row2["id_grupos"] ?>"></td>
      <td><input type="submit" name="button" id="button" value="Asignar"></td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
     <?php if ($si==1){
	
	$sql3 = "SELECT * FROM detalle_grupo_rep WHERE id_grupos = '$grup' ";
	$result_n3 = mysqli_query($db, $sql3);
	?>
    <tr class="letras_blancas">
      <td bgcolor="#00CCCC">&nbsp;</td>
      <td bgcolor="#00CCCC"><div align="center">ID base</div></td>
      <td bgcolor="#00CCCC"><div align="center">Nombre</div></td>
      <td bgcolor="#00CCCC"><div align="center">Eliminar</div></td>
    </tr>
   
     <?php //se hace el ciclo para generar las opciones 
			while ($row3=mysqli_fetch_array($result_n3)) {//llenado de formulario
			//ciclo del las opciones
		?>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo $row3["id_base"] ?></td>
      <td><?php echo $row3["nombre"] ?> </td>
      <td><div align="center"><a href="gp_eliminarbasedelgrupo.php?e=<?php echo $row3["id_detalle_gp"] ?>&gp=<?php echo $row3["id_grupos"] ?>"><img src="../../../IDT/imagenes/delete.png" alt="Eliminar de Base de Datos del Grupo" width="16" height="16" border="0"></a></div></td>
    </tr>
    <?php }
	}//fin del if
	?>
  </table>
</form>

</body>
</html>