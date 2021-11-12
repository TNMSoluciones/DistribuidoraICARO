<?php 
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Distribuidora ICARO');
    $pdo = pdo_conectar_mysql();
    $selectProductos = $pdo->prepare('SELECT idProducto, Nombre, Precio, Imagen FROM producto WHERE idProducto=?');
    ?>    
    <main>
        <div id="productosCarrito">
            
            <?php
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            $precioTotal = 0;
            foreach ($_SESSION['carrito'] as $key) {
                $selectProductos->execute([$key['idProducto']]);
                $datosProducto = $selectProductos->fetch(PDO::FETCH_ASSOC);
                $precioTotal=$precioTotal+($datosProducto['Precio']*$key['Cantidad']);
                ?>
                <div class="carritompra" id="<?=$datosProducto['idProducto']?>">
                    <div class="divImg">
                        <img src="data:image/png;base64,<?=base64_encode($datosProducto['Imagen'])?>" alt="">
                    </div>
                    <h1><?=$datosProducto['Nombre']?></h1>
                    <p>Cantidad <?=$key['Cantidad']?></p>
                    <p>Precio $<?=$datosProducto['Precio']?></p>
                    <p>Total $<?=$datosProducto['Precio']*$key['Cantidad']?></p>
                    <p class="btnEliminar" id="<?=$datosProducto['idProducto']?>"></p>
                </div>
                <?php
            }
            ?>
        </div>
        <div id="resumenPagar">
            <div id="formMetodoPago">
                <p>Monto Final: $<?=$precioTotal?></p>
                <img src="svg/aex.svg" alt="">
                <img src="svg/visa.svg" alt="">
                <img src="svg/paypal.svg" alt="">
                <img src="svg/mastercard.svg" alt="">
                <label>Seleccione el metodo de pago</label>
                <input type="radio" id="radioBtnEfectivo" name="metodoPago" value="Efectivo">
                <label for="radioBtnEfectivo">Efectivo</label>
                <input type="radio" id="radioBtnPOS" name="metodoPago" value="POS">
                <label for="radioBtnPOS">POS</label>
                <input type="button" id="btnComprar" value="Confirmar Compra" style="display: block;">
            </div>
        </div>
            <?php
        }else {
            ?>
                <div class="carritovacio">
                    <h1>¡Hay un carrito que llenar!</h1>
                    <h2>Actualmente no tienes productos en tu carrito.</h2>
                    <h2>Puedes buscar productos dentro de nuestro gran catálogo.</h2>
                    <a href="productos.php"><input type="submit" value="Ver catálogo"></a>
                </div>
            <?php
        }
        ?>
</main>
<div id="divEmergente"></div>
<?php include_once 'Assets/footer.php';?>
<link rel="stylesheet" href="Style/carritoStyle.css">
<script src="JavaScript/comprarCarrito.js"></script>
<script defer>
    document.getElementById('productosCarrito').addEventListener('click', e => {
        console.log(e);
        if (e.target.classList[0]=='btnEliminar') {
            let idProducto = e.target.parentElement.id;
            location.href = `ajax/modCart.php?remove=true&idProducto=${idProducto}`;
        }
    })
</script>