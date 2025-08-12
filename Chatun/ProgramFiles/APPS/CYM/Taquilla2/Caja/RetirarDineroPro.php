<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Portal Institucional Chatún</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/wizard/wizard.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<!-- END STYLESHEETS -->



    
</head>
<body class="menubar-hoverable header-fixed menubar-pin " onload="Imprimir()">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
		<?php
        $Cod = uniqid("RET_");
        $Monto         = $_POST["MontoInicial"];
        $Usuario        = $_POST["UsuarioContabiliza"];
        $punto        = "Taquilla #2";
        
        $query = mysqli_query($db, "INSERT INTO Bodega.RETIRO_DINERO (RD_CODIGO, RD_FECHA, RD_USUARIO, RD_PUNTO, RD_MONTO)
											VALUES('".$Cod."', CURRENT_DATE(), '".$Usuario."', '".$punto."', '".$Monto."')");
        if(!$query)
			{
				echo 'ERROR EN INGRESO DE SOLICITUD';
				
			}else{

                $sql = mysqli_query($db,"SELECT A.nombre 
                FROM info_bbdd.usuarios AS A     
                WHERE A.id_user = ".$Usuario); 
                $row=mysqli_fetch_array($sql);

                $Nombre=$row["nombre"];

    
                echo '<div class="col-lg-12 text-center">
                        <h1><span class="text-xxxl text-light">Bien! <i class="fa fa-check-circle text-success"></i></span></h1>
                        <h2 class="text-light">El Retiro se Hizo Correctamente.</h2>
                        
                        <h2 class="text-light">Codigo: '.$Cod.'</h2>
                        <h2 class="text-light">Monto: '.$Monto.'</h2>
                        <h2 class="text-light">Retiro: '."$Nombre".'</h2>
                        ';
                        


                    }

        ?>
        <div>
        <a href="<?php echo 'ImpRetiro.php?Codigo='.$Cod ?>">
                                <button type="button" class="btn btn-success btn-lg">
                                    <span class="glyphicon glyphicon-ok-sign"></span> Imprimir
                                </button>
                            </a>
                            
        
        </div>

<?php include("../MenuUsers.html"); ?>
        </div>
    </div>
</body>
</html>


