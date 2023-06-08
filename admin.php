<?php 
require("config/database.php");


$db = new Database();
$com = $db->conectar();


$sql = $com->prepare("SELECT * FROM usuarios");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


$idEliminar = isset($_POST['id']) ? $_POST['id'] : "";
if($idEliminar != ""){
  var_dump($idEliminar);
}
if($idEliminar != ""){
  $sql = $com->prepare("DELETE FROM usuarios WHERE usuarios.id = $idEliminar");
  $sql->execute();
}




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="css/estilos.css">
</head>

<nav class="navbar navbar-expand-lg navbar-light bg-black">
  <a class="navbar-brand text-white" href="#">Administrador</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link text-white bg-dark" href="#">Usuarios <span class="text-white bg-dark">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white bg-dark" href="#">Ventas</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white bg-dark" href="#">Productos</a>
      </li>
      <li class="nav-item">
        <a class="nav-link disabled text-white bg-dark" href="#">aBCD</a>
      </li>
    </ul>
  </div>
</nav>

<body>

<main class="container">

<table class="table table-striped-columns">
  <thead>
    <tr class="bg-info text-white">
      <th scope="col">Usuarios</th>
      <th scope="col">ID</th>
      <th scope="col">Activo</th>
      <th scope="col">Accion</th>
    
    </tr>
  </thead>
  <tbody>
    <?php foreach($resultado as $r){ ?>
    <tr>
      <th scope="row"><?php echo $r["usuario"] ?></th>
      <td><?php echo $r["id"] ?></td>
      <td><?php echo $r["activacion"] ?></td>
      <td><button class="btn btn-danger" id="eliminar">Eliminar</button></td> 
    </tr>
    <?php } ?>
  </tbody>
</table>

</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script>
<script>
  let id = <?php echo $r['id']; ?>;

  let btn = document.getElementById("eliminar");
  btn.addEventListener("onclick", Eliminar(id))
function Eliminar(id){ 
  let url = "admin.php"
  

  fetch(url, {
    method:"POST",
    body: id,
    mode: "cors"
  }).then(r => r.json)
  .then(d => console.log(d))
  .catch(e=>console.log("error"))

}


</script>
</body>
</html>