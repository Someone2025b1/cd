<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$grup=$HTTP_GET_VARS["gp"]; 
$si=$HTTP_GET_VARS["s"]; 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
</head>

<body class="Pagina">
<div id="menuprincipal">
<form action="gp_editargrupo.php" method="get">
<table width="50%" border="0" align="center" >
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="center">Gupos Exitentes</div></td>
    <td><label for="select"></label>
      <select name="select" id="select">
        <option>--SELECIONE UN GRUPO--</option>
        <?php  $sql = "SELECT * FROM coosajo_base_bbdd.grupos ";
	  $result_n = mysqli_query($db, $sql);
	  
	  ?>
        <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
        <option value="<?php echo $row["id_grupos"] ?>"><?php echo $row["nombre_grupo"] ?> </option>
        <?php }
	   ?>
      </select></td>
    <td><div align="center"><a href="gp_creargrupo.php"><img src="../Imagenes/label_new_green.png" alt="Nuevo Grupo" width="50" height="50" border="0" /></a></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><div align="center">
      <input type="submit" name="button" id="button" value="Editar Grupo" />
    </div></td>
    <td><div align="center"><a href="gp_creargrupo.php">Nuevo Grupo</a></div></td>
    <td>&nbsp;</td>
  </tr>
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