<?php
error_reporting(error_reporting() & ~E_NOTICE);
ini_set("session.cookie_lifetime","36000");
session_start();
//error_reporting(E_ALL ^ E_NOTICE);
if ($_SESSION["autentificado"] != "SI")
{	
	header("Location:  https://portal.parquechatun.com.gt/index.php?error=63", "_top");
}
?>
