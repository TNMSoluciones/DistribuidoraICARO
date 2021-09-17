<?php
    session_start();
    define('DATOSPORPAGINA', 12);
    include_once 'Assets/header.php';
    include_once 'BD/conBD.php';
    mostrarHeader('Productos');
    $pdo=pdo_conectar_mysql();
    $paginaActual= isset($_GET['paginaActual'])?$_GET['paginaActual']:1;
    $paginaActual= ($paginaActual-1)*DATOSPORPAGINA;
    $sql=$pdo->prepare("SELECT producto.idProducto, producto.Nombre, producto.Stock, producto.Precio, producto.Imagen, producto.Destacado, categorias.Categoria FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria ORDER BY Nombre LIMIT :paginaActual, :datosPorPagina");
    $sql->bindValue(':paginaActual',$paginaActual, PDO::PARAM_INT);
    $sql->bindValue(':datosPorPagina', DATOSPORPAGINA, PDO::PARAM_INT);
    $sql->execute();
?>
<div id="popup">
    <img src="">
    <h1>Name product</h1>
    <h1>Precio</h1>
    <h1>Stock</h1>
    <p>Descripción:</p>
</div>
<main>

<div id="section1">
    <h1 id="title">Articulos</h1>

    <?php
    while($producto = $sql->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="articulos1" id="<?=$producto['idProducto']?>">
            <div class="imgDiv">
                <img class="images" src="<?=$producto['Imagen']?>">
            </div>
            <h1><?=$producto['Nombre']?></h1>
            <p>$<?=$producto['Precio']?></p>
            <p><?=$producto['Stock']>0?'Stock disponible':'Stock no disponible'?></p>
            <a href="extensionProducto.php?idProducto=<?=$producto['idProducto']?>">Ver Mas</a>
        </div>
        <?php
    }
?>
    
</div>
</main>
<?php include_once 'Assets/footer.php'; ?>
</body>
<link rel="stylesheet" type="text/css" href="Style/pagProductosStyle.css">
<script src="JavaScript/productos.js"></script>
</html>
