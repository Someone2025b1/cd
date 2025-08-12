
<!DOCTYPE html>
<html lang="en">
<?php
$ImagenAleatoria = rand(1, 3);
?>
<head>

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
  <div class="login-box card">
    <div class="card-body">
      <form class="form-horizontal form-material" id="loginform" action="Script/control.php" method="post">
        <a href="javascript:void(0)" class="text-center db"><img src="img/logo.png" width="150px" height="100px" alt="Home" /></a> 
        <h3 class="box-title m-t-40 m-b-0 text-center">Iniciar Sesión</h3>  
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
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Iniciar</button>
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