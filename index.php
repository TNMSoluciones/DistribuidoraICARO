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
    $selectProductosSlider = $pdo->prepare('SELECT idProducto, Imagen FROM producto ORDER BY RAND() LIMIT 8');
    $selectProductosSlider->execute();
    $selectProductosSlider=$selectProductosSlider->fetchAll(PDO::FETCH_ASSOC);
?>
<main>
    <div id="slidervista">
        <figure id="slidercontenido">
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[0]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[0]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[1]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[1]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[2]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[2]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[3]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[3]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[4]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[4]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[5]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[5]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[6]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[6]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[7]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[7]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[0]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[0]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[1]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[1]['Imagen'])?>">
            </a>
            <a class="divImgSlider" href="extensionProducto.php?idProducto=<?=$selectProductosSlider[2]['idProducto']?>">
                <img src="data:image/png;base64,<?=base64_encode($selectProductosSlider[2]['Imagen'])?>">>
            </a>
        </figure>
    </div>

    <div id="section1">
        <img src="img/1.jpg"><img src="img/2.jpg"><img src="img/3.jpg">
    </div>
    
    <div id="section2">
        <h1>Productos destacados</h1>
        <?php while($productoDestacado = $selectProductosDestacados->fetch(PDO::FETCH_ASSOC)) {?>
            <div class="articulos">   
                <a class="divImg" href="extensionProducto.php?idProducto=<?=$productoDestacado['idProducto']?>">
                    <img src="data:image/png;base64,<?=base64_encode($productoDestacado['Imagen'])?>" alt="<?=$productoDestacado['Nombre']?>">
                </a> 
                <h1><?=$productoDestacado['Nombre']?></h1>
                <p>$ <?=$productoDestacado['Precio']?></p>
                <p>Stock <?=$productoDestacado['Stock']>0?'':'no'?> disponíble</p>
                <a class="aExtension" href="extensionProducto.php?idProducto=<?=$productoDestacado['idProducto']?>">Ver más</a>
            </div>
        <?php }?>
    </div>
    <div id="section3">
        <h1>Productos</h1>
        <div class="productoSection3">
            <?php while($productosRandom = $selectProductosRandom->fetch(PDO::FETCH_ASSOC)) {?>
                <div class="articulos2">
                    <a href="extensionProducto.php?idProducto=<?=$productosRandom['idProducto']?>" class="divImg2">
                        <img src="data:image/png;base64,<?=base64_encode($productosRandom['Imagen'])?>" alt="<?=$productosRandom['Nombre']?>">
                    </a>
                    <h1><?=$productosRandom['Nombre']?></h1>
                    <p>$ <?=$productosRandom['Precio']?></p>
                    <p>Stock <?=$productosRandom['Stock']>0?'':'no'?> disponíble</p>
                    <a class="aExtension" href="extensionProducto.php?idProducto=<?=$productosRandom['idProducto']?>">Ver más</a>
                </div>
                <?php }?>
        </div>
    </div>
</main>    
<?php include_once 'Assets/footer.php';?>
<link rel="stylesheet" href="Style/indexStyle.css">