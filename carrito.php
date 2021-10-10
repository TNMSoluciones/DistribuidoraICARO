<?php 
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Distribuidora ICARO');
    $pdo = pdo_conectar_mysql();
    $selectProductos = $pdo->prepare('SELECT idProducto, Nombre, Precio, Imagen FROM producto WHERE idProducto=?');
    ?>    
    <main>
        <h1 id="only">Carrito</h1>
        <div id="productosCarrito">
            
            <?php
        if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $key) {
                $selectProductos->execute([$key['idProducto']]);
                $datosProducto = $selectProductos->fetch(PDO::FETCH_ASSOC);
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
        }else {
            echo "El carrito esta vacio";
        }
        ?>
    </div>
    <button id="btnComprar">Comprar</button>
</main>
    
    <?php include_once 'Assets/footer.php';?>
    <link rel="stylesheet" href="Style/carritoStyle.css">
<script defer>
    document.getElementById('btnComprar').addEventListener('click', () => {
        let cantidadArticulos = document.querySelectorAll('.carritompra')
        if(cantidadArticulos.length>0) {
            location.href = 'comprarCarrito.php';
        }
    });
    document.getElementById('productosCarrito').addEventListener('click', e => {
        if (e.target.classList[0]=='btnEliminar') {
            let idProducto = e.target.parentElement.id;
            location.href = `ajax/modCart.php?remove=true&idProducto=${idProducto}`;
        }
    })
</script>