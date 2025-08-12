<!DOCTYPE html>

<html lang="es">

<?php


    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Seguridad.php");

    include($_SERVER["DOCUMENT_ROOT"]."/scripts/funciones.php");

    include($_SERVER["DOCUMENT_ROOT"]."/scripts/Conex.php");

    include($_SERVER["DOCUMENT_ROOT"]."/includes/Header.php");

?>





      <?php

        include($_SERVER["DOCUMENT_ROOT"].'/includes/Head.php');
        include($_SERVER["DOCUMENT_ROOT"]."/App/253_ActualizacionDatos/Menu/Menu.php");
      ?>







    ?>










    <?php

        include($_SERVER["DOCUMENT_ROOT"].'/includes/Scripts.php');

    ?>
    <script src="graficas/js/highcharts.js"></script>
    <script src="graficas/js/modules/exporting.js"></script>


    <!-- END JAVASCRIPT -->
    <script>


  var chart;
  var chart2;
  var chart3;
  function ver_graficos() {
  	var anio = document.getElementById('anio').value;
  	//var fecha_final = document.getElementById('fecha_final').value;
  	var options = {
                  chart: {
                      renderTo: 'grafica',
                      plotBackgroundColor: null,
                      plotBorderWidth: null,
                      plotShadow: false
                  },
                  title: {
                      text: 'GRAFICO DE GESTIONES REALIZADAS POR MES'
                  },
                  tooltip: {
  		            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
  		        },
                  plotOptions: {
  		            pie: {
  		                allowPointSelect: true,
  		                cursor: 'pointer',
  		                dataLabels: {
  		                    enabled: true,
  		                    format: '<b>{point.name}</b>: {point.y} Gestiones',
  		                    style: {
  		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
  		                    }
  		                }
  		            }
  		        },
                  series: [{
                      type: 'pie',
                      name: 'Porcentaje Mensual',
                      data: []
                  }]
              }

              $.getJSON("DatosGrafica.php?anio="+anio, function(json) {
                  options.series[0].data = json;
                  chart = new Highcharts.Chart(options);
         		});


  }

  </script>
    <div class="page-header">
      <div class="container">
        <div class="row">
           <div class="col-lg-12">
             <h3 class="text-center">Estad&iacute;sticas Actualizaci&oacute;n de Datos</h3>
           </div>
          <!-- <div class="col-lg-1" align="center">
             <a href="reporte_informe.php" class="btn btn-warning">Regresar</a>
           </div>-->
        </div>
      </div>
    </div>
  <div class="content-wrapper" >
  <br>
  	 <div class="container">
  		 <div class="panel panel-info">
  		  <div class="panel-heading"></div>
  			  <div class="panel-body">
  			  	<div class="row">
  			  		<div class="col-lg-6 col-lg-offset-1" align="right">
  			  			<label for="">SELECCIONE EL AÑO:</label>
  			  		</div>
  			  		<div class="col-lg-2">
  			  			<select name="anio" id="anio">
  							  <option value="2018">2018</option>
  							  <option value="2019">2019</option>
  							  <option value="2020">2020</option>
  							  <option value="2020">2020</option>
                  <option value="2021">2020</option>
                  <option value="2022">2020</option>
  						</select>
  			  		</div>

  			  		<div class="col-lg-2">
  			  			<button class="btn btn-success" type="button"	onClick="ver_graficos()">Generar</button>
  			  		</div>
  			  	</div>
  				<div class="row">
  					<div class="col-lg-12">
  						<div id="grafica">
  						</div>
  					</div>
  					<div class="col-lg-12">
  						<div id="grafica2">
  						</div>
  					</div>
  					<div class="col-lg-12">
  						<div id="grafica3">
  						</div>
  					</div>
  				 </div>
  			  </div>
  		</div>
  	</div>
  </div>


</body>



</html>
