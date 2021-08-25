<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
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
?>