<?php
require("config/database.php");
require("config/config.php");
require("clases/clientesFunciones.php");
$db = new Database();
$con = $db->conectar();


$erorrs = array();
if(!empty($_POST)){
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono']);
    $dni = trim($_POST['dni']);
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['clave']);
    $repassword = trim($_POST['reclave']);

    if(esNulo([$nombres, $apellidos, $email, $telefono, $dni, $usuario, $password, $repassword])){
      $erorrs[] = "debe llenar todos los campos";
    }
    if(!esEMail($email)){
      $erorrs[] = "la direcion de correo no es valida";

    }
    if(!validadPassword($password, $repassword)){
      $erorrs[] = "las contraseñas no son iguales";
    }
    if(usuarioExiste($usuario, $con)){
      $erorrs[] = "el nombre de usuario $usuario ya existe";
    }
  
    if(emailExiste($email, $con)){
      $erorrs[] = "el correo ya existe $email ya existe";
    }


  }
   
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<?php include 'menu.php';?>
<main>
    
    <div class="container">
     <div class="imagen">
     <img src="http://clubhuellitasinfantiles.weebly.com/uploads/2/3/6/2/23628580/2843676_orig.jpg" alt="Estamos trabajando para llevarle el mejor servicio">
     <h1>contacto a evimport@evimport.sohp</h1>
   
     </div>
    
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>