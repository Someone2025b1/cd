<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$si=$HTTP_GET_VARS["s"]; 

if($si == 1){
$grup=$HTTP_GET_VARS["gp"]; 
} else {
	$grup=$_GET["select"]; 
	}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.letras_balncas {
	color: #FFF;
	font-weight: bold;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<?php 
$sql2 = "SELECT * FROM coosajo_base_bbdd.grupos WHERE  id_grupos = '$grup' "; 
$result_n2 = mysqli_query($db, $sql2);
$row2=mysqli_fetch_array($result_n2)
?>

<form id="form1" name="form1" method="get" action="gp_updategrupo.php">
<table width="50%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#00CCCC"><div align="center" class="letras_balncas">Creación de Grupos</div></td>
    </tr>
  <tr>
    <td>Nombre del Grupo</td>
    <td><label for="nombre_gru"></label>
      <input name="nombre_gru" type="text" id="nombre_gru" value="<?php echo $row2["nombre_grupo"] ?>" /></td>
    </tr>
  <tr>
    <td>Comentario</td>
    <td><label for="comentario"></label>
      <textarea name="comentario" cols="45" rows="2" id="comentario"><?php echo $row2["comentario"] ?></textarea></td>
    </tr>
   
  <tr>
    <td>Nivel</td>
    <td><label for="nivel"></label>
      <select name="nivel" id="nivel">
        <option value="<?php echo $row2["nivel"] ?>" selected><?php echo $row2["nivel"] ?></option>
        <option value="1">Nivel 1</option>
        <option value="2">Nivel 2</option>
        <option value="3">Nivel 3</option>
      </select></td>
    </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">
      <input type="submit" name="button" id="button" value="Editar Grupo">
      &nbsp;&nbsp; 
      <input name="id" type="hidden" id="id" value="<?php echo $row2["id_grupos"] ?>">
    </div></td>
    </tr>
</table>
</form>

<form action="gp_editaringresodetallegrupo.php" method="get">
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
     <?php 
	
	$sql3 = "SELECT * FROM coosajo_base_bbdd.detalle_grupo_rep WHERE id_grupos = '$grup' ";
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
      <td><div align="center"><a href="gp_eliminarbasedelgrupo.php?e=<?php echo $row3["id_detalle_gp"] ?>&gp=<?php echo $row3["id_grupos"] ?>&op=2"><img src="../Imagenes/borrar.png" alt="Eliminar de Base de Datos del Grupo" width="16" height="16" border="0"></a></div></td>
    </tr>
    <?php }

	?>
  </table>
</form>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="javascript:history.back()"><img src="../Imagenes/Regresar.png" alt="Regresar" width="64" height="64" border="0"></a></td>
</tr>
<tr>
  <td align="center"><a href="javascript:history.back()">Regresar</a></td>
</tr>
</table>
</div>
</body>
</html>