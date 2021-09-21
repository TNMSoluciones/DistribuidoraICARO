<?php
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    $pdo=pdo_conectar_mysql();
    //$idProductoSeleccionado = isset($_GET['idProducto']) && $_GET['idProducto']>0?$_GET
    isset($_GET['idProducto']) && $_GET['idProducto']>0?$idProductoSeleccionado=$_GET['idProducto']:header('Location: index.php');
    $siExisteProducto = $pdo->query("SELECT COUNT(idProducto), Nombre FROM producto WHERE idProducto='$idProductoSeleccionado'")->fetch(PDO::FETCH_ASSOC);
    if ($siExisteProducto)
    {
        mostrarHeader('Comprar '.$siExisteProducto['Nombre']);
        ?>

        <?php
    }else{header('Location: index.php');}
    include_once 'Assets/footer.php';
?>