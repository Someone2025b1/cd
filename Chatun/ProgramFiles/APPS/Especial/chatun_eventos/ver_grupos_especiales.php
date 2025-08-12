<?php 
header('Content-Type: text/html; charset=utf-8');
include("../../../../Script/seguridad.php");
include("conex.php");
include("funciones.php");

session_start();
$iduser = $_SESSION["iduser"];
$hoy = date('Y-m-d');
$alertar = $_GET['alerta'];

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet"  href="bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="alertify/css/alertify.css"/>
 	

<script src="jQuery-2.0.0/jQuery-2.0.0.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="alertify/js/alertify.min.js"></script>

<meta charset="UTF-8">

</head>
</head>
<?php  

$id_solicitud = $_GET['id'];
$sql_verificar = "SELECT * FROM coosajo_educacion_cooperativa.solicitud_grupos_especiales WHERE id ='$id_solicitud'";
	$result_verificar=mysql_query($sql_verificar,$db);
	$array_1=mysql_fetch_array($result_verificar);
	$no_asistentes = $array_1["no_asistentes"];	

?>  
	

		 
<body >
	      
<div class="jumbotron" align="center">
  <h2>SOLICITUD DE REQUERIMIENTOS</h2>
 </div>
 
<form action="grabar_grupos_especiales_aprobacion.php?accion=1&id_solicitud=<?php echo $id_solicitud ?>" method="post" name="form1" id="form1">
 
 <table width="*" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td colspan="4" align="center" bgcolor="#3EB33C"><strong><font color="#FFFFFF" >SOLICITUD DE INGRESO DE GRUPOS ESPECIALES</font></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td>      
      <td>            
        
     
					<h4>	No. de Asistentes Adultos</h4>
					
                    
                    </td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="no_asistentes" id="no_asistentes" value="<?php echo  $array_1["no_asistentes"]; ?>" />
					</div>
                    	</div>
      
      </td>
      <td>&nbsp;</td>  
    </tr>   
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><h4>	No. de Asistentes Ninos</h4></td>
      <td>
       <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="no_asistentes" id="no_asistentes" value="<?php echo  $array_1["no_ninos"]; ?>" />
					</div>
                    	</div>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><h4>	Responsable del Grupo </h4></td>
      <td>
       <div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="responsable_grupo" id="responsable_grupo"  value="<?php echo  $array_1["responsable_grupo"]; ?>" />
					</div>
                    	</div>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><h4>	Telefono del Responsable </h4></td>
      <td> <div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="responsable_grupo" id="responsable_grupo"  value="<?php echo  $array_1["telefono_responsable"]; ?>" />
					</div>
                    	</div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><h4>	Comida </h4></td>
      <td>
         <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?php $comida = $array_1["comida"];
	  if($comida == '1'){
		  echo "Si";
	  } else {
		  echo "No";
	  }
	  
	  	 ?>" />
					</div>
                    	</div>
      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      <label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="desayuno" value="1" 
  <?php $desayuno = $array_1["desayuno"];
	  if($comida == '1'){
		  echo "checked";
	  } ?>
  > Desayuno
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="refaccion_am" value="1" 
  <?php $refa_am = $array_1["refaccion_am"];
	  if($refa_am == '1'){
		  echo "checked";
	  } ?>> Refaccion A.M.
</label>
<label class="checkbox-inline"><label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="refaccion_am" value="1"
  <?php $cena = $array_1["cena"];
	  if($cena == '1'){
		  echo "checked";
	  } ?>> Cena
</label>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      <input type="checkbox" id="checkboxEnLinea1" name="almuerzo" value="1" 
      <?php $almuerzo = $array_1["almuerzo"];
	  if($almuerzo == '1'){
		  echo "checked";
	  } ?> > Almuerzo   
</label>
      <label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="refaccion_pm" value="1"
  <?php $refaccion_pm = $array_1["refaccion_pm"];
	  if($refaccion_pm == '1'){
		  echo "checked";
	  } ?>> Refaccion P.M.
</label>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
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
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><h4>	Responsable de la Solicitud </h4></td>
      <td><div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="responsable_solicitud" id="responsable_solicitud"   value="<?php
	$cif_solicitante1 = $array_1["responsable_solicitud"];
	
	
	$usuario1 = mysql_query("select Nombres From info_colaboradores.vista_colaboradores_activos where cif = '$cif_solicitante1'", $db);
	$info_usuario_result1 = mysql_fetch_array($usuario1);
	echo $nombre_solicitante1 = utf8_encode($info_usuario_result1[Nombres]);
	
	?>" />
					</div>
                    	</div></td>
      <td>&nbsp;</td>
    </tr>
    <tr>  
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><h4>	Fecha </h4></td>  
      <td>
      <input type="text" name="fecha" id="fecha"   value="<?php echo  cambio_fecha($array_1["fecha"]); ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><h4>	Hora Estimada de Llegada </h4></td>
      <td>	
<input type="time" name="hora"   value="<?php echo  $array_1["hora_llegada"]; ?>"></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
       <td><h4>	Archivo Subido </h4></td>
      <td>
      <?php
	  
      $sql_archivo = "SELECT * FROM coosajo_educacion_cooperativa.archivos_grupos_especiales where no_solicitud = '$id_solicitud'";
	$result_archivo=mysql_query($sql_archivo,$db);
	$rw1=mysql_fetch_array($result_archivo);
	
	
	   ?>
      
      <a href="descar_archivos.php?id_desca=archivos/<?php echo $rw1["nombre_documento"]?>"><?php echo $rw1["nombre_documento"] ?></a></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>  
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" rowspan="3" align="center">
        
        
        <div class="form-group">
          <h4>	Observaciones </h4>
          <textarea class="form-control" rows="5" id="comentario2" name="comentario2" disabled><?php echo  $array_1["observaciones"] ?> </textarea>
          </div>
        
        
      </td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#CBCACA">
        
      <td>&nbsp;</td>
      <td><h4>	Aprobacion </h4></td>
      <td>
      <select id="aprobacion" name="aprobacion">
  <option value="" selected="selected">- Seleccionar -</option>
  <option value="1">Si</option>
  <option value="2">No</option>
  </select>
      
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
       <td><h4>	Costo de la Actividad </h4></td>
      <td> <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="costo_actividad" id="costo_actividad" />
					</div>   
                    	</div></td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
      <td><h4>	Observaciones del Costo </h4></td>
      <td><div class="form-group"  align="rigth">
      <div class="col-sm-10">
	  <input type="text" class="form-control" name="observaciones_costo" id="observaciones_costo" />
					</div>   
                    	</div></td>
      <td>&nbsp;</td>
      </tr>
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
      <td colspan="2" rowspan="2" align="center">
        
        
        <div class="form-group">
          <h4>	Comentario </h4>
          <textarea class="form-control" rows="5" id="comentario" name="comentario"></textarea>
  </div>
        
        
        </td>
      <td>&nbsp;</td>
      </tr>
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>    
      <td>&nbsp;</td>  
        
    </tr> 
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
      <td colspan="2" align="center">
      <button type="submit" class="btn btn-info">Enviar</button>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#CBCACA">    
      <td>&nbsp;</td>   
      <td>&nbsp;</td>        
      <td>&nbsp;</td>  
      <td>&nbsp;</td>   
    </tr>  
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>  
      <td>&nbsp;</td>     
      <td>&nbsp;</td>       
      <td>&nbsp;</td>         
    </tr>
  </tbody>
</table>  
</form>  
   
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