<?php 
include("../../../../Script/conex.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
<!--
.Tabla_consulta {
	color: #FFF;
	text-align: center;
}
#Agencias2 {
	text-align: center;
}
-->
</style>
</head>

<body><form action="id_agencias.php" method="post" name="agencias">
<table align="center" width="95%">
  <tr>
    <td bgcolor="#000099" class="Tabla_consulta">Busqueda Personalizda</td>
    <td>&nbsp;</td>
    <td colspan="2" bgcolor="#000099" class="Tabla_consulta">Ingresar un Nuevo Enlace</td>
  </tr>
  <tr>
 <?php $agencia=$_POST["Agencias"]; ?>
    <td><div align="center"><span id="Agencias2">
      <select name="Agencias" id="Agencias2">
        <option value="0" selected="selected">- - Todas las Agencias - -</option>
        <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
		
		
      $sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias WHERE compania='telered' ORDER BY agencia";
		 
	  $result_n = mysqli_query($db, $sql);
	  ?>
        <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
        
        <option value="<?php echo $row["id"] ?>"><?php echo $row["agencia"] ?> </option>
        <?php }
	   ?>
      </select>  
      
    </span></div>
      <span id="Agencias2">
      <label for="Agencias"></label>
    </span>      <div align="center"></div></td>
    <td>&nbsp;</td>
    <td><?php
 	 	echo $agencia; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">
      <input type="submit" name="Filtrar" id="Filtrar" value="Enviar">
    </div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php // seleciona de la bases de datos por los usuarios en forma de seleccion 

	if ( $agencia > 1){
		$sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias WHERE id= $agencia";}
	else {
      $sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias ORDER BY agencia";
		}
	  $result_n = mysqli_query($db, $sql);
	  ?>

<table width="100%" border="0" align="center">
  <tr bgcolor="#000099" class="Tabla_consulta">
    <td width="14%">No. ID</td>
    <td width="16%">Agencia</td>
    <td width="16%">Compañia</td>
    <td width="31%">Dirección</td>
    <td width="13%">Dirección Ip</td>
    <td width="10%">Velocidad</td>
  </tr>
  <?php 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
	?>
  <tr style="font-size: 12px">
    <td><?php echo $row["identificacion"]?></td>
    <td><?php echo $row["agencia"]?></td>
    <td><?php echo $row["compania"]?></td>
    <td><?php echo $row["direccion"]?></td>
    <td><?php echo $row["direccion_ip"]?></td>
    <td><?php echo $row["velocidad"]?></td>
  </tr>
  <?php } ?>
</table>
</form>
</body>
</html>