<?php
    session_start();
    include_once 'BD/conBD.php';
    define('DATOSPORPAGINA', 12);
    include_once 'Assets/header.php';
    mostrarHeader('Productos');
    $pdo=pdo_conectar_mysql();
    $paginaActual= isset($_GET['paginaActual'])&&$_GET['paginaActual']>0?$_GET['paginaActual']:1;
    
    if (isset($_GET['query_search']) && $_GET['query_search']!='') {
        $sql=$pdo->prepare("SELECT producto.idProducto, producto.Nombre, producto.Stock, producto.Precio, producto.Imagen, producto.Destacado, categorias.Categoria FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria WHERE producto.Nombre LIKE '%".$_GET['query_search']."%' ORDER BY Nombre LIMIT :paginaActual, :datosPorPagina");
        $sqlCantidad = $pdo->query("SELECT COUNT(idProducto) AS cantidad FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria WHERE producto.Nombre LIKE '%".$_GET['query_search']."%'")->fetch(PDO::FETCH_ASSOC);
    }else if(isset($_GET['query_cat']) && $_GET['query_cat']!=''){
        $sql=$pdo->prepare("SELECT producto.idProducto, producto.Nombre, producto.Stock, producto.Precio, producto.Imagen, producto.Destacado, categorias.Categoria FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria WHERE producto.idCategoria LIKE '".$_GET['query_cat']."' ORDER BY Nombre LIMIT :paginaActual, :datosPorPagina");
        $sqlCantidad = $pdo->query("SELECT COUNT(idProducto) AS cantidad FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria WHERE producto.idCategoria LIKE '".$_GET['query_cat']."'")->fetch(PDO::FETCH_ASSOC);
    }else{
        $sql=$pdo->prepare("SELECT producto.idProducto, producto.Nombre, producto.Stock, producto.Precio, producto.Imagen, producto.Destacado, categorias.Categoria FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria ORDER BY Nombre LIMIT :paginaActual, :datosPorPagina");
        $sqlCantidad = $pdo->query("SELECT COUNT(idProducto) AS cantidad FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria")->fetch(PDO::FETCH_ASSOC);
    }
    $sql->bindValue(':paginaActual',($paginaActual-1)*DATOSPORPAGINA, PDO::PARAM_INT);
    $sql->bindValue(':datosPorPagina', DATOSPORPAGINA, PDO::PARAM_INT);
    $sql->execute();
?>
<main>
    <div id="section1">
        <?php
        if ($sql->rowCount()>0) {
            while($producto = $sql->fetch(PDO::FETCH_ASSOC)){
                ?>
                <div class="articulos1" id="<?=$producto['idProducto']?>">
                    <div class="imgDiv">
                        <img class="images" src="data:image/png;base64,<?=base64_encode($producto['Imagen'])?>">
                    </div>
                    <h1><?=$producto['Nombre']?></h1>
                    <p>$<?=$producto['Precio']?></p>
                    <p><?=$producto['Stock']>0?'Stock disponible':'Stock no disponible'?></p>
                    <a href="extensionProducto.php?idProducto=<?=$producto['idProducto']?>">Ver Mas</a>
                </div>
                <?php
            }
            }else{echo '<h1 class="title">No hay articulos que coincidan con su busqueda</h1>';}
    ?>
    
</div>
<?php 
if ($sqlCantidad['cantidad']>DATOSPORPAGINA) {
    $paginaMas=$paginaActual+1;
    $paginaMenos=$paginaActual-1;
    ?>
    <div class="pagination">
        <?php
        echo $paginaActual>1?"<a href='productos.php?paginaActual=$paginaMenos'>&laquo;</a>":'';
        $num = ceil($paginaActual/6);
        $nummax = ceil($sqlCantidad['cantidad']/DATOSPORPAGINA);
        for ($i=($num*6-6)+1; $i<=$num*6 ;$i++) { 
            $class = $i==$paginaActual?'class="active"':'';
            if($i>$nummax) break;
            echo "<a $class href='productos.php?paginaActual=$i'>$i</a>";
        }
        echo $paginaActual<ceil($sqlCantidad['cantidad']/DATOSPORPAGINA)?"<a href='productos.php?paginaActual=$paginaMas'>&raquo;</a>":'';
        echo '</div>';
    }
?>
</main>
<?php include_once 'Assets/footer.php'; ?>
</body>
<link rel="stylesheet" type="text/css" href="Style/pagProductosStyle.css">  
</html>