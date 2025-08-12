<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mes = $_POST["mes"];
$anio = $_POST["anio"];
$fechaInicial = $_POST["fechaInicial"];
$fechaFinal = $_POST["fechaFinal"];
$dia = $_POST["dia"];
$punto=$_POST["punto"];
if ($mes!="") 
{
	$mesSelect = date("m",strtotime($mes));
	$year = date("Y",strtotime($mes));
	$filtro = "MONTH(A.R_FECHA) = $mesSelect AND YEAR(A.R_FECHA) = $year";
	$texto = "Del mes ".$mesSelect." y del año ".$year;
}
elseif ($anio!="") 
{
	$filtro = "YEAR(A.R_FECHA) = $anio";
	$texto = "Del año ".$anio;
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "A.R_FECHA BETWEEN '$fechaInicial' AND '$fechaFinal'";
	$texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
}
elseif ($dia!="") 
{
	$filtro = "A.R_FECHA = '$dia'";
	$texto = "Del día ".cambio_fecha($dia);
}



?>
<title>Venta de Proiductos 
<?php echo $texto ?></title>
<div class="row">
<br>
<br>
<br>
</div>
<div class="row">
<div class="col-lg-12">
	<?php
	
		$Query = "SELECT A.R_FECHA, A.U_CODIGO, B.*, D.C_NOMBRES, D.C_APELLIDOS, E.A_NOMBRE
				FROM CompraVenta.REQUISICION AS A
				JOIN CompraVenta.REQUISICION_DETALLE AS B ON  B.R_CODIGO = A.R_CODIGO
				JOIN info_bbdd.usuarios AS C ON  A.U_CODIGO = C.id_user
				JOIN RRHH.COLABORADOR AS D ON  C.C_CODIGO = D.C_CODIGO
				JOIN RRHH.AREAS AS E ON  D.A_CODIGO = E.A_CODIGO
				WHERE $filtro
				ORDER BY A.R_FECHA";
	

	
	$Result = mysqli_query($db, $Query);
	$Registros = mysqli_num_rows($Result);

		if($Registros > 0)
		{
			?> 
			<center><h4>Venta de Productos 
<?php echo $texto ?></h4></center>
				<div id="myTable_wrapper" class="dataTables_wrapper no-footer"> <table id="TblTicketsHotel1" class="table table-bordered table-striped dataTable no-footer" role="grid" aria-describedby="myTable_info"> 
					<thead>
						<tr>
							<th><h5><strong>#</strong></h5></th>
							<th><h5><strong>Codigo</strong></h5></th>
							<th><h5><strong>CANTIDAD</strong></h5></th>
							<th><h5><strong>NOMBRE PRODUCTO</strong></h5></th>
							<th><h5><strong>PEDIDO</strong></h5></th>
							<th><h5><strong>NECESIDAD</strong></h5></th>
							<th><h5><strong>DIAS CON ANTICIPACIÓN</strong></h5></th>
							<th><h5><strong>ESTADO</strong></h5></th>
							<th><h5><strong>DIAS TRANSCURRIDOS</strong></h5></th>
							<th><h5><strong>A TIEMPO</strong></h5></th>
							<th><h5><strong>PIDIO</strong></h5></th>


						</tr>
					</thead>
					<tbody>
						<?php
							$Contador = 1;
							while($Fila = mysqli_fetch_array($Result))
							{
	
								$Codigo=number_format( $Fila['RD_CANTIDAD'], 0, '.', ',');
								$Conteo=$Fila["CANTIDAD"];
								$Nombre=$Fila["RD_PRODUCTO"];
								$CodigoRD=$Fila["RD_CODIGO"];
								$CodUsuario=$Fila["U_CODIGO"];
								$Fecha=$Fila["R_FECHA"];
								$Clasificacion=$Fila["RD_CLASIFICACION"];
								$FechaNecesidad=$Fila["RD_FECHA_NECESIDAD"];

								$Estado = $Fila["RD_ESTADO"];

													if($Estado == 1)
													{
														$Text = "Pedido recibido";
													}
													elseif($Estado == 2)
													{
														$Text = "Cotizando";
													}elseif($Estado == 3)
													{
														$Text = "Pendiente de Confirmar Cotización";
													}elseif($Estado == 4)
													{
														$Text = "Cotización Confirmada";
													}elseif($Estado == 5)
													{
														$Text = "Confirmación de Director Ejecutivo ";
													}elseif($Estado == 6)
													{
														$Text = "Pedido";
													}elseif($Estado == 7)
													{
														$Text = "Recibido";
													}elseif($Estado == 8)
													{
														$Text = "Pendiente de Factura";
													}elseif($Estado == 9)
													{
														$Text = "Pendiente de Pagar";
													}elseif($Estado == 10)
													{
														$Text = "Pagado";
													}elseif($Estado == 11)
													{
														$Text = "Cancelado";
													}

													$Pidio=$Fila["C_NOMBRES"]." ".$Fila["C_APELLIDOS"];


								$Total=$Conteo*$Costo;
								$sumaConteo += $Conteo;
								$Cumplio="Pendiente de Recibir";
								$DiasTranscurridos="Pendiente de Recibir";

								$fechaPi= new DateTime($Fecha);
								$fechaNe= new DateTime($FechaNecesidad);
								$Anti =  $fechaPi -> diff($fechaNe);
								$DiasAntici = $Anti -> format('%D días');

								if($Estado >= 7){

									$QuerySeg = "SELECT SEGUIMIENTO_REQUICISION.* FROM CompraVenta.SEGUIMIENTO_REQUICISION 
									WHERE SEGUIMIENTO_REQUICISION.RD_CODIGO ='$CodigoRD' 
									AND SEGUIMIENTO_REQUICISION.U_CODIGO = $CodUsuario 
									AND (SEGUIMIENTO_REQUICISION.RD_ESTADO = 8 OR SEGUIMIENTO_REQUICISION.RD_ESTADO = 9)";
											$ResultSeg = mysqli_query($db, $QuerySeg);
											while($rowSeg = mysqli_fetch_array($ResultSeg))
											{
												
												$FechaRec = $rowSeg["SR_FECHA"];
											}

											if($FechaNecesidad>=$FechaRec){
												$Cumplio="SI se recibió el".$FechaRec;
											}else{
												$Cumplio="NO se recibió el".$FechaRec;
											}


											$fechapro= new DateTime($Fecha);
                                        $fechalis= new DateTime($FechaRec);
                                        $diferencia =  $fechapro -> diff($fechalis);
                                        $DiasTranscurridos = $diferencia -> format('%M meses y %D días');
								}

								if($Clasificacion==6){

									$Cumplio="Compra de Emergencia ".$FechaNecesidad;
									$DiasTranscurridos = $Anti -> format('%D días');

								}

								if($Estado==11){

									$QuerySeg = "SELECT SEGUIMIENTO_REQUICISION.* FROM CompraVenta.SEGUIMIENTO_REQUICISION 
									WHERE SEGUIMIENTO_REQUICISION.RD_CODIGO ='$CodigoRD' 
									AND SEGUIMIENTO_REQUICISION.RD_ESTADO = 11";
											$ResultSeg = mysqli_query($db, $QuerySeg);
											while($rowSeg = mysqli_fetch_array($ResultSeg))
											{
												
												$FechaCance = $rowSeg["SR_FECHA"];
											}


									$Cumplio="Cancelada con fecha ".$FechaCance;
									$fechapro= new DateTime($Fecha);
                                        $fechalis= new DateTime($FechaCance);
                                        $diferencia =  $fechapro -> diff($fechalis);
										$DiasTranscurridos = $diferencia -> format('%M meses y %D días');

								}

								
								

								 
								?>
									<tr>
										<td><h6><?php echo $Contador ?></h6></td>
										<td><h6><?php echo $CodigoRD ?></h6></td>
										<td><h6><?php echo $Codigo ?></h6></td>
										<td><h6><?php echo $Nombre ?></h6></td>	 
										<td class="text-center"><h6><?php echo $Fecha ?></h6></td>
										<td class="text-center"><h6><?php echo $FechaNecesidad ?></h6></td>
										<td class="text-center"><h6><?php echo $DiasAntici ?></h6></td>
										<td class="text-center"><h6><?php echo $Text ?></h6></td>
										<td class="text-center"><h6><?php echo $DiasTranscurridos ?></h6></td>
										<td <?php if($Cumplio=="NO se recibió el".$FechaRec){echo "style='background-color: #f94829;'";}elseif($Cumplio=="SI se recibió el".$FechaRec){echo "style='background-color: #3cea64;'";} ?> class="text-center"><h6><?php echo $Cumplio ?></h6></td>
										<td class="text-center"><h6><?php echo $Pidio ?></h6></td>
									</tr>
								<?php
								
								$sumaConteotO += $Total;
								$Contador++;
								
							}
							
							
						?>
						
						<tfoot>
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td><h3>Total</h3></td>
							<td align="center"><h3><?php echo $sumaConteo ?></h3></td>
							<td align="center"><h3><?php echo $sumaConteotO ?></h3></td>
						</tr>
						</tfoot>
					</tbody>
				</table>
			<?php
		}
		else
		{
			?>
				<div class="row text-center">
					<div class="alert alert-warning">
						<strong>No existen registros para las fechas ingresadas</strong>
					</div>
				</div>
			<?php
		}
	?>
</div>
</div>
</div>
</div>
</div>
 