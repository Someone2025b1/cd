<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");

?> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
.letras_blancas {
	color: #FFF;
}
.letras_azul {
	color: #00F;
	font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<form action="busqueda_modifi_usuarios_dba.php" method="get">
<table width="60%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><div align="center" class="letras_azul">Busqueda por Nombre, Cif y Usuario</div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Ingrese el dato a buscar</td>
    <td><label for="busqueda"></label>
      <input type="text" name="busqueda" id="busqueda"> &nbsp;<a href="usuario_nuevo_dba.php"><img src="../Imagenes/label_new_green.png" alt="Crear Nuevo Usuario" width="50" height="50" border="0"></a></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="sentinela" type="hidden" id="sentinela" value="1"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><div align="right">
      <input type="submit" name="Busqueda" id="Busqueda" value="Buscar">
    </div></td>
    <td><input type="reset" name="Limpiar" id="Limpiar" value="Limpiar"></td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php $senti=$_GET["sentinela"] ;?>
 <?php if ( $senti==1  ){$busq=$_GET["busqueda"];}
  ?>
</form>
<?php echo "Dato Buscado:     ".$busq ; ?>
<?php

if ($senti==1){
$sql = "SELECT * FROM coosajo_base_bbdd.usuarios WHERE id_user like '%$busq%' or nombre like '%$busq%' ";
		$result_n = mysqli_query($db, $sql); }
?>

<table width="100%" border="1" align="center" cellspacing="0">
  <tr>
    <td colspan="9" bgcolor="#0000CC"><div align="center"><span class="letras_blancas">Resultado de las Busquedas</span></div></td>
  </tr>
  <tr>
    <td width="8%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Cif</span></div></td>
    <td width="36%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Nombre</span></div></td>
    <td width="6%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Estado</span></div></td>
    <td width="11%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Departamento</span></div></td>
    <td width="10%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Agencia</span></div></td>
    <td width="7%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Login</span></div></td>
    <td width="7%" bgcolor="#009900" class="letras_blancas"><div align="center">Grupo</div></td>
    <td width="7%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Permisos</span></div></td>
    <td width="15%" bgcolor="#009900"><div align="center"><span class="letras_blancas">Modificar</span></div></td>
  </tr>
  <tr>
  <?php if ($senti==1){ ?>
   <?php while ($row=mysqli_fetch_array($result_n)) {
		
		
		
		?>
    <td><?php echo $row["id_user"] ?></td>
    <td><?php echo $row["nombre"] ?></td>
    <td><?php  $vali=$row["estado"] ?>
    <?php if ( $vali == 1) {echo "si"; } 
		  if ($vali == 2){ echo "Vacaciones"; }
		  if ($vali == 3){ echo "Suspendido" ;}
		  if ($vali==0)	{	echo "No"; }
						?></td>
    <td><?php  $depto=$row["depto"] ?>
         <?php $sql2 = "select * from coosajo_base_bbdd.departamentos where id_depto = '$depto' ";
		 $result_n2 = mysqli_query($db, $sql2);
		$row2=mysqli_fetch_array($result_n2);
		echo $row2["nombre_deto"]; ?></td>
    <td><?php  $agen=$row["agencia"] ?>
	<?php $sql4 = "select * from coosajo_base_bbdd.agencias where id_agencia = '$agen' ";
		 $result_n4 = mysqli_query($db, $sql4);
		$row4=mysqli_fetch_array($result_n4);
		echo $row4["agencia"]; ?></td>
    <td><?php echo $row["login"] ?></td>
    <td><?php  $gru=$row["grupo"] ?><?php 
	$sql6 = "SELECT * FROM coosajo_base_bbdd.grupos WHERE id_grupos = '$gru' ";
	$result_n6 = mysqli_query($db, $sql6);
	$row6=mysqli_fetch_array($result_n6);
	?><?php  echo $row6["nombre_grupo"] ?></td>
    <td><div align="center"><a href="permisos_dba.php?cif=<?php echo $row["id_user"] ?>"><img src="../Imagenes/file_locked.png" alt="Permisos" width="25" height="25" border="0"></a></div></td>
    <td><div align="center"><a href="Ingreso_usuarios_dba.php?cif=<?php echo $row["id_user"] ?>"><img src="../Imagenes/edit.png" alt="editar" width="20" height="20" border="0"></a></div></td>
  </tr>
  <?php }
  ?>
  <?php } ?>
</table>
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