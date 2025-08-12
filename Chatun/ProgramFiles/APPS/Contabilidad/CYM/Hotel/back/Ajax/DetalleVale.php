<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$Id = $_POST["IdCorte"]; 
$Factura = $_POST["Factura"];
?>
<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
	        <label for="vale">Hotel</label>
	         <select class="form-control " required  id="nombreHotel" name="nombreHotel" onchange="verVales(this.value)">
             <option selected="">Seleccione</option>
            <?php 
                $hotel = mysqli_query($db, "SELECT * FROM Taquilla.HOTEL WHERE H_ESTADO = 1");
                while($hotel_result = mysqli_fetch_array($hotel))                                          
                {
                    ?>
                        <option value="<?php echo $hotel_result[H_CODIGO]?>"><?php echo $hotel_result[H_NOMBRE] ?></option>
                    <?php 
                }
            ?>
                </select>                
        </div>
	</div>
</div> 
<div class="row">
<div id="divVale"></div>
</div>	
<br>
<script>
	   function verVales(Id)
    {
    	var IdCorte = '<?php echo $Id ?>';
    	var Factura = '<?php echo $Factura ?>';
        $.ajax({
            url: 'Ajax/Vales.php',
            type: 'POST',
            dataType: 'html',
            data: {Id:Id, IdCorte: IdCorte, Factura:Factura},
            success: function(data)
            { 
                $("#divVale").html(data);
            }
        })
                
    }
</script>				  
<script>
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

 
</script>
</html>
