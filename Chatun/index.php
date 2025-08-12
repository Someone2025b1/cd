
<!DOCTYPE html>
<html lang="en">
<?php
$ImagenAleatoria = rand(1, 3);
?>
<head>

<style>

* {
	box-sizing: border-box;
}
body {
  background-image:url('img/background/fondoini2.png');
	font-family: poppins;
	font-size: 16px;
	color: #fff;
}
.form-box {
	background-color: rgba(255, 255, 255, 0.2);
	margin: auto auto;
	padding: 40px;
	border-radius: 40px;
	box-shadow: 0 0 10px #000;
	position: absolute;
	top: 0;
	bottom: 0;
	left: 0;
	right: 0;
	width: 500px;
	height: 430px;
  
}
.form-box:before {
	
	width: 100%;
	height: 100%;
	background-size: cover;
	content: "";
	position: fixed;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	z-index: -1;
	display: block;
	filter: blur(2px);
}
.form-box .header-text {
	font-size: 32px;
	font-weight: 600;
	padding-bottom: 30px;
	text-align: center;
}
.form-box input {
	margin: 10px 0px;
	border: none;
	padding: 10px;
	border-radius: 5px;
	width: 100%;
	font-size: 18px;
	font-family: poppins;
}
.form-box input[type=checkbox] {
	display: none;
}
.form-box label {
	position: relative;
	margin-left: 5px;
	margin-right: 10px;
	top: 5px;
	display: inline-block;
	width: 20px;
	height: 20px;
	cursor: pointer;
}
.form-box label:before {
	content: "";
	display: inline-block;
	width: 20px;
	height: 20px;
	border-radius: 5px;
	position: absolute;
	left: 0;
	bottom: 1px;
	background-color: #ddd;
}
.form-box input[type=checkbox]:checked+label:before {
	content: "\2713";
	font-size: 20px;
	color: #000;
	text-align: center;
	line-height: 20px;
}
.form-box span {
	font-size: 14px;
}
.form-box button {
	background-color: deepskyblue;
	color: #fff;
	border: none;
	border-radius: 5px;
	cursor: pointer;
	width: 100%;
	font-size: 18px;
	padding: 10px;
	margin: 20px 0px;
}
span a {
	color: #FFF;
}


  </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="img/logo.png">
    <title>Portal Parque Chatun</title>
    <!-- Bootstrap Core CSS -->
    <link href="material-pro/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="material-pro/material/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="material-pro/material/css/colors/blue.css" id="theme" rel="stylesheet"> 
        <!-- BEGIN STYLESHEETS -->
    <link type="text/css" rel="stylesheet" href="css/theme-4/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-4/bootstrap.css" /> 
    <link type="text/css" rel="stylesheet" href="css/theme-4/font-awesome.min.css" />
    <link type="text/css" rel="stylesheet" href="css/theme-4/material-design-iconic-font.min.css" />
    <link type="text/css" rel="stylesheet" href="css/alertify/alertify.core.css"/>
    <link type="text/css" rel="stylesheet" href="css/alertify/alertify.bootstrap.css" />
</head>
 <script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover(); 
    });
    </script>
<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar"  style="background-image:url('img/background/fondoini2.png');">
  <div class="form-box">
    <div class="card-body">
      <form class="form-box" id="loginform" action="Script/control.php" method="post">
        <a href="javascript:void(0)" class="text-center db"><img src="img/logo.png" width="150px" height="100px" alt="Home" style="border-color: #FFF; border: top 10px;" /></a> 
        <b><h3 class="box-title m-t-40 m-b-0 text-center" style="color:#000; font-weight:bold">Iniciar Sesión</h3> </b>
        <div class="form-group m-t-20">
          <div class="col-xs-12">
            <input class="form-control" type="text" required="" placeholder="Usuario" name="username" id="username">
          </div>
        </div> 
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="password" required="" placeholder="Contraseña" id="password" name="password" required>
          </div>
        </div>  
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" style="background-color: green;" type="submit">Iniciar</button>
          </div>
        </div>
        <div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
           <a class="text-right" data-toggle="popover" data-trigger="hover" title="Olvidé mi Contraseña" data-content="Si olvidó su contraseña, comuníquese con el departamento de IDT"><em>Olvidé mi contraseña</em></a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
    <?php 
    if(isset($_GET["error"]))
    {
        if($_GET["error"] == 1)
        {
            echo '<div class="alert alert-danger text-center">Error en usuario o contraseña</div>';
        }
        elseif($_GET["error"] == 2)
        {
            echo '<div class="alert alert-danger text-center">Sesión vencida por inactividad</div>';
        }   
        elseif($_GET["error"] == 3)
        {
            echo '<div class="alert alert-warning text-center">Sesión finalizada</div>';
        }
        elseif($_GET["error"] == 4)
        {
            echo '<div class="alert alert-danger text-center">Su usuario está bloqueado, comuníquese con Desarollo Humano</div>';
        }
    }
    ?>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="material-pro/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="material-pro/assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="material-pro/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="material-pro/material/js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="material-pro/material/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="material-pro/material/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="material-pro/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="material-pro/assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="material-pro/material/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="material-pro/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="js/libs/alertify/alertify.js"></script>
     <script src="js/libs/jquery/jquery-1.11.2.min.js"></script>
    <script src="js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
    <script src="js/libs/bootstrap/bootstrap.min.js"></script>
    <script src="js/libs/spin.js/spin.min.js"></script>
    <script src="js/libs/autosize/jquery.autosize.min.js"></script>
    <script src="js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
    <script src="js/core/source/App.js"></script>
    <script src="js/core/source/AppNavigation.js"></script>
    <script src="js/core/source/AppOffcanvas.js"></script>
    <script src="js/core/source/AppCard.js"></script>
    <script src="js/core/source/AppForm.js"></script>
    <script src="js/core/source/AppNavSearch.js"></script>
    <script src="js/core/source/AppVendor.js"></script>
    <script src="js/core/demo/Demo.js"></script>


</body>

</html>