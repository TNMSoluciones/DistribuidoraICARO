<?php
    session_start();
    $metodoPago = file_get_contents("php://input");
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (isset($_SESSION['user'])) {
        if ($metodoPago==="POS"||$metodoPago==="Efectivo") {
            $precioTotal = 0;
            $bandera=false;
            $idCliente = $_SESSION['user']['idUsuario'];
            foreach($_SESSION['carrito'] as $producto) {
                $sqlPrecio = $pdo->prepare("SELECT Precio, Stock FROM producto WHERE idProducto=?");
                $sqlPrecio->execute([$producto['idProducto']]);
                $sqlPrecio = $sqlPrecio->fetch(PDO::FETCH_ASSOC);
                $sqlPrecio['Stock']<$producto['Cantidad']?$bandera=true:"";
                $precioTotal = $precioTotal+($producto['Cantidad']*$sqlPrecio['Precio']);
            }
            if (!$bandera) {
                $sqlInsertPedido = $pdo->prepare("INSERT INTO pedido(MetodoPago, PrecioTotal, Fecha, idCliente) VALUES(?,?,CURRENT_DATE,?)");
                $sqlInsertPedido->execute([$metodoPago, $precioTotal, $idCliente]);
                $ultimaID=$pdo->lastInsertId(); 
                $sqlInsertItems=$pdo->prepare("INSERT INTO items(idPedido,idProducto,Cantidad,PrecioUnidad) VALUES(?,?,?,?)");
                $sqlRestarStock=$pdo->prepare("UPDATE producto SET Stock=Stock-? WHERE idProducto = ?");
                foreach($_SESSION['carrito'] as $producto) {
                    $sqlPrecio=$pdo->prepare("SELECT Precio FROM producto WHERE idProducto=?");
                    $sqlPrecio->execute([$producto['idProducto']]);
                    $sqlPrecio = $sqlPrecio->fetch(PDO::FETCH_ASSOC);
                    $sqlRestarStock->execute([$producto['Cantidad'], $producto['idProducto']]);
                    $sqlInsertItems->execute([$ultimaID, $producto['idProducto'], $producto['Cantidad'], $sqlPrecio['Precio']]);
                }
                $_SESSION['carrito']=NULL;
                echo 1;
            }else {
                echo 2;
            }
        }else {
            echo 3;
        }
    }else {
        echo 4;
    }
?>