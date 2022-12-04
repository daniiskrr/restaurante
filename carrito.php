<html>
    <head>
        <title>Carrito de la compra</title>
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
    include 'objetos/calculadoraPrecios.php';
    include 'objetos/pedido.php';
    ?>
    <?php
    //iniciamos la sesion
    session_start();
    //La sesion durará un máximo de 90 segundos para que posteriormente, se quiten los productos del carrito. 
    //Para iniciar esto, el usuario debe de haber entrado en el carrito
    if (isset($_SESSION['inicio']) && (time() - $_SESSION['inicio'] > 90)) {
        session_unset(); 
        session_destroy();
        echo '<script>alert("Por inactividad, te hemos borrado los productos. Puedes volver a añadir lo que necesites.")</script>';
    }else{
        $_SESSION['inicio'] = time();
    }
    //si detecta que el usuario le da al boton - y solo hay 1 unidad en el carrito, eliminará el producto del array compra. 
    //En el caso que la cantidad no sea 1, restará -1 a la cantidad
    if(isset($_POST['del'])){
        $pedidoSel = $_SESSION["compra"][$_POST['clave']];
        if($pedidoSel->getCantidad() == 1) {
            unset($_SESSION["compra"][$_POST['clave']]);
        }else{
            $pedidoSel->setCantidad($pedidoSel->getCantidad() - 1);
        }
    //si detecta que el usuario le da al boton +, añadira el producto al array compra y añadirá la posición del producto. 
    //Añadirá +1 en la cantidad del producto 
    }else if(isset($_POST['add'])){
        $pedidoSel = $_SESSION["compra"][$_POST['clave']];
        $pedidoSel->setCantidad($pedidoSel->getCantidad() + 1);
    }
    ?>
    <section id="carritocompra" class="mt-5">
    <h2 class="tituloh2 text-center fs-3 text-color1">CESTA DE LA COMPRA</h2>
    <!-- Si el usuario entra en el carrito habiendo añadido previamente algun producto, mostrará los productos -->
    <?php if(!empty($_SESSION["compra"])){ ?>
    <div class="container-xxl">
        <div class="container-xxl ms-3 mt-5">
            <div class="row mt-5">
                <div class="col-3 col-xs-3">
                    <h2 class="fs-4 text-color1 titulocarrito">PRODUCTO</h2>
                </div>
            <div class="col-3 col-xs-3">
                <h2 class="fs-4 text-color1 titulocarrito">DESCRIPCION</h2>
            </div>
            <div class="col-3 col-xs-3 divtitulocarrito">
                <h2 class="fs-4 text-color1 titulocarrito">CANTIDAD</h2>
            </div>
            <div class="col-3 col-xs-3">
                <h2 class="fs-4 text-color1 titulocarrito">PRECIO</h2>
            </div>
        </div>
    </div>
    
    <?php
    //Mostramos los productos que se han añadido al array compra desde la tienda
    foreach ($_SESSION["compra"] as $clave => $pedido ){ ?>
    <div class="container-xxl">
        <div class="container-xxl ms-3 mt-5">
            <div class="row text-center">
                <div class="col-3 col-xs-3 mt-3">
                <img class="carritoimg" src="imagenes/<?=$clave?>.jpg"/>
            </div>
            <div class="col-3 col-xs-3 text-center desccarrito">
                <p class="fs-5 carritodesc mt-3 text-color2"><?=$pedido->getProducto()->getNombre_producto()?></p>
            </div>
            <div class="col-3 col-xs-3">
            <div class="row"> 
                <div class="col-4 col-xs-4 mt-3">
                <form action=<?=base_url.'carrito.php'?> method="post"> 
                <input type="hidden" name="clave" value=<?=$clave?>>
                <button class="carritoboton1" type="submit" name="del"> - </button>
                </form>
                </div>    
                <div class="divcarritocantidad col-4 col-xs-4 mt-3">
                <p class="text-color2 carritocantidad"><?=$pedido->getCantidad()?></p>
                </div>
                <div class="col-4 col-xs-4 mt-3">
                <form action=<?=base_url.'carrito.php'?> method="post"> 
                <input type="hidden" name="clave" value=<?=$clave?>>
                <input type="hidden" name="clave" value=<?=$clave?>>
                <button class="carritoboton2" type="submit" name="add"> + </button>
                </form>
            </div> 
        </div>
    </div>
            <div class="col-3 col-xs-3 text-center divpreciomovil">
                <p class="text-color2 carritoprecio"><?=$pedido->getProducto()->getPrecio_unidad()?>€</p>
            </div>
                <hr class="lineacarrito mt-5"></hr>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    </section>

    <div class="container-xxl text-center preciosmovil">
        <!-- Llamamos a la funcion calculaPrecioTotal para sumar los valores -->
        <?php $precioTotal = calculadoraPrecios::calculaPrecioTotal($_SESSION["compra"]);?>
        <!-- Mostramos el precio total de los productos --> 
        <p class="fs-5 text-color2 textomovil">PRECIO TOTAL: <?php echo $precioTotal ?>€</p>
        <!-- Llamamos a la funcion calculaDescuento para que nos calcule el descuento en caso de haberlo --> 
        <?php $precioDescuento = pedido::calculaDescuento($_SESSION["compra"]); ?>
        <!-- Mostramos el descuento total de los productos --> 
        <p class="fs-5 text-color2 textomovil">DESCUENTO:    <?php echo $precioDescuento ?>€</p> 
        <!-- Restamos el descuento al precio total para obtener el precio final -->
        <?php $precioPagar = $precioTotal - $precioDescuento; ?> 
        <!-- Mostramos el precio final -->
        <p class="fs-5 text-color2 textomovil">PRECIO FINAL: <?php echo $precioPagar ?>€</p> 
        <form action="pedidoconfirmado.php" method="POST">
            <button class="vermas" type="submit">Finalizar compra</button><br><br>
            <input type="hidden" name="accion" value="finalizar">
        </form>
        <form action="pedidoconfirmado.php" method="POST">
            <button class="vermas" type="submit">Ver último pedido</button>
            <input type="hidden" name="accion" value="ultimoPedido">
        </form>
        
    </div>

    <!--En caso de no haber añadido aún nada al carrito, mostrará un mensaje y la posibilidad de ver el ultimo pedido realizado -->
    <?php }else{ ?>  
    <div class="container-xxl text-center" style="height: 400px">
    <p class="text-center text-color2 mt5 fs-3 noproducto">Actualmente no hay nada en el carrito, prueba a añadir algo!</p>
    <form action="pedidoconfirmado.php" method="POST">
        <button class="vermas" type="submit">Ver último pedido</button>
        <input type="hidden" name="accion" value="ultimoPedido">
    </form>
    </div>
    <?php
    }

    ?> 
    </body>
    <?php include_once 'footer.php';?>     
</html>