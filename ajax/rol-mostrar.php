<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    if (isset($data)) {
        $datosPorPagina = $data->datosPorPagina;
        $paginaActual= $data->paginaActual;
        $sql=$pdo->prepare('SELECT * FROM roles ORDER BY Rol LIMIT :paginaActual, :datosPorPagina');
        $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
        $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
        $sql->execute();
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[]= array(
                'idRol' => $fila['idRol'],
                'Rol' => $fila['Rol']
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }else{
        $sql=$pdo->prepare('SELECT * FROM roles');
        $sql->execute();
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[]= array(
                'idRol' => $fila['idRol'],
                'Rol' => $fila['Rol']
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }
?>