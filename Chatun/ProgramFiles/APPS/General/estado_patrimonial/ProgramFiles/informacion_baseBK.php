<?php
ob_start();
session_start();
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/cambiofecha.php");
//	$auxi=$_SESSION["cuenta"];
$auxi=$_SESSION["iduser"];
$sql1="SELECT * FROM coosajo_base_bbdd.usuarios WHERE id_user=$auxi";
$result1=mysqli_query($db, $sql1);
$row1=mysqli_fetch_array($result1);
//echo $row1["nombre"];
//	echo $auxi;
$sql0="SELECT * FROM coosajo_base_patrimonio.empleados WHERE id=$auxi";
$result1=mysqli_query($db, $sql0);
$datos=mysqli_fetch_array($result1);     
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de Gestión de Colaboradores - Departamento IDT - Coosajo R.L.</title>
</head>

<?php   
$sumatoria_hijos = 0;
$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id) as total FROM coosajo_base_patrimonio.detalle_parentescos WHERE colaborador=$auxi AND parentesco = 'Hijo / Hija'"));
$sumatoria_hijos = $tmp[0];
		
$sumatoria_parentescos = 0;  
$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id) as total FROM coosajo_base_patrimonio.detalle_parentescos WHERE colaborador=$auxi"));
$sumatoria_parentescos = $tmp[0];
		
$sumatoria_organizaciones = 0;
$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id) as total FROM coosajo_base_patrimonio.detalle_organizaciones_civiles WHERE colaborador=$auxi"));
$sumatoria_organizaciones = $tmp[0];

$sumatoria_pasivo_contingente = 0;
$tmp = mysqli_fetch_row(mysqli_query($db, "SELECT COUNT(id) as total FROM coosajo_base_patrimonio.detalle_pasivo_contingente WHERE colaborador=$auxi"));
$sumatoria_pasivo_contingente = $tmp[0];
?>
<script language="JavaScript" type="text/javascript">
//--------------- LOCALIZEABLE GLOBALS ---------------
var d=new Date();
var monthname=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octuber","Noviembre","Diciembre");
//Ensure correct for language. English is "January 1, 2004"
var TODAY =  d.getDate() + " de " + monthname[d.getMonth()] + " del " + d.getFullYear();
//---------------   END LOCALIZEABLE   ---------------
var Guatemala01Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Guatemala')",
"('02-Santa Catarina Pinula')",
"('03-San José Pinula')",
"('04-San José del Golfo')",
"('05-Palencia')",
"('06-Chinautla')",
"('07-San Pedro Ayampuc')",
"('08-Mixco')",
"('09-San Pedro Sacatepéquez')",
"('10-San Juan Sacatepéquez')",
"('11-San Raimundo')",
"('12-Chuarrancho')",
"('13-Fraijanes')",
"('14-Amatitlán')",
"('15-Villa Nueva')",
"('16-Villa Canales')",
"('17-Petapa')");

var Sacatepequez02Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Antigua Guatemala')",
"('02-Jocotenango')",
"('03-Pastores')",
"('04-Santo Domingo Xenacoj')",
"('05-Sumpango')",
"('06-Santiago Sacatepéquez')",
"('07-San Bartolomé Milpas Altas')",
"('08-San Lucas Sacatepéquez')",
"('09-Santa Lucía Milpas Altas')",
"('10-Magdalena Milpas Altas')",
"('11-Santa María de Jesús')",
"('12-Ciudad Vieja')",
"('13-San Miguel Dueñas')",
"('14-Alotenango')",
"('15-San Antonio Aguas Calientes')",
"('16-Santa Catarina Barahona')");

var Chimaltenango03Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Chimaltenango')",
"('02-San José Poaquíl')",
"('03-San Martín Jilotepeque')",
"('04-San Juan Comalapa')",
"('05-Santa Apolonia')",
"('06-Tecpán Guatemala')",
"('07-Patzún')",
"('08-Pochuta')",
"('09-Patzicía')",
"('10-Santa Cruz Balanyá')",
"('11-Acatenango')",
"('12-Yepocapa')",
"('13-San Andrés Itzapa')",
"('14-Parramos')",
"('15-Zaragoza')",
"('16-El Tejar')");

var ElProgreso04Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Guastatoya')",
"('02-Morazán')",
"('03-San Agustín Acasaguastlán')",
"('04-San Cristóbal Acasaguastlán')",
"('05-El Jícaro')",
"('06-Sansare')",
"('07-Sanarate')",
"('08-San Antonio La Paz')");

var Escuintla05Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Escuintla')",
"('02-Santa Lucía Cotzumalguapa')",
"('03-La Democracia')",
"('04-Siquinalá')",
"('05-Masagua')",
"('06-Tiquisate')",
"('07-La Gomera')",
"('08-Guanagazapa')",
"('09-San José')",
"('10-Iztapa')",
"('11-Palín')",
"('12-San Vicente Pacaya')",
"('13-Nueva Concepción')");

var SantaRosa06Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Cuilapa')",
"('02-Barberena')",
"('03-Santa Rosa de Lima')",
"('04-Casillas')",
"('05-San Rafaél Las Flores')",
"('06-Oratorio')",
"('07-San Juan Tecuaco')",
"('08-Chiquimulilla')",
"('09-Taxisco')",
"('10-Santa María Ixhuatán')",
"('11-Guazacapán')",
"('12-Santa Cruz Naranjo')",
"('13-Pueblo Nuevo Viñas')",
"('14-Nueva Santa Rosa')");

var Solola07Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Sololá')",
"('02-San José Chacayá')",
"('03-Santa María Visitación')",
"('04-Santa Lucía Utatlán')",
"('05-Nahualá')",
"('06-Santa Catarina Ixtahuacan')",
"('07-Santa Clara La Laguna ')",
"('08-Concepción')",
"('09-San Andrés Semetabaj ')",
"('10-Panajachel')",
"('11-Santa Catarina Palopó')",
"('12-San Antonio Palopó')",
"('13-San Lucas Tolimán')",
"('14-Santa Cruz La Laguna')",
"('15-San Pablo La Laguna')",
"('16-San Marcos La Laguna')",
"('17-San Juan La Laguna')",
"('18-San Pedro La Laguna')",
"('19-Santiago Atitlán')");

var Totonicapan08Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Totonicapán')",
"('02-San Cristóbal Totonicapán')",
"('03-San Francisco El Alto')",
"('04-San Andrés Xecul')",
"('05-Momostenango')",
"('06-Santa María Chiquimula')",
"('07-Santa Lucía La Reforma')",
"('08-San Bartolo')");

var Quezaltenango09Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Quetzaltenango')",
"('02-Salcajá')",
"('03-Olintepeque')",
"('04-San Carlos Sija')",
"('05-Sibilia')",
"('06-Cabricán')",
"('07-Cajolá')",
"('08-San Miguel Sigüilá')",
"('09-Ostuncalco')",
"('10-San Mateo')",
"('11-Concepción Chiquirichapa')",
"('12-San Martín Sacatepéquez')",
"('13-Almolonga')",
"('14-Cantel')",
"('15-Huitán')",
"('16-Zunil')",
"('17-Colomba')",
"('18-San Francisco La Unión')",
"('19-El Palmar')",
"('20-Coatepeque')",
"('21-Génova')",
"('22-Flores Costa Cuca')",
"('23-La Esperanza')",
"('24-Palestina de Los Altos')");

var Suchitepequez10Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Mazatenango')",
"('02-Cuyotenango')",
"('03-San Francisco Zapotitlán')",
"('04-San Bernardino')",
"('05-San José El Idolo')",
"('06-Santo Domingo Suchitepequez')",
"('07-San Lorenzo')",
"('08-Samayac')",
"('09-San Pablo Jocopilas')",
"('10-San Antonio Suchitepequez')",
"('11-San Miguel Panán')",
"('12-San Gabriel')",
"('13-Chicacao')",
"('14-Patulul')",
"('15-Santa Barbara')",
"('16-San Juan Bautista')",
"('17-Santo Tomas La Unión')",
"('18-Zunilito')",
"('19-Pueblo Nuevo')",
"('20-Río Bravo')");

var Retalhuleu11Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Retalhuleu')",
"('02-San Sebastián')",
"('03-Santa Cruz Muluá')",
"('04-San Martín Zapotitlán')",
"('05-San Felipe')",
"('06-San Andrés Villa Seca')",
"('07-Champerico')",
"('08-Nuevo San Carlos')",
"('09-El Asintal')");

var SanMarcos12Array = new Array("('Seleccione Municipio','',true,true)",
"('01-San Marcos')",
"('02-San Pedro Sacatepéquez')",
"('03-San Antonio Sacatepéquez')",
"('04-Comitancillo')",
"('05-San Miguel Ixtahuacán')",
"('06-Concepción Tutuapa')",
"('07-Tacaná')",
"('08-Sibinal')",
"('09-Tajumulco')",
"('10-Tejutla')",
"('11-San Rafaél Pie de La Cuesta.')",
"('12-Nuevo Progreso')",
"('13-El Tumbador')",
"('14-El Rodeo')",
"('15-Malacatán')",
"('16-Catarina')",
"('17-Ayutla')",
"('18-Ocos')",
"('19-San Pablo')",
"('20-El Quetzal')",
"('21-La Reforma')",
"('22-Pajapita')",
"('23-Ixchiguan')",
"('24-San José Ojetenam')",
"('25-San Cristobal Cucho')",
"('26-Sipacapa')",
"('27-Esquipulas Palo Gordo')",
"('28-Río Blanco')",
"('29-San Lorenzo')");

var Huehuetenango13Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Huehuetenango')",
"('02-Chiantla')",
"('03-Malacatancito')",
"('04-Cuilco')",
"('05-Nentón')",
"('06-San Pedro Necta')",
"('07-Jacaltenango')",
"('08-Soloma')",
"('09-Ixtahuacán')",
"('10-Santa Bárbara')",
"('11-La Libertad')",
"('12-La Democracia')",
"('13-San Miguel Acatán')",
"('14-San Rafaél La Independencia')",
"('15-Todos Santos Cuchumatán')",
"('16-San Juan Atitán')",
"('17-Santa Eulalia')",
"('18-San Mateo Ixtatán')",
"('19-Colotenango')",
"('20-San Sebastián Huehuetenango')",
"('21-Tectitán')",
"('22-Concepción Huista ')",
"('23-San Juan Ixcoy')",
"('24-San Antonio Huista')",
"('25-San Sebastián Coatán')",
"('26-Santa Cruz Barillas')",
"('27-Aguacatán')",
"('28-San Rafaél Petzal')",
"('29-San Gaspar Ixchil')",
"('30-Santiago Chimaltenango')",
"('31-Santa Ana Huista')");

var Quiche14Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Santa Cruz del Quiché')",
"('02-Chiché')",
"('03-Chinique')",
"('04-Zacualpa')",
"('05-Chajul')",
"('06-Chichicastenango')",
"('07-Patzité')",
"('08-San Antonio Ilotenango')",
"('09-San Pedro Jocopilas')",
"('10-Cunén')",
"('11-San Juan Cotzal')",
"('12-Joyabaj')",
"('13-Nebaj')",
"('14-San Andrés Sajcabajá')",
"('15-Uspantán')",
"('16-Sacapulas')",
"('17-San Bartolomé Jocotenango')",
"('18-Canillá')",
"('19-Chicamán')",
"('20-Ixcán')",
"('21-Pachalum')");

var BajaVerapaz15Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Salamá')",
"('02-San Miguel Chicaj')",
"('03-Rabinal')",
"('04-Cubulco')",
"('05-Granados')",
"('06-El Chol')",
"('07-San Jerónimo')",
"('08-Purulhá')");

var AltaVerapaz16Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Cobán')",
"('02-Santa Cruz Verapaz')",
"('03-San Cristóbal Verapaz')",
"('04-Tactic')",
"('05-Tamahú')",
"('06-Tucurú')",
"('07-Panzós')",
"('08-Senahú')",
"('09-San Pedro Carchá')",
"('10-San Juan Chamelco')",
"('11-Lanquín')",
"('12-Cahabón')",
"('13-Chisec')",
"('14-Chahal')",
"('15-Fray Bartolomé de las Casas')");

var Peten17Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Flores')",
"('02-San José')",
"('03-San Benito')",
"('04-San Andrés')",
"('05-La Libertad')",
"('06-San Francisco')",
"('07-Santa Ana')",
"('08-Dolores')",
"('09-San Luis')",
"('10-Sayaxché')",
"('11-Melchor de Mencos')",
"('12-Poptún')");

var Izabal18Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Puerto Barrios')",
"('02-Livingston')",
"('03-El Estor')",
"('04-Morales')",
"('05-Los Amates')");

var Zacapa19Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Zacapa')",
"('02-Cabañas')",
"('03-Estanzuela')",
"('04-Gualán')",
"('05-Huité')",
"('06-La Unión')",
"('07-Río Hondo')",
"('08-San Diego')",
"('09-Teculután')",
"('10-Usumatlán')");

var Chiquimula20Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Chiquimula')",
"('02-San José La Arada')",
"('03-San Juan Ermita')",
"('04-Jocotán')",
"('05-Camotán')",
"('06-Olopa')",
"('07-Esquipulas')",
"('08-Concepción Las Minas')",
"('09-Quezaltepeque')",
"('10-San Jacinto')",
"('11-Ipala')");

var Jalapa21Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Jalapa')",
"('02-San Pedro Pinula')",
"('03-San Luis Jilotepeque')",
"('07-San Manuel Chaparrón')",
"('08-San Carlos Alzatate')",
"('09-Monjas')",
"('10-Mataquescuintla')");

var Jutiapa22Array = new Array("('Seleccione Municipio','',true,true)",
"('01-Jutiapa')",
"('02-El Progreso')",
"('03-Santa Catarina Mita')",
"('04-Agua Blanca')",
"('05-Asunción Mita')",
"('06-Yupiltepeque')",
"('07-Atescatempa')",
"('08-Jerez')",
"('09-El Adelanto')",
"('10-Zapotitlán')",
"('11-Comapa')",
"('12-Jalpatagua')",
"('13-Conguaco')",
"('14-Moyuta')",
"('15-Pasaco')",
"('16-San José Acatempa')",
"('17-Quezada')");

function populateCountry(inForm,selected) {
	var selectedArray = eval(selected + "Array");
	while (selectedArray.length < inForm.country.options.length) {
		inForm.country.options[(inForm.country.options.length - 1)] = null;
	}
	for (var i=0; i < selectedArray.length; i++) {
		eval("inForm.country.options[i]=" + "new Option" + selectedArray[i]);
	}
	if (inForm.region.options[0].value == '') {
		inForm.region.options[0]= null;
	}
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function cerrar(){
	if (confirm("Esta seguro de salir de la aplicacion")){
		window.close();
	}
}
function validar_datos(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/[A-Za-z\s]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 
function validar_datos1(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    patron =/[0-9\s]/; // 4
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 
function orden() {
	if (document.form_general.tipo_documento.value != 1) {
	document.form_general.no_orden.disabled= true;
	}
if (document.form_general.tipo_documento.value == 1) {
	document.form_general.no_orden.disabled= false;
	
}
}
function civil() {
	if (document.form_general.estado_civil.value != 1) {
	document.form_general.nombre_conyugue.disabled= true;
	}
if (document.form_general.estado_civil.value == 1) {
	document.form_general.nombre_conyugue.disabled= false;
	
}
}

function Grabar2() {
	document.form_general.submit();	
}
function Ventana_parentescos() {
	document.form_general.submit();
	window.location="parentescos.php";
}
function Ventana_pasivo() {
	document.form_general.submit();
	window.location="pasivo_contingente.php";
}
function Ventana_organizaciones() {
	document.form_general.submit();
	window.location="organizaciones.php";
}
function Ventana_hijos() {
	document.form_general.submit();
	window.location="hijos.php";
}
function Verificar() {
	if (document.form_general.propiedad_inmueble.value == 'Otro') {
		document.form_general.observaciones_adicionales.disabled = false;
		document.form_general.observaciones_adicionales.style.backgroundColor="#FF9";
		document.form_general.observaciones_adicionales.focus();
	}
	if (document.form_general.propiedad_inmueble.value != 'Otro') {
		document.form_general.observaciones_adicionales.disabled = true;
		document.form_general.observaciones_adicionales.style.backgroundColor="#FFFFFF";
	}

}
function operar() {	
		if (document.form_general.nombre1.value != "") {
			if (document.form_general.apellido1.value != "") {
				document.form_general.submit();
			} else {
				(alert("el apellido no debe estar vacio"));
			}
		} else {
			(alert("el nombre no debe estar vacio"));
		}
		
}
function Validar(Cadena){   
    var Fecha= new String(Cadena);   // Crea un string   
	Fecha = Fecha.replace("/","-");
	Fecha = Fecha.replace("/","-");
	document.form_general.fecha_nacimiento.value = Fecha;
    var RealFecha= new Date()   // Para sacar la fecha de hoy   
    // Cadena Año   
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))   
    // Cadena Mes   
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))   
    // Cadena Día   
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))   
    var year= RealFecha.getYear();
  
	if (document.form_general.fecha_nacimiento.value != "00-00-0000") {

    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1910 || parseFloat(Ano)>(year)){   
		alert('Año inválido');
		document.form_general.fecha_nacimiento.value = "00-00-0000";
		document.form_general.fecha_nacimiento.select();
        return true;
    }   
    // Valido el Mes   
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){   
        alert('Mes inválido') ;
			document.form_general.fecha_nacimiento.value = "00-00-0000";
			document.form_general.fecha_nacimiento.select();
       return true   
    }   
    // Valido el Dia   
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){   
       alert('Día inválido')  ;
			document.form_general.fecha_nacimiento.value = "00-00-0000";
			document.form_general.fecha_nacimiento.select();
       return true   
    }   
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {   
        if (Mes==2 && Dia > 28 || Dia>30) {   
            alert('Día inválido')   
			document.form_general.fecha_nacimiento.value = "00-00-0000";
			document.form_general.fecha_nacimiento.select();
        return true   
        }   
    }   
       
  //para que envie los datos, quitar las  2 lineas siguientes   
//  alert("Fecha correcta.")   
	}
  return false
}     
function Validar1(Cadena){   
    var Fecha= new String(Cadena)   // Crea un string   
	Fecha = Fecha.replace("/","-")
	Fecha = Fecha.replace("/","-")
	document.form_general.fecha_iniciolabores.value = Fecha;
    var RealFecha= new Date()   // Para sacar la fecha de hoy   
    // Cadena Año   
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))   
    // Cadena Mes   
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))   
    // Cadena Día   
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))   
    var year= RealFecha.getYear();
	// Valido el año   

	if (document.form_general.fecha_iniciolabores.value != "00-00-0000") {

    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1910 || parseFloat(Ano)>(year)){   
		alert('Año inválido');
		document.form_general.fecha_iniciolabores.value = "00-00-0000";
		document.form_general.fecha_iniciolabores.select();
        return true;
    }   
    // Valido el Mes   
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){   
        alert('Mes inválido') ;
			document.form_general.fecha_iniciolabores.value = "00-00-0000";
			document.form_general.fecha_iniciolabores.select();
       return true   
    }   
    // Valido el Dia   
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){   
       alert('Día inválido')  ;
			document.form_general.fecha_iniciolabores.value = "00-00-0000";
			document.form_general.fecha_iniciolabores.select();
       return true   
    }   
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {   
        if (Mes==2 && Dia > 28 || Dia>30) {   
            alert('Día inválido')   
			document.form_general.fecha_iniciolabores.value = "00-00-0000";
			document.form_general.fecha_iniciolabores.select();
        return true   
        }   
    }   
       
  //para que envie los datos, quitar las  2 lineas siguientes   
//  alert("Fecha correcta.")   
	}
  return false
}   
function Validar2(Cadena){   
    var Fecha= new String(Cadena)   // Crea un string   
	Fecha = Fecha.replace("/","-")
	Fecha = Fecha.replace("/","-")
	document.form_general.fecha_reiniciolabores.value = Fecha;
    var RealFecha= new Date()   // Para sacar la fecha de hoy   
    // Cadena Año   
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))   
    // Cadena Mes   
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))   
    // Cadena Día   
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("-")))   
    var year= RealFecha.getYear();
	// Valido el año   

	if (document.form_general.fecha_reiniciolabores.value != "00-00-0000") {

    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1910 || parseFloat(Ano)>(year)){   
		alert('Año inválido');
		document.form_general.fecha_reiniciolabores.value = "00-00-0000";
		document.form_general.fecha_reiniciolabores.select();
        return true;
    }   
    // Valido el Mes   
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){   
        alert('Mes inválido') ;
			document.form_general.fecha_reiniciolabores.value = "00-00-0000";
			document.form_general.fecha_reiniciolabores.select();
       return true   
    }   
    // Valido el Dia   
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){   
       alert('Día inválido')  ;
			document.form_general.fecha_reiniciolabores.value = "00-00-0000";
			document.form_general.fecha_reiniciolabores.select();
       return true   
    }   
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {   
        if (Mes==2 && Dia > 28 || Dia>30) {   
            alert('Día inválido')   
			document.form_general.fecha_reiniciolabores.value = "00-00-0000";
			document.form_general.fecha_reiniciolabores.select();
        return true   
        }   
    }   
       
  //para que envie los datos, quitar las  2 lineas siguientes   
//  alert("Fecha correcta.")   
	}
  return false
} 
function Validar3(Cadena){   
    var Fecha= new String(Cadena);   // Crea un string   
	Fecha = Fecha.replace("/","-");
	Fecha = Fecha.replace("/","-");
	document.form_general.fecha_retirolabores.value = Fecha;
    var RealFecha= new Date()   // Para sacar la fecha de hoy   
    // Cadena Año   
    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("-")+1,Fecha.length))   
    // Cadena Mes   
    var Mes= new String(Fecha.substring(Fecha.indexOf("-")+1,Fecha.lastIndexOf("-")))   
    // Cadena Día   
    var Dia= new String(Fecha.substring(0,Fecha.indexOf("-"))) 
    var year= RealFecha.getYear();  
  
	if (document.form_general.fecha_retirolabores.value != "00-00-0000") {

    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1910 || parseFloat(Ano)>(year)){   
		alert('Año inválido');
		document.form_general.fecha_retirolabores.value = "00-00-0000";
		document.form_general.fecha_retirolabores.select();
        return true;
    }   
    // Valido el Mes   
    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){   
        alert('Mes inválido') ;
			document.form_general.fecha_retirolabores.value = "00-00-0000";
			document.form_general.fecha_retirolabores.select();
       return true   
    }   
    // Valido el Dia   
    if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){   
       alert('Día inválido')  ;
			document.form_general.fecha_retirolabores.value = "00-00-0000";
			document.form_general.fecha_retirolabores.select();
       return true   
    }   
    if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {   
        if (Mes==2 && Dia > 28 || Dia>30) {   
            alert('Día inválido')   
			document.form_general.fecha_retirolabores.value = "00-00-0000";
			document.form_general.fecha_retirolabores.select();
        return true   
        }   
    }   
       
  //para que envie los datos, quitar las  2 lineas siguientes   
//  alert("Fecha correcta.")   
	}
  return false
}     
function Ayuda_Hijos() {
	alert("Favor de ingresar la información de sus Hijos, desde la opción de Parentescos.");
}
function Ayuda_Parentescos() {
	alert("Favor de complementar la información de sus Familiares");
}
function Ayuda_Contingentes() {
	alert("Favor de Detallar a quienes les sirve de Fiador...");
}
function Ayuda_Organizaciones() {
	alert("Favor de Complementar la información si pertenece a una Organización Civil, como: Comités, Sindicatos, Juntas Directivas, etc.");
}

</script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingreso de Informaci&oacute;n de Colaboradores</title>
<style type="text/css"> 
<!-- 
body  {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #666666;
	margin: 0; /* es recomendable ajustar a cero el margen y el relleno del elemento body para lograr la compatibilidad con la configuración predeterminada de los diversos navegadores */
	padding: 0;
	text-align: center; /* esto centra el contenedor en los navegadores IE 5*. El texto se ajusta posteriormente con el valor predeterminado de alineación a la izquierda en el selector #container */
	color: #000000;
}
.thrColAbs #container {
	position: relative; /* la adición de position: relative le permite colocar las dos barras laterales en relación con este contenedor */
	width: 820px;  /* el uso de 20px menos que un ancho completo de 800px da cabida a los bordes del navegador y evita la aparición de una barra de desplazamiento horizontal */
	background: #FFFFFF;
	margin: 0 auto; /* los márgenes automáticos (conjuntamente con un ancho) centran la página */
	border: 1px solid #000000;
	text-align: left; /* esto anula text-align: center en el elemento body. */
} 

/* Sugerencias para barras laterales con posición absoluta:
1. Los elementos con posición absoluta (AP) deben recibir un valor superior y lateral, ya sea derecho o izquierdo. (De manera predeterminada, si no se asigna ningún valor superior, el elemento AP comenzará directamente después del último elemento del orden de origen de la página. Esto significa que, si las barras laterales son el primer elemento del #container en el orden de origen del documento, aparecerán en la parte superior del #container aunque no se les asigne un valor superior. No obstante, si posteriormente se trasladan en el orden de origen por cualquier motivo, necesitarán un valor superior para que aparezcan donde usted desea.
2. Los elementos con posición absoluta (AP) se extraen del flujo del documento. Esto significa que los elementos situados alrededor de ellos no saben que existen y no los tienen en cuenta al ocupar su espacio en la página. En consecuencia, sólo deberá utilizar un div AP como columna lateral si está seguro de que el div #mainContent del centro siempre será el que incluya la mayor parte del contenido. Si alguna de las barras laterales incluyera más contenido, la barra lateral superaría la parte inferior del div padre y no parecería que la barra lateral estuviera contenida.
3. Si se cumplen los requisitos anteriores, las barras laterales con posición absoluta pueden ser una forma sencilla de controlar el orden de origen del documento.
*/
.thrColAbs #sidebar1 {
	position: absolute;
	top: 0;
	left: 0;
	width: 150px; /* el ancho real de este div, en navegadores que cumplen los estándares, o el modo de estándares de Internet Explorer, incluirá el relleno y el borde además del ancho */
	background: #EBEBEB; /* el color de fondo se mostrará a lo largo de todo el contenido de la columna, pero no más allá */
	padding: 15px 10px 15px 20px; /* el relleno mantiene el contenido del div alejado de los bordes */
}
.thrColAbs #sidebar2 {
	position: absolute;
	top: 10px;
	right: 311px;
	width: 160px; /* el ancho real de este div, en navegadores que cumplen los estándares, o el modo de estándares de Internet Explorer, incluirá el relleno y el borde además del ancho */
	background: #EBEBEB; /* el color de fondo se mostrará a lo largo de todo el contenido de la columna, pero no más allá */
	padding: 15px 10px 15px 20px; /* el relleno mantiene el contenido del div alejado de los bordes */
}
.thrColAbs #mainContent { 
	margin: 0 200px; /* los márgenes derecho e izquierdo de este elemento div crean las dos columnas externas de los lados de la página. Con independencia de la cantidad de contenido que incluyan los divs de las barras laterales, permanecerá el espacio de la columna. */
	padding: 0 10px; /* recuerde que el relleno es el espacio situado dentro del cuadro div y que el margen es el espacio situado fuera del cuadro div */
}
.fltrt { /* esta clase puede utilizarse para que un elemento flote en la parte derecha de la página. El elemento flotante debe preceder al elemento junto al que debe aparecer en la página. */
	float: right;
	margin-left: 8px;
}
.fltlft { /* esta clase puede utilizarse para que un elemento flote en la parte izquierda de la página. */
	float: left;
	margin-right: 8px;
}
.LetraBlanca {
	color: #FFF;
}
.Tamaño28 {
	font-size: 20px;
}
.Tamaño14 {
	font-size: 14px;
}
.Tamaño10 {
	font-size: 10px;
}
.Tamaño12 {
	font-size: 12px;
	text-align: left;
}

--> 
</style><!--[if IE 5]>
<style type="text/css"> 
/* coloque las reparaciones del modelo de cuadro para IE 5* en este comentario condicional */
.thrColAbs #sidebar1 { width: 180px; }
.thrColAbs #sidebar2 { width: 190px; }
</style>
<![endif]-->
<script src="../Script/jquery-1.4.2.js" type="text/javascript"> </script>
<script src="../Script/jquery.maskedinput-1.2.2.js" type="text/javascript"> </script>
<script type="text/javascript">
	jQuery(function($){
//		$("#fecha_nacimiento").mask("99-99-9999");
//		$("#fecha_iniciolabores").mask("99-99-9999");
//		$("#fecha_reiniciolabores").mask("99-99-9999");
	});
</script>

</head>
<body class="thrColAbs">
<div id="container">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
  <td width="218" bgcolor="#000066" ><div align="left"></div></td>		
  <td align="center" valign="middle" bgcolor="#000066" id="logo"><p class="Estilo6"><span class="Tama&ntilde;o28 LetraBlanca"><b>INFORMACI&Oacute;N COLABORADORES</b></span></p></td>
  <td width="217" bgcolor="#000066" ><div align="right"></div></td>
  </tr>
<tr>
  <td colspan="3" bgcolor="#003366"></td>
</tr>
<tr bgcolor="#CCFF99" class="LetraBlanca Tamaño10" id="dateformat2">
  <td height="25" align="left" bgcolor="#006A00">&nbsp;
	<script language="JavaScript" type="text/javascript">
//	  document.write(TODAY);	
    </script>    </td>
  <td height="25" bgcolor="#006A00">&nbsp;</td>
  <td height="25" bgcolor="#006A00" align="right">
   </td>
</tr>
</table>
<table width="800" border="0" align="center" id="Tabla_general" class="Tamaño12">
<form action="grabar_datos.php" method="post" name="form_general" id="form_general">
  <tr>
    <td width="222">Tipo Documento Identificaci&oacute;n:</td>
    <td width="197"><?php
	   	$sql1="SELECT * FROM coosajo_base_patrimonio.tipodocumento";
		$res1=mysqli_query($db, $sql1);
   	  ?>
          <select name="tipo_documento" size="1" id="tipo_documento" onBlur="orden()">
                          <?php
						while ($rw1=mysqli_fetch_array($res1)) {
							if ($rw1["id"] == $datos["TipoDocumentoIdentificacion"]) {
								$seleccionado="selected";
							} else {
								$seleccionado="";
							}
					?>
                         <option value="<?php echo $rw1["id"] ?>" <?php echo $seleccionado ?>> <?php echo $rw1["tipodocumentoidentificacion"]?> </option>
                          <?php
					  }
					 ?>
          </select></td>
    <td width="15">&nbsp;</td>
    <td width="189">No. Documento Identificaci&oacute;n:</td>
    <td width="76"><select name="no_orden" id="no_orden" onFocus="orden()">
      <option value="">(C&eacute;dula)</option>
      <option value="A1">A-1</option>
      <option value="B2">B-2</option>
      <option value="C3">C-3</option>
      <option value="D4">D-4</option>
      <option value="E5">E-5</option>
      <option value="F6">F-6</option>
      <option value="G7">G-7</option>
      <option value="H8">H-8</option>
      <option value="I9">I-9</option>
      <option value="J10">J-10</option>
      <option value="K11">K-11</option>
      <option value="L12">L-12</option>
      <option value="M13">M-13</option>
      <option value="N14">N-14</option>
      <option value="&Ntilde;15">&Ntilde;-15</option>
      <option value="O16">O-16</option>
      <option value="P17">P-17</option>
      <option value="Q18">Q-18</option>
      <option value="R19">R-19</option>
      <option value="S20">S-20</option>
      <option value="T21">T-21</option>
      <option value="U22">U-22</option>
    </select>      <input name="no_identificacion" type="text" id="no_identificacion"style="background-color:#FF9" value="<?php echo $datos["DocumentoIdentificacion"] ?>" size="11"></td>
    <td width="77">Extendida en
      <input name="ext" type="text" id="ext"style="background-color:#FF9" value="<?php echo $datos["extendida"] ?>" size="20"></td>
  </tr>
  <tr>
    <td><input name="cuenta_llevar" type="hidden" id="cuenta_llevar" value="<?php echo $auxi ?>"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Departamento</td>
    <td colspan="2"><span class="style7">
      <select name="region"
      onChange="populateCountry(document.form_general,document.form_general.region.options[document.form_general.region.selectedIndex].value)"
      size="1">
        <option value="<?php echo $datos['depto']?>"><?php echo $datos['depto'] ?></option>
        <option value="0">Seleccione Departamento</option>
        <option value="Guatemala01">Guatemala</option>
        <option value="Sacatepequez02">Sacatep&eacute;quez</option>
        <option value="Chimaltenango03">Chimaltenango</option>
        <option value="ElProgreso04">El Progreso</option>
        <option value="Escuintla05">Escuintla</option>
        <option value="SantaRosa06">Santa Rosa</option>
        <option value="Solola07">Solol&aacute;</option>
        <option value="Totonicapan08">Totonicap&aacute;n</option>
        <option value="Quezaltenango09">Quezaltenango</option>
        <option value="Suchitepequez10">Suchitep&eacute;quez</option>
        <option value="Retalhuleu11">Retalhuleu</option>
        <option value="SanMarcos12">San Marcos</option>
        <option value="Huehuetenango13">Huehuetenango</option>
        <option value="Quiche14">Quich&eacute;</option>
        <option value="BajaVerapaz15">Baja Verapaz</option>
        <option value="AltaVerapaz16">Alta Verapaz</option>
        <option value="Peten17">Pet&eacute;n</option>
        <option value="Izabal18">Izabal</option>
        <option value="Zacapa19">Zacapa</option>
        <option value="Chiquimula20">Chiquimula</option>
        <option value="Jalapa21">Jalapa</option>
        <option value="Jutiapa22">Jutiapa</option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td>Pais Origen:</td>
    <td><?php
	   	$sql1="SELECT * FROM coosajo_base_patrimonio.paises";
		$res1=mysqli_query($db, $sql1);
   	  ?>
      <select name="pais" size="1" id="pais">
                          <?php
						while ($rw1=mysqli_fetch_array($res1)) {
							if ($rw1["id"] == $datos["PaisOrigen"]) {
								$seleccionado="selected";
							} else {
								$seleccionado="";
							}
					?>
                         <option value="<?php echo $rw1["id"] ?>" <?php echo $seleccionado ?>> <?php echo $rw1["nombrepais"]?> </option>
                          <?php
					  }
					 ?>
          </select>
    
    </td>
    <td>&nbsp;</td>
    <td>Lugar de Nacimiento:</td>
    <td colspan="2"><span class="style7">
      <select name="country" size="1">
        <option value="<?php echo $datos['LugarNacimiento']?>"><?php echo $datos['LugarNacimiento'] ?></option>
      </select>
    </span></td>
  </tr>
  <tr>
    <td>Nit:</td>
    <td><label>
      <input name="nit" type="text" id="nit" value="<?php echo $datos["NitEmpleado"] ?>"style="background-color:#FF9">
    </label></td>
    <td>&nbsp;</td>
    <td><p>Fecha Nacimiento: (dd-mm-aaaa)</p></td>
    <td colspan="2"><label>
      <input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php echo cambio_fecha($datos["FechaNacimiento"]) ?>"style="background-color:#FF9" onBlur="">
    </label></td>
  </tr>
  <tr>
    <td>Primer Nombre:</td>
    <td><label>
      <input name="nombre1" type="text" id="nombre1" value="<?php echo $datos["Nombre1"] ?>"style="background-color:#FF9" onKeyPress="return validar_datos(event)">
    </label></td>
    <td>&nbsp;</td>
    <td>Segundo Nombre:</td>
    <td colspan="2"><label>
      <input name="nombre2" type="text" id="nombre2" value="<?php echo $datos["Nombre2"] ?>"style="background-color:#FF9" onKeyPress="return validar_datos(event)">
    </label></td>
  </tr>
  <tr>
    <td>Primer Apellido:</td>
    <td><label>
      <input name="apellido1" type="text" id="apellido1" value="<?php echo $datos["Apellido1"] ?>"style="background-color:#FF9" onKeyPress="return validar_datos(event)">
    </label></td>
    <td><p>&nbsp;</p></td>
    <td>Segundo Apellido:</td>
    <td colspan="2"><label>
      <input name="apellido2" type="text" id="apellido2" value="<?php echo $datos["Apellido2"] ?>"style="background-color:#FF9" onKeyPress="return validar_datos(event)">
    </label></td>
  </tr>
  <tr>
    <td>Apellido Casada:</td>
    <td><label>
      <input name="apellidocasada" type="text" id="apellidocasada" value="<?php echo $datos["ApellidoCasada"] ?>"style="background-color:#FF9">
    </label></td>
    <td>&nbsp;</td>
    <td>Estado Civil:</td>
    <td colspan="2">
     <?php
	   	$estado_civil_codigo = $datos["EstadoCivil"];
		switch ($estado_civil_codigo) {
		case 0:
			$estado_civil_nombre = "Soltero";
			
		case 1:
			$estado_civil_nombre = "Casado(a) / Unido(a)";
			
		case 2:
			$estado_civil_nombre = "Viudo(a)";
			
		case 3:
			$estado_civil_nombre = "Divorciado(a)";
					
		}
?>
    
    <label>
      <select name="estado_civil" id="estado_civil"style="background-color:#FF9"onBlur="civil()">
        <option value="<?php echo $estado_civil_codigo ?>"><?php echo $estado_civil_nombre?></option>
        <option value="">- - Seleccione Estado Civil - -</option>
        <option value="0">Soltero(a)</option>
        <option value="1">Casado(a)/Unido(a)</option>
        <option value="2">Viudo(a)</option>
        <option value="3">Divorciado(a)</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td>No. Afiliaci&oacute;n al IGSS:</td>
    <td><input name="igss" type="text" id="igss" value="<?php echo $datos["IgssEmpleado"] ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Sexo:</td>
    <td><?php
	   	$sexo_codigo = $datos["Sexo"];
		switch ($sexo_codigo) {
		case "M":
			$sexo_nombre = "Masculino";
			
		case "F":
			$sexo_nombre = "Femenino";
			
		}
?>
      <select name="sexo" id="sexo"style="background-color:#FF9">
        <option value="<?php echo $sexo_codigo ?>" selected><?php echo $sexo_nombre?></option>
        <option value="">- - Seleccione Sexo - -</option>
        <option value="M">Masculino</option>
        <option value="F">Femenino</option>
      </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Puesto:</td>
    <td colspan="3">
      <?php
	   	$sql1="SELECT * FROM coosajo_base_patrimonio.puestos ORDER BY puesto";
		$res1=mysqli_query($db, $sql1);
	?>
      <select name="puesto_origen" size="1" id="puesto_origen">
        <?php
		while ($rw1=mysqli_fetch_array($res1)) {
			if ($rw1["id"] == $datos["Puesto"]) {
				$seleccionado="selected";
			} else {
				$seleccionado="";
			}
	?>
        <option value="<?php echo $rw1["id"] ?>" <?php echo $seleccionado ?>> <?php echo $rw1["puesto"]?> </option>
        <?php
		}
	?>
        </select>
  </td>
    <td colspan="2" bgcolor="#FFFF99"><input type="button" name="button2" id="button2" value="Actualizar..." onClick="operar()"></td>
  </tr>
  <tr>
    <td>Profesi&oacute;n:</td>
    <td><input name="profesion" type="text" id="profesion" value="<?php echo $datos["Profesion"] ?>"></td>
    <td>&nbsp;</td>
    <td>Nivel Acad&eacute;mico:</td>
    <td colspan="2">
      <?php
	   	$sql1="SELECT * FROM coosajo_base_patrimonio.nivelacademico";
		$res1=mysqli_query($db, $sql1);
	?>
      <select name="nivel_academico" size="1" id="nivel_academico">
        <?php
		while ($rw1=mysqli_fetch_array($res1)) {
			if ($rw1["id"] == $datos["NivelAcademico"]) {
				$seleccionado="selected";
			} else {
				$seleccionado="";
			}
	?>
        <option value="<?php echo $rw1["id"] ?>" <?php echo $seleccionado ?>> <?php echo $rw1["nivelacademico"]?> </option>
        <?php
		}
	?>
        </select>    
      </td>
  </tr>
  <tr>
    <td>Etnia:</td>
    <td><?php
	   	$sql1="SELECT * FROM coosajo_base_patrimonio.etnia";
		$res1=mysqli_query($db, $sql1);
	?>
      <select name="etnia" size="1" id="etnia">
        <?php
		while ($rw1=mysqli_fetch_array($res1)) {
			if ($rw1["id"] == $datos["Etnia"]) {
				$seleccionado="selected";
			} else {
				$seleccionado="";
			}
	?>
        <option value="<?php echo $rw1["id"] ?>" <?php echo $seleccionado ?>> <?php echo $rw1["etnia"]?></option>
        <?php
		}
	?>
      </select></td>
    <td>&nbsp;</td>
    <td>Idiomas:</td>
    <td colspan="2"><?php
	   	$sql1="SELECT * FROM coosajo_base_patrimonio.idiomas";
		$res1=mysqli_query($db, $sql1);
	?>
      <select name="idiomas" id="idiomas">
        <?php
		while ($rw1=mysqli_fetch_array($res1)) {
			if ($rw1["id"] == $datos["Idiomas"]) {
				$seleccionado="selected";
			} else {
				$seleccionado="";
			}
	?>
        <option value="<?php echo $rw1["id"] ?>" <?php echo $seleccionado ?>> <?php echo $rw1["idioma"]?></option>
        <?php
		}
	?>
      </select></td>
  </tr>
  <tr>
    <td>Correo Electr&oacute;nico:</td>
    <td><input name="correo_electronico" type="text" id="correo_electronico" value="<?php echo $datos["email"] ?>"style="background-color:#FF9"></td>
    <td>&nbsp;</td>
    <td>Tel&eacute;fono:</td>
    <td colspan="2"><input name="telefono" type="text" id="telefono" value="<?php echo $datos["Telefono"] ?>" style="background-color:#FF9" onkeypress="return validar_datos1(event)" /></td>
    </tr>
  <tr>
    <td>Direcci&oacute;n:</td>
    <td><label>
      <input name="direccion" type="text" id="direccion" value="<?php echo $datos["Direccion"] ?>"style="background-color:#FF9">
    </label></td>
    <td>&nbsp;</td>
    <td align="left">Celular:</td>
    <td colspan="2" align="left"><input name="celular" type="text" id="celular" value="<?php echo $datos["Celular"] ?>" style="background-color:#FF9" onkeypress="return validar_datos1(event)" /></td>
    </tr>
  <tr>
    <td align="left">Parentescos:</td>
    <td align="left"><input name="parentescos" type="text" id="parentescos"style="background-color:#FF9" value="<?php echo $sumatoria_parentescos ?>" readonly="readonly" onfocus="Grabar2()" />
      <img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0" onclick="Ventana_parentescos()" /><img src="../Imagenes/Ayuda.png" alt="Ayuda..." width="18" height="22" border="0" onclick="Ayuda_Parentescos()" /></td>
    <td align="center">&nbsp;</td>
    <td align="left">No. de Hijos:</td>
    <td colspan="2" align="left"><input name="no_hijos" type="text" id="no_hijos"style="background-color:#FF9" value="<?php echo $sumatoria_hijos ?>" size="5" readonly="readonly" />
      <img src="../Imagenes/Ayuda.png" alt="Ayuda..." width="18" height="22" border="0" onclick="Ayuda_Hijos()" /></td>
    </tr>
  <tr>
    <td align="left">Nombre C&oacute;nyuge:</td>
    <td align="left"><input name="nombre_conyuge" type="text" id="nombre_conyuge"style="background-color:#FF9" onkeypress="return validar_datos(event)" value="<?php echo $datos["Nombre_conyuge"] ?>" readonly="readonly" />
      <img src="../Imagenes/Ayuda.png" alt="Ayuda..." width="18" height="22" border="0" onclick="Ayuda_Parentescos()" /></td>
    <td align="center">&nbsp;</td>
    <td align="left">Organizaciones Civiles:</td>
    <td colspan="2" align="left"><input name="parentescos2" type="text" id="parentescos2"style="background-color:#FF9" value="<?php echo $sumatoria_organizaciones ?>" readonly="readonly" onfocus="Grabar2()" />
      <img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0" onclick="Ventana_organizaciones()" /><img src="../Imagenes/Ayuda.png" alt="Ayuda..." width="18" height="22" border="0" onclick="Ayuda_Civiles()" /></td>
    </tr>
  <tr>
    <td align="left">Propiedad del Inmueble:</td>
    <td align="left"><select onChange="Verificar()" style="background-color:#FF9" name="propiedad_inmueble" id="propiedad_inmueble" >
        <option value="Propio" <?php if ($datos['propiedad'] == 'Propio') { echo 'selected'; }?>>Propio</option>
        <option value="Alquila"<?php if ($datos['propiedad'] == 'Alquila') { echo 'selected' ;}?>>Alquila</option>
        <option value="Otro"<?php if ($datos['propiedad'] == 'Otro') { echo 'selected'; }?>>Otro</option>
      </select> </td>
    <td align="left">&nbsp;</td>
    <td align="left">Observaciones Adicionales:</td>
    <td colspan="2" align="left"><label for="observaciones_adicionales"></label>
      <input name="observaciones_adicionales" type="text" disabled="disabled" id="observaciones_adicionales" /></td>
    </tr>
  <tr>
    <td align="left">Pasivo Contingente:</td>
    <td align="left"><input name="parentescos3" type="text" id="parentescos3" style="background-color:#FF9" value="<?php echo $sumatoria_pasivo_contingente ?>" readonly="readonly" onFocus="Grabar2()"><img src="../Imagenes/Agregar.gif" alt="Agregar..." width="20" height="20" border="0" onClick="Ventana_pasivo()"><img src="../Imagenes/Ayuda.png" alt="Ayuda..." width="18" height="22" border="0" onClick="Ayuda_Contingentes()"></td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td colspan="2" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="6" align="center"><input type="button" name="button" id="button" value="Actualizar..." onClick="operar()"></td>
  </tr>
  <tr>
    <td colspan="6" align="center">&nbsp;</td>
  </tr>
</form>
</table>
<table width="81" border="0" align="center">
  <tr>
    <td width="75" height="62" align="center"><a href="menu.php"><img src="../Imagenes/back.png" alt="Regresar..." width="128" height="128" border="0"></a></td>
    <td width="75" align="center"><a href="estado_patrimonial.php"><img src="../Imagenes/next.png" alt="Siguiente..." width="128" height="128" border="0"></a></td>
  </tr>
  <tr>
    <td height="25" align="center"><a href="menu.php">REGRESAR</a><a href="salir.php"></a></td>
    <td align="center"><a href="estado_patrimonial.php">SIGUIENTE</a></td>
  </tr>
</table>
  <!-- end #container -->	
</div>
</body>
</html>
<?php
ob_flush();
?>