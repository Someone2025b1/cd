<?php 

include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Panel Principal</title>


<link href="../../../IDT/estilo.css" rel="stylesheet" type="text/css">
<meta name="" content="Primer de verdad titulo ">
<style type="text/css">
body {
	background-image: url(../../../IDT/imagenes/background_052.gif);
	background-repeat: repeat;
}
</style>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="6" bgcolor="#0000CC"><div align="left"><img src="../../../IDT/imagenes/logo.png" width="326" height="85" alt="COOSAJO"></div></td>
    <td rowspan="6" bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td rowspan="6" bgcolor="#0000CC"><div align="right"><a href="salir.php"><img src="../../../IDT/imagenes/exit.png" width="128" height="128" alt="exit" border="0"></a></div></td>
  </tr>
  <tr>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#0000CC">&nbsp;</td>
    <td bgcolor="#0000CC">&nbsp;</td>
  </tr>
  <tr>
    <td bgcolor="#339900"><?php echo $date= date("d-m-Y") ?></td>
    <td bgcolor="#339900">&nbsp;</td>
    <td bgcolor="#339900">&nbsp;</td>
    <td bgcolor="#339900">&nbsp;</td>
    <td bgcolor="#339900"><?php
				  	
				  	session_start();
				  	$auxi=$_SESSION["nombre_user"];
					echo $auxi;
	  
	  ?>
    <div align="left"></div></td>
  </tr>
  <tr>
    <td bgcolor="#339900">&nbsp;</td>
    <td colspan="3" bgcolor="#339900"><div align="center"></div></td>
    <td bgcolor="#339900">&nbsp;</td>
  </tr>
</table>

<table  align="center"width="85%" border="0">
  <tr>
    <td width="13%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="24%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="13%">&nbsp;</td>
    <td width="5%">&nbsp;</td>
    <td width="35%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td><a href="act_manejo_equipo.php" target="mainframe"><img src="../Imagenes/Computadora.png" alt="Ingreso de Equipo" width="150" height="150" border="0"></a></td>
    <td class="dsd">&nbsp;</td>
    <td class="dsd"><div align="center"><a href="password.php"  target="mainframe"><img src="../Imagenes/password.png" alt="password" width="217" height="65" border="0" /></a></div></td>
    <td>&nbsp;</td>
    <td class="centro"><div align="center"><a href="tickes_proceso.php" target="mainframe"><img src="../Imagenes/tickets_256.png" alt="Ticket" width="150" height="150" border="0" /></a></div></td>
    <td>&nbsp;</td>
    <td class="centro"><div align="center"><a href="menu_bd.php" target="mainframe"><img src="../Imagenes/database.png" alt="Manejo de Base Datos y Usuarios" width="150" height="150" border="0"></a></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><a href="act_manejo_equipo.php" target="mainframe">Ingreso de Equipo a Reparacion </a></div></td>
    <td>&nbsp;</td>
    <td><div align="center"><a target="mainframe" href="password.php">Password Agencias</a></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"><a href="tickes_proceso.php" target="mainframe">Apertura de Tickets</a></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"><a href="menu_bd.php" target="mainframe">Manejo de Usuarios y Base Datos</a></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="7"><p>&nbsp;</p>
      <p><iframe name="mainframe" width="100%" height="800" frameborder="0" scrolling="auto" src="tickes_proceso.php"      
        </iframe>
    </p></td>
    <td>&nbsp;</td>
  </tr>
</table>

<hr>

<table align="center" width="35%">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><a href="tickes_proceso.php" target="mainframe"><img src="../../../IDT/imagenes/flecha-izquierda.png" alt="Regresar" width="75" height="75" border="0"></a></div></td>
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
<p class="TABLA_MENU">&nbsp;</p>
<p class="center">&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
