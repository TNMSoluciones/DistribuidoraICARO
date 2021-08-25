<?php
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (!isset($data->delete)) {
        if(!$data->insert){
            $idRol = $data->idRol;
            $nameRol = !empty($data->rol)? $data->rol : '';
            $sql=$pdo->prepare('UPDATE roles SET idRol=?, Rol=? WHERE idRol=?');
            $sql->execute([$idRol, $nameRol, $idRol]);
            $res = $sql==true ? true : false;
            echo $res;
        }else{
            $nameRol = !empty($data->rol)? $data->rol : '';
            $sqlInsert=$pdo->prepare("INSERT INTO roles(Rol) VALUES('$nameRol')");
            $sqlInsert->execute();
            $resInsert = $sqlInsert ? true : false;
            echo $resInsert;
        }
    }else{
        $idRol = $data->idRol;
        $sqlDelete=$pdo->prepare("DELETE FROM roles WHERE idRol=?");
        $sqlDelete->execute([$idRol]);
        $resDelete = $sqlDelete ? true : false;
        echo $resDelete;
    }
?>