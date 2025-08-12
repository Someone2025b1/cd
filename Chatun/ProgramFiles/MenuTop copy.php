<!-- BEGIN HEADER-->
<?php $Actual =  $_SERVER['PHP_SELF'];
$NotificacionesResoluciones = 0;
$TotalConsumo = 0;
$NotificacionesConsumoTR = 0;
$NotificacionesConsumoSV = 0;
$StockMinimoCentral = 0;
$StockMinimoHelados = 0;
$StockMinimoSouvenir  = 0;
$StockMinimoRestaurant = 0;
$NumeroRequisicionesCompra  = 0;
$NumeroSolicitudesBodega  = 0;

$Mes = date('m', strtotime('now'));
$Anho = date('Y', strtotime('now'));

$SelfCIF = $_SESSION["iduser"];
$Hoy = date('Y-m-d', strtotime('now'));
$HoyMenosDiezDias = strtotime('-30 days', strtotime($Hoy));
$HoyMenosDiezDias = date('Y-m-d', $HoyMenosDiezDias);


$PrimerDiaMes = 1;
$UltimoDiaMes = date("d",(mktime(0,0,0,$Mes+1,1,$Anho)-1));
$FechaInicio = '1-'.$Mes.'-'.$Anho;
$FechaFinal  = $UltimoDiaMes.'-'.$Mes.'-'.$Anho;
$FechaInicioMes = date('Y-m-d', strtotime($FechaInicio));
$FechaFinalMes  = date('Y-m-d', strtotime($FechaFinal));

$DiaHoy = date('d', strtotime('now'));



$tmp_sql = mysqli_fetch_row(mysqli_query($db, "select puesto from info_colaboradores.datos_laborales where cif = '$SelfCIF'", mysqli_connect("10.60.58.205", "root", "chatun2021")));
$Puesto = $tmp_sql[0];


//ALERTAS PARA FINANCIERO CONTABLE
if($Puesto == 4)
{
	//ALERTA PARA VENCIMIENTO DE RESOLUCION DE FACTURAS
	$Consulta = "SELECT RES_FECHA_VENCIMIENTO FROM Bodega.RESOLUCION WHERE RES_ESTADO = 1";
	$Resultado = mysqli_query($db, $Consulta);
	while($Fila = mysqli_fetch_array($Resultado))
	{
		if($Fila["RES_FECHA_VENCIMIENTO"] <= $HoyMenosDiezDias)
		{
			$NotificacionesResoluciones = mysqli_num_rows($Resultado);
		}
	}

	//ALERTA PARA CONSUMO DE MAS DEL 75% DE FACTURAS DE UNA RESOLUCION
	$Consulta1 = "SELECT RES_SERIE, RES_AL FROM Bodega.RESOLUCION WHERE RES_ESTADO = 1 AND RES_TIPO = 'TR'";
	$Resultado1 = mysqli_query($db, $Consulta1);
	while($Fila1 = mysqli_fetch_array($Resultado1))
	{
		$Serie = $Fila1["RES_SERIE"];
		$Final = $Fila1["RES_AL"];

		$SubConsulta1 = "SELECT MAX(F_NUMERO) AS TOTAL FROM Bodega.FACTURA WHERE F_SERIE = '".$Serie."' ";
		$SubResultado1 = mysqli_query($db, $SubConsulta1);
		while($SubFila1 = mysqli_fetch_array($SubResultado1))
		{
			$TotalFacturas = $SubFila1["TOTAL"];

			$TotalConsumo = (100 * $TotalFacturas) / $Final;
		}
	}

	if($TotalConsumo >= 75)
	{
		$NotificacionesConsumoTR = 1;
	}
	else
	{
		$NotificacionesConsumoTR = 0;
	}

	//ALERTA PARA CONSUMO DE MAS DEL 75% DE FACTURAS DE UNA RESOLUCION
	$Consulta2 = "SELECT RES_SERIE, RES_AL FROM Bodega.RESOLUCION WHERE RES_ESTADO = 1 AND RES_TIPO = 'SV'";
	$Resultado2 = mysqli_query($db, $Consulta2);
	while($Fila2 = mysqli_fetch_array($Resultado2))
	{
		$Serie = $Fila2["RES_SERIE"];
		$Final = $Fila2["RES_AL"];

		$SubConsulta2 = "SELECT MAX(F_NUMERO) AS TOTAL FROM Bodega.FACTURA_SV WHERE F_SERIE = '".$Serie."' ";
		$SubResultado2 = mysqli_query($db, $SubConsulta2);
		while($SubFila2 = mysqli_fetch_array($SubResultado2))
		{
			$TotalFacturasSV = $SubFila2["TOTAL"];

			$TotalConsumoSV = (100 * $TotalFacturasSV) / $Final;
		}
	}

	if($TotalConsumoSV >= 75)
	{
		$NotificacionesConsumoSV = 1;
	}
	else
	{
		$NotificacionesConsumoSV = 0;
	}

	//ALERTA PARA CORRER LA PARTIDA DE DEPRECIACIÓN DE ACTIVOS FIJOS
	$ConsultaAF = "SELECT TRA_CODIGO FROM Contabilidad.TRANSACCION WHERE TT_CODIGO = 14 AND TRA_FECHA_TRANS BETWEEN '".$FechaInicioMes."' AND '".$FechaFinalMes."' AND E_CODIGO = 2";
	$ResultAF = mysqli_query($db, $ConsultaAF);
	$ExistePartida = mysqli_num_rows($ResultAF);
	if($ExistePartida == 0)
	{
		$PartidaDepreciacion = 0;
	}
	elseif($ExistePartida > 0)
	{
		$PartidaDepreciacion = 1;
	}
	
}
//ALERTAS PARA ENCARGADO DE BODEGA CENTRAL
if($Puesto == 16)
{
	$QueryProductos = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE FROM Bodega.PRODUCTO, Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION, Bodega.UNIDAD_MEDIDA
	WHERE TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
	AND TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
	AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
	AND TRANSACCION.B_CODIGO = 4
	GROUP BY TRANSACCION_DETALLE.P_CODIGO
	ORDER BY PRODUCTO.P_NOMBRE";
	$ResultProductos = mysqli_query($db, $QueryProductos);
	while($FilaProductos = mysqli_fetch_array($ResultProductos))
	{
		$CodigoProducto = $FilaProductos["P_CODIGO"];
		$ProductoNombre = $FilaProductos["P_NOMBRE"];
		$Minimo			= $FilaProductos["P_STOCK_MINIMO"];
		$UnidadMedida   = $FilaProductos["UM_NOMBRE"];

		$QueryStock = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS ENTRADAS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS SALIDAS
		FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
		WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
		AND TRANSACCION_DETALLE.P_CODIGO = ".$CodigoProducto."
		AND TRANSACCION.B_CODIGO = 4";

		$ResultStock = mysqli_query($db, $QueryStock);
		while($FilaStock = mysqli_fetch_array($ResultStock))
		{
			$Cargos = $FilaStock["ENTRADAS"];
			$Abonos = $FilaStock["SALIDAS"];

			$Stock = $Cargos - $Abonos;

			if($Stock < $Minimo)
			{
				$StockMinimoCentral++;
			}
		}

	}
}
//ALERTAS PARA ENCARGADO DE BODEGA HELADOS
if($Puesto == 16)
{
	$QueryProductos = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE FROM Bodega.PRODUCTO, Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION, Bodega.UNIDAD_MEDIDA
	WHERE TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
	AND TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
	AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
	AND TRANSACCION.B_CODIGO = 3
	GROUP BY TRANSACCION_DETALLE.P_CODIGO
	ORDER BY PRODUCTO.P_NOMBRE";
	$ResultProductos = mysqli_query($db, $QueryProductos);
	while($FilaProductos = mysqli_fetch_array($ResultProductos))
	{
		$CodigoProducto = $FilaProductos["P_CODIGO"];
		$ProductoNombre = $FilaProductos["P_NOMBRE"];
		$Minimo			= $FilaProductos["P_STOCK_MINIMO"];
		$UnidadMedida   = $FilaProductos["UM_NOMBRE"];

		$QueryStock = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS ENTRADAS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS SALIDAS
		FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
		WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
		AND TRANSACCION_DETALLE.P_CODIGO = ".$CodigoProducto."
		AND TRANSACCION.B_CODIGO = 3";

		$ResultStock = mysqli_query($db, $QueryStock);
		while($FilaStock = mysqli_fetch_array($ResultStock))
		{
			$Cargos = $FilaStock["ENTRADAS"];
			$Abonos = $FilaStock["SALIDAS"];

			$Stock = $Cargos - $Abonos;

			if($Stock < $Minimo)
			{
				$StockMinimoHelados++;
			}
		}

	}
}
//ALERTAS PARA ENCARGADO DE BODEGA TERRAZAS
if($Puesto == 15)
{
	$QueryProductos = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE FROM Bodega.PRODUCTO, Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION, Bodega.UNIDAD_MEDIDA
	WHERE TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
	AND TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
	AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
	AND TRANSACCION.B_CODIGO = 1
	GROUP BY TRANSACCION_DETALLE.P_CODIGO
	ORDER BY PRODUCTO.P_NOMBRE";
	$ResultProductos = mysqli_query($db, $QueryProductos);
	while($FilaProductos = mysqli_fetch_array($ResultProductos))
	{
		$CodigoProducto = $FilaProductos["P_CODIGO"];
		$ProductoNombre = $FilaProductos["P_NOMBRE"];
		$Minimo			= $FilaProductos["P_STOCK_MINIMO"];
		$UnidadMedida   = $FilaProductos["UM_NOMBRE"];

		$QueryStock = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS ENTRADAS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS SALIDAS
		FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
		WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
		AND TRANSACCION_DETALLE.P_CODIGO = ".$CodigoProducto."
		AND TRANSACCION.B_CODIGO = 1";

		$ResultStock = mysqli_query($db, $QueryStock);
		while($FilaStock = mysqli_fetch_array($ResultStock))
		{
			$Cargos = $FilaStock["ENTRADAS"];
			$Abonos = $FilaStock["SALIDAS"];

			$Stock = $Cargos - $Abonos;

			if($Stock < $Minimo)
			{
				$StockMinimoRestaurant++;
			}
		}

	}
}
//ALERTAS PARA ENCARGADO DE BODEGA SOUVENIR
if($Puesto == 18)
{
	$QueryProductos = "SELECT PRODUCTO.*, UNIDAD_MEDIDA.UM_NOMBRE FROM Bodega.PRODUCTO, Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION, Bodega.UNIDAD_MEDIDA
	WHERE TRANSACCION_DETALLE.P_CODIGO = PRODUCTO.P_CODIGO
	AND TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
	AND PRODUCTO.UM_CODIGO = UNIDAD_MEDIDA.UM_CODIGO
	AND TRANSACCION.B_CODIGO = 2
	GROUP BY TRANSACCION_DETALLE.P_CODIGO
	ORDER BY PRODUCTO.P_NOMBRE";
	$ResultProductos = mysqli_query($db, $QueryProductos);
	while($FilaProductos = mysqli_fetch_array($ResultProductos))
	{
		$CodigoProducto = $FilaProductos["P_CODIGO"];
		$ProductoNombre = $FilaProductos["P_NOMBRE"];
		$Minimo			= $FilaProductos["P_STOCK_MINIMO"];
		$UnidadMedida   = $FilaProductos["UM_NOMBRE"];

		$QueryStock = "SELECT SUM(TRANSACCION_DETALLE.TRAD_CARGO_PRODUCTO) AS ENTRADAS, SUM(TRANSACCION_DETALLE.TRAD_ABONO_PRODUCTO) AS SALIDAS
		FROM Bodega.TRANSACCION_DETALLE, Bodega.TRANSACCION
		WHERE TRANSACCION_DETALLE.TRA_CODIGO = TRANSACCION.TRA_CODIGO
		AND TRANSACCION_DETALLE.P_CODIGO = ".$CodigoProducto."
		AND TRANSACCION.B_CODIGO = 2";

		$ResultStock = mysqli_query($db, $QueryStock);
		while($FilaStock = mysqli_fetch_array($ResultStock))
		{
			$Cargos = $FilaStock["ENTRADAS"];
			$Abonos = $FilaStock["SALIDAS"];

			$Stock = $Cargos - $Abonos;

			if($Stock < $Minimo)
			{
				$StockMinimoSouvenir++;
			}
		}

	}
}
//ALERTAS PARA COLABORADOR COMPRAS Y PROVEEDURÍA
if($Puesto == 3)
{
	$Query = "SELECT REQUISICION.*, AREA_GASTO.AG_NOMBRE, REQUISICION_ESTADO.RE_NOMBRE 
	FROM Contabilidad.REQUISICION, Contabilidad.AREA_GASTO, Contabilidad.REQUISICION_ESTADO
	WHERE REQUISICION.AG_CODIGO = AREA_GASTO.AG_CODIGO
	AND REQUISICION.RE_CODIGO = REQUISICION_ESTADO.RE_CODIGO
	AND REQUISICION.R_FACTURA_COMPRA = ''
	AND REQUISICION.RE_CODIGO <> 4";
	$Result = mysqli_query($db, $Query);
	$NumeroRequisicionesCompra = mysqli_num_rows($Result);

	$query = "SELECT REQUISICION.*, REQUISICION_DETALLE.*, BODEGA.B_NOMBRE
												FROM Bodega.REQUISICION, Bodega.REQUISICION_DETALLE, Bodega.BODEGA
												WHERE REQUISICION.R_CODIGO = REQUISICION_DETALLE.R_CODIGO
												AND REQUISICION.B_CODIGO = BODEGA.B_CODIGO
												AND RT_CODIGO = 1
												AND R_ESTADO = 1";
									$result = mysqli_query($db, $query);
									$NumeroSolicitudesBodega = mysqli_num_rows($result);
}


//ALERTAS PARA TODO EL PERSONAL
$ConsultaFacturasRechazadas = "SELECT TRA_CODIGO FROM Contabilidad.TRANSACCION WHERE TRA_USUARIO = '".$SelfCIF."' AND E_CODIGO = 3 AND TRA_VISTO = 0";
$ResultadoCRR = mysqli_query($db, $ConsultaFacturasRechazadas);
$NotificacionesCFF = mysqli_num_rows($ResultadoCRR);



$TotalNotificaciones = ($NotificacionesResoluciones) + $NotificacionesConsumoTR + $NotificacionesConsumoSV + $NotificacionesCFF + $PartidaDepreciacion + $StockMinimoCentral + $StockMinimoHelados + $StockMinimoSouvenir + $StockMinimoRestaurant + $NumeroRequisicionesCompra + $NumeroSolicitudesBodega;
?>
<header id="header" >
	<div class="headerbar">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="headerbar-left">
			<ul class="header-nav header-nav-options">
				<li class="header-nav-brand" >
					<div class="brand-holder">
						<span class="text-lg text-bold text-primary"><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/index.php"> <img src="<?php $_SERVER['DOCUMENT_ROOT']?>/img/logo.png" ></a></span>
					</div>
				</li>
			</ul>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="headerbar-right">
			<ul class="header-nav header-nav-options">
				<li class="dropdown hidden-xs">
					<a class="btn btn-icon-toggle btn-default" data-toggle="dropdown">
						<?php
						if($TotalNotificaciones == 0)
						{
							echo '<i class="fa fa-bell"></i><sup class="badge style-primary">0</sup>';	
						}
						elseif($TotalNotificaciones > 0)
						{
							echo '<i class="fa fa-bell"></i><sup class="badge style-danger">'.$TotalNotificaciones.'</sup>';	
						}
						else
						{
							echo '<i class="fa fa-bell"></i><sup class="badge style-primary">0</sup>';	
						}


						?>
						<ul class="dropdown-menu animation-expand">
					</a>
					<?php
					//MOSTRAR NOTIFICACIONES DE VENCIMIENTO DE RESOLUCIONES DE FACUTRA DE RESTAURANTE
					if($TotalConsumo >= 75)
					{
						?>
							
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Conta_Chatun/Mantenimiento/Res.php" class="alert alert-callout alert-danger">
										<b>75% O Más de Consumo de Facturas TR</b>
									</a>
								</li>
						<?php
					}
					//MOSTRAR NOTIFICACIONES DE VENCIMIENTO DE RESOLUCIONES DE FACUTRA DE SOUVENIRS
					if($TotalConsumoSV >= 75)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Conta_Chatun/Mantenimiento/Res.php" class="alert alert-callout alert-danger">
										<b>75% O Más de Consumo de Facturas SV</b>
									</a>
								</li>
						<?php
					}
					//MOSTRAR NOTIFICACIONES DE CONSUMO DE 75% DE FACTURAS
					if($NotificacionesResoluciones > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Conta_Chatun/Mantenimiento/Res.php" class="alert alert-callout alert-danger">
										<b>Resoluciones por Vencer, menor a 10 días</b>
									</a>
								</li>
						<?php
					}
					//MOSTRAR NOTIFICACIONES DE FACTURAS RECHAZADAS
					if($NotificacionesCFF > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Conta_Chatun/Otros_Reportes/TR.php" class="alert alert-callout alert-danger">
										<b>Transacción Rechazada</b>
									</a>
								</li>
						<?php
					}
					//MOSTRAR NOTIFICACIONES DE CORRER PARTIDA DE DEPRECIACION
					if($PartidaDepreciacion == 0)
					{
						if($DiaHoy >= 28)
						{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Conta_Chatun/Activos_Fijos/PD.php" class="alert alert-callout alert-warning">
										<b>Partida de Depreciación</b>
									</a>
								</li>
						<?php
						}
					}
					//MOSTRAR NOTIFICACIONES PARA STOCK MINIMO DE BODEGA CENTRA
					
					if($StockMinimoCentral > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Bodega/Reportes/Min.php" class="alert alert-callout alert-danger">
										<b>Stock Mínimo Bodega Central</b>
									</a>
								</li>
						<?php
					}
					if($StockMinimoHelados > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/CYM/Helados/Reportes/Min.php" class="alert alert-callout alert-danger">
										<b>Stock Mínimo</b>
									</a>
								</li>
						<?php
					}
					if($StockMinimoRestaurant > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/CYM/Restaurant/Reportes/Min.php" class="alert alert-callout alert-danger">
										<b>Stock Mínimo</b>
									</a>
								</li>
						<?php
					}
					if($StockMinimoSouvenir > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/CYM/Souvenirs/Reportes/Min.php" class="alert alert-callout alert-danger">
										<b>Stock Mínimo</b>
									</a>
								</li>
						<?php
					}
					if($NumeroRequisicionesCompra > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Conta_Chatun/Facturas/RCP.php" class="alert alert-callout alert-danger">
										<b>Requisición Pendiente</b>
									</a>
								</li>
						<?php
					}
					if($NumeroSolicitudesBodega > 0)
					{
						?>
								<li>
									<a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ProgramFiles/APPS/Contabilidad/Conta_Chatun/Facturas/Solicitud.php" class="alert alert-callout alert-danger">
										<b>Solicitudes Bodega</b>
									</a>
								</li>
						<?php
					}
					?>			
					</ul>		
				</li><!--end .dropdown -->
			</ul><!--end .header-nav-options -->
			<ul class="header-nav header-nav-profile">
				<li class="dropdown">
					<a class="dropdown-toggle ink-reaction" data-toggle="dropdown">
						<span class="profile-info text-center">
							Bienvenido 
							<b><small><?php echo $_SESSION["nombre_user"]; ?></small></b>
						</span>
					</a>
					<ul class="dropdown-menu animation-dock">
						<li><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/Script/CambiarPass.php?user=<?php echo $_SESSION['login']; ?>"><i class="fa fa-fw fa-refresh text-success"></i> Cambiar Contraseña</a></li>
						<li><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/locked.php?user=<?php echo $_SESSION['login']; ?>&Nombre=<?php echo $_SESSION["nombre_user"] ?>&Actual=<?php echo $Actual; ?>"><i class="fa fa-fw fa-lock"></i> Bloquear</a></li>
						<li><a href="<?php $_SERVER['DOCUMENT_ROOT']?>/Script/salida.php"><i class="fa fa-fw fa-power-off text-danger"></i> Logout</a></li>
					</ul><!--end .dropdown-menu -->
				</li><!--end .dropdown -->
			</ul><!--end .header-nav-profile -->
		</div><!--end #header-navbar-collapse -->
	</div>
</header>
<!-- END HEADER-->