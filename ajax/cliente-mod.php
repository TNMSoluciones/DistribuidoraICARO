<?php
    $data=json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (isset($data)) {
        if (!$data->delete) {
            //Actualizar
            $idCliente = $data->idCliente;
            $activo = $data->activo? 1 : 0;
            $sql=$pdo->prepare('UPDATE cliente SET Activo=? WHERE idCliente=?');
            $sql->execute([$activo, $idCliente]);
            echo $sql ? true : false;
        }else if($data->delete){
            $idCliente = $data->idCliente;
            $sqlDelete = $pdo->prepare('DELETE FROM cliente WHERE idCliente=?');
            $sqlDelete->execute([$idCliente]);
            echo $sqlDelete ? true : false;
        }
    }
?>