<?php
include("../Script/seguridad.php");
include("../Script/conex.php");
include("../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$base_general = 'info_base';
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
		<link type="text/css" rel="stylesheet" href="../css/theme-4/bootstrap.css" />
		<link type="text/css" rel="stylesheet" href="../css/theme-4/materialadmin.css" />
		<link type="text/css" rel="stylesheet" href="../css/theme-4/font-awesome.min.css" />
		<link type="text/css" rel="stylesheet" href="../css/theme-4/material-design-iconic-font.min.css" />
		<!-- END STYLESHEETS -->
	</head>
	<body class="menubar-hoverable header-fixed menubar-pin ">

		<?php include("MenuTop.php") ?>
<div id="main-wrapper">
	<div class="container-fluid"><br><br><br> 
                                        <div class="row">
                                        <div class="col-lg-8">
                                        	<div class="form-group">
											 <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="Buscar un aplicativo..">
											</div>
                                        </div> 
                                            <div class="col-lg-12">
                                            <table >
                                                <thead>
                                                    <tr>
                                                        <th data-sortable="false" data-field="APLICATIVOS0"></th>
                                                        <th data-sortable="false" data-field="APLICATIVOS1"></th>
                                                        <th data-sortable="false" data-field="APLICATIVOS2"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                    $ContadorX = 0;
                                                        $Sql_Aplicativos = mysqli_query($db, "SELECT a.nombre, a.icono, a.link, a.id_aplicacion FROM info_bbdd.aplicaciones_agg a 
														INNER JOIN info_bbdd.permisos_app b ON b.id_aplicacion = a.id_aplicacion 
														WHERE b.id_user = $id_user AND b.estado = 1");
                                                        while($Fila_Aplicativos = mysqli_fetch_array($Sql_Aplicativos))
                                                        {  
                                                            if($ContadorX == 0)
                                                            {
                                                                ?>
                                                                <tr>
                                                                <?php
                                                            }
                                                            $Icono = "APPS/IDT/Imagenes/Aplicaciones/".$Fila_Aplicativos['icono'];
                                                            $Link = "APPS/".$Fila_Aplicativos['link'];
                                                            ?>                       
                                                                <td style="width:500px">
                                                                    <div class="col-lg-12">
                                                                        <a href="<?php echo $Link ?>">
                                                                            <div class="card">
                                                                            
                                                                                <div class="bg-info text-center">
                                                                                    <img src="<?php echo $Icono ?>" height="100px" width="100px">
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <button type="button" class="btn-sm btn <?php echo $ClaseFavorito ?> btn-circle pull-right" onclick="MarcarFavorito(this)" value="<?php echo $Fila_Aplicativos['nombre'] ?>"><i class="fa fa-star"></i> </button>
                                                                                    <h4 class="font-normal text-center"><?php echo $Fila_Aplicativos['nombre'] ?></h4> 
                                                                                </div>
                                                                            
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </td>                                                                
                                                            <?php
                                                            if($ContadorX == 4)
                                                            {
                                                                ?>
                                                                </tr>
                                                                <?php
                                                                $ContadorX = 0;
                                                            }
                                                            else
                                                            {
                                                                $ContadorX++;
                                                            }
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>
                                            </div>
                                   </div>   
</div>
</div>


		<!-- BEGIN JAVASCRIPT -->
		<script src="../js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../js/libs/spin.js/spin.min.js"></script>
		<script src="../js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../js/core/source/App.js"></script>
		<script src="../js/core/source/AppNavigation.js"></script>
		<script src="../js/core/source/AppOffcanvas.js"></script>
		<script src="../js/core/source/AppCard.js"></script>
		<script src="../js/core/source/AppForm.js"></script>
		<script src="../js/core/source/AppNavSearch.js"></script>
		<script src="../js/core/source/AppVendor.js"></script>
		<script src="../js/core/demo/Demo.js"></script>
		<!-- END JAVASCRIPT -->
		<script>
		 // Write on keyup event of keyword input element
		 $(document).ready(function(){
		 $("#search").keyup(function(){
		 _this = this;
		 // Show only matching TR, hide rest of them
		 $.each($("#mytable tbody tr"), function() {
		 if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
		 $(this).hide();
		 else
		 $(this).show();
		 });
		 });
		});
		</script>
	</body>
</html>
