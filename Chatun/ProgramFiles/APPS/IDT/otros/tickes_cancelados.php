<?php 
include("../../../../Script/conex.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<style type="text/css">
.color {
	color: #FFF;
}
.Tablas_Formato {
	text-align: center;
}
.tamano {
	font-size: 10px;
}
.grande {
	font-size: 12px;
}
.cetnro {
	text-align: center;
}
.texto {
	font-size: 11px;
}
.mas_grand {
	font-size: 12px;
}
.centradoss {
	text-align: center;
}
</style>
</head>

<body>
<form action="../../../IDT/otros/actualizar.php" method="get">
<table align="center" border="0" width="98%">
<?php
$sql = "SELECT * FROM coosajo_caidas_enlaces.caidas WHERE estado='c'";
		$result_n = mysqli_query($db, $sql);
		
		
?>
  <tr>
    <td colspan="8" bgcolor="#0000CC" class="centradoss" style="color: #FFF">Tickets en Proceso</td>
  </tr>
  <tr bgcolor="#009933">
    <td width="15%" class="centradoss" style="color: #FFF">No. Ticket</td>
    <td width="23%" class="centradoss" style="color: #FFF">Fecha de iniciado</td>
    <td width="12%" class="centradoss" style="color: #FFF">Agencia</td>
    <td width="12%" class="centradoss" style="color: #FFF">Id Agencia</td>
    <td width="14%" class="centradoss" style="color: #FFF">Colaborador</td>
    <td width="12%" class="centradoss" style="color: #FFF">Problema</td>
    <td width="12%" class="centradoss" style="color: #FFF">Fecha Cierre</td>
    <td width="12%" class="centradoss" style="color: #FFF">Comentarios</td>
  </tr>
   <?php while ($row=mysqli_fetch_array($result_n)) {
		
		
		
		?>
  <tr class="texto">
    <td class="centradoss"><?php echo $row["tiket"] ?></td>
    <td class="centradoss"><?php echo $row["fecha_inicio"] ?></td>
    <td class="centradoss"><?php echo $row["agencia"] ?></td>
    <td class="centradoss"><?php echo $row["id_agencia"] ?></td>
    <td class="centradoss"><?php echo $row["nombre_operador"] ?></td>
    <td class="centradoss"><?php echo $row["problema"] ?></td>
    <td> <span class="centradoss"><?php echo $row["fecha_inicio"] ?>   
    </span>
    <td><span class="centradoss"><?php echo $row["comentarios"] ?>
    </span>
    <td width="0%">&nbsp;</td><td width="0%" class="grande">
    </td>
      </tr>
  
  <?php }
  ?>
</table>
<p class="grande">&nbsp;</p>
</form>
</body>
</html>