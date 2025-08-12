<?php
ob_start();
include("../Script/seguridad.php");
include("../../../../../Script/conex.php");

$sql_periodo = "SELECT * FROM Estado_Patrimonial.periodo order by id desc limit 1 ";
$result_periodo = mysqli_query($db, $sql_periodo) or die("".mysqli_error());
$row_periodo=mysqli_fetch_array($result_periodo); 
echo $mes_periodo=$row_periodo[1];
echo $anio_periodo=$row_periodo[2];


session_start();
	$auxi=$_SESSION["iduser"];
	$grabar = $_GET["grabar"];
//	****	CAMPOS ESTADO PATRIMONIAL
	$caja = $_POST["caja"];
	$depositos_coosajo = $_POST["depositos_coosajo"];
	$depositos_bancos = $_POST["depositos_bancos"];
	$fondo_retiro = $_POST["fondo_retiro"];
	$cuentas_cobrar = $_POST["cuentas_cobrar"];
	$subtotal_activocirculante = $caja + $depositos_coosajo + $depositos_bancos + $fondo_retiro + $cuentas_cobrar;
	$terrenos = $_POST["terrenos"];
	$vehiculos = $_POST["vehiculos"];
	$mobiliario = $_POST["mobiliario"];
	$inversiones_ganado = $_POST["inversiones_ganado"];
	$inversiones_valores = $_POST["inversiones_valores"];
	$otros_activos = $_POST["otros_activos"];
	$subtotal_activofijo = $terrenos + $vehiculos + $mobiliario + $inversiones_ganado + $inversiones_valores + $otros_activos;
	$total_activo = $subtotal_activocirculante + $subtotal_activofijo;
	$prestamos_coosajo_menor = $_POST["prestamos_coosajo_menor"];
	$prestamos_bancos_menor = $_POST["prestamos_bancos_menor"];
	$anticipo_sueldo = $_POST["anticipo_sueldo"];
	$otros_prestamos = $_POST["otros_prestamos"];
	$tarjetas_credito = $_POST["tarjetas_credito"];
	$cuentas_por_pagar = $_POST["cuentas_por_pagar"];
	$proveedores = $_POST["proveedores"];
	$otros_pasivocirculante = $_POST["otros_pasivocirculante"];
	$subtotal_pasivocirculante = $prestamos_coosajo_menor + $prestamos_bancos_menor + $anticipo_sueldo + $otros_prestamos + $tarjetas_credito + $cuentas_por_pagar + $proveedores + $otros_pasivocirculante;
	$prestamos_coosajo_mayores = $_POST["prestamos_coosajo_mayores"];
	$prestamos_bancos_mayores = $_POST["prestamos_bancos_mayores"];
	$otras_deudas = $_POST["otras_deudas"];
	$subtotal_pasivofijo = $prestamos_coosajo_mayores + $prestamos_bancos_mayores + $otras_deudas;
	$total_pasivo = $subtotal_pasivocirculante + $subtotal_pasivofijo;
	$patrimonio = $total_activo - $total_pasivo;
	$total_pasivo_patrimonio = $patrimonio + $total_pasivo;
//	****	****
//	****	CAMPOS DE PROYECCION
	$sueldos_salarios = $_POST["sueldos_salarios"];
	$bonificaciones = $_POST["bonificaciones"];
	$alquileres_rentas = $_POST["alquileres_rentas"];
	$jubilaciones_pensiones = $_POST["jubilaciones_pensiones"];
	$bono14_aguinaldo = $_POST["bono14_aguinaldo"];
	$otros_ingresos = $_POST["otros_ingresos"];
	$gastos_personales = $_POST["gastos_personales"];
	$gastos_familiares = $_POST["gastos_familiares"];	
	$descuentos_salariales = $_POST["descuentos_salariales"];
	$amortizacion_creditos = $_POST["amortizacion_creditos"];
	$pago_tarjetas_credito = $_POST["pago_tarjetas_credito"];
	$otros_egresos = $_POST["otros_egresos"];
	$total_ingresos = $sueldos_salarios + $bonificaciones + $alquileres_rentas + $jubilaciones_pensiones + $otros_ingresos;
	$total_egresos = $gastos_personales + $gastos_familiares + $descuentos_salariales + $amortizacion_creditos + $pago_tarjetas_credito + $otros_egresos;	
//	****	****
	$verifica_filas = "SELECT COUNT(id) as hay FROM Estado_Patrimonial.detalle_estado_patrimonial WHERE id = '$auxi' and mes=$mes_periodo and anio=$anio_periodo ";
	$resultado123 = mysqli_query($db, $verifica_filas) or die ("No hay filas"); 
	$row123=mysqli_fetch_array($resultado123);
	$num_reg = $row123["hay"];


//verificar el campo planilla si se hacen cambios
	$actualizar = "UPDATE Estado_Patrimonial.empleados SET `FechaActualizacion` = NOW() WHERE id ='$auxi'" ;
	mysqli_query($db, $actualizar) or die (mysqli_error());




	if($num_reg>0) 
	{ 
		$insertar = "UPDATE Estado_Patrimonial.detalle_estado_patrimonial SET caja = '$caja', depositos_coosajo = '$depositos_coosajo', depositos_bancos = '$depositos_bancos', fondo_retiro = '$fondo_retiro', cuentas_cobrar = '$cuentas_cobrar', subtotal_activocirculante = '$subtotal_activocirculante', 		terrenos = '$terrenos', vehiculos = '$vehiculos', mobiliario = '$mobiliario', inversiones_ganado = '$inversiones_ganado', inversiones_valores = '$inversiones_valores', otros_activos = '$otros_activos', subtotal_activofijo = '$subtotal_activofijo', total_activo = '$total_activo', prestamos_coosajo_menor = '$prestamos_coosajo_menor', prestamos_bancos_menor = '$prestamos_bancos_menor', anticipo_sueldo = '$anticipo_sueldo', otros_prestamos = '$otros_prestamos', tarjetas_credito = '$tarjetas_credito', cuentas_por_pagar = '$cuentas_por_pagar', proveedores = '$proveedores', otros_pasivocirculante = '$otros_pasivocirculante', subtotal_pasivocirculante = '$subtotal_pasivocirculante', prestamos_coosajo_mayores = '$prestamos_coosajo_mayores', prestamos_bancos_mayores = '$prestamos_bancos_mayores', otras_deudas = '$otras_deudas', subtotal_pasivofijo = '$subtotal_pasivofijo', total_pasivo = '$total_pasivo', patrimonio = '$patrimonio', total_pasivo_patrimonio = '$total_pasivo_patrimonio' WHERE id = '$auxi' and mes=$mes_periodo and anio=$anio_periodo ";
	} else  { 
		$insertar = "INSERT INTO Estado_Patrimonial.detalle_estado_patrimonial (id, caja, depositos_coosajo, depositos_bancos, fondo_retiro, cuentas_cobrar, subtotal_activocirculante, terrenos, vehiculos, mobiliario, inversiones_ganado, inversiones_valores, otros_activos, subtotal_activofijo, total_activo, prestamos_coosajo_menor, prestamos_bancos_menor, anticipo_sueldo, otros_prestamos, tarjetas_credito, cuentas_por_pagar, proveedores, otros_pasivocirculante, subtotal_pasivocirculante, prestamos_coosajo_mayores, prestamos_bancos_mayores, otras_deudas, subtotal_pasivofijo, total_pasivo, patrimonio, total_pasivo_patrimonio, mes, anio) VALUES ('$auxi', '$caja', '$depositos_coosajo', '$depositos_bancos', '$fondo_retiro', '$cuentas_cobrar', '$subtotal_activocirculante', '$terrenos', '$vehiculos', '$mobiliario', '$inversiones_ganado', '$inversiones_valores', '$otros_activos', '$subtotal_activofijo', '$total_activo', '$prestamos_coosajo_menor', '$prestamos_bancos_menor', '$anticipo_sueldo', '$otros_prestamos', '$tarjetas_credito', '$cuentas_por_pagar', '$proveedores', '$otros_pasivocirculante', '$subtotal_pasivocirculante', '$prestamos_coosajo_mayores', '$prestamos_bancos_mayores', '$otras_deudas', '$subtotal_pasivofijo', '$total_pasivo', '$patrimonio', '$total_pasivo_patrimonio', $mes_periodo, $anio_periodo)";
	} 
	mysqli_query ($insertar) or die ("No ejecuta Update vs Insert no sirve"."    ".mysqli_error());

	$verifica_filas_1 = "SELECT COUNT(id) as hay FROM Estado_Patrimonial.detalle_proyeccion_ingresos_egresos WHERE colaborador = '$auxi' and mes=$mes_periodo and anio=$anio_periodo ";
	$resultado1234 = mysqli_query($db, $verifica_filas_1) or die ("No hay filas"); 
	$row1234=mysqli_fetch_array($resultado1234);
	$num_reg_1 = $row123["hay"];

	if($num_reg_1>0) 
	{ 
		$insertar2 = "UPDATE Estado_Patrimonial.detalle_proyeccion_ingresos_egresos SET colaborador = '$auxi', sueldos_salarios = '$sueldos_salarios', bonificaciones = '$bonificaciones', alquileres_rentas = '$alquileres_rentas', jubilaciones_pensiones = '$jubilaciones_pensiones', bono14_aguinaldo = '$bono14_aguinaldo', otros_ingresos = '$otros_ingresos', total_ingresos = '$total_ingresos', gastos_personales = '$gastos_personales', gastos_familiares = '$gastos_familiares', descuentos_salariales = '$descuentos_salariales', amortizacion_creditos = '$amortizacion_creditos', pago_tarjetas_credito = '$pago_tarjetas_credito', otros_egresos = '$otros_egresos', total_egresos = '$total_egresos' WHERE colaborador = '$auxi' and mes=$mes_periodo and anio=$anio_periodo ";
	} else { 
		$insertar2 = "INSERT INTO Estado_Patrimonial.detalle_proyeccion_ingresos_egresos (colaborador, sueldos_salarios, bonificaciones, alquileres_rentas, jubilaciones_pensiones, bono14_aguinaldo, otros_ingresos, total_ingresos, gastos_personales, gastos_familiares, descuentos_salariales, amortizacion_creditos, pago_tarjetas_credito, otros_egresos, total_egresos, mes, anio) VALUES ('$auxi', '$sueldos_salarios', '$bonificaciones', '$alquileres_rentas', '$jubilaciones_pensiones', '$bono14_aguinaldo', '$otros_ingresos', '$total_ingresos', '$gastos_personales', '$gastos_familiares', '$descuentos_salariales', '$amortizacion_creditos', '$pago_tarjetas_credito', '$otros_egresos', '$total_egresos', $mes_periodo, $anio_periodo)";
	} 
	mysqli_query ($insertar2) or die ("No graba en el apartado de Proyeccion de Ingresos e Egresos"."    ".mysqli_error());
	header ("Location: estado_patrimonial.php");		
?>	