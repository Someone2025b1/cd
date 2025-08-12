<?php
include("Script/seguridad.php");
$ImagenAleatoria = rand(1, 3);
session_destroy();
?>
 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="material-pro/assets/images/favicon.png">
    <title>Portal Parque Chatun</title>
    <!-- Bootstrap Core CSS -->
    <link href="material-pro/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="material-pro/material/css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="material-pro/material/css/colors/blue.css" id="theme" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/theme-4/bootstrap.css" />  
	<link type="text/css" rel="stylesheet" href="css/theme-4/font-awesome.min.css" />
	<link type="text/css" rel="stylesheet" href="css/theme-4/material-design-iconic-font.min.css" />
	<link type="text/css" rel="stylesheet" href="css/alertify/alertify.core.css"/>
	<link type="text/css" rel="stylesheet" href="css/alertify/alertify.bootstrap.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

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
    <section id="wrapper">
        <div class="login-register" style="background-image:url(img/background/img2.jpeg);">        
            <div class="login-box card">
                <div class="card-body">
                  <form class="form-horizontal form-material" id="loginform"  action="Script/control.php" method="post">
                  	<input type="hidden" class="form-control" id="username" name="username" value="<?php echo $_GET["user"] ?>" required>
					<input type="hidden" class="form-control" id="Directorio" name="Directorio" value="<?php echo $_GET["Actual"] ?>" required>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                        <div class="user-thumb text-center"> <img alt="thumbnail" class="img-circle" width="100" src="img/logo.png">
                          <h3><?php echo $_GET["Nombre"] ?></h3>
                        </div>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <input class="form-control" type="password" id="password" name="password" required="" placeholder="password">
                      </div>
                    </div>
                    <div class="form-group text-center">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Iniciar</button>
                      </div><br><br>
                      <p class="help-block"><a href="index.php">Iniciar sesión con otro usuario</a></p>
                    </div>
                  </form>
                </div>
              </div>
        </div>
        
    </section>
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