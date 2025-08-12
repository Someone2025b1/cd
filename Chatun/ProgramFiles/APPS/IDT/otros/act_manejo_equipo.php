<?php
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$enti = $HTTP_GET_VARS[ordi];//ordenamineto
$senti = $HTTP_GET_VARS[sev];
$opcion=0; 
$orde = $HTTP_GET_VARS[order];// no funciona
$busque = $_GET["busqueda"];//recibe la busqueda
$variable= $_GET["veri"];//valida la case
//$variable=2;
?>

<?php 	if ($senti ==1){ $opcion = 1; }
		if ($verifica == 1){ $variable=1;  echo "**variable a 1**";}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">

<style type="text/css">
letras_blancas {
	color: #FFF;
}
letrasbalnca {
	color: #FFF;
}
letras_blanca {
	color: #CCC;
}
letrasblancasss {
	color: #FFF;
}
#letras_blancas {
	color: #FFF;
}
.lestras_blacnas {
	color: #FFF;
	font-size: 12px;
}
.letras12 {
	font-size: 12px;
}
.letras_blcas {
	color: #FFF;
}
</style>
</head>

<body class="Pagina">
<div id="menuprincipal">
<table width="65%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="4" bgcolor="#000099" class="letras_blcas"><div align="center">Sistema de Ingreso de Inventario al Departamento IDT</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td><form name="form2" method="get" action="act_manejo_equipo.php">
  <table width="45%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="2"><div align="center"><img src="../Imagenes/busquedae.png" width="50" height="50" alt="Busqueda de Activo"></div></td>
    </tr>
    
    <tr>
      <td><div align="center">Busqueda &nbsp; &nbsp;</div></td>
      <td><label for="busqueda"></label>
      <input type="text" name="busqueda" id="busqueda">
      <input name="veri" type="hidden" id="veri" value="1"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button2" id="button2" value="Busqueda"></td>
    </tr>
  </table>

</form></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><form id="form1" name="form1" method="get" action="act_ingreso_inventario_idt.php">
<table width="35%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="40%">Inventario</td>
    <td width="60%"><label for="inven"></label>
      <input type="text" name="inven" id="inven"></td>
  </tr>
  <tr>
    <td>Colaborador del Inventario</td>
    <td><label for="empleado"></label>
      <select name="empleado" id="empleado">
        <option value="0" selected="selected">- - Selecione Un Colaborador - - </option>
        <?php // seleciona de la bases de datos por los usuarios en forma de seleccion 
      $sql = "SELECT * FROM info_bbdd.usuarios_general ORDER BY nombre ";
	  $result_n = mysqli_query($db, $sql);
	  ?>
        <?php //se hace el ciclo para generar las opciones 
			while ($row=mysqli_fetch_array($result_n)) {//llenado de formulario
			//ciclo del las opciones
		?>
        
        <option value="<?php echo $row["id_user"] ?>"><?php echo $row["nombre"] ?></option>
        <?php }
	   ?>
      </select></td>
    </tr>
  <tr>
    <td>Tipo</td>
    <td><label for="tipo"></label>
      <select name="tipo" id="tipo">
        <option>--Selecione un Tipo--</option>
        <option>Portatil</option>
        <option>Monitor</option>
        <option>Impresora</option>
        <option>CPU</option>
        <option>Escaner</option>
        <option>Servidores</option>
        <option>SWITCH / ROUTER</option>
        <option>Bateria UPS</option>
        <option>Camara de Seguridad</option>
        <option>Camara Web o Digital</option>
        <option>Televisores</option>
        <option>Rack</option>
        <option>Otros</option>
      </select></td>
    </tr>
  <tr>
    <td>Otros ==&gt;&gt;</td>
    <td><label for="otros"></label>
      <input type="text" name="otros" id="otros"></td>
  </tr>
  <tr>
    <td>Descripcion</td>
    <td><label for="descri"></label>
      <textarea name="descri" id="descri" cols="45" rows="2"></textarea></td>
    </tr>
  <tr>
    <td>Estado</td>
    <td><label for="estado"></label>
      <select name="estado" id="estado">
        <option>--Selecione un Estado--</option>
        <option>Reparacion</option>
        <option>Mantenimiento</option>
        <option>Quemado</option>
        <option>Revision</option>
        <option>Espera-Asignacion</option>
        <option>Baja Inventario</option>
      </select></td>
    </tr>
  <tr>
    <td><input name="veri2" type="hidden" id="veri2" value="2"></td>
    <td><input type="submit" name="button" id="button" value="Ingresar">&nbsp;<input name="" type="reset" value="Restablecer"></td>
  </tr>
</table>

</form></td>
  </tr>
</table>

<?php
switch ($variable){
	case 1: // busca por inventario tipo o dueño
	  
	$sql2 = "SELECT * FROM coosajo_inventario_idt.inventario_departamento where estado_actual ='1' and  inventario = '$busque' or tipo like '%$busque%' or nombre_activo like '%$busque%'  ORDER BY fecha_ingreso DESC, nombre_activo DESC limit 0,100 ";
		$result_n2 = mysqli_query($db, $sql2); 

	break;
	default:
if ($opcion ==0 ){
//infromacion que esta la base datos selecionando que esten en el departamento
$sql2 = "SELECT * FROM coosajo_inventario_idt.inventario_departamento where estado_actual ='1' ORDER BY fecha_ingreso DESC, nombre_activo DESC ";
		$result_n2 = mysqli_query($db, $sql2); } 
		else {
			$sql2 = "SELECT * FROM coosajo_inventario_idt.inventario_departamento where estado_actual ='1'  order by $enti ASC ";
		$result_n2 = mysqli_query($db, $sql2); }
	break;
}
?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td colspan="2" class="letras_blcas">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><div align="right"></div></td>
  </tr>
  <tr class="letras_blcas">
    <td bgcolor="#66CC66"><div align="center"><a href="act_manejo_equipo.php?ordi=inventario&sev=1$order=ASC" class="letras_blancas">#  Inventario</a></div></td>
    <td bgcolor="#66CC66"><div align="center"><a href="act_manejo_equipo.php?ordi=dueno_activo&sev=1" class="letras_blancas">Inventario Asignado</a></div></td>
    <td bgcolor="#66CC66"><div align="center"><a href="act_manejo_equipo.php?ordi=tipo&sev=1" class="letras_blcas"><span class="LetraBlanca"><span class="letras_blancas">Tipo</span></span></a></div></td>
    <td bgcolor="#66CC66" class="letras_blancas">&nbsp;</td>
    <td bgcolor="#66CC66"><div align="center"><a href="act_manejo_equipo.php?ordi=descripcion&sev=1" class="letras_blancas">Descripcion</a></div></td>
    <td bgcolor="#66CC66"><div align="center"><a href="act_manejo_equipo.php?ordi=estado&sev=1" class="letras_blancas">Estado</a></div></td>
    <td bgcolor="#66CC66"><div align="center"><a href="act_manejo_equipo.php?ordi=fecha_ingreso&sev=1" class="letras_blancas">Fecha Ingreso</a></div></td>
    <td bgcolor="#66CC66"><div align="center"><a href="act_manejo_equipo.php?ordi=colaborador_idt&sev=1" class="letras_blancas">Responsable</a></div></td>
    <td bgcolor="#66CC66"><div align="center" class="letras_blancas">Modificar</div></td>
  </tr>
  <tr>
  
   <?php 
   //se hace el ciclo para generar las opciones
 
			while ($row2=mysqli_fetch_array($result_n2)) {//llenado de formulario
			//ciclo del las opciones
			?>
        
    <td class="letras12"><?php echo $row2["inventario"] ?></td>
    <td class="letras12">
      <?php  $colabor=$row2["dueno_activo"];
	$sql3 = "SELECT * FROM ".$base_bbdd.".usuarios where id_user='$colabor'";
	  $result_n3 = mysqli_query($db, $sql3); 
	  $row3=mysqli_fetch_array($result_n3);
	  echo $row3["nombre"]; ?>
    </td>
    <td class="letras12"><?php echo $row2["tipo"] ?></td>
    <td class="letras12"><?php echo $row2["tipo_otros"] ?>
    <div align="center"></div></td>
    <td class="letras12"><?php echo $row2["descripcion"] ?></td>
    <td class="letras12"><?php echo $row2["estado"] ?></td>
    <td class="letras12"><?php echo $row2["fecha_ingreso"] ?></td>
    <td class="letras12">
      <?php $res=$row2["colaborador_idt"];
	$sql4="SELECT * FROM coosajo_base_bbdd.usuarios where id_user ='$res'";
	  $result_n4 = mysqli_query($db, $sql4); 
	  $row4=mysqli_fetch_array($result_n4);
	  echo $row4["nombre"];  ?>
    </td>
    <td><div align="center" class="letras12"><a href="act_salida_departamento.php?id=<?php echo $row2["id"] ?>"><img src="../Imagenes/edit.png" alt="Modificar" width="16" height="16" border="0"></a></div></td>
  </tr>
  <?php } ?>
</table>
</div>

<div id="flotante_derecho">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="flotante" class="Tamano12" align="center">
<tr>
  <td align="center"><a href="../configuracion.php"><img src="../Imagenes/cerrar.png" alt="Regresar" width="64" height="64" border="0"></br>Cerrar</a></td>
</tr>
</table>
</div>

</body>
</html>		