<?php
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
 
						 
								$BilletesQ200   = $_POST["BQ200"];
								$BilletesQ100   = $_POST["BQ100"];
								$BilletesQ50    = $_POST["BQ50"];
								$BilletesQ20    = $_POST["BQ20"];
								$BilletesQ10    = $_POST["BQ10"];
								$BilletesQ5     = $_POST["BQ5"];
								$BilletesQ1     = $_POST["BQ1"];
								$BilletesM1     = $_POST["MQ1"];
								$BilletesM50    = $_POST["MQ50"];
								$BilletesM25    = $_POST["MQ25"];
								$BilletesM10    = $_POST["MQ10"];
								$BilletesM5    = $_POST["MQ5"];
								$BilletesQTotal = $_POST["TCQ"];

								$BilletesD100   = $_POST["BD100"];
								$BilletesD50    = $_POST["BD50"];
								$BilletesD20    = $_POST["BD20"];
								$BilletesD10    = $_POST["BD10"];
								$BilletesD5     = $_POST["BD5"];
								$BilletesD1     = $_POST["BD1"];
								$BilletesDTotal = $_POST["TCD"];
								
								$BilletesL500   = $_POST["BL500"];
								$BilletesL100   = $_POST["BL100"];
								$BilletesL50    = $_POST["BL50"];
								$BilletesL20    = $_POST["BL20"];
								$BilletesL10    = $_POST["BL10"];
								$BilletesL5     = $_POST["BL5"];
								$BilletesLTotal = $_POST["TCL"];

								$CodigoCierre = $_POST["CodigoCierre"];

								$Cont = mysqli_query($db, "SELECT * FROM Bodega.APERTURA_CIERRE_CAJA a WHERE a.ACC_TIENE_PARCIAL = 1 AND a.ACC_CODIGO = '$CodigoCierre'");


							   if ($Cont) 
							   { 
								   $Consulta = "SELECT *FROM Bodega.CIERRE_DETALLE_PARCIAL a WHERE a.ACC_CODIGO = '$CodigoCierre'";
										   $Resultado = mysqli_query($db, $Consulta);
										   while($row = mysqli_fetch_array($Resultado))
										   {
											   $TotalParcial+=$row["ACCP_TOTAL"];
											   $BilletesQTotal+=$row["CD_TOTAL_Q"];
											   $BilletesDTotal+=$row["CD_TOTAL_D"];
											   $BilletesLTotal+=$row["CD_TOTAL_L"];
										   }
										   
								   $TotalGeneral+=$TotalParcial;
		   
							   }

							   $Detalle = mysqli_fetch_array(mysqli_query($db, "SELECT *FROM Bodega.CIERRE_DETALLE A WHERE A.ACC_CODIGO = '$CodigoCierre'"));

							   $sql = mysqli_query($db,"INSERT INTO Bodega.CIERRE_DETALLE_HISTORIAL (ACC_CODIGO, CD_Q_200, CD_Q_100, CD_Q_50, CD_Q_20, CD_Q_10, CD_Q_5, CD_Q_1, CD_M_1, CD_M_50, CD_M_25, CD_M_10, CD_M_5, CD_TOTAL_Q, CD_D_100, CD_D_50, CD_D_20, CD_D_10, CD_D_5, CD_D_1, CD_TOTAL_D, CD_L_500, CD_L_100, CD_L_50, CD_L_20, CD_L_10, CD_L_5, CD_TOTAL_L, CD_USUARIO)
							     VALUES ('".$CodigoCierre."', '".$Detalle["CD_Q_200"]."', '".$Detalle["CD_Q_100"]."', '".$Detalle["CD_Q_50"]."', '".$Detalle["CD_Q_20"]."', '".$Detalle["CD_Q_10"]."', '".$Detalle["CD_Q_5"]."', '".$Detalle["CD_Q_1"]."', '".$Detalle["CD_M_1"]."', '".$Detalle["CD_M_50"]."', '".$Detalle["CD_M_25"]."', '".$Detalle["CD_M_10"]."', '".$Detalle["CD_M_5"]."', '".$Detalle["CD_TOTAL_Q"]."', '".$Detalle["CD_D_100"]."', '".$Detalle["CD_D_50"]."', '".$Detalle["CD_D_20"]."', '".$Detalle["CD_D_10"]."', '".$Detalle["CD_D_5"]."', '".$Detalle["CD_D_1"]."', '".$Detalle["CD_TOTAL_D"]."', '".$Detalle["CD_L_500"]."', '".$Detalle["CD_L_100"]."', '".$Detalle["CD_L_50"]."', '".$Detalle["CD_L_20"]."', '".$Detalle["CD_L_10"]."', '".$Detalle["CD_L_5"]."', '".$Detalle["CD_TOTAL_L"]."', '".$id_user."')") or die(mysqli_error());

								$Query = mysqli_query($db, "UPDATE Bodega.CIERRE_DETALLE SET CD_Q_200 = '".$BilletesQ200."', CD_Q_100 = '".$BilletesQ100."', CD_Q_50 = '".$BilletesQ50."', CD_Q_20 = '".$BilletesQ20."', CD_Q_10 = '".$BilletesQ10."', CD_Q_5 = '".$BilletesQ5."', CD_Q_1 = '".$BilletesQ1."', CD_M_1 = '".$BilletesM1."', CD_M_50 = '".$BilletesM50."', CD_M_25 = '".$BilletesM25."', CD_M_10 = '".$BilletesM10."', CD_M_5 = '".$BilletesM5."', CD_TOTAL_Q = '".$BilletesQTotal."', CD_D_100 = '".$BilletesD100."', CD_D_50 = '".$BilletesD50."', CD_D_20 = '".$BilletesD20."', CD_D_10 = '".$BilletesD10."', CD_D_5 = '".$BilletesD5."', CD_D_1 = '".$BilletesD1."', CD_TOTAL_D = '".$BilletesDTotal."', CD_L_500 = '".$BilletesL500."', CD_L_100 = '".$BilletesL100."', CD_L_50 = '".$BilletesL50."', CD_L_20 = '".$BilletesL20."', CD_L_10 = '".$BilletesL10."', CD_L_5 = '".$BilletesL5."', CD_TOTAL_L = '".$BilletesLTotal."', CD_ACTUALIZA = '".$id_user."' WHERE ACC_CODIGO = '".$CodigoCierre."'") or die(mysqli_error());

								if(!$Query)
								{
									echo '2'; 
								 
								}
								else
								{ 
									echo "1";
								}
							?>
						 