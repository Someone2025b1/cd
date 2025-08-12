<?php
include("../../../../Script/seguridad.php");
include("../../../../Script/conex.php");
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
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/bootstrap.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/materialadmin.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="../../../../css/theme-4/material-design-iconic-font.min.css" />
	<!-- END STYLESHEETS -->
</head>
<body class="menubar-hoverable header-fixed menubar-pin menubar-first">
	<!-- BEGIN MENUBAR-->
	<div id="menubar" class="menubar-inverse ">
		<div class="menubar-scroll-panel">

			<!-- BEGIN MAIN MENU -->
			<ul id="main-menu" class="gui-controls">

				<!-- BEGIN MANTENIMIENTO -->
				<!-- BEGIN MANTENIMIENTO -->
				<li class="gui-folder">
					<a href="Administracion.php?Codigo=<?php echo $_GET[Codigo] ?>">
						<div class="gui-icon"><i class="fa fa-list"></i></div>
						<span class="title">Menu</span>
					</a>
				</li><!--end /menu-li -->
				<li class="gui-folder">
					<a href="Administracion.php?Codigo=<?php echo $_GET[Codigo] ?>">
						<div class="gui-icon"><i class="fa fa-list-alt"></i></div>
						<span class="title">SubMenu</span>
					</a>
				</li><!--end /menu-li -->
			</ul><!--end .main-menu -->
			<!-- END MAIN MENU -->
		</div><!--end .menubar-scroll-panel-->
	</div><!--end #menubar-->
		<!-- END MENUBAR -->
	<div id="base">
			<div id="content">
				<div class="btn-group">
					<br>
				</div>
				<div class="card card-bordered style-primary">
					<div class="card-head text-center">
						<div class="tools">
							<div class="btn-group">
								<div class="btn-group">
									<a href="#" class="btn btn-icon-toggle dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-cog"></i></a>
									<ul class="dropdown-menu animation-dock pull-right" role="menu" style="text-align: left;">
										<li onClick="AgregarMenu()"><a><i class="fa fa-plus text-success"></i> Agregar Menú</a></li>
									</ul>
								</div>
								<a class="btn btn-icon-toggle btn-collapse"><i class="fa fa-angle-down"></i></a>
							</div>

						</div>
						<header>ADMINISTRACIÓN DE MENU</header>
					</div>
					<div class="card-body style-default-bright">
						<div class="container-fluid">
							<table class="table table-hover table-condensed" id="tblEntidades">
								<thead>
									<tr>
										<th><h5><strong>#</strong></h5></th>
										<th><h5><strong>NOMBRE</strong></h5></th>
										<th><h5><strong>ICONO</strong></h5></th>
										<th><h5><strong>ORDEN</strong></h5></th>
										<th><h5><strong>ESTADO</strong></h5></th>
										<th><h5><strong>ADMINISTRA DEPARTAMENTO</strong></h5></th>
										<th><h5><strong>EDITAR</strong></h5></th>
									</tr>
								</thead>
								<tbody>
									<?php
										$i = 1;

										$sql_Menu = mysqli_query($db, "SELECT * FROM info_base.menu WHERE codigoaplicacion = ".$_GET[Codigo]);
										while($rw_Menu = mysqli_fetch_array($sql_Menu))
										{
											
											?>
												<tr>
													<td><h6><?php echo $i ?></h6></td>
													<td><h6><?php echo utf8_encode($rw_Menu["nombremenu"]); ?></h6></td>
													<td class="text-primary"><h6><span class="<?php echo $rw_Menu['iconomenu'] ?> fa-3x"></span></h6></td>
													<td><h6><?php echo $rw_Menu["ordenmenu"] ?></h6></td>
													<td><h6><?php echo $rw_Menu["nomestatus"] ?></h6></td>
													<td><h6><?php echo utf8_encode(saber_departamentoid($rw_Menu['departamento_permiso'])) ?></h6></td>
													<td><button class="btn btn-warning btn-md" value="<?php echo $rw_Menu["codmenu"] ?>" data-empresa="<?php echo $rw_Menu["codempresa"] ?>" onclick="EditarMenu(this)"><span class="glyphicon glyphicon-edit"></span></button></td>
												</tr>
											<?php
											$i++;
										}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>	
			<?php			
				/* Llamada de archivo para la asignación de menú de acuerdo al tipo de rol */
			//	include("../resources/menu/Asignacion_Menu.php");
			?>
		</div>

		<div class="modal fade" id="md_EditarMenu" role="dialog" >
                    <div class="modal-dialog" style="width: 65%">
                    <!-- Conetenido -->
				<div class="modal-content">
					<div class="modal-header text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><strong>EDITAR MENU</strong></h4>
					</div>
					<div class="modal-body">
						<div class="container-fluid" id="DIVEditar">	
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" onclick="EdicionMenu()">Guardar</button>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="md_AgregarMenu">
			<div class="modal-dialog" ">
				<div class="modal-content">
					<div class="modal-header text-center">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><strong>AGREGAR MENÚ</strong></h4>
					</div>
					<div class="modal-body">

						<form class="form" role="form" id="frm_AgregarMenu">
							<input type="hidden" name="">
							<div class="container">
								<div class="form-group col-lg-4 floating-label">	
									<input type="text" class="form-control" name="NombreAgregar" id="NombreAgregar" required>
									<label for="NombreAgregar">Nombre</label>
								</div>
							</div>
							<div class="container">
								<div class="form-group col-lg-4">	
									<div class="input-group">
										<div class="input-group-btn" id="BotonIconoAgregar" style="display: none">
											<button class="btn btn-primary btn-lg" type="button"><span id="SpanIconoAgregar"></span></button>
										</div>
										<div class="input-group-content">
											<input type="text" class="form-control" id="IconoAgregar" id="IconoAgregar" readonly>
											<label for="IconoAgregar">Ícono</label>
										</div>
										<div class="input-group-btn">
											<button class="btn btn-success btn-lg" type="button" style="cursor: hand" onclick="SeleccionarIconoAgregar()"><span class="glyphicon glyphicon-plus"></span></button>
										</div>
									</div>
								</div>
							</div>
							<div class="container">
								<div class="form-group col-lg-1 floating-label">	
									<input type="number" class="form-control" name="OrdenAgregar" id="OrdenAgregar" required>
									<label for="OrdenAgregar">Orden</label>
								</div>
							</div>
							<div class="container">
								<div class="form-group col-lg-3 floating-label">	
									
										<label>Estado</label>
									    
									    <select name="EstadoAgregar" id="EstadoAgregar" class="form-control">
											 <option value="1">Activado</option>
											 <option value="2">Desactivado</option>
										</select>
									
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-primary" onclick="GuardarMenu()">Guardar</button>
					</div>
				</div>
			</div>
		</div>



		<!--  -->

	<div class="modal fade" id="ModalPreloader" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-body text-center">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
							<span class="sr-only">Loading...</span>
					</div>
				</div>
			</div>
		</div>


		<!--  -->
<!-- Agragar Iconos -->
		<div class="modal fade" id="md_SeleccionarIconoAgregar"  role="dialog">
			<div class="modal-dialog" style="width: 90%" data-backdrop="static" data-keyboard="false">
				<div class="modal-content">
					<div class="modal-header text-center">
						<h4 class="modal-title"><strong>Seleccione Menú</strong></h4>
					</div>
					<div class="modal-body">
						<div id="container">  

					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-book"><i class="fa fa-address-book" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-book</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-book-o"><i class="fa fa-address-book-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-book-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-card"><i class="fa fa-address-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-card</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-card-o"><i class="fa fa-address-card-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-card-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bandcamp"><i class="fa fa-bandcamp" aria-hidden="true"></i> <span class="sr-only">Example of </span>bandcamp</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bath"><i class="fa fa-bath" aria-hidden="true"></i> <span class="sr-only">Example of </span>bath</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bath"><i class="fa fa-bathtub" aria-hidden="true"></i> <span class="sr-only">Example of </span>bathtub <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card"><i class="fa fa-drivers-license" aria-hidden="true"></i> <span class="sr-only">Example of </span>drivers-license <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card-o"><i class="fa fa-drivers-license-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>drivers-license-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="eercast"><i class="fa fa-eercast" aria-hidden="true"></i> <span class="sr-only">Example of </span>eercast</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="envelope-open"><i class="fa fa-envelope-open" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-open</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="envelope-open-o"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-open-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="etsy"><i class="fa fa-etsy" aria-hidden="true"></i> <span class="sr-only">Example of </span>etsy</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="free-code-camp"><i class="fa fa-free-code-camp" aria-hidden="true"></i> <span class="sr-only">Example of </span>free-code-camp</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="grav"><i class="fa fa-grav" aria-hidden="true"></i> <span class="sr-only">Example of </span>grav</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="handshake-o"><i class="fa fa-handshake-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>handshake-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-badge"><i class="fa fa-id-badge" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-badge</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card"><i class="fa fa-id-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-card</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card-o"><i class="fa fa-id-card-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-card-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="imdb"><i class="fa fa-imdb" aria-hidden="true"></i> <span class="sr-only">Example of </span>imdb</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="linode"><i class="fa fa-linode" aria-hidden="true"></i> <span class="sr-only">Example of </span>linode</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="meetup"><i class="fa fa-meetup" aria-hidden="true"></i> <span class="sr-only">Example of </span>meetup</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="microchip"><i class="fa fa-microchip" aria-hidden="true"></i> <span class="sr-only">Example of </span>microchip</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="podcast"><i class="fa fa-podcast" aria-hidden="true"></i> <span class="sr-only">Example of </span>podcast</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="quora"><i class="fa fa-quora" aria-hidden="true"></i> <span class="sr-only">Example of </span>quora</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="ravelry"><i class="fa fa-ravelry" aria-hidden="true"></i> <span class="sr-only">Example of </span>ravelry</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bath"><i class="fa fa-s15" aria-hidden="true"></i> <span class="sr-only">Example of </span>s15 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="shower"><i class="fa fa-shower" aria-hidden="true"></i> <span class="sr-only">Example of </span>shower</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="snowflake-o"><i class="fa fa-snowflake-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>snowflake-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="superpowers"><i class="fa fa-superpowers" aria-hidden="true"></i> <span class="sr-only">Example of </span>superpowers</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="telegram"><i class="fa fa-telegram" aria-hidden="true"></i> <span class="sr-only">Example of </span>telegram</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-full"><i class="fa fa-thermometer" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-empty"><i class="fa fa-thermometer-0" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-0 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-quarter"><i class="fa fa-thermometer-1" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-1 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-half"><i class="fa fa-thermometer-2" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-2 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-three-quarters"><i class="fa fa-thermometer-3" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-3 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-full"><i class="fa fa-thermometer-4" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-4 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-empty"><i class="fa fa-thermometer-empty" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-empty</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-full"><i class="fa fa-thermometer-full" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-full</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-half"><i class="fa fa-thermometer-half" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-half</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-quarter"><i class="fa fa-thermometer-quarter" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-quarter</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="thermometer-three-quarters"><i class="fa fa-thermometer-three-quarters" aria-hidden="true"></i> <span class="sr-only">Example of </span>thermometer-three-quarters</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="window-close"><i class="fa fa-times-rectangle" aria-hidden="true"></i> <span class="sr-only">Example of </span>times-rectangle <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="window-close-o"><i class="fa fa-times-rectangle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>times-rectangle-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="user-circle"><i class="fa fa-user-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-circle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="user-circle-o"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-circle-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="user-o"><i class="fa fa-user-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>user-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-card"><i class="fa fa-vcard" aria-hidden="true"></i> <span class="sr-only">Example of </span>vcard <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-card-o"><i class="fa fa-vcard-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>vcard-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="window-close"><i class="fa fa-window-close" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-close</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="window-close-o"><i class="fa fa-window-close-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-close-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="window-maximize"><i class="fa fa-window-maximize" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-maximize</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="window-minimize"><i class="fa fa-window-minimize" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-minimize</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="window-restore"><i class="fa fa-window-restore" aria-hidden="true"></i> <span class="sr-only">Example of </span>window-restore</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="wpexplorer"><i class="fa fa-wpexplorer" aria-hidden="true"></i> <span class="sr-only">Example of </span>wpexplorer</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-book"><i class="fa fa-address-book" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-book</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-book-o"><i class="fa fa-address-book-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-book-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-card"><i class="fa fa-address-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-card</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="address-card-o"><i class="fa fa-address-card-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>address-card-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="adjust"><i class="fa fa-adjust" aria-hidden="true"></i> <span class="sr-only">Example of </span>adjust</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="american-sign-language-interpreting"><i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i> <span class="sr-only">Example of </span>american-sign-language-interpreting</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="anchor"><i class="fa fa-anchor" aria-hidden="true"></i> <span class="sr-only">Example of </span>anchor</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="archive"><i class="fa fa-archive" aria-hidden="true"></i> <span class="sr-only">Example of </span>archive</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="area-chart"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>area-chart</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="arrows"><i class="fa fa-arrows" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="arrows-h"><i class="fa fa-arrows-h" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-h</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="arrows-v"><i class="fa fa-arrows-v" aria-hidden="true"></i> <span class="sr-only">Example of </span>arrows-v</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="american-sign-language-interpreting"><i class="fa fa-asl-interpreting" aria-hidden="true"></i> <span class="sr-only">Example of </span>asl-interpreting <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="assistive-listening-systems"><i class="fa fa-assistive-listening-systems" aria-hidden="true"></i> <span class="sr-only">Example of </span>assistive-listening-systems</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="asterisk"><i class="fa fa-asterisk" aria-hidden="true"></i> <span class="sr-only">Example of </span>asterisk</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="at"><i class="fa fa-at" aria-hidden="true"></i> <span class="sr-only">Example of </span>at</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="audio-description"><i class="fa fa-audio-description" aria-hidden="true"></i> <span class="sr-only">Example of </span>audio-description</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="car"><i class="fa fa-automobile" aria-hidden="true"></i> <span class="sr-only">Example of </span>automobile <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="balance-scale"><i class="fa fa-balance-scale" aria-hidden="true"></i> <span class="sr-only">Example of </span>balance-scale</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="ban"><i class="fa fa-ban" aria-hidden="true"></i> <span class="sr-only">Example of </span>ban</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="university"><i class="fa fa-bank" aria-hidden="true"></i> <span class="sr-only">Example of </span>bank <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bar-chart"><i class="fa fa-bar-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>bar-chart</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bar-chart"><i class="fa fa-bar-chart-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bar-chart-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="barcode"><i class="fa fa-barcode" aria-hidden="true"></i> <span class="sr-only">Example of </span>barcode</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bars"><i class="fa fa-bars" aria-hidden="true"></i> <span class="sr-only">Example of </span>bars</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bath"><i class="fa fa-bath" aria-hidden="true"></i> <span class="sr-only">Example of </span>bath</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bath"><i class="fa fa-bathtub" aria-hidden="true"></i> <span class="sr-only">Example of </span>bathtub <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-full"><i class="fa fa-battery" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-empty"><i class="fa fa-battery-0" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-0 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-quarter"><i class="fa fa-battery-1" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-1 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-half"><i class="fa fa-battery-2" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-2 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-three-quarters"><i class="fa fa-battery-3" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-3 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-full"><i class="fa fa-battery-4" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-4 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-empty"><i class="fa fa-battery-empty" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-empty</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-full"><i class="fa fa-battery-full" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-full</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-half"><i class="fa fa-battery-half" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-half</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-quarter"><i class="fa fa-battery-quarter" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-quarter</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="battery-three-quarters"><i class="fa fa-battery-three-quarters" aria-hidden="true"></i> <span class="sr-only">Example of </span>battery-three-quarters</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bed"><i class="fa fa-bed" aria-hidden="true"></i> <span class="sr-only">Example of </span>bed</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="beer"><i class="fa fa-beer" aria-hidden="true"></i> <span class="sr-only">Example of </span>beer</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bell"><i class="fa fa-bell" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bell-o"><i class="fa fa-bell-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bell-slash"><i class="fa fa-bell-slash" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell-slash</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bell-slash-o"><i class="fa fa-bell-slash-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bell-slash-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bicycle"><i class="fa fa-bicycle" aria-hidden="true"></i> <span class="sr-only">Example of </span>bicycle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="binoculars"><i class="fa fa-binoculars" aria-hidden="true"></i> <span class="sr-only">Example of </span>binoculars</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="birthday-cake"><i class="fa fa-birthday-cake" aria-hidden="true"></i> <span class="sr-only">Example of </span>birthday-cake</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="blind"><i class="fa fa-blind" aria-hidden="true"></i> <span class="sr-only">Example of </span>blind</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bluetooth"><i class="fa fa-bluetooth" aria-hidden="true"></i> <span class="sr-only">Example of </span>bluetooth</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bluetooth-b"><i class="fa fa-bluetooth-b" aria-hidden="true"></i> <span class="sr-only">Example of </span>bluetooth-b</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bolt"><i class="fa fa-bolt" aria-hidden="true"></i> <span class="sr-only">Example of </span>bolt</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bomb"><i class="fa fa-bomb" aria-hidden="true"></i> <span class="sr-only">Example of </span>bomb</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="book"><i class="fa fa-book" aria-hidden="true"></i> <span class="sr-only">Example of </span>book</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bookmark"><i class="fa fa-bookmark" aria-hidden="true"></i> <span class="sr-only">Example of </span>bookmark</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bookmark-o"><i class="fa fa-bookmark-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>bookmark-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="braille"><i class="fa fa-braille" aria-hidden="true"></i> <span class="sr-only">Example of </span>braille</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="briefcase"><i class="fa fa-briefcase" aria-hidden="true"></i> <span class="sr-only">Example of </span>briefcase</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bug"><i class="fa fa-bug" aria-hidden="true"></i> <span class="sr-only">Example of </span>bug</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="building"><i class="fa fa-building" aria-hidden="true"></i> <span class="sr-only">Example of </span>building</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="building-o"><i class="fa fa-building-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>building-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bullhorn"><i class="fa fa-bullhorn" aria-hidden="true"></i> <span class="sr-only">Example of </span>bullhorn</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bullseye"><i class="fa fa-bullseye" aria-hidden="true"></i> <span class="sr-only">Example of </span>bullseye</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bus"><i class="fa fa-bus" aria-hidden="true"></i> <span class="sr-only">Example of </span>bus</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="taxi"><i class="fa fa-cab" aria-hidden="true"></i> <span class="sr-only">Example of </span>cab <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="calculator"><i class="fa fa-calculator" aria-hidden="true"></i> <span class="sr-only">Example of </span>calculator</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="calendar"><i class="fa fa-calendar" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="calendar-check-o"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-check-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="calendar-minus-o"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-minus-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="calendar-o"><i class="fa fa-calendar-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="calendar-plus-o"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-plus-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="calendar-times-o"><i class="fa fa-calendar-times-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>calendar-times-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="camera"><i class="fa fa-camera" aria-hidden="true"></i> <span class="sr-only">Example of </span>camera</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="camera-retro"><i class="fa fa-camera-retro" aria-hidden="true"></i> <span class="sr-only">Example of </span>camera-retro</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="car"><i class="fa fa-car" aria-hidden="true"></i> <span class="sr-only">Example of </span>car</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="caret-square-o-down"><i class="fa fa-caret-square-o-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-down</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="caret-square-o-left"><i class="fa fa-caret-square-o-left" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-left</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="caret-square-o-right"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-right</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="caret-square-o-up"><i class="fa fa-caret-square-o-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>caret-square-o-up</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cart-arrow-down"><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>cart-arrow-down</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cart-plus"><i class="fa fa-cart-plus" aria-hidden="true"></i> <span class="sr-only">Example of </span>cart-plus</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cc"><i class="fa fa-cc" aria-hidden="true"></i> <span class="sr-only">Example of </span>cc</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="certificate"><i class="fa fa-certificate" aria-hidden="true"></i> <span class="sr-only">Example of </span>certificate</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="check"><i class="fa fa-check" aria-hidden="true"></i> <span class="sr-only">Example of </span>check</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="check-circle"><i class="fa fa-check-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-circle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="check-circle-o"><i class="fa fa-check-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-circle-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="check-square"><i class="fa fa-check-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-square</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="check-square-o"><i class="fa fa-check-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>check-square-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="child"><i class="fa fa-child" aria-hidden="true"></i> <span class="sr-only">Example of </span>child</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="circle"><i class="fa fa-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="circle-o"><i class="fa fa-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="circle-o-notch"><i class="fa fa-circle-o-notch" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle-o-notch</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="circle-thin"><i class="fa fa-circle-thin" aria-hidden="true"></i> <span class="sr-only">Example of </span>circle-thin</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="clock-o"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>clock-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="clone"><i class="fa fa-clone" aria-hidden="true"></i> <span class="sr-only">Example of </span>clone</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="times"><i class="fa fa-close" aria-hidden="true"></i> <span class="sr-only">Example of </span>close <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cloud"><i class="fa fa-cloud" aria-hidden="true"></i> <span class="sr-only">Example of </span>cloud</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cloud-download"><i class="fa fa-cloud-download" aria-hidden="true"></i> <span class="sr-only">Example of </span>cloud-download</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cloud-upload"><i class="fa fa-cloud-upload" aria-hidden="true"></i> <span class="sr-only">Example of </span>cloud-upload</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="code"><i class="fa fa-code" aria-hidden="true"></i> <span class="sr-only">Example of </span>code</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="code-fork"><i class="fa fa-code-fork" aria-hidden="true"></i> <span class="sr-only">Example of </span>code-fork</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="coffee"><i class="fa fa-coffee" aria-hidden="true"></i> <span class="sr-only">Example of </span>coffee</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cog"><i class="fa fa-cog" aria-hidden="true"></i> <span class="sr-only">Example of </span>cog</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cogs"><i class="fa fa-cogs" aria-hidden="true"></i> <span class="sr-only">Example of </span>cogs</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="comment"><i class="fa fa-comment" aria-hidden="true"></i> <span class="sr-only">Example of </span>comment</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="comment-o"><i class="fa fa-comment-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>comment-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="commenting"><i class="fa fa-commenting" aria-hidden="true"></i> <span class="sr-only">Example of </span>commenting</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="commenting-o"><i class="fa fa-commenting-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>commenting-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="comments"><i class="fa fa-comments" aria-hidden="true"></i> <span class="sr-only">Example of </span>comments</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="comments-o"><i class="fa fa-comments-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>comments-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="compass"><i class="fa fa-compass" aria-hidden="true"></i> <span class="sr-only">Example of </span>compass</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="copyright"><i class="fa fa-copyright" aria-hidden="true"></i> <span class="sr-only">Example of </span>copyright</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="creative-commons"><i class="fa fa-creative-commons" aria-hidden="true"></i> <span class="sr-only">Example of </span>creative-commons</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="credit-card"><i class="fa fa-credit-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>credit-card</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="credit-card-alt"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> <span class="sr-only">Example of </span>credit-card-alt</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="crop"><i class="fa fa-crop" aria-hidden="true"></i> <span class="sr-only">Example of </span>crop</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="crosshairs"><i class="fa fa-crosshairs" aria-hidden="true"></i> <span class="sr-only">Example of </span>crosshairs</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cube"><i class="fa fa-cube" aria-hidden="true"></i> <span class="sr-only">Example of </span>cube</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cubes"><i class="fa fa-cubes" aria-hidden="true"></i> <span class="sr-only">Example of </span>cubes</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cutlery"><i class="fa fa-cutlery" aria-hidden="true"></i> <span class="sr-only">Example of </span>cutlery</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="tachometer"><i class="fa fa-dashboard" aria-hidden="true"></i> <span class="sr-only">Example of </span>dashboard <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="database"><i class="fa fa-database" aria-hidden="true"></i> <span class="sr-only">Example of </span>database</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="deaf"><i class="fa fa-deaf" aria-hidden="true"></i> <span class="sr-only">Example of </span>deaf</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="deaf"><i class="fa fa-deafness" aria-hidden="true"></i> <span class="sr-only">Example of </span>deafness <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="desktop"><i class="fa fa-desktop" aria-hidden="true"></i> <span class="sr-only">Example of </span>desktop</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="diamond"><i class="fa fa-diamond" aria-hidden="true"></i> <span class="sr-only">Example of </span>diamond</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="dot-circle-o"><i class="fa fa-dot-circle-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>dot-circle-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="download"><i class="fa fa-download" aria-hidden="true"></i> <span class="sr-only">Example of </span>download</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card"><i class="fa fa-drivers-license" aria-hidden="true"></i> <span class="sr-only">Example of </span>drivers-license <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card-o"><i class="fa fa-drivers-license-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>drivers-license-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="pencil-square-o"><i class="fa fa-edit" aria-hidden="true"></i> <span class="sr-only">Example of </span>edit <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="ellipsis-h"><i class="fa fa-ellipsis-h" aria-hidden="true"></i> <span class="sr-only">Example of </span>ellipsis-h</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="ellipsis-v"><i class="fa fa-ellipsis-v" aria-hidden="true"></i> <span class="sr-only">Example of </span>ellipsis-v</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="envelope"><i class="fa fa-envelope" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="envelope-o"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="envelope-open"><i class="fa fa-envelope-open" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-open</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="envelope-open-o"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-open-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="envelope-square"><i class="fa fa-envelope-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>envelope-square</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="eraser"><i class="fa fa-eraser" aria-hidden="true"></i> <span class="sr-only">Example of </span>eraser</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="exchange"><i class="fa fa-exchange" aria-hidden="true"></i> <span class="sr-only">Example of </span>exchange</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="exclamation"><i class="fa fa-exclamation" aria-hidden="true"></i> <span class="sr-only">Example of </span>exclamation</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="exclamation-circle"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>exclamation-circle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="exclamation-triangle"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <span class="sr-only">Example of </span>exclamation-triangle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="external-link"><i class="fa fa-external-link" aria-hidden="true"></i> <span class="sr-only">Example of </span>external-link</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="external-link-square"><i class="fa fa-external-link-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>external-link-square</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="eye"><i class="fa fa-eye" aria-hidden="true"></i> <span class="sr-only">Example of </span>eye</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="eye-slash"><i class="fa fa-eye-slash" aria-hidden="true"></i> <span class="sr-only">Example of </span>eye-slash</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="eyedropper"><i class="fa fa-eyedropper" aria-hidden="true"></i> <span class="sr-only">Example of </span>eyedropper</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="fax"><i class="fa fa-fax" aria-hidden="true"></i> <span class="sr-only">Example of </span>fax</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="rss"><i class="fa fa-feed" aria-hidden="true"></i> <span class="sr-only">Example of </span>feed <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="female"><i class="fa fa-female" aria-hidden="true"></i> <span class="sr-only">Example of </span>female</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="fighter-jet"><i class="fa fa-fighter-jet" aria-hidden="true"></i> <span class="sr-only">Example of </span>fighter-jet</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-archive-o"><i class="fa fa-file-archive-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-archive-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-audio-o"><i class="fa fa-file-audio-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-audio-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-code-o"><i class="fa fa-file-code-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-code-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-excel-o"><i class="fa fa-file-excel-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-excel-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-image-o"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-image-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-video-o"><i class="fa fa-file-movie-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-movie-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-pdf-o"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-pdf-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-image-o"><i class="fa fa-file-photo-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-photo-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-image-o"><i class="fa fa-file-picture-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-picture-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-powerpoint-o"><i class="fa fa-file-powerpoint-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-powerpoint-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-audio-o"><i class="fa fa-file-sound-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-sound-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-video-o"><i class="fa fa-file-video-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-video-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-word-o"><i class="fa fa-file-word-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-word-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="file-archive-o"><i class="fa fa-file-zip-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>file-zip-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="film"><i class="fa fa-film" aria-hidden="true"></i> <span class="sr-only">Example of </span>film</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="filter"><i class="fa fa-filter" aria-hidden="true"></i> <span class="sr-only">Example of </span>filter</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="fire"><i class="fa fa-fire" aria-hidden="true"></i> <span class="sr-only">Example of </span>fire</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="fire-extinguisher"><i class="fa fa-fire-extinguisher" aria-hidden="true"></i> <span class="sr-only">Example of </span>fire-extinguisher</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="flag"><i class="fa fa-flag" aria-hidden="true"></i> <span class="sr-only">Example of </span>flag</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="flag-checkered"><i class="fa fa-flag-checkered" aria-hidden="true"></i> <span class="sr-only">Example of </span>flag-checkered</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="flag-o"><i class="fa fa-flag-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>flag-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bolt"><i class="fa fa-flash" aria-hidden="true"></i> <span class="sr-only">Example of </span>flash <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="flask"><i class="fa fa-flask" aria-hidden="true"></i> <span class="sr-only">Example of </span>flask</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="folder"><i class="fa fa-folder" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="folder-o"><i class="fa fa-folder-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="folder-open"><i class="fa fa-folder-open" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder-open</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="folder-open-o"><i class="fa fa-folder-open-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>folder-open-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="frown-o"><i class="fa fa-frown-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>frown-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="futbol-o"><i class="fa fa-futbol-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>futbol-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="gamepad"><i class="fa fa-gamepad" aria-hidden="true"></i> <span class="sr-only">Example of </span>gamepad</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="gavel"><i class="fa fa-gavel" aria-hidden="true"></i> <span class="sr-only">Example of </span>gavel</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cog"><i class="fa fa-gear" aria-hidden="true"></i> <span class="sr-only">Example of </span>gear <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="cogs"><i class="fa fa-gears" aria-hidden="true"></i> <span class="sr-only">Example of </span>gears <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="gift"><i class="fa fa-gift" aria-hidden="true"></i> <span class="sr-only">Example of </span>gift</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="glass"><i class="fa fa-glass" aria-hidden="true"></i> <span class="sr-only">Example of </span>glass</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="globe"><i class="fa fa-globe" aria-hidden="true"></i> <span class="sr-only">Example of </span>globe</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="graduation-cap"><i class="fa fa-graduation-cap" aria-hidden="true"></i> <span class="sr-only">Example of </span>graduation-cap</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="users"><i class="fa fa-group" aria-hidden="true"></i> <span class="sr-only">Example of </span>group <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-rock-o"><i class="fa fa-hand-grab-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-grab-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-lizard-o"><i class="fa fa-hand-lizard-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-lizard-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-paper-o"><i class="fa fa-hand-paper-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-paper-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-peace-o"><i class="fa fa-hand-peace-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-peace-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-pointer-o"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-pointer-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-rock-o"><i class="fa fa-hand-rock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-rock-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-scissors-o"><i class="fa fa-hand-scissors-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-scissors-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-spock-o"><i class="fa fa-hand-spock-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-spock-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hand-paper-o"><i class="fa fa-hand-stop-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hand-stop-o <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="handshake-o"><i class="fa fa-handshake-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>handshake-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="deaf"><i class="fa fa-hard-of-hearing" aria-hidden="true"></i> <span class="sr-only">Example of </span>hard-of-hearing <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hashtag"><i class="fa fa-hashtag" aria-hidden="true"></i> <span class="sr-only">Example of </span>hashtag</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hdd-o"><i class="fa fa-hdd-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hdd-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="headphones"><i class="fa fa-headphones" aria-hidden="true"></i> <span class="sr-only">Example of </span>headphones</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="heart"><i class="fa fa-heart" aria-hidden="true"></i> <span class="sr-only">Example of </span>heart</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="heart-o"><i class="fa fa-heart-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>heart-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="heartbeat"><i class="fa fa-heartbeat" aria-hidden="true"></i> <span class="sr-only">Example of </span>heartbeat</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="history"><i class="fa fa-history" aria-hidden="true"></i> <span class="sr-only">Example of </span>history</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="home"><i class="fa fa-home" aria-hidden="true"></i> <span class="sr-only">Example of </span>home</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bed"><i class="fa fa-hotel" aria-hidden="true"></i> <span class="sr-only">Example of </span>hotel <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass"><i class="fa fa-hourglass" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass-start"><i class="fa fa-hourglass-1" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-1 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass-half"><i class="fa fa-hourglass-2" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-2 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass-end"><i class="fa fa-hourglass-3" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-3 <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass-end"><i class="fa fa-hourglass-end" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-end</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass-half"><i class="fa fa-hourglass-half" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-half</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass-o"><i class="fa fa-hourglass-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="hourglass-start"><i class="fa fa-hourglass-start" aria-hidden="true"></i> <span class="sr-only">Example of </span>hourglass-start</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="i-cursor"><i class="fa fa-i-cursor" aria-hidden="true"></i> <span class="sr-only">Example of </span>i-cursor</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-badge"><i class="fa fa-id-badge" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-badge</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card"><i class="fa fa-id-card" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-card</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="id-card-o"><i class="fa fa-id-card-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>id-card-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="picture-o"><i class="fa fa-image" aria-hidden="true"></i> <span class="sr-only">Example of </span>image <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="inbox"><i class="fa fa-inbox" aria-hidden="true"></i> <span class="sr-only">Example of </span>inbox</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="industry"><i class="fa fa-industry" aria-hidden="true"></i> <span class="sr-only">Example of </span>industry</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="info"><i class="fa fa-info" aria-hidden="true"></i> <span class="sr-only">Example of </span>info</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="info-circle"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>info-circle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="university"><i class="fa fa-institution" aria-hidden="true"></i> <span class="sr-only">Example of </span>institution <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="key"><i class="fa fa-key" aria-hidden="true"></i> <span class="sr-only">Example of </span>key</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="keyboard-o"><i class="fa fa-keyboard-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>keyboard-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="language"><i class="fa fa-language" aria-hidden="true"></i> <span class="sr-only">Example of </span>language</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="laptop"><i class="fa fa-laptop" aria-hidden="true"></i> <span class="sr-only">Example of </span>laptop</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="leaf"><i class="fa fa-leaf" aria-hidden="true"></i> <span class="sr-only">Example of </span>leaf</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="gavel"><i class="fa fa-legal" aria-hidden="true"></i> <span class="sr-only">Example of </span>legal <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="lemon-o"><i class="fa fa-lemon-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>lemon-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="level-down"><i class="fa fa-level-down" aria-hidden="true"></i> <span class="sr-only">Example of </span>level-down</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="level-up"><i class="fa fa-level-up" aria-hidden="true"></i> <span class="sr-only">Example of </span>level-up</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="life-ring"><i class="fa fa-life-bouy" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-bouy <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="life-ring"><i class="fa fa-life-buoy" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-buoy <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="life-ring"><i class="fa fa-life-ring" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-ring</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="life-ring"><i class="fa fa-life-saver" aria-hidden="true"></i> <span class="sr-only">Example of </span>life-saver <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="lightbulb-o"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>lightbulb-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="line-chart"><i class="fa fa-line-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>line-chart</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="location-arrow"><i class="fa fa-location-arrow" aria-hidden="true"></i> <span class="sr-only">Example of </span>location-arrow</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="lock"><i class="fa fa-lock" aria-hidden="true"></i> <span class="sr-only">Example of </span>lock</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="low-vision"><i class="fa fa-low-vision" aria-hidden="true"></i> <span class="sr-only">Example of </span>low-vision</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="magic"><i class="fa fa-magic" aria-hidden="true"></i> <span class="sr-only">Example of </span>magic</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="magnet"><i class="fa fa-magnet" aria-hidden="true"></i> <span class="sr-only">Example of </span>magnet</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="share"><i class="fa fa-mail-forward" aria-hidden="true"></i> <span class="sr-only">Example of </span>mail-forward <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="reply"><i class="fa fa-mail-reply" aria-hidden="true"></i> <span class="sr-only">Example of </span>mail-reply <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="reply-all"><i class="fa fa-mail-reply-all" aria-hidden="true"></i> <span class="sr-only">Example of </span>mail-reply-all <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="male"><i class="fa fa-male" aria-hidden="true"></i> <span class="sr-only">Example of </span>male</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="map"><i class="fa fa-map" aria-hidden="true"></i> <span class="sr-only">Example of </span>map</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="map-marker"><i class="fa fa-map-marker" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-marker</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="map-o"><i class="fa fa-map-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="map-pin"><i class="fa fa-map-pin" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-pin</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="map-signs"><i class="fa fa-map-signs" aria-hidden="true"></i> <span class="sr-only">Example of </span>map-signs</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="meh-o"><i class="fa fa-meh-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>meh-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="microchip"><i class="fa fa-microchip" aria-hidden="true"></i> <span class="sr-only">Example of </span>microchip</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="microphone"><i class="fa fa-microphone" aria-hidden="true"></i> <span class="sr-only">Example of </span>microphone</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="microphone-slash"><i class="fa fa-microphone-slash" aria-hidden="true"></i> <span class="sr-only">Example of </span>microphone-slash</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="minus"><i class="fa fa-minus" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="minus-circle"><i class="fa fa-minus-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-circle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="minus-square"><i class="fa fa-minus-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-square</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="minus-square-o"><i class="fa fa-minus-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>minus-square-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="mobile"><i class="fa fa-mobile" aria-hidden="true"></i> <span class="sr-only">Example of </span>mobile</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="mobile"><i class="fa fa-mobile-phone" aria-hidden="true"></i> <span class="sr-only">Example of </span>mobile-phone <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="money"><i class="fa fa-money" aria-hidden="true"></i> <span class="sr-only">Example of </span>money</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="moon-o"><i class="fa fa-moon-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>moon-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="graduation-cap"><i class="fa fa-mortar-board" aria-hidden="true"></i> <span class="sr-only">Example of </span>mortar-board <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="motorcycle"><i class="fa fa-motorcycle" aria-hidden="true"></i> <span class="sr-only">Example of </span>motorcycle</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="mouse-pointer"><i class="fa fa-mouse-pointer" aria-hidden="true"></i> <span class="sr-only">Example of </span>mouse-pointer</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="music"><i class="fa fa-music" aria-hidden="true"></i> <span class="sr-only">Example of </span>music</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="bars"><i class="fa fa-navicon" aria-hidden="true"></i> <span class="sr-only">Example of </span>navicon <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="newspaper-o"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>newspaper-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="object-group"><i class="fa fa-object-group" aria-hidden="true"></i> <span class="sr-only">Example of </span>object-group</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="object-ungroup"><i class="fa fa-object-ungroup" aria-hidden="true"></i> <span class="sr-only">Example of </span>object-ungroup</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="paint-brush"><i class="fa fa-paint-brush" aria-hidden="true"></i> <span class="sr-only">Example of </span>paint-brush</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="paper-plane"><i class="fa fa-paper-plane" aria-hidden="true"></i> <span class="sr-only">Example of </span>paper-plane</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="paper-plane-o"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>paper-plane-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="paw"><i class="fa fa-paw" aria-hidden="true"></i> <span class="sr-only">Example of </span>paw</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="pencil"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="sr-only">Example of </span>pencil</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="pencil-square"><i class="fa fa-pencil-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>pencil-square</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="pencil-square-o"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>pencil-square-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="percent"><i class="fa fa-percent" aria-hidden="true"></i> <span class="sr-only">Example of </span>percent</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="phone"><i class="fa fa-phone" aria-hidden="true"></i> <span class="sr-only">Example of </span>phone</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="phone-square"><i class="fa fa-phone-square" aria-hidden="true"></i> <span class="sr-only">Example of </span>phone-square</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="picture-o"><i class="fa fa-photo" aria-hidden="true"></i> <span class="sr-only">Example of </span>photo <span class="text-muted">(alias)</span></a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="picture-o"><i class="fa fa-picture-o" aria-hidden="true"></i> <span class="sr-only">Example of </span>picture-o</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="pie-chart"><i class="fa fa-pie-chart" aria-hidden="true"></i> <span class="sr-only">Example of </span>pie-chart</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="plane"><i class="fa fa-plane" aria-hidden="true"></i> <span class="sr-only">Example of </span>plane</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="plug"><i class="fa fa-plug" aria-hidden="true"></i> <span class="sr-only">Example of </span>plug</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="plus"><i class="fa fa-plus" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus</a></div>
					    
					      <div class="fa-hover col-md-3 col-sm-4"><a style="cursor: hand" onclick="SeleccionarIcono(this)" data-icono="plus-circle"><i class="fa fa-plus-circle" aria-hidden="true"></i> <span class="sr-only">Example of </span>plus-circle</a></div>
					    		  </div>
					    </div>  
				<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>

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
		<!-- END JAVASCRIPT -->

			<script>	
			function AgregarMenu()
			{
				$('#md_AgregarMenu').modal('show');
			}


			function SelectGerencia()
			{
					var IdGerencia=$('#gerencia').val();

					//alert(IdGerencia);
				
					$.ajax({
							url: 'ajax/SelectGerencia.php',
							type: 'post',
							data: 'IdGerencia='+IdGerencia,						
							beforeSend: function(){
								$('#ModalPreloader').modal('show');
							},
							success: function (data) {
							$('#ModalPreloader').modal('hide');		
							$('#departamento').html(data);		
								
							}
						});	
			}
				function SelectGerenciaEditar()
			{
					var IdGerencia=$('#gerenciaeditar').val();

					//alert(IdGerencia);
				
					$.ajax({
							url: 'ajax/SelectGerencia.php',
							type: 'post',
							data: 'IdGerencia='+IdGerencia,						
							beforeSend: function(){
								$('#ModalPreloader').modal('show');
							},
							success: function (data) {
							$('#ModalPreloader').modal('hide');		
							$('#departamentoeditar').html(data);		
								
							}
						});	
			}
			function SeleccionarIconoAgregar()
			{
				$('#md_SeleccionarIconoAgregar').modal('show');
			}
			function SeleccionarIcono(x)
			{
				$("#SpanIconoAgregar").attr('class', '');

				var TextoIcono = $(x).attr('data-icono');

				var TextoIcono = "fa fa-"+TextoIcono;

				$('#SpanIconoAgregar').addClass(TextoIcono);
				$('#BotonIconoAgregar').show();
				$('#IconoAgregar').val(TextoIcono);
				

				$('#md_SeleccionarIconoAgregar').modal('hide');
			}
			function GuardarMenu()
			{
				var NombreAgregar = $('#NombreAgregar').val();
				var IconoAgregar  = $('#IconoAgregar').val();
				var OrdenAgregar  = $('#OrdenAgregar').val();
				var EstadoAgregar = $('#EstadoAgregar').val();
				var Gerencia 	  = $('#gerencia').val();
				var Departamento  = $('#departamento').val();

				if((NombreAgregar == '' || NombreAgregar == null ) || (IconoAgregar == '' || IconoAgregar == null ) || (OrdenAgregar == '' || OrdenAgregar == null ))
				{
					alertify.error('Antes de continuar por favor, llene los campos');
				}
				else
				{
					$.ajax({
							url: 'ajax/GuardarMenu.php',
							type: 'post',
							data: 'Nombre='+NombreAgregar+'&Icono='+IconoAgregar+'&Orden='+OrdenAgregar+'&Estado='+EstadoAgregar+'&gerencia='+ Gerencia + '&departamento='+Departamento,
							beforeSend: function(){
								$('#ModalPreloader').modal('show');
							},
							success: function (data) {
								if(data == 1)
								{
									window.location.reload();
								}
								else
								{
									alertify.error(data);
								}
							}
						});
				}
			}
			function EditarMenu(x)
			{
				var CodigoMenu = x.value;

				$.ajax({
					url: 'ajax/frm_EditarMenu.php',
					type: 'post',
					data: 'Codigo='+CodigoMenu,
					beforeSend: function(){
						$('#ModalPreloader').modal('show');
					},
					success: function (data) {
						$('#DIVEditar').html(data);
						$('#ModalPreloader').modal('hide');	
						$('#md_EditarMenu').modal('show');
						
					}
				});
			}
		
			function EdicionMenu()
			{
				// var NombreAgregar = $('#NombreEditar').val();
				// var IconoAgregar  = $('#IconoEditar').val();
				// var OrdenAgregar  = $('#OrdenEditar').val();
				// var EstadoAgregar = $('#EstadoEditar').val();
				// var CodigoAgregar = $('#CodigoEditar').val();

				var FrmMenu = $('#frm_EditarMenu').serialize();


 					$.ajax({
							url: 'ajax/EditarMenu.php',
							type: 'post',
							data: FrmMenu,
							beforeSend: function(){
								$('#ModalPreloader').modal('show');
							},
							success: function (data) {
								if(data == 1)
								{
								 window.location.reload();
								}
								else
								{
									alertify.error(data);
								}
							}
						});
				
			}

		</script>

	</body>
	</html>
