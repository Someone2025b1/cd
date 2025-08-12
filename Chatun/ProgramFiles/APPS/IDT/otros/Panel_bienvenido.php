<?php 
include("../../../../Script/conex.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
<!--
.estilo {
	color: #FFF;
	text-align: center;
}
.clase {
	font-size: 12;
}
-->
</style>
</head>

<body>
<table align="center" border="0" width="70%">
  <tr class="estilo">
    <td colspan="3" bgcolor="#0000CC">Ingreso de Datos</td>
  </tr>
  <tr>
    <td>Agencia</td>
    <td><label for="Agencias2"></label>
      <select name="Agencias" id="Agencias2">
        <option value="0" selected="selected">- - Todas las Agencias - -</option>
            <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias ORDER BY agencia";
	  $result_n = mysqli_query($db, $sql);
	  ?>
            <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
            
            <option value="<?php echo $row["id"] ?>"><?php echo $row["agencia"] ?> - <?php echo $row["compania"] ?></option>
            <?php }
	   ?>
          </select>     <label for="Agencias"></label></td>
    <td><form name="form1" method="post" action="">
      <label for="hh"></label>
    </form></td>
  </tr>
  <tr>
    <td>Colaborador</td>
    <td><label for="colaborador"></label>
      <select name="colaborador" id="colaborador">
        <option value="0" selected="selected">- - Seleciones un Colaborador - -</option>
            <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_caidas_enlaces.colaboradores";
	  $result_n = mysqli_query($db, $sql);
	  ?>
            <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
            
            <option value="<?php echo $row["cif"] ?>"><?php echo $row["nombre_colaborador"] ?> - <?php echo $row["nun_telefono"] ?></option>
            <?php }
	   ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nombre Operador</td>
    <td><label for="nom_operador"></label>
    <input type="text" name="nom_operador" id="nom_operador"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Problema Presentado</td>
    <td><label for="problemas_enlaces"></label>
      <select name="problemas_enlaces" id="problemas_enlaces">
        <option>- - Selecione una Opción - -</option>
        <option>Caida de Enlace</option>
        <option>Lentitud de Enlace</option>
        <option>Señal Región</option>
        <option>Inestabilidad</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>No. Ticket</td>
    <td><label for="num_ticket"></label>
    <input type="text" name="num_ticket" id="num_ticket"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Fecha de Inicio</td>
    <td><?php $fecha_actual = date("d-m-Y ");
			  $fecha_actual2 = date("Y-m-d H:i:s");
				echo $fecha_actual;?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><label for="Enviar"></label>
    <input type="submit" name="Enviar" id="Enviar" value="Enviar">
    <label for="Restablecer"></label>
    <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer"></td>
  </tr>
</table>
<table  align="center"width="70%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias";
	  $result_n = mysqli_query($db, $sql);
	  ?>

<table align="center" border="1" width="95%">
  <tr>
    <td colspan="6" bgcolor="#0000CC" class="estilo">Pendientes de Cierre</td>
  </tr>
  <tr>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table align="center" width="35%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="../../../IDT/imagenes/flecha-izquierda.png" width="75" height="75" alt="Regresar"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><img src="../../../IDT/imagenes/micoope.jpg" width="75" height="75" alt="micoope"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>