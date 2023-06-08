<?php
require("config/database.php");
require("config/config.php");

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);


$cantidad = 1;
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

<?php include "menu.php"; ?>

<main>
    
    <div class="container">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
      <?php foreach($resultado as $row){ ?>

        <div class="col">
          <div class="card shadow-sm">
            <?php
            $id = $row["id"];
            $imagen = "images/productos/$id/i.jpg";
            if(!file_exists($imagen)){$imagen = "images/no-foto.jpg";}
            ?>
             <img src= '<?php echo $imagen;?>' >
            <div class="card-body">
              <h5 class='card-title'> <?php echo $row['nombre']; ?></h5>
             <p classs="card-text">$<?php echo number_format($row['precio'], 2, '.', ','); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                 <a href="detalles.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'],KEY_TOKEN);?>" class="btn btn-primary">Detalles</a>
                </div>
                <button class="btn btn-outline-success" type="button" onclick="addProducto('<?php echo $row['id']; ?>','<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>')"> Agregar</button>
                </div>
            </div>
          </div>
        </div>

      
    <?php  } ?>

      </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script >
  
//let btnAgregar = document.getElementById('btnAgregar')
//btnAgregar.onclick = addProducto(<?php //echo $id; ?> )

function addProducto(id,cantidad, token){
    let url = 'clases/carrito.php'
    let formData = new FormData()
    formData.append('id', id)
    formData.append/('cantidad', cantidad)
    formData.append('token', token)
   

    fetch(url, {
        method: 'POST',
        body: formData,
        mode: 'cors'
    }).then(response => response.json())
    .then(data =>{
        if(data.ok){
            let elemento = document.getElementById('num_cart')
            elemento.innerHTML = data.numero
           
          
            
        }
    })

} </script>

</body>
</html>