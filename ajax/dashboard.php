<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data = json_decode(file_get_contents("php://input"));
    if ($data->tipo == 'dataPorMes') {
        $sqlPorMes=$pdo->query("SELECT MONTH(pedido.Fecha) AS mes, SUM(pedido.PrecioTotal) AS precio FROM pedido WHERE YEAR(pedido.Fecha) = YEAR(curdate()) GROUP BY MONTH(pedido.Fecha)");
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