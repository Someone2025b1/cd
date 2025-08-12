
<?php  

include("../../../../Script/seguridad.php");
include("conex.php");
include("funciones.php");

$cif_colaborador= $_SESSION["iduser"];
$auxi = $_SESSION["cuenta"];

$cif = $_GET['cif'];     
$id_doc= $_GET['id_documento'];
$alertar = $_GET['alerta'];

?>
<script language="JavaScript" type="text/javascript" src="calendario/javascripts.js">
</script>
<script language="JavaScript" type="text/javascript">
//--------------- LOCALIZEABLE GLOBALS ---------------
var d=new Date();
var monthname=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octuber","Noviembre","Diciembre");
//Ensure correct for language. English is "January 1, 2004"
var TODAY =  d.getDate() + " de " + monthname[d.getMonth()] + " del " + d.getFullYear();
//---------------   END LOCALIZEABLE   ---------------
function cerrar(){
if (confirm("Esta seguro de salir de la aplicacion")){
window.close();
}   
}  
function check_folios() {
  var ext = document.formulario_ftp.archivo.value;
  ext = ext.substring(ext.length-3,ext.length); 
  ext = ext.toLowerCase();
	formulario_ftp.submit();  
	return true; }   
function check() {
  var ext = document.formulario_ftp.archivo.value;
  ext = ext.substring(ext.length-3,ext.length);
  ext = ext.toLowerCase();
  if(ext != 'pdf') {
	document.formulario_ftp.archivo.value == "";
	alert('Su archivo es extensión .'+ext+
          '; por favor seleccione un archivo .pdf');
	return false; }
  else
	formulario_ftp.submit();
	return true; }
</script> 

<html> 
<head>
<link rel="stylesheet"  href="bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="alertify/css/alertify.css"/>
 	
   
<script src="jQuery-2.0.0/jQuery-2.0.0.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="alertify/js/alertify.min.js"></script>

<meta charset="UTF-8">
<title>Ingreso de Informaci&oacute;n de Asociados</title>
<style type="text/css">
<!--
.letras_blancas {
	color: #FFF; 
	font-weight: bold;
}
.style4 {color: #203DD7;
	font-size: xx-large;
	font-weight: bold;
}
.style6 {color: #DFC228; font-size: xx-large; font-weight: bold; }
.style8 {color: #FFFFFF; font-size: xx-large; font-weight: bold; }
.style9 {color: #3366CC}
.style11 {color: #3366CC; font-weight: bold; }
.Estilo1 {color: #203DD7; font-size: large; font-weight: bold; }
.Estilo2 {
	color: #FFFFFF;
	font-weight: bold;
}
body {
	background-image: url(../Images/honey_im_subtle.png);

	background-repeat: repeat;
}
.Estilo5 {color: #000000}
.Estilo6 {font-weight: bold; font-size: xx-large;}

.table-hover tbody tr:hover td
        {
            background-color: #ADEBAF;
            color: black; }

-->
</style>
</head>
      
<body>
<table align="center" width="*" border="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
//$result = mssql_query("SET ANSI_NULLS ON") or die(mssql_get_last_message()); 
//$result = mssql_query("SET ANSI_WARNINGS ON") or die(mssql_get_last_message());



      
?>  

<form action="<?php echo $PHP_SELF ?>" method="post" name="form1" id="form1">
<table width="*" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td align="center" colspan="7"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">INGRESE RANGO DE FECHAS</font></span></td>
    </tr>  
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Fecha Inicio:</td>
      <td><label for="date"></label>
      <input type="date" name="date" id="date"></td>
      <td>&nbsp;</td>
      <td>Fecha Fin:</td>
      <td><input type="date" name="date2" id="date2"></td>
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
    </tr>
    <tr>
      <td align="center" colspan="7"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366">
        <input type="submit" name="Submit" class="btn btn-success" value="Verificar"  />
        </font><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366">
        <input type="hidden" name="centinela" value="1" />
      </font></td>
    </tr>
  </tbody>
</table>      
</form>   





<hr />  

    
 
    
       <?php		
			 $date = $_POST['date'];
			 if($date == ''){
				$date = date('Y-m-d'); 
			 }
			 			 $date1 = $_POST['date2'];
			 if($date1 == ''){
				$date1 = date('Y-m-d'); 
			 }
			 
			if($date != '') {
					 
			$sql_doc_in = "SELECT * from coosajo_educacion_cooperativa.solicitud_capacitaciones where estado = '0' and fecha_solicitud >= '$date' and fecha_solicitud <= '$date1'";
$result_doc_in = mysql_query($sql_doc_in,$db) or die("196".mysql_error());	
			     
		     
	  ?>
      
      
</font></p>
<hr />
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" class="table-hover">
  <tr     bgcolor="#006600">
    <td colspan="9" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">SOLICITUD DE CAPACITACIONES</font></span></td>
  </tr>
  <tr     bgcolor="#006600">
    <td width="12%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">No. Solicitud</font></span></td>
    <td width="20%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Solicitante</font></span></td>
   <td width="20%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">No. Asistentes</font></span></td>
    <td width="20%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Tipo de Evento</font></span></td>
    <td width="19%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Sonido</font></span></td>
   <td width="10%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Manteleria</font></span></td>
    <td width="10%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Comida</font></span></td>
    <td width="33%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha Capacitacion</font></span></td>
    <td width="33%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">VER</font></span></td>
  </tr>
  <?php           
			while ($row_doc_in=mysql_fetch_array($result_doc_in)) {
			$i++;
						if ($i % 2 == 0) {  
							$color="#e0e0e0";
						} else {
			  				$color="#ffffff";
						}    
		?> 
  <tr bgcolor="<?php echo $color ?>">
    
    <td align="center" width="12%" height="17" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php echo $row_doc_in["id"] ?></font></td>
    <td align="center" width="20%" >
    <?php
	$cif_solicitante = $row_doc_in["cif_solicitante"];
	
	
	$usuario = mysql_query("select Nombres From info_colaboradores.vista_colaboradores_activos where cif = '$cif_solicitante'", $db);
	$info_usuario_result = mysql_fetch_array($usuario);
	echo $nombre_solicitante = utf8_encode($info_usuario_result[Nombres]);
	
	?>
    
    
    </td>
    <td align="center" width="20%" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php 
	
	$adutos = $row_doc_in["no_asistentes"];
	$ninos = $row_doc_in["no_ninos"];
	 echo $total = $adutos + $ninos;
	
	 ?></font></td>
    <td align="center" width="20%" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php 
	

	     echo $row_doc_in["tipo_evento"]; 
	 
	
	?>
	</font></td>
    <td align="center" width="19%" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php $sonido = $row_doc_in["sonido"];
	
	if($sonido == '1'){ ?>       
		<img src="../imagenes/check.png" alt="contrato" width="24" height="24" border="0" />  
<?php	}else {
	
	  ?>  
      <img src="../imagenes/not.png" alt="contrato" width="24" height="24" border="0" />
      <?php
} ?>
      
      
      
      </a></font></td>
    <td align="center"><?php  $manteleria = $row_doc_in["manteleria"];
	
	if($manteleria == '1'){
?>
<img src="../imagenes/check.png" alt="contrato" width="24" height="24" border="0" />
  
<?php }    
        
if($manteleria == '0'){
?>
<img src="../imagenes/not.png" alt="contrato" width="24" height="24" border="0" />

<?php } ?>
	           
	
	
	</td>
    <td align="center"><?php  $comida = $row_doc_in["comida"];
	
	if($comida == '1'){
?>
<img src="../imagenes/check.png" alt="contrato" width="24" height="24" border="0" />

<?php } 

if($comida == '0'){
?>
<img src="../imagenes/not.png" alt="contrato" width="24" height="24" border="0" />

<?php } ?>
	     
	
	
	</td>
    <td height="17"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#003366"><?php echo cambio_fecha($row_doc_in["fecha_capacitacion"])?></a></font></div></td>
    <td width="12%" ><div align="center"><a href="ver_capacitaciones.php?id=<?php echo $row_doc_in["id"] ?>"><img src="../imagenes/go.png" alt="contrato" width="48" height="48" border="0" /></a></div></td>
  </tr>
  <?php  
			} // end while  
		?>    
</table>        
<?php
			}
	 
	       // end if-else (num_rows < 100) ?>
</font></div>




  

<? ///////////////SEGUNDA TABLA DONDE APARECEN LOS OPERADOS//////////// ?>
<?php		
			 if($date != '') {	 
			
			 
			
			$sql_doc_in1 = "SELECT * from coosajo_educacion_cooperativa.solicitud_grupos_especiales where estado = '0' and fecha_solicitud >= '$date' and fecha_solicitud <= '$date1'";
$result_doc_in1 = mysql_query($sql_doc_in1,$db) or die("196".mysql_error());	
			     
		
	  ?>     
</font></p>
<hr />
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" class="table-hover">
  <tr     bgcolor="#006600">
    <td colspan="8" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">SOLICITUDES DE GRUPOS ESPECIALES</font></span></td>
  </tr>   
  <tr     bgcolor="#006600">
  
    <td width="12%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">No. Solicitud</font></span></td>
    <td width="20%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Solicitante</font></span></td>
   <td width="20%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">No. Asistentes</font></span></td>
    <td width="20%" align="center"  bgcolor="#006600"><span class="Estilo2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Responsable del Grupo</font></span></td>
    <td width="19%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">COMIDA</font></span></td>
   <td width="10%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">FECHA</font></span></td>
    <td width="10%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">HORA DE LLEGADA</font></span></td>
    <td width="12%" align="center" ><span class="Estilo2"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Consultar</font></span></td>
  </tr>
  <?php             
			while ($row_doc_in1=mysql_fetch_array($result_doc_in1)) {
			$i++;
						if ($i % 2 == 0) {    
							$color="#e0e0e0";
						} else {
			  				$color="#ffffff";
						}      
		?>   
  <tr bgcolor="<?php echo $color ?>">
    
    <td align="center" width="12%" height="17" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php echo $row_doc_in1["id"] ?></font></td>
    <td align="center" width="20%" ><?php
	$cif_solicitante1 = $row_doc_in1["responsable_solicitud"];
	   
	
	$usuario1 = mysql_query("select Nombres From info_colaboradores.vista_colaboradores_activos where cif = '$cif_solicitante1'", $db);
	$info_usuario_result1 = mysql_fetch_array($usuario1);
	echo $nombre_solicitante1 = utf8_encode($info_usuario_result1[Nombres]);
	
	?></td>
    <td align="center" width="20%" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php 
	
	$adutos = $row_doc_in1["no_asistentes"];
	$ninos = $row_doc_in1["no_ninos"];
	 echo $total1 = $adutos + $ninos;
	
	 ?></font></td>
    <td align="center" width="20%" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php    
	
	echo $row_doc_in1["responsable_grupo"]; 
	   
	 
	
	?>  
	</font></td>
    <td align="center" width="19%" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><?php $comida1 = $row_doc_in1["comida"]  ?></a></font>
<?    
    if($comida1 == '1'){
?>
<img src="../imagenes/check.png" alt="contrato" width="24" height="24" border="0" />

<? } 

if($comida1 == '0'){
?>
<img src="../imagenes/not.png" alt="contrato" width="24" height="24" border="0" />

<? } ?>
    
    
    </td>
    <td align="center"><?php echo cambio_fecha($row_doc_in1["fecha"]); ?>
	        
	
	
	</td>
    <td align="center"><?php  echo  $row_doc_in1["hora_llegada"];?>
      
      
      
    </td>
    <td width="12%" ><div align="center"><a href="ver_grupos_especiales.php?id=<?php echo $row_doc_in1["id"] ?>"><img src="../imagenes/go.png" alt="contrato" width="48" height="48" border="0" /></a></div></td>
  </tr>
  <?php   
			} // end while  
			 
		?>    
</table>        
<?php
			 }
			 
	  ?>

<p>&nbsp;</p>

  <table align="center" width="120" border="0">
  <tr>
    <td width="196" align="right"><div align="center"><a href="menu.php"><img src="../imagenes/back.png" width="64" height="64" border="0" /></br>Retroceder..</a></div></td>
  </tr>
</table>
  <?php
if($alertar == '1'){ ?>
<script>
alertify.success('<h4><font color="white">Guardado Correctamente... </font> </h4>' );
</script>	
<?php
}
?>  

<?php
if($alertar == '2'){ ?>
<script>
alertify.error('<h3><font color="white">Error... </font> </h3>' );
</script>	
<?php   
} 
?> 




</body>
</html>