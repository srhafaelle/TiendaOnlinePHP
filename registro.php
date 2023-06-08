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



    if(count($erorrs) == 0){
         
    

      $id = registraCliente([$nombres, $apellidos, $email, $telefono, $dni], $con);


      if($id > 0){

    require 'clases/mailler.php';
    $mailer = new Mailer();
    $token = generarToken();
    $pass_hash = password_hash($password, PASSWORD_DEFAULT);
     
    $idUsusario = registraUsuario([$id, $usuario,  $token, $pass_hash ], $con); 
    if($idUsusario > 0){

      $url = SITE_URL . '/activar_cliente.php?id='. $idUsusario .'&token='.$token;
      $asunto = "activar cuenta EVimport.shop somos tu mejor aliado ";
      $cuerpo = " <h1><strom>$nombres</strom></h1> </br> para continuar con el registro debe activar su cuenta dando click en el siguente link <a href='$url'>Activar cuenta</a>";

     if($mailer->envairEmail($email, $asunto, $cuerpo)){
      echo "para terminar el registros siga las instrucciones que enviamos a su correo electronico $email";
      exit;
     }

    }else{
        $erorrs[]= "error al registrar usuario";
    }
}else{
   $erorrs[] = "error al registrar cliente";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/brands.min.css" integrity="sha512-G/T7HQJXSeNV7mKMXeJKlYNJ0jrs8RsWzYG7rVACye+qrcUhEAYKYzaa+VFy6eFzM2+/JT1Q+eqBbZFSHmJQew==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<?php include "menu.php" ?>
<main>
    
    <div class="container">

    <h2>Datos del cliente</h2>
    <?php 
    mostrarMensajes($erorrs);
    
    ?>

    <form  class="row g-3" action="registro.php" method="post" autocomplete="off">

    <div class="col-md-6">
      <label for="usuario"><span class="text-danger">*</span> Elige tu nombre de usuario</label>
      <input type="text" name="usuario" id="usuario" class="form-control" values="<?php echo $nombres; ?>" required>
      <span id="validaUsuario" class="text-danger"></span>
    </div>

    <div class="col-md-6">
      <label for="nombre"><span class="text-danger">*</span> Nombres</label>
      <input type="text" name="nombres" id="nombres" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label for="apellido"><span class="text-danger">*</span> Apellidos</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label for="DNI"><span class="text-danger">*</span> Documento numero</label>
      <input type="text" name="dni" id="dni" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label for="email"><span class="text-danger">*</span> Email</label>
      <input type="text" name="email" id="email" class="form-control" required>
      <span id="validaEmail" class="text-danger"></span>
    </div>
    <div class="col-md-6">
      <label for="clave"><span class="text-danger">*</span> Clave</label>
      <input type="password" name="clave" id="clave" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label for="reclave"><span class="text-danger">*</span> repite la clave</label>
      <input type="repassword" name="reclave" id="reclave" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label for="telefono"><span class="text-danger">*</span> Telefono</label>
      <input type="tel" name="telefono" id="telefono" class="form-control" required>
    </div>
    <i><b>Nota:</b>Los campos con asterico son obligatorios</i>
    <div class="col-12">
     
     <button type="submit" class="btn btn-primary">Registrar</button>
     <a href="login.php"><button class="btn btn-danger">Volver</button></a>
    </div>

    </form>
   
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>

let txtUsuario = document.getElementById('usuario')
txtUsuario.addEventListener('blur', function (){existeUsuario(txtUsuario.value)},false)

let txtEmail = document.getElementById('email')
txtEmail.addEventListener('blur', function (){existeEmail(txtEmail.value)},false)


function existeUsuario(usuario){
  let url = "clases/clienteAjax.php"
  let formData = new formData()
  formData.append("action", "existeUsuario")
  formData.append("usuario", usuario)

  fetch(url,{
    method: 'POST',
    body: formData
  }).then(response => response.json())
  .then(data =>{
    if(data.ok){
      document.getElementById('usuario').value = ''
      document.getElementById('validaUsuario').innerHTML = 'usuario ya registrado'
    }else{
      document.getElementById('validaUsuario').innerHTML = ''
    }

  })

}

function existeEmail(email){
  let url = "clases/clienteAjax.php"
  let formData = new formData()
  formData.append("action", "existeEmail")
  formData.append("email", email)

  fetch(url,{
    method: 'POST',
    body: formData
  }).then(response => response.json())
  .then(data =>{
    if(data.ok){
      document.getElementById('email').value = ''
      document.getElementById('validaEmail').innerHTML = 'email ya registrado'
    }else{
      document.getElementById('validaEmail').innerHTML = ''
    }

  })

}
</script>
</body>
</html>