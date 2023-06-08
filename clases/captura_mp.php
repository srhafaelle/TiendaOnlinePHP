<?php

require '../config/config.php';
require '../config/database.php';

$db = new DataBase();
$con = $db->conectar();

$id_transaccion = isset($_GET['paymend_id']) ? $_GET['payment_id'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

if($id_transaccion != ''){
    $fecha = date("Y-m-d H:i:s");
    $monto = isset($_SESSION['carrito']['total']) ? $_SESSION['carrito']['total'] : 0;
    $id_cliente = $_SESSION['user_cliente'];
    $sqlProd = $con->prepare("SELECT email, FROM clientes WHERE id=? AND estatus=1");
    $sqlProd->execute([$id_cliente]);
    $row_cliente = $sqlProd->fetch(PDO::FETCH_ASSOC);
    $email = $row_cliente['email'];


    $comando = $con->prepare("INSERT INTO compra (fecha, status, email, id_cliente, total, id_transaccion, medio_pago) VALUES(?,?,?,?,?,?,?)");
    $comando->execute([$fecha, $status, $email, $id_cliente, $monto, $id_transaccion, 'MP']);
    $id = $con->lastInsertId();

if($id > 0){
    $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;

if($productos != null){
    foreach($productos as $clave => $cantidad){
        $sqlProd = $con->prepare("SELECT id, nombre, precio, descuento FROM productos WHERE id= ? AND activo = 1");
        $sqlProd->execute([$clave]);
        $row_prod = $sqlProd->fetch(PDO::FETCH_ASSOC);

        $precio = $row_prod['precio'];
        $descuento = $row_prod['descuento'];
        $precio_desc = $precio - (($precio * $descuento) / 100);


        $sql = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, cantidad, precio) VALUES(?,?,?,?,?)");
        $sql->execute([$id, $row_pro['id'], $row_pro['nombre'], $cantidad, $precio_desc]);
    }
      require 'mailler.php';
      require 'mailler.php';

       $asunto = 'Detalles de su Pedido';
       $cuerpo = '<h4>gracias por su compra</h4>';
       $cuerpo .= '<p>id de su comprea es <b> ' . $id_transaccion . '</b></p>';

       $mailer = new Mailer();
       $mailer->envairEmail($email, $asunto, $cuerpo);

}
    unset($_SESSION['carrito']);
    header("Location: ". SITE_URL . "/completado.php?key=" . $id_transaccion);
 }
}

?>