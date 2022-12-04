<!DOCTYPE html PUBLIC>
<html>
<head>
    <title>Platilla de bootstrapp</title>
    <meta charset="UTF-8">
    <meta name="author" content="Autor">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/navbars/">
    <link href="assets/bootstrap.min.css" rel="stylesheet">
    <link href="assets/full_estil.css" rel="stylesheet" type="text/css" media="screen">
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</head>
<header>
  <nav class="navbar navbar-expand-lg bg-white">
    <div class="container-xxl">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand text-color1" href="index.php"><img class="logotipo" src="imagenes/logotipo.png"></a>  
                
      <div id="botones_tienda_smartphone">
        <a href="#" id="login" class="me-3 "><img src="imagenes/iconologin.png" alt=""></a>
        <a href="carrito.php"><img src="imagenes/iconocarrito.png" alt=""></a>
      </div>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="sobrenosotros.php">Sobre Nosotros</a>
          </li>
          <li class="nav-item dropdown tiendaBoton">
            <a class="nav-link dropdown-toggle active" href="tienda.php">Tienda</a>
            <ul class="dropdown-menu mostrar">
              <li><a class="dropdown-item" href="tienda.php#seccionjamones">Jamones</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="tienda.php#seccionbocadillos">Bocadillos</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="tienda.php#seccionofertas">Ofertas</a></li>
            </ul>
          </li>
        </ul>
        <div id="botones_tienda_escritorio" class="form-inline my-2 my-lg-0">
          <a href="#" id="login" class="me-3"><img src="imagenes/iconologin.png" alt=""></a>
          <a href="carrito.php"><img src="imagenes/iconocarrito.png" alt=""></a>
        </div>
      </div>
    </div>
  </nav>
</header>