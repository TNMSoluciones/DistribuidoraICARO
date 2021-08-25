<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $sql=$pdo->prepare('SELECT * FROM roles ORDER BY Rol');
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
?>