<?php

use MercadoPago\Preference;

require("config/database.php");
require("config/config.php");
require __DIR__ .  '/vendor/autoload.php';

MercadoPago\SDK::setAccessToken(TOKEN_MP);

$prederence = new \MercadoPago\Preference();
$productos_mp = array();

$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

$lista_carrito = array();

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
}else{
    header("location: index.php");
    exit;
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
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">

    <script src="https://www.paypal.com/sdk/js?client-id=AeTOVsNkeATVC7lAIWPJqxihr1x7QswlukRfkYsn8Sr3aGQbphSGYMPeLItHyyQADrgw08hzqHLVpD7b&currency=USD"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>

<?php include 'menu.php'; ?>
<main>
    
    <div class="container">

    <div class="row ">
        <div class="col-6">
            <h4 class="text-center">Detalles de pago</h4>
             <div class="row">
               <div class="col-12">
            <div id="paypal-button-container"></div>
               </div>
             </div>

             <div class="row">
               <div class="col-12">
            <div class="cho-container"></div>
               </div>
             </div>
        </div>
       
        <div class="col-6">
      <div class="table-responsive">
        <table class="table">
               <thead>
                <tr>
                <th>producto</th>
                <th>subtotal</th>
                <th></th> 
                </tr>
               </thead>
               <tbody>
               <?php if($lista_carrito == null){
                            echo '<tr><td colspan="5" class="text-center"><b>Lista vacia</b></td></tr>';
           } else {
               $total = 0;
               foreach ($lista_carrito as $producto) {
                   $_id = $producto['id'];
                   $nombre = $producto['nombre'];
                   $precio = $producto['precio'];
                   $descuento = $producto['descuento'];
                   $cantidad = $producto['cantidad'];
                   $precio_desc = $precio - (($precio * $descuento) / 100);
                   $subtotal = $cantidad * $precio_desc;
                   $total += $subtotal;
            

          
                   $item = new MercadoPago\Item();
                   $item->id = $_id;
                   $item->title = $nombre;
                   $item->quantity = $cantidad;
                   $item->unit_price = $precio_desc;
                   $item->currency_id = CURRENCY;
                
                   array_push($productos_mp, $item);
                   unset($item);
                  ?>
                <tr>
                    <td><?php echo $nombre; ?>  </td>
                    <td> 
                        <div id="subtotal_<?php echo $_id;?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal, 2, ".", ",");?></div>
                    </td>
                    
                </tr>
                <?php } ?>

                <tr>
                   
                    <td colspan="2">
                       <p class="h3 text-end" id="total"><?php echo MONEDA . number_format($total, 2, ",", ".");?></p>
                      
                    </td>
                   
                </tr>
               </tbody>
               <?php } ?>
        </table>
      </div>
     
    </div>
    </div>
    </div>
           

</main>
<?php 
$preference->items = $productos_mp;
$preference->back_urls = array(
    "succes" => "https://srv245.hstgr.io:7443/66beddf0d88276b0/files/public_html/captura.php",
    "failure" => "https://srv245.hstgr.io:7443/66beddf0d88276b0/files/public_html/fallo.php"
);
$preference->auto_return = "approved";
$preference->binary_mode = true;


$preference->save();

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


<script>
    paypal.Buttons({
        style:{
            color:'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions){
            return actions.order.create({
                 purchase_units: [{
                     amount:{
                        value: <?php echo $total; ?>
                } 
                    
                 }]
            });
        },

        onApprove: (data, actions)=>{
            let URL = 'clases/captura.php'
             actions.order.capture().then(function(detalles){
            

            return fetch(URL,{
                method: 'post',
                headers: {
                    'content-type': 'application/json'
                },
                body: JSON.stringify({
                    detalles: detalles      
                })
             }).then(function(response){
                window.location.href = 'completado.php?key=' + detalles['id']; 
                
             })
           });
        },

        onCancel: function(data){
            alert("pago cancelado");
            
        }
    }).render('#paypal-button-container');

    //boton de mercado pago

    const mp = new MercadoPago(<?php echo TOKENMP_USER; ?>, {
    locale: 'es-AR'
   });
   
   
   mp.checkout({
    preference: {
      id: '<?php echo $preference->id;?>'
    },
    render: {
      container: '.cho-container',
      label: 'Pagar MP',
    }
  });

  </script>


</body>
</html>