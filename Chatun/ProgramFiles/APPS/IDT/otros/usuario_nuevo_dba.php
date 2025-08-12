<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

?>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Creacion de Usuario</title>
<style type="text/css">
.LETRAS_BLANCA {
	color: #FFF;
}
</style>
</head>

<body>
<form action="actualizar_ingresar_usuario_dba.php" method="get">
<table width="35%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" bgcolor="#000099"><div align="center"><span class="LETRAS_BLANCA">Creaci&oacute;n de los Usuarios en BD</span></div></td>
    </tr>
  <tr>
    <td bgcolor="#009900">&nbsp;</td>
    <td bgcolor="#009900">&nbsp;</td>
  </tr>
  <tr>
    <td>Cif</td>
    <td><label for="cif"></label>
      <input type="text" name="cif" id="cif"></td>
  </tr>
  <tr>
    <td>Nombre Completo</td>
    <td><label for="nombre"></label>
      <input name="nombre" type="text" id="nombre" size="0"></td>
  </tr>
  <tr>
    <td>Departamento</td>
    <td><select name="Departamento" id="depertamento">
        <option value="0" selected="selected">- - Selecione Un Departamento - - </option>
            <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_base_bbdd.departamentos ";
	  $result_n = mysqli_query($db, $sql);
	  ?>
            <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
            
            <option value="<?php echo $row["id_depto"] ?>"><?php echo $row["nombre_deto"] ?></option>
            <?php }
	   ?>
  </select></td>
  </tr>
  <tr>
    <td>Agencia</td>
    <td><select name="Agencias" id="Agencias2">
        <option value="0" selected="selected">- - Seleciones Una Agencia - -</option>
            <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_base_bbdd.agencias ";
	  $result_n = mysqli_query($db, $sql);
	  ?>
            <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
            
            <option value="<?php echo $row["id_agencia"] ?>"><?php echo $row["agencia"] ?></option>
            <?php }
	   ?>
          </select></td>
  </tr>
  <tr>
    <td>Grupo</td>
    <td><select name="grupo" id="Agencias2">
        <option value="0" selected="selected">- - Seleciones Un Grupo - -</option>
            <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_base_bbdd.grupos ";
	  $result_n = mysqli_query($db, $sql);
	  ?>
            <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
            
            <option value="<?php echo $row["id_grupos"] ?>"><?php echo $row["nombre_grupo"] ?></option>
            <?php }
	   ?>
      </select></td>
  </tr>
  <tr>
    <td>Login</td>
    <td><label for="login"></label>
      <input type="text" name="login" id="login"></td>
  </tr>
  <tr>
    <td>Contrase&ntilde;a</td>
    <td><label for="password"></label>
      <input type="password" name="password" id="password"></td>
  </tr>
  <tr>
    <td>Cod Ejecutivo</td>
    <td><label for="ejecu"></label>
      <input type="text" name="ejecu" id="ejecu"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="right">
      <input type="submit" name="crear" id="crear" value="CREAR USUARIO">
    </div></td>
    <td><input type="reset" name="RESTAR" id="RESTAR" value="RESTABLECER"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><span class="mainForm">
      <input name="modi" type="hidden" id="modi" value="creacion usuarios">
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>
</body>
</html>