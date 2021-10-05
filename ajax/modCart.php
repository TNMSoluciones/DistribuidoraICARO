<?php
    session_start();
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (isset($data)) {
        $idProducto = $data->idProducto;
        $cantidad = $data->cantidad;
        $sql=$pdo->prepare("SELECT COUNT(idProducto) AS cantidad FROM producto WHERE idProducto = ? AND Stock >= ?");
        $sql->execute([$idProducto, $cantidad]);
        $sql = $sql->fetch(PDO::FETCH_ASSOC);
        if ($sql['cantidad']==1) {
            if (!isset($_SESSION['carrito'])) {
                $producto = array(
                    'idProducto' => $idProducto,
                    'Cantidad' => $cantidad
                );
                $_SESSION['carrito'][0]=$producto;
                echo 1;
            }else {
                $clave = array_search($idProducto, array_column($_SESSION['carrito'], 'idProducto'));
                if ($clave!='') {
                    $_SESSION['carrito'][$clave]['Cantidad']+=$cantidad;
                    echo 2;
                }else {
                    $producto = array(
                        'idProducto' => $idProducto,
                        'Cantidad' => $cantidad
                    );
                    $_SESSION['carrito'][count($_SESSION['carrito'])]=$producto;
                    echo 1;
                }
            }
        }else{echo 3;}
    }else if (isset($_GET)) {
        if(isset($_GET['remove']) && $_GET['remove'] && isset($_GET['idProducto']) && $_GET['idProducto']>=0) {
            $idProducto = $_GET['idProducto'];
            $clave = array_search($idProducto, array_column($_SESSION['carrito'], 'idProducto'));
            if ($clave!='') {
                unset($_SESSION['carrito'][$clave]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']);
            }
        }
        header("Location: ../carrito.php");
    }
?>