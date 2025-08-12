<?php 
include("../../../../Script/conex.php");
include("../../../../Script/seguridad.php");
$iduser= $HTTP_GET_VARS[cif];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
</head>

<body class="Pagina">
<div id="menuprincipal">
<?php echo "Cuenta del Colaborador:   ". $iduser; 
if ($iduser > 0) {

	$sql = "select *
from coosajo_base_bbdd.usuarios u, coosajo_base_bbdd_nac.departamentos d, coosajo_base_bbdd_nac.agencias a
where u.depto=d.id_depto and a.id_agencia=u.agencia and u.id_user='$iduser' ";
		$result_n = mysqli_query($db, $sql);
		$row3=mysqli_fetch_array($result_n);
}
?>
	



<form method=get enctype=multipart/form-data action=actualizar_user_dba.php Files/processor.php onSubmit="return validatePage1();"><ul class=mainForm id="mainForm_1">

  <li class="mainForm" id="fieldBox_1">
	<label class="formFieldQuestion">Nombre Usuario&nbsp; </label><input class=mainForm type=text name=nombre id=nombre size='100' value='<?php echo $row3["nombre"] ?>'></li>

				<li class="mainForm" id="fieldBox_2">
  <label class="formFieldQuestion">Departamento&nbsp;</label>
<select name="Departamento" id="depertamento">
        <option value="<?php echo $row3["id_depto"] ?> selected="selected"><?php echo $row3["nombre_deto"] ?></option>
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
  </select></li>
				<li class="mainForm">Estado del Usuario</li>
				<li class="mainForm">
  <p>
    <label>
      <input name="estados" type="radio" id="estados_0" value="1"checked>
      Activo</label>
    
    <label>
      <input type="radio" name="estados" value="0" id="estados_1">
      Baja</label>
    
    <label>
      <input type="radio" name="estados" value="2" id="estados_2">
      Vacaciones</label>
    
    <label>
      <input type="radio" name="estados" value="3" id="estados_3">
      Suspendido</label>
    
  </p>
  </li>

				
				  <label class="formFieldQuestion">Agencia&nbsp;</label><select name="Agencias" id="Agencias2">
        <option value="<?php echo $row3["id_agencia"] ?> selected="selected"><?php echo $row3["agencia"] ?></option>
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
          </select></li>

  <li class="mainForm" id="fieldBox_5">
	<label class="formFieldQuestion">Cif&nbsp;</label><input class=mainForm type=text name=cif id=cif size='20' value='<?php echo $row3["id_user"] ?>'></li>

  <li class="mainForm" id="fieldBox_6">
	<label class="formFieldQuestion">Login&nbsp;</label><input class=mainForm type=text name=login id=login size='20' value='<?php echo $row3["login"] ?>'></li>
  <li class="mainForm">Grupo<select name="grupo" id="Agencias2">
        <option value="<?php $var=$row3["grupo"]; ?> <?php echo $var ?>" selected="selected"><?php 
	$sql6 = "SELECT * FROM coosajo_base_bbdd.grupos WHERE id_grupos = '$var' ";
	$result_n6 = mysqli_query($db, $sql6);
	$row6=mysqli_fetch_array($result_n6);
	echo $row6["nombre_grupo"];
	?></option>
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
      </select></li>
  <li class="mainForm">Password&nbsp;<input name="pass" type="password" value="<?php echo $row3["clave"] ?>"></li>
  <li class="mainForm">Cod Ejecutivo &nbsp;<input name="ejecu" type="text" value="<?php echo $row3["codigo_ejecutivo"] ?>"></li>
<li class="mainForm"></li>
		
		
		<!-- end of this page -->

		<!-- page validation -->
		<SCRIPT type=text/javascript>
		<!--
			function validatePage1()
			{
				retVal = true;
				if (validateField('field_1','fieldBox_1','text',1) == false)
 retVal=false;
if (validateField('field_2','fieldBox_2','menu',1) == false)
 retVal=false;
if (validateField('field_3','fieldBox_3','radio',1) == false)
 retVal=false;
if (validateField('field_4','fieldBox_4','menu',1) == false)
 retVal=false;
if (validateField('field_5','fieldBox_5','text',1) == false)
 retVal=false;
if (validateField('field_6','fieldBox_6','text',1) == false)
 retVal=false;

				if(retVal == false)
				{
					alert('Please correct the errors.  Fields marked with an asterisk (*) are required');
					return false;
				}
				return retVal;
			}
		//-->
		</SCRIPT>

		<!-- end page validaton -->


 
		<!-- next page buttons --><li class="mainForm">
					<input id="saveForm" class="mainForm" type="submit" value="Guardar" />
          <input name="datos" type="hidden" id="datos" value="<?php echo $iduser ?>">
		  <input name="modi" type="hidden" id="modi" value="modificacion usuarios">
		</li>

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