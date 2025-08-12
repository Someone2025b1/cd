<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$Id = mysqli_fetch_array(mysqli_query($db, "SELECT a.Id, a.Fecha FROM Bodega.LIMPIEZA_TILAPIA a ORDER BY a.Id DESC LIMIT 1"));
$IdLimp = $Id["Id"];
$Fecha = $Id["Fecha"];
//ingreso fotografia peces mortalidad
$filename = $_FILES['file']['name']; 
$AnioActual = date('Y');
$MesActual 	= date('m');
$carpeta_anual = 'ProductoDaniado/'.$AnioActual; 

if (!file_exists($carpeta_anual)) 
{ 
	mkdir($carpeta_anual, 0777, true);
} 
	//////////// CREAR CARPETAS POR DEPARTAMENTOS //////////////////
 $carpeta_mensual = 'ProductoDaniado/'.$AnioActual.'/'.$MesActual;	  
if (!file_exists($carpeta_mensual)) 
{  
	mkdir($carpeta_mensual,  0777, true);
} 
	  	
$return1 = Array('ok'=>TRUE);
$upload_folder  = $carpeta_mensual; 
$archivador     = $upload_folder."/".$IdLimp."-".$filename;
$archivoBBDD = $filename;
 
if(copy($_FILES["file"]["tmp_name"], $archivador))
{ //Copio el archivo de la carpeta temporal a la ubicación.
	$NameA = $IdLimp."-".$filename;
   $SQL_INSERT_ARCH = mysqli_query($db, "INSERT INTO Bodega.ARCHIVOS_MORTALIDAD (IdControl, Nombre, Tipo, Fecha) 
   VALUES ($IdLimp, '$NameA', 2, '$Fecha')"); 
}
  
	?>