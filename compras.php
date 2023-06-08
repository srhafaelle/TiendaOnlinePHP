<?php
require("config/database.php");
require("config/config.php");
require("clases/clientesFunciones.php");
$db = new Database();
$con = $db->conectar();
$id_cliente = $_SESSION['user_cliente'];

$sql = $con->prepare("SELECT id_transaccion,  fecha, status, total, medio_pago FROM compra WHERE id_cliente = ? ORDER BY DATE(fecha) DESC");
$sql->execute([$id_cliente]);


   
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

<?php include 'menu.php'; ?>
<main>
    
    <div class="container">
        <h4>Mis compras</h4>
        <hr>

       <?php while($row = $sql->fetch(PDO::FETCH_ASSOC)){ ?> 
        <div class="card mb-3 border-primary">
  <div class="card-header">
   <?php echo $row['fecha']; ?>
  </div>
  <div class="card-body">
    <h5 class="card-title">Folio:<?php echo $row['id_transaccion']; ?></h5>
    <p class="card-text">Total <?php echo $row['total']; ?></p>
    <a href="compra_detalle.php" class="btn btn-primary">ver compra</a>
  </div>
</div>
<?php } ?>
   
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>