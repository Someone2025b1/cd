<?php

include("../../../../../Script/conex.php");

	$NIT = $_POST["id"];

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://felcloud-instance-three.feel.com.gt/api/v2/servicios/externos/cuib",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n  \"emisor_codigo\": \"ASOCRE\",\n  \"emisor_clave\": \"6423B3029AEAE099309BF1930C6EB09D\",\n  \"nit_consulta\": \"2898766992007\"\n}",
  CURLOPT_HTTPHEADER => [
    "Accept: */*",
    "Content-Type: application/json",
    "User-Agent: Thunder Client (https://www.thunderclient.com)"
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);



curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {

}

$Explode = explode('"', $response);

$Nombre=$Explode[7];
$Direccion=$Explode[7];



$Data["Respuesta"] = 'OK';
$Data["Nombre"] = $Nombre;
$Data["Direccion"] = "CIUDAD";

echo json_encode($Data);
?>