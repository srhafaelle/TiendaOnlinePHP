<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://www.paypal.com/sdk/js?client-id=AeTOVsNkeATVC7lAIWPJqxihr1x7QswlukRfkYsn8Sr3aGQbphSGYMPeLItHyyQADrgw08hzqHLVpD7b&currency=USD"></script>
</head>
<body>
  <div id="paypal-button-container"></div>

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
                        value: 100
                } 
                    
                 }]
            });
        },

        onApprove: function(data, actions){
           actions.order.capture().then(function(detalles){
             window.location.href="completado.php";
           });
        },

        onCancel: function(data){
            alert("pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container');
  </script>
</body>
</html>