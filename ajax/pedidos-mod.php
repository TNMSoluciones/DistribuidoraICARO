<?php
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (isset($data)) {
        if (isset($data->delete) && $data->delete) {
            $idPedido = $data->idPedido;
            $sqlDelete=$pdo->prepare("DELETE FROM pedido WHERE idPedido=?");
            $sqlDelete->execute([$idPedido]);
            echo $resDelete;
        }
        if (isset($data->delete) && !$data->delete) {
            $idPedido = $data->idPedido;
            $activo = $data->activo? 1 : 0;
            $sql=$pdo->prepare('UPDATE pedido SET Confirmacion=? WHERE idPedido=?');
            $sql->execute([$activo, $idPedido]);
            echo $sql ? true : false;
        }
    }else {
        header("Location: index.php");
    }