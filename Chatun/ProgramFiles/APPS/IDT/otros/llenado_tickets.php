<?php 
include("../../../../Script/conex.php");
?>

 <?php 
 $agencia=$_GET["Agencias"]; //recibe la variable
 
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.estilo {	color: #FFF;
	text-align: center;
}
#Enviar {
	text-align: center;
}
body {
	background-image: url(../../../IDT/imagenes/background_052.gif);
}
#modircacoo {
	font-size: 24px;
	color: #003;
}
#modircacoo td {
	color: #00F;
	font-family: Arial, Helvetica, sans-serif;
}
#modircacoo td {
	font-family: Arial, Helvetica, sans-serif;
}
#modircacoo td {
	font-weight: bold;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
body p {
	font-size: 18px;
}
body p {
	font-size: 16px;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<?php
 	 	//echo $agencia; 
		$sql3 = "SELECT * FROM coosajo_caidas_enlaces.id_agencias WHERE id =$agencia";
		$result_n3 = mysqli_query($db, $sql3);
		$row3=mysqli_fetch_array($result_n3); 
		$nom_agencia=$row3["agencia"];
		$id_agencia=$row3["identificacion"];
		
		
		
		?>
<form action="ingreso_ticket.php" method="post">
  <table align="center" width="60%" border="0">
    <tr>
      <td colspan="4" bgcolor="#000099" class="estilo">Ingreso de Datos</td>
    </tr>
    <tr>
      <td colspan="2">Agencia</td>
      <td colspan="2"><input name="agencia" type="text" id="agencia" value="<?php echo $nom_agencia; ?>"></td>
    </tr>
    <tr>
      <td colspan="2">Proveedor</td>
      <td colspan="2"><select name="enlace" id="enlace">
        <option>- - Elija un Proveedor - -</option><?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias WHERE id =$agencia";
	  $result_n = mysqli_query($db, $sql);
	  
	  ?>
        <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
        <option value="<?php echo $row["identificacion"] ?>"><?php echo $row["identificacion"] ?> - <?php echo $row["compania"] ?></option>
        <?php }
	   ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">Colaborador</td>
      <td colspan="2"><select name="colaborador" id="colaborador">
        <option value="0" selected="selected">- - Seleciones un Colaborador - -</option>
        <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_caidas_enlaces.colaboradores WHERE agencia=$agencia";
	  $result_n = mysqli_query($db, $sql);
	  ?>
        <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
        <option value="<?php echo $row["id"] ?>"><?php echo $row["nombre_colaborador"] ?> - <?php echo $row["nun_telefono"] ?></option>
        <?php }
	   ?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2"><p>Nombre Operador</p></td>
      <td colspan="2"><input name="nom_operador" type="text" id="nom_operador" maxlength="250"></td>
    </tr>
    <tr>
      <td colspan="2">Problema Presentado</td>
      <td colspan="2"><select name="problemas_enlaces" id="problemas_enlaces">
        <option>- - Selecione una Opción - -</option>
        <option>Caida de Enlace</option>
        <option>Lentitud de Enlace</option>
        <option>Señal Región</option>
        <option>Inestabilidad</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2">No. Ticket</td>
      <td colspan="2"><input type="text" name="num_ticket" id="num_ticket"></td>
    </tr>
    <tr>
      <td colspan="2">Fecha de Inicio</td>
      <td colspan="2"><?php $fecha_actual = date("d-m-Y ");
			  $fecha_actual2 = date("Y-m-d H:i:s");
				echo $fecha_actual;?></td>
    </tr>
    <tr>
      <td colspan="2"><hr></td>
      <td colspan="2"><hr></td>
    </tr>
    <tr>
      <td><div align="center"><img src="../Imagenes/telefono (1).png" alt="Regresar" width="75" height="75" border="0"></div></td>
      <td><div align="center"><img src="../Imagenes/logo-tigo.png" alt="Regresar" width="75" height="75" border="0"></div></td>
      <td><div align="center"><img src="../Imagenes/telefono (1).png" alt="Regresar" width="75" height="75" border="0"></div></td>
      <td><div align="center"><img src="../Imagenes/logo claro.png" alt="Regresar" width="75" height="75" border="0"></div></td>
    </tr>
    <tr id="modircacoo">
      <td><div align="center">Telefono de Navega</div></td>
      <td><div align="center">2428-8888</div></td>
      <td><div align="center">Telefono de Telered</div></td>
      <td><div align="center">2420-1414</div></td>
    </tr>
    <tr>
      <td colspan="4" class="estilo"><hr></td>
    </tr>
    <tr>
      <td colspan="4" class="estilo"><input type="submit" name="Enviar" id="Enviar" value="Enviar"> &nbsp;
      <input type="reset" name="Restablecer" id="Restablecer" value="Restablecer"></td>
    </tr>
    <tr>
      <td ></td>
      <td ></td>
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