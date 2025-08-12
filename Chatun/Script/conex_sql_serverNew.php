<?php
//error_reporting(error_reporting() & ~E_NOTICE);
ob_start();

// register_globals();
// Conecto con la base de datos 

session_start();
// Conecto con la base de datos 
//  $connectionInfo = array("UID" => "userconex", "PWD" => "Coosajo2041");
//  $db_sql = sqlsrv_connect("10.60.59.206", $connectionInfo);

//  if (!$db_sql) {
//      if( ($errors = sqlsrv_errors() ) != null) {
//          foreach( $errors as $error ) {
//              echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
//              echo "code: ".$error[ 'code']."<br />";
//              echo "message: ".$error[ 'message']."<br />";
//          }
//      } 
    
//     die( print_r( sqlsrv_errors(), true));

//      echo "Error con la base de datos, favor de comunicarse al departamento de IDT para verificar...";
    
//  } 
$serverName = "10.60.8.210";
$connectionInfo = array("UID"=>"bwlecturachatun","PWD"=>"BWChatun2021","ColumnEncryption"=>"Enabled");
$db_sql = sqlsrv_connect( $serverName, $connectionInfo);

if( $db_sql ) {
   // echo "Conexión establecidaasdfsdfsfas fasdf.<br />";
}else{
    echo "Conexión no se pudo establecer.<br />";
    die( print_r( sqlsrv_errors(), true));
}
    
//  function register_globals($order = 'egpcs')
// {
//     // define a subroutine
    // if(!function_exists('register_global_array'))
    // {
    //     function register_global_array(array $superglobal)
    //     {
    //         foreach($superglobal as $varname => $value)
    //         {
    //             global $$varname;
    //             $$varname = $value;
    //         }
    //     }
    // }
    
    // $order = explode("\r\n", trim(chunk_split($order, 1)));
    // foreach($order as $k)
    // {
        // switch(strtolower($k))
        // {
            // case 'e':    register_global_array($_ENV);        break;
            // case 'g':    register_global_array($_GET);        break;
            // case 'p':    register_global_array($_POST);        break;
            // case 'c':    register_global_array($_COOKIE);    break;
            // case 's':    register_global_array($_SERVER);    break;
        // }
    // }
// }

?>

