<?php

include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex2.php");
include("../../../../../Script/calendario/calendario.php");
include("encabezado.php");
$generar_alertas=$_GET[generar_alertas];
$generar_informe=$_GET[generar_informe];
$negativo=$_GET[negativo];


$centinela=$_GET["centinela"];
$periodo_a=$_GET["periodo_a"];
$periodo_b=$_GET["periodo_b"];

if($centinela ==1){

$sql_periodo_default = "SELECT * FROM Estado_Patrimonial.periodo WHERE id=$periodo_b  ";
$result_periodo_default = mysqli_query($db, $sql_periodo_default) or die("22".mysqli_error());
$row_periodo_default=mysqli_fetch_array($result_periodo_default);	
$periodo_b=$row_periodo_default[0];
$mes_b=$row_periodo_default[mes];
$anio_b=$row_periodo_default[anio];
$periodo_ante=$periodo_ante -1;
$sql_periodo_default2 = "SELECT * FROM Estado_Patrimonial.periodo WHERE id=$periodo_a  ";
$result_periodo_default2 = mysqli_query($db, $sql_periodo_default2) or die("29".mysqli_error());
$row_periodo_default2=mysqli_fetch_array($result_periodo_default2);
$periodo_a=$row_periodo_default2[0];
$mes_a=$row_periodo_default2[mes];
$anio_a=$row_periodo_default2[anio];
	
}else{
	
$sql_periodo_default = "SELECT * FROM Estado_Patrimonial.periodo order by id desc limit 1  ";
$result_periodo_default = mysqli_query($db, $sql_periodo_default) or die("38".mysqli_error());
$row_periodo_default=mysqli_fetch_array($result_periodo_default);	
$periodo_ante=$row_periodo_default[id];
$mes_b=$row_periodo_default[mes];
$anio_b=$row_periodo_default[anio];
$periodo_ante=$periodo_ante -1;
$sql_periodo_default2 = "SELECT * FROM Estado_Patrimonial.periodo WHERE id=$periodo_ante   ";
$result_periodo_default2 = mysqli_query($db, $sql_periodo_default2) or die("45".mysqli_error());
$row_periodo_default2=mysqli_fetch_array($result_periodo_default2);
$periodo_a=$row_periodo_default2[0];
$mes_a=$row_periodo_default2[mes];
$anio_a=$row_periodo_default2[anio];
	
}


session_start();
	 $colaborador=$_SESSION["iduser"];
//sacr el maximo conteo
$sql_id = "SELECT  max(id_alerta)as conteo FROM coosajo_rti.asignacion_tareas_alertas WHERE codigo_alerta=9995 limit 1  ";
$result_id = mysqli_query($db, $sql_id) or die("109".mysqli_error());
$row_id=mysqli_fetch_array($result_id);
$conteo=$row_id[0]; 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin título</title>
<style type="text/css">
.letras_blancas {
	color: #FFF;
}
.letras_azules {
	color: #00F;
}
</style>
</head>

<body><table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center">ANALISIS DE ESTADOS PATRIMONIALES EMPLEADOS DE COOSAJO R.L.</div></td>
  </tr>
  <tr>
    <td><div align="center">PERIODO DE EVALUACION </div></td>
  </tr>
</table>

<table width="45%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><a href="analisis_estado_patrimonial_empleados.php?generar_informe=1&centinela=<?php echo $centinela ?>&periodo_a=<?php echo $periodo_a ?>&periodo_b=<?php  echo $periodo_b ?>"><img src="../Imagenes/44.png" width="52" height="51" border="0" /></br>
    Solo generar Reporte</a></div></td>
    <td><div align="center"><a href="analisis_estado_patrimonial_empleados.php?negativo=1&centinela=<?php echo $centinela ?>&periodo_a=<?php echo $periodo_a ?>&periodo_b=<?php  echo $periodo_b ?> "><img src="../Imagenes/Search-icon.png" width="64" height="64" border="0" /></br>Saldos Negativos</a></div></td>
    <td><div align="center">
    <?PHP 
	$numrows_per=0;
	$sql_per = "SELECT * FROM info_colaboradores.datos_laborales WHERE cif='$colaborador' and departamento=23 ";
	$result_per = mysqli_query($db, $sql_per) or die("52".mysqli_error());
	$numrows_per = mysqli_num_rows($result_per);
	if($colaborador == 15413){  $numrows_per=1;} //aqui indica que roxana tenga permisos por que no es de caja
	if($numrows_per > 0){ ?>
    
    <a href="analisis_estado_patrimonial_empleados.php?generar_alertas=1&centinela=<?php echo $centinela ?>&periodo_a=<?php echo $periodo_a ?>&periodo_b=<?php  echo $periodo_b ?>"><img src="../Imagenes/cambiarclave.png" width="64" height="64" border="0" /></br>Crear Alertas</a>
	
	<?php } ?>
	</div></td>
  </tr>
</table>
<form id="form1" name="form1" method="get" action="analisis_estado_patrimonial_empleados.php">
<table width="45%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">Periodo A</div></td>
    <td><select name="periodo_a" id="periodo_a">
      <?php
$sql_periodo = "SELECT * FROM Estado_Patrimonial.periodo order by id desc  ";
$result_periodo = mysqli_query($db, $sql_periodo) or die("130".mysqli_error());
while ( $row_periodo=mysqli_fetch_array($result_periodo)){; 
	  ?>
      <option value="<?php echo $row_periodo[0] ?>" <?php if( $row_periodo[0]== $periodo_a){ echo 'selected="selected" '; }?>><?php echo $row_periodo[1]." - ".$row_periodo[2] ?></option>
      <?php } ?>
    </select></td>
    <td>&nbsp;</td>
    <td><div align="center">Periodo B</div></td>
    <td><select name="periodo_b" id="periodo_b">
      <?php
$sql_periodo2 = "SELECT * FROM Estado_Patrimonial.periodo order by id desc  ";
$result_periodo2 = mysqli_query($db, $sql_periodo2) or die("141".mysqli_error());
while ( $row_periodo2=mysqli_fetch_array($result_periodo2)){; 
	  ?>
      <option value="<?php echo $row_periodo2[0] ?>" <?php if( $row_periodo2[0]== $periodo_b){ echo 'selected="selected" '; }?>><?php echo $row_periodo2[1]." - ".$row_periodo2[2] ?></option>
      <?php } ?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="centinela" type="hidden" id="centinela" value="1" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="button" id="button" value="Cargar" /></td>
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
</form>
<hr />

<?php if($generar_alertas == 1 or $generar_informe == 1 ){ ?>
<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center"><a href="reporte_empleados_analisis-PDF.php" target="_blank"><img src="../Imagenes/print-icon-nor.png" alt="" name="impre" width="64" height="64" border="0" id="impre2" /></br>
    Imprimir</a></div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?php } ?>

<table width="95%" border="0" align="center" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#006600">
    <td colspan="4" bgcolor="#FFFFFF"><div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
    <td><div align="center" class="letras_blancas">Activos</div></td>
    <td><div align="center" class="letras_blancas">Pasivos</div></td>
    <td><div align="center" class="letras_blancas">Patrimonio</div></td>
    <td><div align="center" class="letras_blancas">Activos</div></td>
    <td><div align="center" class="letras_blancas">Pasivos</div></td>
    <td><div align="center" class="letras_blancas">Patrimonio</div></td>
    <td class="letras_blancas"><div align="center">Incr/Decre</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Factor Riesgo</div></td>
    <td><div align="center" class="letras_blancas">Riesgo</div></td>
    <td><div align="center" class="letras_blancas">Factor Riesgo</div></td>
    <td><div align="center"><span class="letras_blancas">Total</span></div></td>
  </tr>
  <tr bgcolor="#006600">
    <td><div align="center" class="letras_blancas">No.</div></td>
    <td class="letras_blancas"><div align="center">Cif</div></td>
    <td><div align="center" class="letras_blancas">Nombre</div></td>
    <td><div align="center" class="letras_blancas">Puesto</div></td>
    <td><div align="center" class="letras_blancas"><?php echo $anio_a ?></div></td>
    <td><div align="center" class="letras_blancas"><?php echo $anio_a ?></div></td>
    <td><div align="center" class="letras_blancas"><?php echo $anio_a ?></div></td>
    <td><div align="center" class="letras_blancas"><?php echo $anio_b ?></div></td>
    <td><div align="center" class="letras_blancas"><?php echo $anio_b ?></div></td>
    <td><div align="center" class="letras_blancas"><?php echo $anio_b ?></div></td>
    <td class="letras_blancas"><div align="center"><span class="letras_blancas">Patrimonio</span></div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Patrimonio</div></td>
    <td><div align="center" class="letras_blancas">Crecimiento Activo</div></td>
    <td><div align="center" class="letras_blancas">Crecimiento de Activos</div></td>
    <td><div align="center"><span class="letras_blancas">Riesgo</span></div></td>
  </tr>
  <?php 
  $sql = "SELECT * FROM info_bbdd.usuarios_general  WHERE estado=1 ";
$result_n = mysqli_query($db, $sql) or die("239".mysqli_error());
if($result_n > 0){ while ($row=mysqli_fetch_array($result_n)) { 

$ver=0;

						if ($ii % 2 == 0) {
							$color="#e0e0e0";
						} else {
							$color="#ffffff"; 	}	
if($negativo == 1 ){
	
	$sql_a = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.detalle_estado_patrimonial  WHERE mes=$mes_a and anio=$anio_a  and id=$row[0] ";
$result_a = mysqli_query($db, $sql_a) or die("".mysqli_error());
$row_a=mysqli_fetch_array($result_a); 

//sacar el Periodo B
$sql_b = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.detalle_estado_patrimonial  WHERE mes=$mes_b and anio=$anio_b  and id=$row[0] ";
$result_b = mysqli_query($db, $sql_b) or die("".mysqli_error());
$row_b=mysqli_fetch_array($result_b);
$resultado_patri=$row_b[2]-$row_a[2];

}else{
//sacar el Periodo A
$sql_a = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.detalle_estado_patrimonial  WHERE mes=$mes_a and anio=$anio_a  and id=$row[0] ";
$result_a = mysqli_query($db, $sql_a) or die("".mysqli_error());
$row_a=mysqli_fetch_array($result_a); 

//sacar el Periodo B
$sql_b = "SELECT total_activo, total_pasivo, patrimonio FROM Estado_Patrimonial.detalle_estado_patrimonial  WHERE mes=$mes_b and anio=$anio_b  and id=$row[0] ";
$result_b = mysqli_query($db, $sql_b) or die("".mysqli_error());
$row_b=mysqli_fetch_array($result_b); 
							
}

if($negativo !=1){$ver=1;
$ii++; 
$aa++;
}

if($negativo ==1 and $resultado_patri < 0){ $ver=1;
$ii++;
$aa++;
}
if($ver ==1){
	
							?>

  <tr bgcolor="<?php echo $color ?>">
    <td bgcolor="<?php echo $color ?>"><?php echo $ii ?></td>
    <td bgcolor="<?php echo $color ?>"><?php echo $row[0]; ?></td>
    <td bgcolor="<?php echo $color ?>"><?php echo $row[1]; ?></td>
    <td bgcolor="<?php echo $color ?>"><?php echo $row[14]; ?></td>
    <td bgcolor="<?php echo $color ?>"><div align="right"><?php echo number_format($row_a[0],2); ?></div></td>
    <td bgcolor="<?php echo $color ?>"><div align="right"><?php echo number_format($row_a[1],2); ?></div></td>
    <td bgcolor="<?php echo $color ?>"><div align="right"><?php echo number_format($row_a[2],2); ?></div></td>
    <td bgcolor="<?php echo $color ?>"><div align="right"><?php echo number_format($row_b[0],2); ?></div></td>
    <td bgcolor="<?php echo $color ?>"><div align="right"><?php echo number_format($row_b[1],2); ?></div></td>
    <td bgcolor="<?php echo $color ?>"><div align="right"><?php echo number_format($row_b[2],2); ?></div></td>
    <td <?php if($negativo ==1){ echo ' bgcolor="#99CC66"'; }?>><div align="right"><?php echo number_format($row_b[2]-$row_a[2],2); 
	$incre_decre_pa=$row_b[2]-$row_a[2];?></div></td>
    <td><div align="right">
    <?php 
    if($incre_decre_pa >=500000)
    {  
      $nota_a=10; 
    }
    else
    { 
      if($incre_decre_pa >=80000)
      {
        $nota_a=((500000 - 80000)*(10-2)) / (( 500000 - 80000) + 2);
      }
      else
      {  
        $nota_a=1; 
      }
    }

	echo number_format($nota_a,2);
	
	?></div></td>
  <td bgcolor="<?php echo $color ?>">
    <div align="right">
      <?php 
        echo number_format($row_b[0] / $row_a[0],2);
        $resultado_activo=$row_b[0] / $row_a[0];
      ?>
    </div>
  </td>
  <td bgcolor="<?php echo $color ?>">
    <div align="right">
      <?php 
        if($resultado_activo > 2)
        { 
          $nota_b=10; 
        }
        else
        {
          if($resultado_activo >=1.333)
          { 
            $nota_b= (($resultado_activo -1)*10); 
          }
          else
          {  
            $nota_b=1;
          }
        }
        
        echo number_format($nota_b,2);
      ?>
    </div>
  </td>
    <td bgcolor="<?php  
	if($nota_a * $nota_b >= 51){ $aler='#FF0000'; }
	if($nota_a * $nota_b >= 31 and $nota_a * $nota_b <=50 ){ $aler='#CCCC33'; }
	if($nota_a * $nota_b >= 0 and $nota_a * $nota_b <= 30){ $aler='#FFFFFF'; }
	
	echo $aler; ?>"><div align="right"><?php echo $total_riesgo=number_format($nota_a * $nota_b,2) ?></div></td>
  </tr>
   <?php 
}//negativo
   
   if($generar_alertas == 1 and $total_riesgo >= 50){
	   $conteo++;
$fecha_hoy=date('Y-m-d');

$alerta++;

$sql_gra_alerta = "INSERT INTO coosajo_rti.asignacion_tareas_alertas VALUES ($conteo, 13418, 9995, now(), 1, '0000-00-00', 'Cif:', '$row[0]', 'Nombre: ', '$row[1]', 'Puesto: ', '$row[14]', 'Tipo de Alerta  :', 'ESTADO PATRIMONIAL', 'Total de Riesgo:', '$total_riesgo', 'Perido A', '$mes_a - $anio_a', 'Periodo B', '$mes_b - $anio_b ', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '',   NULL, NULL, $row[0]);";
$result_gra_alerta = mysqli_query($db, $sql_gra_alerta) or die("289".mysqli_error());

//reporte crear pdf
$periodoa=$mes_a."-".$anio_a;
$periodob=$mes_b."-".$anio_b;
$sql_reporte = "INSERT INTO Estado_Patrimonial.reporte_empleados_riesgo (id, cif, nombre, puesto, total_riesgo, fecha, periodo_a, periodo_b , colaborador ) VALUES (NULL, '$row[0]', '$row[1]', '$row[14]', '$total_riesgo', now(), '$periodoa', '$periodob', $colaborador)ON DUPLICATE KEY UPDATE total_riesgo='$total_riesgo';";  
$result_reporte = mysqli_query($db, $sql_reporte) or die("293".mysqli_error());
}
 
   if($generar_informe == 1 and $total_riesgo >= 50){ 
   $alerta++;
//reporte crear pdf
$periodoa=$mes_a."-".$anio_a;
$periodob=$mes_b."-".$anio_b;
$sql_reporte = "INSERT INTO Estado_Patrimonial.reporte_empleados_riesgo (id, cif, nombre, puesto, total_riesgo, fecha, periodo_a, periodo_b , colaborador ) VALUES (NULL, '$row[0]', '$row[1]', '$row[14]', '$total_riesgo', now(), '$periodoa', '$periodob', $colaborador)ON DUPLICATE KEY UPDATE total_riesgo='$total_riesgo';";  
$result_reporte = mysqli_query($db, $sql_reporte) or die("300".mysqli_error());	   
	   
	   
   }
if($aa == 20){   ?>
<tr bgcolor="#006600">
    <td colspan="4" bgcolor="#FFFFFF"><div align="center"></div>      <div align="center"></div>      <div align="center"></div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Activos</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Pasivos</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Patrimonio</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Activos</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Pasivos</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Patrimonio</div></td>
    <td bgcolor="#006600" class="letras_blancas"><div align="center">Incr/Decre</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Factor Riesgo</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Riesgo</div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Factor Riesgo</div></td>
    <td bgcolor="#006600"><div align="center"><span class="letras_blancas">Total</span></div></td>
  </tr>
  <tr bgcolor="#006600">
    <td><div align="center" class="letras_blancas">No.</div></td>
    <td class="letras_blancas"><div align="center">Cif</div></td>
    <td><div align="center" class="letras_blancas">Nombre</div></td>
    <td><div align="center" class="letras_blancas">Puesto</div></td>
    <td><div align="center" class="letras_blancas">2013</div></td>
    <td><div align="center" class="letras_blancas">2013</div></td>
    <td><div align="center" class="letras_blancas">2013</div></td>
    <td><div align="center" class="letras_blancas">2014</div></td>
    <td><div align="center" class="letras_blancas">2014</div></td>
    <td><div align="center" class="letras_blancas">2014</div></td>
    <td class="letras_blancas"><div align="center"><span class="letras_blancas">Patrimonio</span></div></td>
    <td bgcolor="#006600"><div align="center" class="letras_blancas">Patrimonio</div></td>
    <td><div align="center" class="letras_blancas">Crecimiento Activo</div></td>
    <td><div align="center" class="letras_blancas">Crecimiento de Activos</div></td>
    <td><div align="center"><span class="letras_blancas">Riesgo</span></div></td>
  </tr>
  <?php

$aa=1;	} 
//fin de repetir
   
   }} //end the cycle ?>
  <tr>
    <td colspan="15" bgcolor="#0000FF">&nbsp;</td>
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
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php if($generar_alertas == 1 or $generar_informe == 1 ){ 
  
 if($generar_alertas == 1){ ?> 
  <script language="JavaScript">
  var a=<?php echo $alerta ?>;
alert (" !! Ya fueron generadas las alertas !!  " + a);		
</script>
<?php } 
if($generar_informe == 1 ){
?>
<script language="JavaScript">
  var a=<?php echo $alerta ?>;
alert (" !! Ya fueron generadas el informe !!  " + a );	
	
</script>

 <?php } 
  
  ?>
</table><table width="25%" border="1" align="center" cellspacing="10">
  <tr>
    <td><div align="center" class="letras_azules">Total de Alertas <?php echo $alerta ?></div></td>
  </tr>
</table>

<table width="25%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td id="ver"><div align="center"><a href="reporte_empleados_analisis-PDF.php" target="_blank">
      
      <img src="../Imagenes/print-icon-nor.png" alt="" name="impre" width="64" height="64" border="0" id="impre" /></br>
    Imprimir</a></div></td>
  </tr>
</table>
<?php } ?>

</body>
</html>