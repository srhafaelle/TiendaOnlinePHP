<?php

require __DIR__ .  '/vendor/autoload.php';
MercadoPago\SDK::setAccessToken('TEST-3631904791571486-011602-412a016758a66604a20fd0eaa7c82eb1-463916111');

$preference = new MercadoPago\Preference();


$item = new MercadoPago\Item();
$item->id = '0001';
$item->title = 'Mi producto';
$item->quantity = 1;
$item->unit_price = 75.56;
$item->currency_id = 'USD';
$preference->items = array($item);

$preference->back_urls = array(
    "succes" => "http://localhost/dashboard/captura.php",
    "failure" => "http://localhost/dashboard/fallo.php"
);
$preference->auto_return = "approved";
$preference->binary_mode = true;


$preference->save();



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba MercadoPago</title>
<script src="https://sdk.mercadopago.com/js/v2"></script>
</head>
<body>
    <h3>Mercado MercadoPago</h3>

    <div class="cho-container"></div>






    <script>
   const mp = new MercadoPago('TEST-cfd16090-eed4-4f0e-a7fc-1761c8a66cd7', {
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