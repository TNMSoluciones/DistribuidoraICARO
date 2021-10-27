<?php 
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Distribuidora ICARO');
    $pdo = pdo_conectar_mysql();
    $selectProductosDestacados = $pdo->prepare('SELECT idProducto, Nombre, Precio, Imagen, Stock FROM producto WHERE Destacado=1 ORDER BY RAND() LIMIT 3');
    $selectProductosDestacados->execute();
    $selectProductosRandom = $pdo->prepare('SELECT idProducto, Nombre, Precio, Imagen, Stock FROM producto ORDER BY RAND() LIMIT 15');
    $selectProductosRandom->execute();
?>
<main>
    <div id="slidervista">
        <figure id="slidercontenido">
            <img src="imgSlider/1.jpg">
            <img src="imgSlider/2.jpg">
            <img src="imgSlider/3.jpg">
            <img src="imgSlider/4.jpg">
            <img src="imgSlider/5.jpg">
            <img src="imgSlider/6.jpg">
            <img src="imgSlider/7.jpg">
            <img src="imgSlider/8.jpg">
            <img src="imgSlider/1.jpg">
            <img src="imgSlider/2.jpg">
            <img src="imgSlider/3.jpg">
        </figure>
    </div>

    <div id="section1">
        <img src="img/1.jpg"><img src="img/2.jpg"><img src="img/3.jpg">
    </div>
    
    <div id="section2">
        <h1>Productos destacados</h1>
        <?php while($productoDestacado = $selectProductosDestacados->fetch(PDO::FETCH_ASSOC)) {?>
            <div class="articulos">
                <div class="divImg">    
                    <img src="data:image/png;base64,<?=base64_encode($productoDestacado['Imagen'])?>" alt="<?=$productoDestacado['Nombre']?>">
                </div>
                <h1><?=$productoDestacado['Nombre']?></h1>
                <p>$ <?=$productoDestacado['Precio']?></p>
                <p>Stock <?=$productoDestacado['Stock']>0?'':'no'?> disponible</p>
                <a href="extensionProducto.php?idProducto=<?=$productoDestacado['idProducto']?>">Ver Mas</a>
            </div>
        <?php }?>
    </div>
    <div id="section3">
        <h1>Productos</h1>
        <div class="productoSection3">
            <?php while($productosRandom = $selectProductosRandom->fetch(PDO::FETCH_ASSOC)) {?>
                <div class="articulos2">
                    <div class="divImg2">
                        <img src="data:image/png;base64,<?=base64_encode($productosRandom['Imagen'])?>" alt="<?=$productosRandom['Nombre']?>">
                    </div>
                    <h1><?=$productosRandom['Nombre']?></h1>
                    <p>$ <?=$productosRandom['Precio']?></p>
                    <p>Stock <?=$productosRandom['Stock']>0?'':'no'?> disponible</p>
                    <a href="extensionProducto.php?idProducto=<?=$productosRandom['idProducto']?>">Ver Mas</a>
                </div>
                <?php }?>
        </div>
    </div>
</main>    
<?php include_once 'Assets/footer.php';?>
<link rel="stylesheet" href="Style/indexStyle.css">