<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    if (isset($data)) {
        $datosPorPagina = $data->datosPorPagina;
        $paginaActual= $data->paginaActual;
        $sql=$pdo->prepare('SELECT * FROM categorias ORDER BY Categoria LIMIT :paginaActual, :datosPorPagina');
        $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
        $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
        $sql->execute();
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[]= array(
                'idCategoria' => $fila['idCategoria'],
                'Categoria' => $fila['Categoria']
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }else{
        $sql=$pdo->prepare('SELECT * FROM categorias ORDER BY Categoria');
        $sql->execute();
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[]= array(
                'idCategoria' => $fila['idCategoria'],
                'Categoria' => $fila['Categoria']
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }

?>