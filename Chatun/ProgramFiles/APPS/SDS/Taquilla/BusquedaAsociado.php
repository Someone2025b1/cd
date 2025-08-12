<?php 
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/conex_a_coosajo.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];

$buscador = $_POST['buscador'];

if(is_numeric($buscador))
	{
		$prestamo = mysql_query("select cifcodcliente, cifnombreclie, cifdocident02, cifsexo, cifdocident06  from bankworks.cif_generales where cifcodcliente = $buscador", $dbc) or die("error en buscar cif en condiciones diarias".mysql_error());

		if(mysql_num_rows($prestamo) < 1)
			{
				$prestamo = mysql_query("select cifcodcliente, cifnombreclie, cifdocident02, cifsexo, cifdocident06  from bankworks.cif_generales where cifdocident06 = $buscador", $dbc);
			}//fin if mysql_num_rows
				while($prestamo_result = mysql_fetch_array($prestamo)){
					$data['cif_asociado'] = $prestamo_result['cifcodcliente'];
					$data['nombre_asociado'] = $prestamo_result['cifnombreclie'];
					$data['nit_asociado'] = $prestamo_result['cifdocident02'];
					$data['dpi_asociado'] = $prestamo_result['cifdocident06'];
				}
				echo json_encode($data);

	}//fin is numeric
	else
	{
	 //	echo '{data: 1}';
		$buscador = str_replace(' ', '%', $buscador);

 		$prestamo = mysql_query("select cifcodcliente, cifnombreclie, cifdocident02, cifsexo, cifdocident06  from bankworks.cif_generales as t where t.cifnombreclie like '%$buscador%' ", $dbc);

 		if(mysql_num_rows($prestamo) > 0)
 		{
 		
		while($row = mysql_fetch_array($prestamo)) 
			{
			 echo $cif_asociado = $row['cifcodcliente'];
			  $nombre_asociado = $row['cifnombreclie'];
			  $dpi_asociado = $row['cifdocident06'];
			}			
 			
 		}// fin if mysql_numrows
 	}//fin else


 ?>
