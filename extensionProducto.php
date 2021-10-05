<?php
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    $pdo=pdo_conectar_mysql();
    //$idProductoSeleccionado = isset($_GET['idProducto']) && $_GET['idProducto']>0?$_GET
    isset($_GET['idProducto']) && $_GET['idProducto']>0?$idProductoSeleccionado=$_GET['idProducto']:header('Location: productos.php');
    $siExisteProducto = $pdo->query("SELECT COUNT(idProducto), Nombre FROM producto WHERE idProducto='$idProductoSeleccionado'")->fetch(PDO::FETCH_ASSOC);
    if ($siExisteProducto['COUNT(idProducto)']==1) {
        mostrarHeader('Comprar '.$siExisteProducto['Nombre']);
        $sql=$pdo->prepare("SELECT producto.*, categorias.Categoria FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria WHERE idProducto=?");
        $sql->execute([$idProductoSeleccionado]);
        $producto=$sql->fetch(PDO::FETCH_ASSOC);
        ?>
        <main>
            <div class="producto" id="<?=$producto['idProducto']?>">
                <div class="divImg">
                    <img src="data:image/png;base64,<?=base64_encode($producto['Imagen'])?>" alt="<?=$producto['Nombre']?>">
                </div>
                <div class="divInfo">
                    <h1><?=$producto['Nombre']?></h1>
                    <p>Stock Disponible: <?=$producto['Stock']?></p>
                    <input min="0" max="100" type="text" placeholder="Cantidad" oninput="comprobarChar()" id="cantidad">
                    <p>$ <?=$producto['Precio']?></p>
                    <p><?=$producto['Categoria']?></p>
                    <p>Descripción del producto: Esta increible cajita de chocolatada hecha por la gran empresa conaprole conocida por todo el país y el exterior llega a nuestra página para distribuir por cantidades mayores a un precio más que razonbale.</p>
                    <?php
                        if (!isset($_SESSION['idRol'])) {
                            echo '<input type="submit" id="btnAddCart" value="agregar al carrito">';
                        }
                    ?>
                </div>
            </div>
        </main>
            <script defer>
                const numeros = /^([0-9])/;
                const stockActual = parseInt(`<?=$producto['Stock']?>`);
                const numCantidad = document.getElementById('cantidad');
                const comprobarChar = function() {
                    !numeros.exec(numCantidad.value.slice(-1)) ? numCantidad.value = numCantidad.value.slice(0,-1):'';
                    numCantidad.value>stockActual ? numCantidad.value = stockActual : '';
                }
            </script>

            <script src="JavaScript/addCart.js" defer></script>
        <?php
    }else{header('Location: index.php');}
    include_once 'Assets/footer.php';
?>
<link rel="stylesheet" href="Style/extensionProducto.css">