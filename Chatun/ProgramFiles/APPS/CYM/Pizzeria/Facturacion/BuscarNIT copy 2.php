<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://consultareceptores.feel.com.gt/rest/action",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n  \"emisor_codigo\": \"ASOCRE\",\n  \"emisor_clave\": \"6423B3029AEAE099309BF1930C6EB09D\",\n  \"nit_consulta\": \"104219157\"\n}",
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
  echo $response;

$Data["Respuesta"] = 'OK';
$Data["Nombre"] = $response["nombre"];
$Data["Direccion"] = $response["ciudad"];
}
?>