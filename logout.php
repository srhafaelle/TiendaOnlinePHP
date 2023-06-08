<?php 
require 'config/config.php';


session_destroy();

// unset($_SESSION['user_id']);
//  unset($_SESSION['user_name']);
//  unset($_SESSION['user_cliente']);
header("Location: index.php");

?>