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
<?PHP  

$id_solicitud = $_GET['id'];
$sql_verificar = "SELECT * FROM coosajo_educacion_cooperativa.solicitud_capacitaciones WHERE id ='$id_solicitud'";
	$result_verificar=mysql_query($sql_verificar,$db);
	$array_1=mysql_fetch_array($result_verificar);
	$no_asistentes = $array_1["no_asistentes"];	
	
	
	


?>     
		 
<body >
	
<div class="jumbotron" align="center">
  <h2>SOLICITUD DE REQUERIMIENTOS</h2>
 </div>
 
<form action="grabar_capacitaciones_aprobacion.php?accion=1&id_solicitud=<?PHP echo $id_solicitud ?>" method="post" name="form1" id="form1">
 
 <table width="*" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td colspan="4" align="center" bgcolor="#3EB33C"><strong><font color="#FFFFFF" >SOLICITUD DE CAPACITACIONES</font></strong></td>
    </tr>
    <tr>
      <td>&nbsp;</td> 
      <td> 
     
     
					<h4>	No. de Asistentes Adultos </h4>
					
                    
                    </td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="no_asistentes" id="no_asistentes" value="<?PHP echo $array_1["no_asistentes"];	 ?>" />
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
      <td> 
     
     
					<h4>	No. de Asistentes Niños </h4>
					
                    
                    </td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="no_asistentes" id="no_asistentes" value="<?PHP echo $array_1["no_ninos"];	 ?>" />
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
      <td><h4>	Tipo de Evento </h4></td>
      <td>
       <div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP echo $array_1["tipo_evento"];	 ?>" />
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
      <td><h4>	Tipo de Montaje</h4></td>
      <td>
       <div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP
	  
	   $tipo_montaje = $array_1["tipo_montaje"];
	   if($tipo_montaje == '1'){
		   echo "Tipo Universidad";
	   } 
	   if($tipo_montaje == '2'){
		   echo "Tipo Imperio";
	   }
	   if($tipo_montaje == '3'){
		   echo "Tipo Dialogo";
	   }
	   	 ?>" />
					</div>
                    	</div>
      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td> 
     
     
					<h4>	Observaciones </h4>
					
                    
                    </td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="no_asistentes" id="no_asistentes" value="<?PHP echo $array_1["observaciones_montaje"];	 ?>" />
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
      <td><h4>	Solicitud de Sonido </h4></td>
      <td>
      
      <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP $sonido = $array_1["sonido"];
	  if($sonido == '1'){
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
       <td> 
     
     
					<h4>	Observaciones </h4>
					
                    
                    </td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="no_asistentes" id="no_asistentes" value="<?PHP echo $array_1["observaciones_sonido"];	 ?>" />
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
      <td><h4>	Manteleria y Cristaleria </h4></td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP $manteleria = $array_1["manteleria"];
	  if($manteleria == '1'){
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
     <td> 
     
     
					<h4>	Observaciones </h4>
					
                    
                    </td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-40">
	  <input type="text" class="form-control" name="no_asistentes" id="no_asistentes" value="<?PHP echo $array_1["observaciones_manteleria"];	 ?>" />
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
      <td><h4>	Comida </h4></td>
      <td>
      <div class="form-group"  align="rigth">
      <div class="col-sm-5">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP $comida = $array_1["comida"];
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      <label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="desayuno" value="1" 
  <?PHP $desayuno = $array_1["desayuno"];
	  if($desayuno == '1'){
		  echo "checked";
	  } ?>
  > Desayuno
</label>
<label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="refaccion_am" value="1" 
  <?PHP $refa_am = $array_1["refaccion_am"];
	  if($refa_am == '1'){
		  echo "checked";
	  } ?>> Refaccion A.M.
</label>
<label class="checkbox-inline"><label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="refaccion_am" value="1"
  <?PHP $cena = $array_1["cena"];
	  if($cena == '1'){
		  echo "checked";
	  } ?>> Cena
</label></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      <input type="checkbox" id="checkboxEnLinea1" name="almuerzo" value="1" 
      <?PHP $almuerzo = $array_1["almuerzo"];
	  if($almuerzo == '1'){
		  echo "checked";
	  } ?> > Almuerzo   
</label>
      <label class="checkbox-inline">
  <input type="checkbox" id="checkboxEnLinea1" name="refaccion_pm" value="1"
  <?PHP $refaccion_pm = $array_1["refaccion_pm"];
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
      <td><h4>	Fecha de la Capacitacion </h4></td>
      <td>
      
      <div class="form-group"  align="rigth">
      <div class="col-sm-10">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP echo cambio_fecha($array_1["fecha_capacitacion"]) ?>" />
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
      <td><h4>	Hora de la Capacitacion </h4></td>
      <td>	
<div class="form-group"  align="rigth">
      <div class="col-sm-8">
	  <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP echo $array_1["hora_capacitacion"]." "."Horas"; ?>" />
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
      <td><h4>	Duracion del Evento </h4></td>
      <td>
        <div class="form-group"  align="rigth">
          <div class="col-sm-10">
            <input type="text" class="form-control" name="tipo_evento" id="tipo_evento" value="<?PHP echo $array_1["duracion_evento"] ?>" />
            </div>   
          </div>
        
        </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2" rowspan="4" align="center">
        
             
        <div class="form-group">
          <h4>	observaciones </h4>
          <textarea class="form-control" rows="5" id="comentario" name="comentario" disabled><?PHP echo $array_1["observaciones"] ?></textarea>
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
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
      <div style="position:absolute; top:100px; left:100px; width:200px; background-color:#D5D4D4">
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
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
      <td colspan="2" rowspan="4" align="center">
      
      
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
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#CBCACA">
      <td>&nbsp;</td>
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
    </div>
  </tbody>
</table>
</form>  
    
    
    
    
     
  <?PHP
if($alertar == '1'){ ?>
<script>
alertify.success('<h4><font color="white">Guardado Correctamente... </font> </h4>' );
</script>	
<?PHP 
}
?>  

<?PHP
if($alertar == '2'){ ?>
<script>
alertify.error('<h3><font color="white">Error... </font> </h3>' );
</script>	
<?PHP 
}
?>
</body>


</html>