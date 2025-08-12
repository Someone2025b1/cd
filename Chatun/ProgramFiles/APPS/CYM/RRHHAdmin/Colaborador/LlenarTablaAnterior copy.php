<?php 
include("../../../../../Script/seguridad.php");
include("../../../../../Script/conex.php"); 
include("../../../../../Script/conex_a_coosajo.php");
include("../../../../../Script/conex_sql_server.php");
include("../../../../../Script/funciones.php");
$id_user = $_SESSION["iduser"];
$id_depto = $_SESSION["id_departamento"];
$CodCol = $_POST["id"];






$query = "SELECT * FROM RRHH.AREA_EVALUAR WHERE AREA_EVALUAR.AR_CODIGO <> 8 AND  AREA_EVALUAR.AR_CODIGO <> 9 ORDER BY AR_CODIGO";
        $result = mysqli_query($db, $query);
        while($row = mysqli_fetch_array($result))
        {
            $CodAre=$row["AR_CODIGO"];
            $NombreAre=$row["AR_NOMBRE"];

            $sqlRet = mysqli_query($db,"SELECT A.*, B.C_CODIGO
            FROM RRHH.EVALUACION_DES_RESUMEN AS A, RRHH.EVALUACION_DESEMPENO AS B     
            WHERE A.ED_CODIGO = B.ED_CODIGO
            AND B.C_CODIGO = '$CodCol'
            AND A.AR_CODIGO = ".$CodAre."
            ORDER BY B.ED_FECHA DESC
            LIMIT 1"
            ); 

            $rowret=mysqli_fetch_array($sqlRet);

          
            $PunteoAnte=number_format($rowret["EVDR_PUNTEO"], 2, '.', ',');
									
	


		$Variable .= '<tr>';

            $Variable .= '<th>
                                        '.$NombreAre.'
                                        </th>';
		
			$Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="PromedioAreaR'.$CodAre.'" id="PromedioAreaR'.$CodAre.'" value="'.$PunteoE.'" readonly>
										</th>';
			$Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="ObtenidoAreaR'.$CodAre.'" id="ObtenidoAreaR'.$CodAre.'" value="'.$PunteoE.'" readonly>
										</th>';
			$Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="EsperadoAreaR'.$CodAre.'" id="EsperadoAreaR'.$CodAre.'" value="'.$PunteoE.'" readonly>
										</th>';
            $Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="UltimoObtenido'.$CodAre.'" id="UltimoObtenido'.$CodAre.'" value="'.$PunteoAnte.'" readonly>
										</th>';
			 
		$Variable .= '</tr>';
	}


    $sqlRet = mysqli_query($db,"SELECT A.*, B.C_CODIGO
            FROM RRHH.EVALUACION_DES_RESUMEN AS A, RRHH.EVALUACION_DESEMPENO AS B     
            WHERE A.ED_CODIGO = B.ED_CODIGO
            AND B.C_CODIGO = '$CodCol'
            AND A.AR_CODIGO = 8
            ORDER BY B.ED_FECHA DESC
            LIMIT 1"
            ); 

            $rowret=mysqli_fetch_array($sqlRet);

          
            $PunteoAnte=number_format($rowret["EVDR_PUNTEO"], 2, '.', ',');

    $Variable .= '<tr>';

            $Variable .= '<th>
                                        ÁREA DE TRABAJO
                                        </th>';
		
			$Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="PromedioAreaR8" id="PromedioAreaR8" value="'.$PunteoE.'" readonly>
										</th>';
			$Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="ObtenidoAreaR8" id="ObtenidoAreaR8" value="'.$PunteoE.'" readonly>
										</th>';
			$Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="EsperadoAreaR8" id="EsperadoAreaR8" value="'.$PunteoE.'" readonly>
										</th>';
            $Variable .= '<th>
										<input style="font-size:8px;" type="text" class="form-control" name="UltimoObtenido8" id="UltimoObtenido8" value="'.$PunteoAnte.'" readonly>
										</th>';
			 
		$Variable .= '</tr>';



        $sqlRet = mysqli_query($db,"SELECT A.*, B.C_CODIGO
            FROM RRHH.EVALUACION_DES_RESUMEN AS A, RRHH.EVALUACION_DESEMPENO AS B     
            WHERE A.ED_CODIGO = B.ED_CODIGO
            AND B.C_CODIGO = '$CodCol'
            AND A.AR_CODIGO = 9
            ORDER BY B.ED_FECHA DESC
            LIMIT 1"
            ); 

            $rowret=mysqli_fetch_array($sqlRet);

          
            $PunteoAnte=number_format($rowret["EVDR_PUNTEO"], 2, '.', ',');

        $Variable .= '<tr>';

        $Variable .= '<th>
                                    PUESTO DE TRABAJO
                                    </th>';
    
        $Variable .= '<th>
                                    <input style="font-size:8px;" type="text" class="form-control" name="PromedioAreaR9" id="PromedioAreaR9" value="'.$PunteoE.'" readonly>
                                    </th>';
        $Variable .= '<th>
                                    <input style="font-size:8px;" type="text" class="form-control" name="ObtenidoAreaR9" id="ObtenidoAreaR9" value="'.$PunteoE.'" readonly>
                                    </th>';
        $Variable .= '<th>
                                    <input style="font-size:8px;" type="text" class="form-control" name="EsperadoAreaR9" id="EsperadoAreaR9" value="'.$PunteoE.'" readonly>
                                    </th>';
        $Variable .= '<th>
                                    <input style="font-size:8px;" type="text" class="form-control" name="UltimoObtenido9" id="UltimoObtenido9" value="'.$PunteoAnte.'" readonly>
                                    </th>';
         
    $Variable .= '</tr>';


echo $Variable;

?>
