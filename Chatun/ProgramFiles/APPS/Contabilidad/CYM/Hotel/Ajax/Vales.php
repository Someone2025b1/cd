<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$fechaHoy = date("d-m-Y");
$Id = $_POST["Id"];
$IdCorte = $_POST["IdCorte"]; 
$Factura = $_POST["Factura"];

$Datos = mysqli_query($db,  "SELECT b.IH_VALE
FROM   Taquilla.INGRESO_HOTEL b WHERE b.H_CODIGO = $Id 
AND NOT EXISTS (SELECT *FROM Taquilla.DETALLE_VALE_FACTURA a WHERE a.DVF_Estado = 2 AND a.DVF_Vale = b.IH_VALE AND a.DVF_Hotel = b.H_CODIGO)
HAVING b.IH_VALE > 0");

$Cantidad = mysqli_num_rows($Datos);

if($Cantidad>0)
{
?>
<form id="Form">
	<input type="hidden" name="nombreHotel" id="nombreHotel" value="<?php echo $Id ?>">
	<input type="hidden" name="IdCorte" id="IdCorte" value="<?php echo $IdCorte ?>">
	<input type="hidden" name="Factura" id="Factura" value="<?php echo $Factura ?>">
<center>
	<h2>Vales</h2>
<?php 
while ($rowDatos = mysqli_fetch_array($Datos))
{
	  $iC = $rowDatos['IH_VALE'];
?>
<div class="input-group" >
    <div class="col-sm-9">
        <div class="demo-switch-title"></div>
        <div class="switch">
        	<div class="row">
        		<div class="col-sm-6">
        			<label for="dato<?php echo $iC ?>">
		            	<input value="<?php echo $iC ?>"  name="dato[]" id="dato<?php echo $iC ?>" type="checkbox" >
		            	<span class="lever switch-col-teal"></span>
		            </label>
        		</div>
	            <div class="col-sm-6"> 
	            	<?php echo $iC ?>	        		
	            </div>
            </div>
        </div>
    </div>

</div>
<?php 
$con++;
}
?>
<button type="button" class="btn ink-reaction btn-raised btn-primary" id="BtnExportarTicketHotel" onclick="GuardarVale()">Guardar</button>
</form>
<br>
<?php 
}
else
{?>
No se encontraron resultados
<?php 
} ?>
</center>	
<script>
	   function GuardarVale(Id)
    {
    	var Form = $("#Form").serialize();
        $.ajax({
            url: 'Ajax/GuardarVale.php',
            type: 'POST',
            dataType: 'html',
            data: Form,
            success: function(data)
            { 
               if (data==1) 
               {
               	$("#modalHoteles").modal('hide');
               	Tabla();
               }
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
