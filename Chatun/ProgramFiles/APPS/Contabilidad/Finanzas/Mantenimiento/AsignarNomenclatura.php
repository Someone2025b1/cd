<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/funciones.php");
include("../../../../../Script/httpful.phar");
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

	<!-- BEGIN JAVASCRIPT -->
	<script src="../../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../../js/core/source/App.js"></script>
	<script src="../../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <script src="../../../../../libs/alertify/js/alertify.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../../css/jquery-ui.css" />
    <!-- END STYLESHEETS -->
    <script>
    function AgregarNomenclatura(Id, TIT)
	{
		$.ajax({
			url: 'Ajax/ModificarNomenclatura.php',
			type: 'POST',
			dataType: 'html',
			data: {Id: Id, TIT: TIT},
			success:function(data)
			{
				if (data==1) 
				{
                    var TIT1 = $("#TIT").val();
                    ListadoAplicacion(TIT1);
				}
			}			
		});		
	}
    </script>
<style>
	.filtro{
    display: none;
}

input{
    width: 90%;
    padding: 5px;
    outline: none;
    border: 3px solid #0d5906;
    font-weight: 200;
	border-radius: 20px;
	text-align: center;
}
</style>
</head>
<body class="menubar-hoverable header-fixed menubar-pin ">

	<?php include("../../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<div id="content">
		<?php
        $NombreTitulo         = $_GET["Titulo"];
        
        $titulo = mysqli_query($db, "SELECT T_CODIGO, T_NOMBRE FROM Finanzas.TITULO
											WHERE TITULO.T_NOMBRE='$NombreTitulo'");
        while($row = mysqli_fetch_array($titulo))
        {
            $CodTitulo=$row["T_CODIGO"];
            $NomTitulo=$row["T_NOMBRE"];
			?>
            <form>
				<div style="margin: 3em;
							height: 4em;
							position: sticky;
							top:20px;
							">
			<div class="card" >
			<div class="card-head style-primary">
				<h4 class="text-center" ><strong>Datos del Titulo</strong></h4>
				</div>				
            <div class="col-lg-12 text-center" style="position: sticky;">  
            
            <label class="text-center">Codigo Titulo: <input class="form-control" type="number" name="TIT" id="TIT" min="0" value="<?php echo $CodTitulo;?>" required readonly/></label>  
            </div>
			<div class="col-lg-12 text-center">
			<label class="text-center">Nombre Titulo: <input class="form-control" type="text" name="Nombre" id="Nombre"  value="<?php echo $NomTitulo;?>" required readonly/></label>  
			</div>
            </div>
			</div>
			
            <?php
                    }

        ?>
            <div class="col-lg-12">
							<div class="card" >
								<div class="card-head style-primary" >
									<h4 class="text-center"><strong>SELECCIONE NOMECALTURAS</strong></h4>
								</div>
								<div class="card-body">
									<div class="row">
										<div id="ListadoNomenclaturas"></div>
									</div>
								</div>
							</div>
						</div>
            </form>



        

<?php include("../MenuUsers.html"); ?>
        </div>
    </div>
</body>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		var TIT = $("#TIT").val();
		ListadoAplicacion(TIT);
	});

	function ListadoAplicacion(TIT)
	{
		$.ajax({
			url: 'Ajax/AsignarNomenclaturaAU.php',
			type: 'POST',
			dataType: 'html',
			data: {TIT: TIT},
			success:function(data)
			{
				$("#ListadoNomenclaturas").html(data);
			}
		})  
	}
</script>

<script>
	document.addEventListener("keyup", e=>{

if (e.target.matches("#Buscador")){

	if (e.key ==="Escape")e.target.value = ""

	document.querySelectorAll(".buscar").forEach(nomenclatura =>{

		nomenclatura.textContent.toLowerCase().includes(e.target.value.toLowerCase())
		  ?nomenclatura.classList.remove("filtro")
		  :nomenclatura.classList.add("filtro")
	})

}


})
	</script>
</html>
