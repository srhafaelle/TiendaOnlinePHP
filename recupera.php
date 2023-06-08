<?php
require("config/database.php");
require("config/config.php");
require("clases/clientesFunciones.php");
$db = new Database();
$con = $db->conectar();


$erorrs = array();
if(!empty($_POST)){
  
    $email = trim($_POST['email']);
   

    if(esNulo([$email])){
      $erorrs[] = "debe llenar todos los campos";
    }
    if(!esEMail($email)){
      $erorrs[] = "la direcion de correo no es valida";

    }
   
    if(count($erorrs) == 0){
      if(emailExiste($email, $con)){
        $sql = $con->prepare("SELECT usuarios.id, clientes.nombre FROM usuarios INNER JOIN clientes ON usuarios.id=clientes.id WHERE clientes.email LIKE ? LIMIT 1 ");
        $sql->execute([$email]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['id'];
        $nombre = $row['nombre'];

        $token = solicitaPassword($user_id, $con);
        if($token !== null){
          require 'clases/mailler.php';
          $mailer = new Mailer();
          $url = SITE_URL . '/reset_password.php?id='. $user_id .'&token='.$token;

          $asunto = "recuperar clave ";
          $cuerpo = "Estimado Cliente $nombre: </br> click en este link para cambiar tu clave <a href='$url'>recuperar clave</a>";
          $cuerpo.="</br> <h1>si no hiciste esta solicitus puedes ignorar este correo</h1>";

          if($mailer->envairEmail($email, $asunto, $cuerpo)){
            echo "<p><b>correo enviado</b></p> al corrreo $email";
            exit;
           }


        }
      }else{
        $erorrs[] = "no existe cuenta asociado de correo electronico";
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

<?php include("./menu.php"); ?>
<main class="form-login m-auto pt-4">
    
   <h3>Recuperar contraseña</h3>
   <?php  //mostrarMensajes($errors); ?>
   <form action="recupera.php" method="post" class="row g-3" autocomplete="off">

      <div class="form-floating">
        <input class="form-control" type="email" name="email" id="email" placeholder="correo electronico" required>
        <label for="email">correo electronico</label>
      </div>

      <div class="d.grid gap-3 col-12">
        <button type="submit" class="btn btn-primary">Enviar</button>
      </div>
      <div class="col-12">
        ¿Quieres registrarte? <a href="registro.php">Registrarse aqui</a>
      </div>

   </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>