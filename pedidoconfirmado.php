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
    session_start();

    $ultimoPedido = null;

    //Si el usuario le ha dado a finalizar pedido, los productos se almacenaran en la variable $ultimoPedido
    //y se creará la cookie con el nombre ultimoPedido y tebdrá los valores del array de la sesion compra
    //Los valores se convierten en String porque sino la cookie no funciona
    if(isset($_POST["accion"])){   
        if($_POST["accion"] == "finalizar"){
            $ultimoPedido = $_SESSION["compra"];
            setcookie("ultimoPedido",serialize($_SESSION["compra"]),time() + 60);
            //Ya que se ha finalizado el pedido, la sesion con los productos será destruida, así no siguen apareciendo en el carrito
            session_unset(); 
            session_destroy();
        }else{
            if(isset($_COOKIE["ultimoPedido"])){
                $ultimoPedido = unserialize($_COOKIE["ultimoPedido"]);
            }
        }
        
    }

    ?>
    <section id="carritocompra" class="mt-5">
    <h2 class="tituloh2 text-center fs-3 text-color1">PEDIDO COMPLETO</h2>
    <!-- Si el usuario entra en el carrito habiendo añadido previamente algun producto, mostrará los productos -->
    <?php if(!empty($ultimoPedido)){ ?>
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
    //Mostramos los productos 
    foreach ($ultimoPedido as $clave => $pedido ){ ?>
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
                <div class="divcarritocantidad2 col-3 col-xs-3 mt-3">
                <p class="text-color2 carritocantidad2"><?=$pedido->getCantidad()?></p>
                </div>
                </form>
            <div class="col-3 col-xs-3 text-center divpreciomovil2">
                <p class="text-color2 carritoprecio2"><?=$pedido->getProducto()->getPrecio_unidad()?>€</p>
            </div>
        </div>
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
        <?php $precioTotal = calculadoraPrecios::calculaPrecioTotal($ultimoPedido);?>
        <!-- Mostramos el precio total de los productos --> 
        <p class="fs-5 text-color2 textomovil">PRECIO TOTAL: <?php echo $precioTotal ?>€</p>
        <!-- Llamamos a la funcion calculaDescuento para que nos calcule el descuento en caso de haberlo --> 
        <?php $precioDescuento = pedido::calculaDescuento($ultimoPedido); ?>
        <!-- Mostramos el descuento total de los productos --> 
        <p class="fs-5 text-color2 textomovil">DESCUENTO:    <?php echo $precioDescuento ?>€</p> 
        <!-- Restamos el descuento al precio total para obtener el precio final -->
        <?php $precioPagar = $precioTotal - $precioDescuento; ?> 
        <!-- Mostramos el precio final -->
        <p class="fs-5 text-color2 textomovil">PRECIO FINAL: <?php echo $precioPagar ?>€</p> 
    </div>

    <!--En caso de no haber añadido aún nada al carrito, mostrará un mensaje y la posibilidad de ver el ultimo pedido realizado -->
    <?php }else{ ?>  
    <div class="container-xxl text-center" style="height: 400px">
    <p class="text-center text-color2 mt5 fs-3 noproducto">No has hecho ningún pedido</p>
    <button class="ultimopedido" type="submit"><a href="tienda.php">Ir a comprar</a></button>
    </div>
    <?php
    }
    ?>

      
    </body>
</html>