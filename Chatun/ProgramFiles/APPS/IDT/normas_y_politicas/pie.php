<?php
session_start();
?>
<head>
<meta charset="iso-8859-1" http-equiv="Content-Type" content="text/html"/>
<link href="../../../../Script/style.css" rel="stylesheet" type="text/css">
<link href="../../../../Script/links.css" rel="stylesheet" type="text/css">
</head>

<body class="Pagina">
<div id="piepagina">
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="piepagina">
<tr>
<td><a href="../../../portal_principal.php" target="_top">Men&uacute; Principal</a> > <a href="<?php echo "../../".$_SESSION["url_departamento"].'?id_depto='.$_SESSION["id_departamento"] ?>" target="_top">M&oacute;dulo <?php echo $_SESSION["nombre_departamento"] ?></a> > <a href="principal.php" target="_top">Normas y Pol&iacute;ticas</a> ></td>
<td align="right">Copyright&reg; <?php echo date("Y") ?></td>
</tr>
</table>
</div>

</body>
</html>