<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
$IdJuego = $_POST["IdJuego"];
$Consulta1 = "SELECT * FROM Bodega.ESCALA_PRODUCTO WHERE P_CODIGO = $IdJuego and Estado = 1 ORDER BY Cantidad DESC";
$Resultado1 = mysqli_num_rows(mysqli_query($db, $Consulta1));
if ($Resultado1>0) { 
?> 
<div class="container">
<div class="col-lg-12">
<div class="card"> 
	<div class="card-body">
<table class="table table-hover table-condensed" id="tbl_resultados">
	<thead>
		<th><strong>Cantidad</strong></th>  
		<th><strong>Precio</strong></th> 
		<th><strong>Total</strong></th>
		<th><strong>Eliminar</strong></th>
	</thead>
	<tbody>
	<?php
		$Consulta = "SELECT * FROM Bodega.ESCALA_PRODUCTO WHERE P_CODIGO = $IdJuego and Estado = 1 ORDER BY Cantidad DESC";
		$Resultado = mysqli_query($db, $Consulta);
		while($row = mysqli_fetch_array($Resultado))
		{
			$Codigo = $row["P_CODIGO"];
			echo '<tr>';
			    	echo '<td>'.$row["Cantidad"].'</td>';               
			    	echo '<td>'.$row["Precio"].'</td>';  
			    	echo '<td>'.$row["Precio"]*$row["Cantidad"].'</td>';  
			    	echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="Eliminar('.$row["IdEscala"].')">
							    x
							  </button></a>
							</td>';
			    echo '</tr>';
		}
	?>									
	</tbody>
</table>
</div>
</div>
</div>
</div>
<script>
var tbl_filtrado =  { 
        mark_active_columns: true,
        highlight_keywords: true,
        filters_row_index:1,
    paging: true,             //paginar 3 filas por pagina
    paging_length: 20,  
    rows_counter: true,      //mostrar cantidad de filas
    rows_counter_text: "Registros: ", 
    page_text: "Página:",
    of_text: "de",
    btn_reset: true, 
    loader: true, 
    loader_html: "<img src='../../../../../libs/TableFilter/img_loading.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
    display_all_text: "-Todos-",
    results_per_page: ["# Filas por Página...",[10,20,50,100]],  
    btn_reset: true,
    col_4: "disable",
    col_3: "select",
};
var tf = setFilterGrid('tbl_resultados', tbl_filtrado);
</script>
<?php } ?>