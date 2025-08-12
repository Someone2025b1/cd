<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
include("../../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$mes = $_POST["mes"];
#$mes = "12-06-2025";
$anio = $_POST["anio"];
$fechaInicial = $_POST["fechaInicial"];
$fechaFinal = $_POST["fechaFinal"];
$dia = $_POST["dia"];
$punto=$_POST["punto"];
if ($mes!="") 
{
	$mesSelect = date("m",strtotime($mes));
	$year = date("Y",strtotime($mes));
	$filtro = "MONTH(A.PI_FECHA_PEDIDO) = $mesSelect AND YEAR(A.PI_FECHA_PEDIDO) = $year";
	$texto = "Del mes ".$mesSelect." y del año ".$year;
}
elseif ($anio!="") 
{
	$filtro = "YEAR(A.PI_FECHA_PEDIDO) = $anio";
	$texto = "Del año ".$anio;
}
elseif ($fechaInicial!="" && $fechaFinal!="") 
{
	$filtro = "A.PI_FECHA_PEDIDO BETWEEN '$fechaInicial' AND '$fechaFinal'";
	$texto = "De la fecha ".cambio_fecha($fechaInicial)." al ".cambio_fecha($fechaFinal);
}
elseif ($dia!="") 
{
	$filtro = "A.PI_FECHA_PEDIDO = '$dia'";
	$texto = "Del día ".cambio_fecha($dia);
}



?>
<title>Compras Bodega
<?php echo $texto ?></title>
<div class="row">
<br>
<br>
<br>
</div>
<div class="row">
<div class="col-lg-12">
	<?php
	
		$Query = "SELECT A.PI_FECHA_PEDIDO, A.PI_USUARIO, A.PI_FECHA_NECESIDAD, B.*, D.C_NOMBRES, D.C_APELLIDOS
				FROM CompraVenta.PEDIDO_INVENTARIO AS A
				JOIN CompraVenta.PEDIDO_INVENTARIO_DETALLE AS B ON  B.PI_CODIGO = A.PI_CODIGO
				JOIN info_bbdd.usuarios AS C ON  A.PI_USUARIO = C.id_user
				JOIN RRHH.COLABORADOR AS D ON  C.C_CODIGO = D.C_CODIGO
				WHERE $filtro
				ORDER BY A.PI_FECHA_PEDIDO";
	

	
	$Result = mysqli_query($db, $Query);
	$Registros = mysqli_num_rows($Result);

		if($Registros > 0)
		{
			?> 
			<center><h4>Compra Bodega
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
	
								$Codigo=number_format( $Fila['PID_CANTIDAD'], 0, '.', ',');
								$Conteo=$Fila["PID_CANTIDAD"];
								$Nombre=$Fila["PID_NOMBRE"];
								$CodigoRD=$Fila["RD_CPID_CODIGOODIGO"];
								$CodUsuario=$Fila["PI_USUARIO"];
								$Fecha=$Fila["PI_FECHA_PEDIDO"];
								$FechaNecesidad=$Fila["PI_FECHA_NECESIDAD"];

								$Estado = $Fila["PID_ESTADO"];

													if($Estado == 1)
													{
														$Text = "Solicitado";
													}
													elseif($Estado == 2)
													{
														$Text = "Realizado";
													}elseif($Estado == 3)
													{
														$Text = "Recibido";
													}elseif($Estado == 4)
													{
														$Text = "Cancelado";
													}
													$Pidio=$Fila["C_NOMBRES"]." ".$Fila["C_APELLIDOS"];


							
								$Cumplio="Pendiente de Recibir";
								$DiasTranscurridos="Pendiente de Recibir";

								$fechaPi= new DateTime($Fecha);
								$fechaNe= new DateTime($FechaNecesidad);
								$Anti =  $fechaPi -> diff($fechaNe);
								$DiasAntici = $Anti -> format('%D días');

								

								
								if($Estado == 3){

									
												
												$FechaRec = $Fila["PID_FECHA_RECI"];
											

											if($FechaNecesidad>=$FechaRec){
												$Cumplio="SI se recibió el ".$FechaRec;
											}else{
												$Cumplio="NO se recibió el ".$FechaRec;
											}


											$fechapro= new DateTime($Fecha);
                                        $fechalis= new DateTime($FechaRec);
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
										<td <?php if($Cumplio=="NO se recibió el ".$FechaRec){echo "style='background-color: #f94829;'";}elseif($Cumplio=="SI se recibió el ".$FechaRec){echo "style='background-color: #3cea64;'";} ?> class="text-center"><h6><?php echo $Cumplio ?></h6></td>
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
 