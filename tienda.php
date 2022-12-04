<html>
    <head>
        <title>Tienda</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/full_estil.css" type="text/css" />
        <link href="assets/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-black">
    <?php
    include_once 'header.php';
    include 'config/parameters.php';
    include 'objetos/bocadillo.php';
    include 'objetos/jamon.php';
    include 'objetos/meterbocadillos.php';
    include 'objetos/pedido.php';
    //iniciamos la sesion
    session_start();
    //Si detecta una sesion de compra (el usuario ha añadido a la cesta algún producto), se comprobará el tipo de producto (jamon o bocadillo)  
    //y dentro de la variable productoSel, se meterá el producto en su correspondiente array, ya que obtendremos el correspondiente id de producto al clicar el botón.
    //Con $clave, se consigue introducir las imágenes en el bucle del carrito gracias a que recoge la letra b (en caso de ser bocadillo) y la letra j (en caso de ser jamon)
    //y seguidamente, obtiene el id del producto convertiendo este valor en string para obtener el mismo nombre que tiene la imagen.
    if(isset($_SESSION['compra'])){
        if(isset($_POST['bocadillo'])){
            $productoSel = $bocadillos[$_POST['bocadillo']];
            $clave = "b".strval($_POST['bocadillo']);
        }else if(isset($_POST['jamon'])){
            $productoSel = $jamones[$_POST['jamon']];
            $clave = "j".strval($_POST['jamon']);
        }
        if(isset($productoSel)){
            $pedido = new pedido($productoSel);
            //Si detecta un proucto que ya existe en el array, no lo añadirá al carrito
            $_SESSION['compra'][$clave] = $pedido;
        }
    }else{
        $_SESSION['compra'] = array();
    }
    ?>
    <section id="banner_tienda" class="container-fluid">
        <div class="col-12 bannertienda">
        <div class="container-xxl mb-2">
          <h1 class="mb-5 text-color1 text-center fs-1">TIENDA</h1>
        </div>
        </div>
    </section>

    <section id="seccionjamones" class="container-xxl mt-5">
    <h2 class="tituloh2 text-center fs-3 text-color1">JAMONES</h2>
    <div class="row">
    <?php
    //Mostramos todos los jamones con un bucle. Mostramos la foto, nombre de producto y precio junto a su correspondiente boton 
    //para añadirlo a la cesta
    foreach ($jamones as $jamon){ ?>
    <div class="articulomovil text-center col-xs-6 col-sm-4">
        <img class="productoimagen mt-4" src="imagenes/j<?=$jamon->getId_producto()?>.jpg" alt="<?=$jamon->getNombre_producto()?>" />
        <p class="fs-5 productodescripcion mt-2 mb-1 text-color2"><?=$jamon->getNombre_producto()?></p>
        <p class="fs-5 precio text-color2"><b><?=$jamon->getPrecio_unidad()?>€</b></p>
        <form action=<?=base_url.'tienda.php'?> method="post">
            <input type="hidden" name="jamon" value=<?=$jamon->getId_producto();?>>
            <button class="vermas" type="submit"> Añadir a la cesta</button>
        </form>
    </div>
    <?php
    } 
    ?>
    </div>
    </section>

    <section id="seccionbocadillos" class="container-xxl mt-5">
    <h2 class="tituloh2 text-center fs-3 text-color1">BOCADILLOS</h2>
    <div class="row">
    <?php
    //Mostramos todos los bocadillos con un bucle. Mostramos la foto, nombre de producto y precio junto a su correspondiente boton 
    //para añadirlo a la cesta
    foreach ($bocadillos as $bocadillo){ ?>
    <div class="articulomovil text-center col-xs-6 col-sm-4">
        <img class="productoimagen mt-4" src="imagenes/b<?=$bocadillo->getId_producto()?>.jpg" alt="<?=$bocadillo->getNombre_producto()?>" />
        <p class="fs-5 productodescripcion mt-2 mb-1 text-color2"><?=$bocadillo->getNombre_producto()?></p>
        <p class="fs-5 precio text-color2"><b><?=$bocadillo->getPrecio_unidad()?>€</b></p>
        <form action=<?=base_url.'tienda.php'?> method="post">
            <input type="hidden" name="bocadillo" value=<?=$bocadillo->getId_producto();?>>
            <button class="vermas" type="submit"> Añadir a la cesta</button>
        </form>
    </div>
    <?php
    } 
    ?>
    </div>
    </section>

    <section id="seccionofertas" class="container-xxl mt-5">
    <h2 class="tituloh2 text-center fs-3 text-color1">OFERTAS</h2>
    <div class="row">
    <?php
    //Mostramos todos los bocadillos que tengan en el campo oferta el valor SI con un bucle. Mostramos la foto, nombre de producto y precio junto a su correspondiente boton 
    //para añadirlo a la cesta. El precio sale con el descuento aplicado ya que llamamos a la función que calcula el descuento (precioConDescuento)
    foreach ($bocadillos as $bocadillo){ 
        if($bocadillo->getOferta() == 'SI'){
        ?>
        <div class="articulomovil text-center col-xs-6 col-sm-4">
            <img class="productoimagen mt-4" src="imagenes/b<?=$bocadillo->getId_producto()?>.jpg" alt="<?=$bocadillo->getNombre_producto()?>" />
            <p class="fs-5 productodescripcion mt-2 mb-1 text-color2"><?=$bocadillo->getNombre_producto()?></p>
            <p class="fs-5 precio text-color2"><b><?=$bocadillo->precioConDescuento()?>€</b></p>
            <form action=<?=base_url.'tienda.php'?> method="post">
                <input type="hidden" name="bocadillo" value=<?=$bocadillo->getId_producto();?>>
                <button class="vermas" type="submit"> Añadir a la cesta</button>
            </form>
        </div>
        <?php }
        }
        ?>
    </div>
    </section>
    </body>
    <?php include 'footer.php';?>
