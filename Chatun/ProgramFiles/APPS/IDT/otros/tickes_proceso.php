<?php 
include("../../../../Script/conex.php");
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
#Agencias {
	text-align: right;
}
.d {
	text-align: right;
}
.Tablas_Formato {
	text-align: center;
	color: #FFF;
}
.negro {
	color: #000;
}
.letra {
	font-size: 9px;
	color: #000;
}
.leras {
	font-size: 11px;
	color: #000;
}
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background-image: url(../../../IDT/imagenes/background_052.gif);
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<form action="llenado_tickets.php" method="get">
<table align="center" width="95%">
  <tr>
    <td width="30%">&nbsp;</td>
    <td width="43%" bgcolor="#0000CC" class="Tablas_Formato">Solicitud de Nuevo Tickets</td>
    <td width="27%">&nbsp;</td>
  </tr>
  <tr>
    <td class="guar"><img src="../Imagenes/label_new_green.png" width="50" height="50" alt="nuevo"></td>
    <?php $agencia=$_POST["Agencias"]; ?>
    <td>
      <select name="Agencias" id="Agencias2">
        <option value="0" selected="selected">- - Todas las Agencias - -</option>
            <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM coosajo_caidas_enlaces.id_agencias WHERE compania ='telered' ORDER BY agencia";
	  $result_n = mysqli_query($db, $sql);
	  ?>
            <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
            
            <option value="<?php echo $row["id"] ?>"><?php echo $row["agencia"] ?></option>
            <?php }
	   ?>
          </select>  
      
        <label for="Agencias"></label>
   </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
      <input type="submit" name="Ingresar" id="Ingresar" value="Ingresar Nuevo">
    </td>
    <td>&nbsp;</td>
    </tr>
</table>
</form>

<form action="../../../IDT/otros/actualizar.php" method="get">
<table align="center" border="0" width="98%">
<?php
$sql = "SELECT * FROM coosajo_caidas_enlaces.caidas WHERE estado='a'";
		$result_n = mysqli_query($db, $sql);
?>
  <tr>
    <td colspan="8" bgcolor="#0000CC" class="Tablas_Formato">Tickets en Proceso</td>
  </tr>
  <tr bgcolor="#009933">
    <td width="15%" class="Tablas_Formato">No. Ticket</td>
    <td width="23%" class="Tablas_Formato">Fecha de Inicio</td>
    <td width="12%" class="Tablas_Formato">Agencia</td>
    <td width="12%" class="Tablas_Formato">Id Agencia</td>
    <td width="19%" class="Tablas_Formato">Colaborador</td>
    <td width="12%" class="Tablas_Formato">Problema</td>
    <td width="7%" class="Tablas_Formato">Proceso</td>
    <td width="7%" class="Tablas_Formato">Cancelacion</td>
  </tr>
	<?php while ($row=mysqli_fetch_array($result_n)) {
	?>
  <tr class="leras">
    <td><?php echo $row["tiket"] ?></td>
    <td><?php echo $row["fecha_inicio"] ?></td>
    <td><?php echo $row["agencia"] ?></td>
    <td><?php echo $row["id_agencia"] ?></td>
    <td><?php echo $row["nombre_operador"] ?></td>
    <td><?php echo $row["problema"] ?></td>
    <td><a href="comentario_ticket.php?ti=<?php echo $row["tiket"] ?>"><img src="../Imagenes/mas.png" alt="insertar" width="20" height="20" border="0"></a></td>
    <td><a href="cierre_tiket.php?ti=<?php echo $row["tiket"] ?>"><img src="../Imagenes/update-manager.png" alt="actualizar" width="20" height="20" border="0"></a>
      <label for="cancelar"></label></td>
  </tr>
  
  <?php }
  ?>
</table>
</form>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="../configuracion.php"><img src="../Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"><br>Cerrar</a></td>
</tr>
</table>
</div>

<p>&nbsp;</p>
</body>
</html>