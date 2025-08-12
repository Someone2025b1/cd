<?php
      include("../../../../../Script/conex.php");

      $search = $_POST['service'];

      $query_services = mysqli_query($db, "(SELECT UM_CODIGO, P_NOMBRE, P_CODIGO, P_PRECIO_COMPRA_PONDERADO  FROM Productos.PRODUCTO WHERE ((P_NOMBRE LIKE '%".$search."%') OR (P_CODIGO_BARRAS = '%".$search."%') OR (P_CODIGO = '%".$search."%')) AND P_ESTADO = 1 AND P_CAFE = 1 AND P_LLEVA_EXISTENCIA = 1 AND R_CODIGO IS NULL
) LIMIT 100");
      while ($row_services = mysqli_fetch_array($query_services)) {
      	
      	
      		$Nombre = $row_services["P_NOMBRE"];
      		$Unidad = $row_services["UM_CODIGO"];

                  $QueryCuentas = "SELECT UNIDAD_MEDIDA.UM_NOMBRE 
                                    FROM Bodega.UNIDAD_MEDIDA 
                                    WHERE UNIDAD_MEDIDA.UM_CODIGO = ".$Unidad;
                  $ResultCuentas = mysqli_query($db, $QueryCuentas);
                  while($row = mysqli_fetch_array($ResultCuentas))
                  {
                        
                        $UnidadMedida = $row["UM_NOMBRE"];
                                                            }
      	

          echo '<h5 class="text-ultra-bold"><a class="suggest-element text-primary-dark" data="'.$row_services['P_NOMBRE'].'" UM="'.$UnidadMedida.'" dataPrecio="'.$row_services['P_PRECIO_COMPRA_PONDERADO'].'" dataCant="'.$row_services['Cantidad'].'" dataTipo="'.$row_services['Tipo'].'" id="'.$row_services['P_CODIGO'].'">'.$Nombre.' Medida '. $UnidadMedida.'</a></h5>'; 
      }
?>