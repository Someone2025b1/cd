<?php
      include("../../../../../Script/conex.php");
      include("../../../../../Script/seguridad.php");
      include("../../../../../Script/funciones.php");

      $NIT = $_POST["NIT"];
      $Tiene=0;
     

      $SqlEventos   = ("SELECT * FROM Contabilidad.CLIENTE_CREDITO WHERE CLIC_NIT = $NIT");
      $Resultado = mysqli_query($db, $SqlEventos);
      while($dataEvento = mysqli_fetch_array($Resultado)){ 

        $Tiene=1;
      }


      if($Tiene==1){
        echo "1";
      }else{
        echo "0";
      }

?>  