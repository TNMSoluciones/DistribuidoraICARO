<?php
    session_start();
    $metodoPago = file_get_contents("php://input");
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if ($metodoPago==="POS"||$metodoPago==="Efectivo") {
        $precioTotal = 0;
        $idCliente = $_SESSION['user']['idUsuario'];
        foreach($_SESSION['carrito'] as $producto) {
            $sqlPrecio=$pdo->query("SELECT Precio FROM producto WHERE idProducto=".$producto['idProducto'])->fetch(PDO::FETCH_ASSOC);
            $precioTotal = $precioTotal+($producto['Cantidad']*$sqlPrecio['Precio']);
        }
        $sqlInsertPedido = $pdo->prepare("INSERT INTO pedido(MetodoPago, PrecioTotal, Fecha, idCliente) VALUES(?,?,CURRENT_DATE,?)");
        $sqlInsertPedido->execute([$metodoPago, $precioTotal, $idCliente]);
        $ultimaID=$pdo->lastInsertId();
        $sqlInsertItems=$pdo->prepare("INSERT INTO items(idPedido,idProducto,Cantidad,PrecioUnidad) VALUES(?,?,?,?)");
        foreach($_SESSION['carrito'] as $producto) {
            $sqlPrecio=$pdo->query("SELECT Precio FROM producto WHERE idProducto=".$producto['idProducto'])->fetch(PDO::FETCH_ASSOC);
            $sqlInsertItems->execute([$ultimaID, $producto['idProducto'], $producto['Cantidad'], $sqlPrecio['Precio']]);
        }
        $_SESSION['carrito']=NULL;
        echo 1;
    }else{
        echo 2;
    }