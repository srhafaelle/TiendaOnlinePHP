<?php
require("config/database.php");
require("config/config.php");
require("clases/clientesFunciones.php");
$db = new Database();
$con = $db->conectar();


$proceso = isset($_GET['pago']) ? 'pago' : 'login';



$errors = array();

if(!empty($_POST)){
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    $proceso = $_POST['proceso'] ?? 'login';
 

    if(esNulo([$usuario, $password])){
      $errors [] = "debe llenar todos los campos";
    }
   if(count($errors ) == 0){
    $errors [] = login($usuario, $password, $con, $proceso);
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

<?php include "menu.php"  ?>



<main class="form-login m-auto pt-4">
  <h2>Iniciar sesion</h2>
    <?php 
     mostrarMensajes($errors); ?>
    <form class="row g-3" action="login.php" method="post" autocomplete="off">
      <input type="hidden" name="proceso" value="<?php echo $proceso; ?>">

      <div class="form-floating">
      <input class="form-control" type="text" name="usuario" placeholder="Usuario" required>
      <label for="usuario">Ususario</label>
      </div>

      <div class="form-floating">
      <input class="form-control" type="password" name="password" placeholder="clave" required>
      <label for="password">clave</label>
      </div>

      <div class="col-12">
        <a href="recupera.php">¿olvidaste tu clave?</a>
      </div>

      <div class="d-grid gap-3 col-12">
        <button type="submit" class="btn btn-primary">Ingresar</button>
      </div>
      <hr>
      <div class="col-12">
        ¿Quieres registrarte? <a href="registro.php">Registrarse aqui</a>
      </div>

    </form>
    
   
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>