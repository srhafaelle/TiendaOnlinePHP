<header>

  <div class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
     
      <a href="index.php" class="navbar-brand">
        <img  src="images/evimportp.png" alt="" class="img">
      </a>
     
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse  navbar-collapse" id="navbarHeader">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a href="contacto.php" class="nav-link">Usados</a>
             </li> 
             <li class="nav-item">
                <a href="contacto.php" class="nav-link">Nuevos</a>
             </li>
             <li class="nav-item">
                <a href="contacto.php" class="nav-link">Contacto</a>
             </li>
        </ul>
    </div>
     

      
      
      
      <a href="checkout.php" class="btn btn-primary me-2"> Carrito <span id="num_cart" class="badge bg-secondary"><?php echo $num_cart ?></span></a>
      
      <?php if(isset($_SESSION['user_name'])){?>


        <div class="dropdown">
           <button class="btn btn-secces btn-sm dropdown-toggle" type="button" id="btn-session" data-bs-toggle="dropdown" aria-expanded="false">
               <i class="fas fa-user"></i> &nbsp; <?php echo $_SESSION['user_name'];?>
           </button>
            <ul class="dropdown-menu" aria-labelledby="btn-session">
              <li><a class="dropdown-item" href="compras.php"> Mis Compras</a></li>
              <li><a class="dropdown-item" href="logout.php">cerrar session</a></li>
             </ul>
           </div>

      <?php }else{ ?>
        <a href="login.php" class="btn btn-success btn-sm"><i class="fas fa-user"></i> Ingresar</a>

        <?php } ?>
      
    </div>
  </div>
</header>