<?php
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (!isset($data->delete)) {
        if(!$data->insert){
            $idCategoria = $data->idCategoria;
            $nameCategoria = !empty($data->categoria)? $data->categoria : '';
            $sql=$pdo->prepare('UPDATE categorias SET idCategoria=?, Categoria=? WHERE idCategoria=?');
            $sql->execute([$idCategoria, $nameCategoria, $idCategoria]);
            $res = $sql==true ? true : false;
            echo $res;
        }else{
            $nameCategoria = !empty($data->categoria)? $data->categoria : '';
            $sqlInsert=$pdo->prepare("INSERT INTO categorias(Categoria) VALUES('$nameCategoria')");
            $sqlInsert->execute();
            $resInsert = $sqlInsert ? true : false;
            echo $resInsert;
        }
    }else{
        $idCategoria = $data->idCategoria;
        $sqlDelete=$pdo->prepare("DELETE FROM categorias WHERE idCategoria=?");
        $sqlDelete->execute([$idCategoria]);
        $resDelete = $sqlDelete ? true : false;
        echo $resDelete;
    }
?>