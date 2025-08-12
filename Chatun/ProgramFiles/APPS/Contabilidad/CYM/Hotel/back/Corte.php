<?php 
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
include("../../../../Script/conex_a_coosajo.php");
include("../../../../Script/conex_sql_server.php");
include("../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");

$Insert = mysqli_query($db, "INSERT INTO Taquilla.CORTE_HOTEL (CH_Fecha, CH_Colaborador, CH_Estado) VALUES (CURRENT_TIMESTAMP, $id_user, 1)");
$IdCorte = mysqli_insert_id($db);
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
		<script src="../../../../js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../../../js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
	<script src="../../../../js/libs/bootstrap/bootstrap.min.js"></script>
	<script src="../../../../js/libs/spin.js/spin.min.js"></script>
	<script src="../../../../js/libs/autosize/jquery.autosize.min.js"></script>
	<script src="../../../../js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
	<script src="../../../../js/core/source/App.js"></script>
	<script src="../../../../js/core/source/AppNavigation.js"></script>
	<script src="../../../../js/core/source/AppOffcanvas.js"></script>
	<script src="../../../../js/core/source/AppCard.js"></script>
	<script src="../../../../js/core/source/AppForm.js"></script>
	<script src="../../../../js/core/source/AppNavSearch.js"></script>
	<script src="../../../../js/core/source/AppVendor.js"></script>
	<script src="../../../../js/core/demo/Demo.js"></script>
	<script src="../../../../js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
	<script src="../../../../libs/alertify/js/alertify.js"></script>
	<script src="../../../../js/libs/bootstrap-select/bootstrap-select.min.js"></script>
	<!-- END JAVASCRIPT -->

	<!-- BEGIN STYLESHEETS -->
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/libs/bootstrap-datepicker/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../libs/alertify/css/alertify.bootstrap.css"/>
	<link type="text/css" rel="stylesheet" href="../../../../js/libs/bootstrap-select/bootstrap-select.min.css"/>
	<!-- END STYLESHEETS -->

</head>
<body class="menubar-hoverable header-fixed menubar-pin">

	<?php include("../../../MenuTop.php") ?>

	<!-- BEGIN BASE-->
	<div id="base">

		<!-- BEGIN CONTENT-->
		<div id="content">
			<div class="container"><br>
				<form class="form" action="#"  id="FormCorte" role="form" >
					<input type="hidden" name="IdCorte" id="IdCorte" value="<?php echo $IdCorte ?>">
					<div class="col-lg-12"> 
						<div class="card">
							<div class="card-head style-primary">
								<h4 class="text-center"><strong>Fecha <?php echo $fechaHoy ?></strong></h4>
							</div>
							<div class="card-body">
								<!-- <div class="row">
									<div class="col-lg-5">
									  <div class="row">
									 	<div class="col-lg-3">
											Facturas
										</div> 	
										<div class="col-lg-3">
											 
										</div> 		
									   </div>
									   <div class="row">
									 	<div class="col-lg-3">
											Del
										</div> 	
										<div class="col-lg-3">
											Al
										</div> 
									 	<div class="col-lg-3">
											Total
										</div>								  		
									   </div>
									   <div class="row">
									 	<div class="col-lg-3">
											<input type="text" name="DelFac" id="DelFac" class="form-control">
										</div> 	
										<div class="col-lg-3">
											<input type="text" name="AlFac" id="AlFac" class="form-control" onblur="DiferenciaFac()">
										</div> 
									 	<div class="col-lg-3">
											<input type="text" name="TotalFac" id="TotalFac" class="form-control">
										</div>		 					  		
								   </div> -->
								   </div><br><br><br>
								  <div class="row">
								 	<div class="col-lg-12">
										<div id="Detalle"></div> 
									</div> 		
								   </div><br>
								   <div class="row">
								   	<div class="col-xs-8">
								   <div class="row">
									 	<div class="col-lg-3">
									 		Forma de Pago
										</div>
										<div class="col-lg-2">
									 		No.
										</div>
										<div class="col-lg-2">
									 		Cantidad
										</div>
										<div class="col-lg-5">
									 		Observaciones
										</div> 		
								   </div>
								   <div class="row">
									 	<div class="col-lg-3">
									 		EFECTIVO
										</div>
										<div class="col-lg-2">
									 		<input type="number" name="NoEfectivo" id="NoEfectivo" class="form-control">
										</div>
										<div class="col-lg-2">
									 		<input type="number" step=".00" value="0" onblur="Suma()" name="CantEfectivo" id="CantEfectivo" class="form-control">
										</div>
										<div class="col-lg-5">
									 		<input type="text" name="ObsEfectivo" id="ObsEfectivo" class="form-control">
										</div> 		
								   </div>
								   <div class="row">
									 	<div class="col-lg-3">
									 		CHEQUE
										</div>
										<div class="col-lg-2">
									 		<input type="number" name="NoCheque" id="NoCheque" class="form-control">
										</div>
										<div class="col-lg-2">
									 		<input type="number" step=".00" value="0" onblur="Suma()" name="CantCheque" id="CantCheque" class="form-control">
										</div>
										<div class="col-lg-5">
									 		<input type="text" name="ObsCheque" id="ObsCheque" class="form-control">
										</div> 		
								   </div>
								   <div class="row">
									 	<div class="col-lg-3">
									 		DEPÓSITO
										</div>
										<div class="col-lg-2">
									 		<input type="number" name="NoDeposito" id="NoDeposito" class="form-control">
										</div>
										<div class="col-lg-2">
									 		<input type="number" step=".00" value="0" onblur="Suma()" name="CantDeposito" id="CantDeposito" class="form-control">
										</div>
										<div class="col-lg-5">
									 		<input type="text" name="ObsDeposito" id="ObsDeposito" class="form-control">
										</div> 		
								   </div>
								   <div class="row">
									 	<div class="col-lg-3">
									 		TARJETAS
										</div>
										<div class="col-lg-2">
									 		<input type="number" name="NoTarjetas" id="NoTarjetas" class="form-control">
										</div>
										<div class="col-lg-2">
									 		<input type="number" step=".00" value="0" onblur="Suma()" name="CantTarjetas" id="CantTarjetas" class="form-control">
										</div>
										<div class="col-lg-5">
									 		<input type="text" name="ObsTarjetas" id="ObsTarjetas" class="form-control">
										</div> 		
								   </div>
								   <div class="row">
									 	<div class="col-lg-5">
									 		Total del día
										</div> 
										<div class="col-lg-2">
									 		<input type="text" name="TotalDia" id="TotalDia" class="form-control">
										</div> 		
								   </div><br><br>
								   <div class="row">
									 	<div class="col-lg-5">
									 		Recibido Por:
										</div> 
										<div class="col-lg-5">
									 		<select class="form-control selectpicker" required data-live-search="true"  id="Recibido" name="Recibido">
									 			<option>Seleccione</option>
									 			<?php 
									 			$DataRecibido = mysqli_query($db, "SELECT cif, Nombres FROM info_colaboradores.vista_colaboradores");
									 			while ($RowColaborador = mysqli_fetch_array($DataRecibido))
									 			{
									 			?>
									 			<option value="<?php echo $RowColaborador[cif]?>"><?php echo $RowColaborador[Nombres] ?></option>
									 			<?php 
									 			}
									 			?>
									 		</select>
										</div> 		
								   </div>
								   </div>
								   </div>
								   <div class="row">
								   	 <button type="button" class="btn ink-reaction btn-raised btn-primary" onclick="GuardarCorteHotel()">Guardar</button>
								   </div>
							</div>
						</div>
					</div> 
				</form>
			</div>
		</div>
	</div>

<div class="modal fade in" id="modalHoteles"  >
    <div class="modal-dialog modal-full-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Hotel</h4>
            </div> 
            <div class="modal-body"> 
            	<div id="divValesHotel"></div> 
            </div>
        </div>
    </div>
</div>
	 <?php include("MenuUsers.html"); ?>
	<!-- END BASE -->
	</body>
	</html>
<script>
	$(document).ready(function() {
  		Tabla();
  	});

var Contador = "<?php echo $Contador ?>";
  var tbl_filtrado =  { 
	mark_active_columns: true,
    highlight_keywords: true,
	filters_row_index: 1,
	paging: true,             //paginar 3 filas por pagina
    rows_counter: true,      //mostrar cantidad de filas
    rows_counter_text: "Registros: ", 
	page_text: "Página:",
    of_text: "de",
	btn_reset: true, 
    loader: true, 
    loader_html: "<img src='../../../../img/Preloader.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
	display_all_text: "-Todos-",
	results_per_page: ["# Filas por Página...",[10,25,50,100, Contador]],  
	btn_reset: true,
	col_0: "select",
	col_5: "select",
	col_6: "select",
  };
  var tf = setFilterGrid('TblTicketsHotel', tbl_filtrado);//fin opciones para tabla de productos

  $('#BtnExportarTicketHotel').click(function(event) {
			$('#TblTicketsHotel').tableExport({
				type:'excel',
				escape:'false', 
			});//fin funcion exportar
		});//fin funcion click

   function DiferenciaFac()
   {
   	var DelFac = $("#DelFac").val();
   	var AlFac = $("#AlFac").val();
   	var Total = (parseFloat(AlFac)-parseFloat(DelFac))+1;
   	$("#TotalFac").val(Total);
   }
  	
   function verHoteles()
    {
    	var IdCorte = '<?php echo $IdCorte ?>';
    	var Factura = $("#Factura").val();
        $.ajax({
            url: 'Ajax/DetalleVale.php',
            type: 'POST',
            dataType: 'html',
            data: {IdCorte:IdCorte, Factura:Factura},
            success: function(data)
            {
            	$("#modalHoteles").modal('show');
                $("#divValesHotel").html(data);
            }
        })
                
    }

    function GuardarCorteHotel()
    {
    	var TotalDia = $("#TotalDia").val();
    	var TotalCorte = $("#TotalCorte").val();
    	if (TotalDia==TotalCorte) 
    	{ 
    	var Id = '<?php echo $IdCorte?>';
    	var FormCorte = $("#FormCorte").serialize();
        $.ajax({
            url: 'Ajax/GuardarCorte.php',
            type: 'POST',
            dataType: 'html',
            data: FormCorte,
            success: function(data)
            {
             	if (data==1) 
             	{
             		window.location.href  = "ImprimirCorte.php?Id="+Id;
             	}
            }
        })
    	}
    	else
    	{
    		alertify.error("No cuadran los Totales");
    	}
                
    }

    function Tabla()
    { 
    	var IdCorte = '<?php echo $IdCorte ?>';
        $.ajax({
            url: 'Ajax/DetalleCorte.php',
            type: 'POST',
            dataType: 'html',
            data: {IdCorte:IdCorte},
            success: function(data)
            { 
                $("#Detalle").html(data);
            }
        })
                
    }

    function Suma()
    {
    	var CantEfectivo = $("#CantEfectivo").val();
		var CantCheque = $("#CantCheque").val();
		var CantDeposito = $("#CantDeposito").val();
		var CantTarjetas = $("#CantTarjetas").val();

		var Suma = parseFloat(CantTarjetas) + parseFloat(CantDeposito) + parseFloat(CantCheque) + parseFloat(CantEfectivo);
		$("#TotalDia").val(Suma);
 
    }
</script>
</html>
