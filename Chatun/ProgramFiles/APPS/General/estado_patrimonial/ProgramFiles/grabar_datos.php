<?php
include("../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../Script/cambiofecha.php");
	$auxi=$_SESSION["iduser"];
	$cuenta_llevar = $_POST["cuenta_llevar"];
	$tipo_documento = $_POST["tipo_documento"];
	$no_orden = $_POST["no_orden"];
	$no_identificacion = $_POST["no_identificacion"];
	$ext1 = $_POST["ext"];
	$pais = $_POST["pais"];
	$depto1 = $_POST["region"];
	$lugar_nacimiento = $_POST["country"];
	$nit = $_POST["nit"];
	$igss = $_POST["igss"];
	$nombre1 = $_POST["nombre1"];
	$nombre2 = $_POST["nombre2"];
	$nombre3 = $_POST["nombre3"];
	$apellido1 = $_POST["apellido1"];
	$apellido2 = $_POST["apellido2"];
	$apellidocasada = $_POST["apellidocasada"];
	$estado_civil = $_POST["estado_civil"];
	$TipoSangre = $_POST["TipoSangre"];
	$no_hijos = $_POST["no_hijos"];
	$sexo = $_POST["sexo"];
	 
	$fecha_iniciolabores = $_POST["fecha_iniciolabores"];
	$fecha_reiniciolabores = $_POST["fecha_reiniciolabores"];
	$fecha_retirolabores = $_POST["fecha_retirolabores"];
	$puesto_origen = $_POST["puesto_origen"];
	$dias_pagados = $_POST["dias_pagados"];
	$dias_trabajados = $_POST["dias_trabajados"];
	$jornada = $_POST["jornada"];
	$horas_ordinarias = $_POST["horas_ordinarias"];
	$salario_ordinario = $_POST["salario_ordinario"];
	$total_horasextras = $_POST["total_horasextras"];
	$salario_extraordinario = $_POST["salario_extraordinario"];
	$aguinaldo = $_POST["aguinaldo"];
	$bono14 = $_POST["bono14"];
	$comisiones = $_POST["comisiones"];
	$otros_pagos = $_POST["otros_pagos"];
	$nivel_academico = $_POST["nivel_academico"];
	$profesion = $_POST["profesion"];
	$etnia = $_POST["etnia"];
	$idiomas = $_POST["idiomas"];
	$permisos_trabajo = $_POST["permisos_trabajo"];
	$tipo_contrato = $_POST["tipo_contrato"];
	$correo_electronico = $_POST["correo_electronico"];
	$direccion = $_POST["direccion"];
	$telefono = $_POST["telefono"];
	$celular = $_POST["celular"];
	$nombre_conyuge = $_POST["nombre_conyuge"];
	$documento_completo_identificacion = $no_orden.$no_identificacion;
	$nit = str_replace('-','',$nit);
	$igss = str_replace('-','',$igss);
	$documento_completo_identificacion = str_replace(' ','',$documento_completo_identificacion);
	$documento_completo_identificacion = str_replace('-','',$documento_completo_identificacion);
	$propiedad = $_POST["propiedad_inmueble"];
	$fecha_nacimiento = $_POST["fecha_nacimiento"];
	$FormaGrabar = $_POST["FormaGrabar"];


     //Obtener el nombre temporal del archivo
	$tmpFilePath = $_FILES['FotoCedula']['tmp_name'];

        //Asegurarse que existe el nombre temporal
	if ($tmpFilePath != "")
	{
            //Bloque de código para darle surir el archivo
            //Bloque para saber la extensión del archivo
		$archivo = basename( $_FILES['FotoCedula']['name']); 
		$trozos = explode(".", $archivo); 
		$extension = end($trozos);    

            //Darle la ruta y el nombre al archivo a guardar
		$newFilePath = "files/";
		$newFilePath = $newFilePath . uniqid('file_') . '.' . $extension;

        //Subir el Archivo
        if(move_uploaded_file($tmpFilePath, $newFilePath)) //Comprobar si no existe un error en la subida
        {
            //Query para almacenar el path del archivo que se acaba de subir en la base de datos
           	$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.fotografia_colaborador (FC_RUTA, FC_TIPO, FC_COLABORADOR) 
            		VALUES ('". $newFilePath ."', 1, ".$cuenta_llevar.")");

            if(!$sql) //Comprobar si existió algún error en la transacción anterior
            {
               	
            }
        }
        else //Comprobar si existió un error en la subida
        {
            
        }
    }

     //Obtener el nombre temporal del archivo
	$tmpFilePath = $_FILES['FotoCuerpoCompleto']['tmp_name'];

        //Asegurarse que existe el nombre temporal
	if ($tmpFilePath != "")
	{
            //Bloque de código para darle surir el archivo
            //Bloque para saber la extensión del archivo
		$archivo = basename( $_FILES['FotoCuerpoCompleto']['name']); 
		$trozos = explode(".", $archivo); 
		$extension = end($trozos);    

            //Darle la ruta y el nombre al archivo a guardar
		$newFilePath = "files/";
		$newFilePath = $newFilePath . uniqid('file_') . '.' . $extension;

        //Subir el Archivo
        if(move_uploaded_file($tmpFilePath, $newFilePath)) //Comprobar si no existe un error en la subida
        {
            //Query para almacenar el path del archivo que se acaba de subir en la base de datos
           	$sql = mysqli_query($db, "INSERT INTO Estado_Patrimonial.fotografia_colaborador (FC_RUTA, FC_TIPO, FC_COLABORADOR) 
            		VALUES ('". $newFilePath ."', 2, ".$cuenta_llevar.")");

            if(!$sql) //Comprobar si existió algún error en la transacción anterior
            {
               	
            }
        }
        else //Comprobar si existió un error en la subida
        {
            
        }
    }


	
	

  	$query = "INSERT INTO Estado_Patrimonial.empleados (id, TipoDocumentoIdentificacion, DocumentoIdentificacion, extendida, PaisOrigen, depto, LugarNacimiento, NitEmpleado, IgssEmpleado, Nombre1, Nombre2, Nombre3, Apellido1, Apellido2, EstadoCivil, NumeroHijos, Sexo, FechaNacimiento, FechaInicioLabores, FechaReinicioLabores, FechaRetiroLabores, Puesto, DiasPagadosAno, DiasTrabajadosAno, Jornada, HorasOrdinariasTrabajadasDia, SalarioOrdinarioAnual, TotalHorasExtras, SalarioExtraOrdinario, Aguinaldo, Bono14, Comisiones, OtrosPagos, NivelAcademico, Profesion, Etnia, Idiomas, PermisoTrabajo, TipoContrato, Indemnizacion, Talla, Telefono, Direccion, email, ApellidoCasada, Nombre_conyuge, Celular, propiedad, TipoSangre) VALUES ('$cuenta_llevar', '$tipo_documento', '$documento_completo_identificacion',  '$ext1', '$pais', $depto1, $lugar_nacimiento, '$nit', '$igss', '$nombre1', '$nombre2', '$nombre3', '$apellido1', '$apellido2', '$estado_civil', '$no_hijos', '$sexo', '$fecha_nacimiento', '$fecha_iniciolabores', '$fecha_reiniciolabores', '$fecha_retirolabores', '$puesto_origen', '$dias_pagados', '$dias_trabajados', '$jornada', '$horas_ordinarias', '$salario_ordinario', '$total_horasextras', '$salario_extraordinario', '$aguinaldo', '$bono14', '$comisiones', '$otros_pagos', '$nivel_academico', '$profesion', '$etnia', '$idiomas', '$permisos_trabajo', '$tipo_contrato', '$indemnizacion', '$talla', '$telefono', '$direccion', '$correo_electronico', '$apellidocasada', '$nombre_conyugue', '$celular', '$propiedad', '$TipoSangre')";
	mysqli_query($db, $query);
	
	if (mysqli_errno() != "") {
		$actualizar = "UPDATE Estado_Patrimonial.empleados SET TipoDocumentoIdentificacion = '".$tipo_documento."', DocumentoIdentificacion = '".$documento_completo_identificacion."', extendida = '".$ext1."', PaisOrigen = '".$pais."', depto = '".$depto1."', LugarNacimiento = '".$lugar_nacimiento."', NitEmpleado = '".$nit."', IgssEmpleado = '".$igss."', Nombre1 = '".$nombre1."', Nombre2 = '".$nombre2."', Apellido1 = '".$apellido1."', Apellido2 = '".$apellido2."', EstadoCivil = '".$estado_civil."', NumeroHijos = '".$no_hijos."', Sexo = '".$sexo."', FechaNacimiento = '".$fecha_nacimiento."', FechaInicioLabores = '".$fecha_iniciolabores."', FechaReinicioLabores = '".$fecha_reiniciolabores."', FechaRetiroLabores = '".$fecha_retirolabores."', Puesto = '".$puesto_origen."', DiasPagadosAno = '".$dias_pagados."', DiasTrabajadosAno = '".$dias_trabajados."', Jornada = '".$jornada."', HorasOrdinariasTrabajadasDia = '".$horas_ordinarias."', SalarioOrdinarioAnual = '".$salario_ordinario."', TotalHorasExtras = '".$total_horasextras."', SalarioExtraOrdinario = '".$salario_extraordinario."', Aguinaldo = '".$aguinaldo."', Bono14 = '".$bono14."', Comisiones = '".$comisiones."', OtrosPagos = '".$otros_pagos."', NivelAcademico = '".$nivel_academico."', Profesion = '".$profesion."', Etnia = '".$etnia."', Idiomas = '".$idiomas."', PermisoTrabajo = '".$permisos_trabajo."', TipoContrato = '".$tipo_contrato."', Indemnizacion = '".$indemnizacion."', Talla = '".$talla."', Telefono = '".$telefono."', Direccion = '".$direccion."', email = '".$correo_electronico."', ApellidoCasada = '".$apellidocasada."', Nombre_conyuge = '".$nombre_conyuge."', Celular = '".$celular."', propiedad = '".$propiedad."', TipoSangre = '".$TipoSangre."'  WHERE id = '".$auxi."'";
	mysqli_query($db, $actualizar) or die (mysqli_error());
	}

	if($FormaGrabar == 1)
	{
		header ("Location: informacion_base.php");
	}
	elseif($FormaGrabar == 2)
	{
		header ("Location: estado_patrimonial.php");
	}
	
//*************************************************//
?>