<?php
//configuaracion de sistema
define("SITE_URL", "http://localhost/dashboard/");
define("MONEDA", "$");


//constantes paypal
define("KEY_TOKEN", "ABC.wcq-354*");
define("CLIENTE_ID", "AeTOVsNkeATVC7lAIWPJqxihr1x7QswlukRfkYsn8Sr3aGQbphSGYMPeLItHyyQADrgw08hzqHLVpD7b");
define("CURRENCY", "USD");

//constantes mercado libre
define("TOKEN_MP", "TEST-3631904791571486-011602-412a016758a66604a20fd0eaa7c82eb1-463916111");
define("TOKENMP_USER", "TEST-cfd16090-eed4-4f0e-a7fc-1761c8a66cd7");

//correo constantes
define("MAIL_HOST", "srhafaelle@hotmail.com");
define("MAIL_USER", "evimport.shop");
define("MAIL_PASS", "21235022Rha.");
define("MAIL_PORT", "465");

session_start();



$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}
?>

