<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data = json_decode(file_get_contents("php://input"));
    if ($data['tipo'] == 'dataPorMes') {
        $sqlPorMes=$pdo->query("SELECT * FROM ganadoPorMes");
        print_r($sqlPorMes->fetch(PDO::FETCH_ASSOC));
        $jsonPorMes = array();
        while ($fila = $sqlPorMes->fetch(PDO::FETCH_ASSOC)) {
            $json[] = array(
                'x' => $fila['mes'],
                'y' => $fila['precio']
            );
        }
        echo json_encode($json);
    }
?>