<?php
	$conexion = new mysqli("localhost","root","redhat12","info_base",3306);

	$strConsulta = "select id_gerencia, gerencia from gerencia";
	$result = $conexion->query($strConsulta);
	$opciones = '<option value="0"> Elige una Gerencia</option>';
	while( $fila = $result->fetch_array() )
	{
		$opciones.='<option value="'.$fila["id_gerencia"].'">'.$fila["gerencia"].'</option>';
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Selects combinados JQuery + Ajax + PHP + MySQL</title>
		<script type="text/javascript" src="../../../Script/jquery.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#gerencia").change(function(){
					alert($("#gerencia").val());
					$.ajax({
						url:"procesa.php",
						type: "POST",
						data:"iddatos="+$("#gerencia").val(),
						success: function(opciones){
							$("#departamento").html(opciones);
						}
					})
				});
			});
		</script>
    </head>
    <body>
		<div> Selects combinados </div>
	<div> <label> Gerencia:</label> <select id="gerencia"><?php echo $opciones; ?></select>  
	</div>
		<div>
			<label> Departamento:</label>
			<select id="departamento">
				<option value="0">Elige un departamento</option>
			</select>
		</div>

    </body>
</html>
