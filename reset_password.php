<?php
require("config/database.php");
require("config/config.php");
require("clases/clientesFunciones.php");

$user_id = $_GET['id'] ?? $_POST['user_id'] ?? '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if($user_id == "" || $token == ""){
  header("Location: index.php");
  exit;
}

$db = new Database();
$con = $db->conectar();

$erorrs = array();

if(!varificaTokenRequest($user_id, $token, $con)){
   echo "nose pudo verficar la informacion ";
   exit;
}

if(!empty($_POST)){
    
    $password = trim($_POST['clave']);
    $repassword = trim($_POST['reclave']);

    if(esNulo([$user_id, $token, $password, $repassword])){
      $erorrs[] = "debe llenar todos los campos";
    }
    
    if(!validadPassword($password, $repassword)){
      $erorrs[] = "las contraseñas no son iguales";
    }
    if(count($erorrs) == 0){
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
    if(actualizarPassword($user_id, $pass_hash, $con)){
      echo "clave modificada. </br> ";
      echo "<a href='login.php'>Iniciar sesion</a>";
      exit;

    }else{
      $erorrs[] = "error la clave no pudo ser modificada intenta nuevamente";
    }
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

<header>
  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a href="#" class="navbar-brand">
        <strong>Tienda nico</strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse  navbar.collapse" id="navbarHeader"></div>

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
             <li class="nav-item">
                <a href="#" class="nav-link active">Catalogo</a>
             </li>
             <li class="nav-item">
                <a href="#" class="nav-link">Contacto</a>
             </li>
      </ul>
      <a href="checkout.php" class="btn btn-primary">
         Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span></a>
    </div>
  </div>
</header>
<main class="form-login m-auto pt-4">
    
   <h3>Cambiar clave</h3>
   <?php  //mostrarMensajes($errors); ?>
   <form action="reset_password.php" method="post" class="row g-3" autocomplete="off">

   <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
   <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

      <div class="form-floating">
        <input class="form-control" type="password" name="password" id="password" placeholder="clave nueva" required>
        <label for="password">nueva clave</label>
      </div>
      <div class="form-floating">
        <input class="form-control" type="password" name="repassword" id="repassword" placeholder=" confirmar clave nueva" required>
        <label for="repassword">nueva clave</label>
      </div>

      <div class="d.grid gap-3 col-12">
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
      <div class="col-12">
        <a href="login.php">iniciar sesion</a>
      </div>

   </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>