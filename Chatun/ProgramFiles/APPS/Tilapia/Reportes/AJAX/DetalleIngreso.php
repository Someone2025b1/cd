<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$IdEstanque = $_POST["IdEstanque"]; 
$FechaInicial = $_POST["FechaInicial"];
$FechaFinal = $_POST["FechaFinal"];
$QueryDetalle = mysqli_query($db, "SELECT A.CostoUCompra, A.TotalCompra, A.CantidadCompra, A.Fecha, A.CostoAlimentacion, A.UnidadesTerminadas, A.LibrasTerminadas, A.PromedioLibra, A.CostoTerminado, A.UnidadesTraslado, A.CostoUTraslado, A.CostoUTotalTraslado, A.UnidadesMortalidad, A.CostoUMortalidad, A.CostoTotalMortalidad, A.Oxigeno, A.PH, A.Temperatura, A.Amonio, A.PesoMuestra, A.TallaMuestra, A.Existencia, A.CostoUnitario, A.CostoTotal  FROM Bodega.CONTROL_PISICULTURA A WHERE A.Estanque = '$IdEstanque' AND A.Fecha BETWEEN '$FechaInicial' AND '$FechaFinal'
ORDER BY A.Fecha ASC");
?>
<table class="table table-hover table-condensed" id="table"
   data-toggle="table"
   data-toolbar="#toolbar"
   data-toggle-pagination="true"
   data-show-export="true"
   data-icons-prefix="fa"
   data-icons="icons"
   data-pagination="false"
   data-sortable="true"
   data-search="true"
   data-filter-control="true">
	<thead>
		<tr>
			<th data-sortable="true" data-field="Fecha" data-filter-control="input"><h6><strong>Fecha</strong></h6></th>
			<th data-sortable="true" data-field="Costo Alimento" data-filter-control="input"><h6><strong>Costo Alimento</strong></h6></th>
			<th data-sortable="true" data-field="Unidades T" data-filter-control="input"><h6><strong>Unidades T</strong></h6></th>
			<th data-sortable="true" data-field="Libras T" data-filter-control="input"><h6><strong>Libras T</strong></h6></th>	
			<th data-sortable="true" data-field="Promedio L" data-filter-control="input"><h6><strong>Promedio L</strong></h6></th>				
			<th data-sortable="true" data-field="Costo T" data-filter-control="input"><h6><strong>Costo T</strong></h6></th>
			<th data-sortable="true" data-field="Unidades Traslado" data-filter-control="input"><h6><strong>Unidades Traslado</strong></h6></th>
			<th data-sortable="true" data-field="Costo Traslado" data-filter-control="input"><h6><strong>Costo Traslado</strong></h6></th>
			<th data-sortable="true" data-field="Unidades Mortalidad" data-filter-control="input"><h6><strong>Unidades Mortalidad</strong></h6></th>
			<th data-sortable="true" data-field="Costo Mortalidad" data-filter-control="input"><h6><strong>Costo Mortalidad</strong></h6></th>

			<th data-sortable="true" data-field="Costo Mortalidad" data-filter-control="input"><h6><strong>Unidades Compra</strong></h6></th> 
			<th data-sortable="true" data-field="Costo Mortalidad" data-filter-control="input"><h6><strong>Costo U/Compra</strong></h6></th> 
			<th data-sortable="true" data-field="Costo Mortalidad" data-filter-control="input"><h6><strong>Costo T/Compra</strong></h6></th> 
			<th data-sortable="true" data-field="Peso" data-filter-control="input"><h6><strong>Peso</strong></h6></th> 
			<th data-sortable="true" data-field="Talla" data-filter-control="input"><h6><strong>Talla</strong></h6></th> 
			<th data-sortable="true" data-field="Existencia" data-filter-control="input"><h6><strong>Existencia</strong></h6></th> 
			<th data-sortable="true" data-field="Costo Unitario" data-filter-control="input"><h6><strong>Costo Unitario</strong></h6></th> 
			<th data-sortable="true" data-field="Costo Total" data-filter-control="input"><h6><strong>Costo Total</strong></h6></th> 
		</tr>
	</thead>
	<tbody>
		<?php  
			while($FilaDetalle = mysqli_fetch_array($QueryDetalle))
			{

				$Fecha = date('d-m-Y', strtotime($FilaDetalle["Fecha"])); 
			    ?>
					<tr>
					    <td align="center"><?php echo $Fecha ?></td>
					    <td align="center"><?php echo number_format($FilaDetalle['CostoAlimentacion'],2) ?></td>
					    <td align="center"><?php echo number_format($FilaDetalle['UnidadesTerminadas'],2) ?></td>
					    <td align="center"><?php echo number_format($FilaDetalle['LibrasTerminadas'],2) ?></td>  
					    <td align="right"><?php echo number_format($FilaDetalle['PromedioLibra'],2) ?></td>
					    <td align="right"><?php echo number_format($FilaDetalle['CostoTerminado'],2) ?></td>
					    <td align="right"><?php echo number_format($FilaDetalle['UnidadesTraslado'],2) ?></td>
					    <td align="right"><?php echo number_format($FilaDetalle['CostoUTraslado'],2) ?></td>
					    <td align="right"><?php echo number_format($FilaDetalle['UnidadesMortalidad'],2) ?></td>
					    <td align="right"><?php echo number_format($FilaDetalle['CostoTotalMortalidad'],2) ?></td>
					    <td align="right"><?php echo number_format($FilaDetalle['CantidadCompra'],2) ?></td> 
					    <td align="right"><?php echo number_format($FilaDetalle['CostoUCompra'],2) ?></td> 
					    <td align="right"><?php echo number_format($FilaDetalle['TotalCompra'],2) ?></td>  
					    <td align="right"><?php echo number_format($FilaDetalle['PesoMuestra'],2) ?></td> 
					    <td align="right"><?php echo number_format($FilaDetalle['TallaMuestra'],2) ?></td>
					    <td align="right"><?php echo number_format($FilaDetalle['Existencia'],2) ?></td> 
					    <td align="right"><?php echo number_format($FilaDetalle['CostoUnitario'],2) ?></td> 
					    <td align="right"><?php echo number_format($FilaDetalle['CostoTotal'],2) ?></td> 
			  		</tr>
			    <?php 
			    $CostoA += $FilaDetalle['CostoAlimentacion'];
			    $CostoUT += $FilaDetalle['UnidadesTerminadas'];
			    $CostoLT += $FilaDetalle['LibrasTerminadas'];
			    $CostoTR += $FilaDetalle['CostoTerminado'];
			    $CostoUTR += $FilaDetalle['UnidadesTraslado'];
			    $CostoUTRT += $FilaDetalle['CostoUTraslado'];
			    $CostoM += $FilaDetalle['UnidadesMortalidad'];
			    $CostoTM += $FilaDetalle['CostoTotalMortalidad'];
			    $CostoC += $FilaDetalle['CantidadCompra'];
			    $CostoUC += $FilaDetalle['CostoUCompra'];
			    $CostoTC += $FilaDetalle['TotalCompra']; 
			} 

		?>
	</tbody>
	<tfoot>
		<tr>
		    <td align="center">Total</td>
		    <td align="center"><?php echo number_format($CostoA,2) ?></td>
		    <td align="center"><?php echo number_format($CostoUT,2) ?></td>
		    <td align="center"><?php echo number_format($CostoLT,2) ?></td>  
		    <td align="right"><?php echo number_format(1,2) ?></td>
		    <td align="right"><?php echo number_format($CostoTR,2) ?></td>
		    <td align="right"><?php echo number_format($CostoUTR,2) ?></td>
		    <td align="right"><?php echo number_format($CostoUTRT,2) ?></td>
		    <td align="right"><?php echo number_format($CostoM,2) ?></td> 
		    <td align="right"><?php echo number_format($CostoTM,2) ?></td>   
		    <td align="right"><?php echo number_format($CostoC,2) ?></td>  
		    <td align="right"><?php echo number_format($CostoUC,2) ?></td>  
		    <td align="right"><?php echo number_format($CostoTC,2) ?></td>  
	    </tr>
	</tfoot>

</table>