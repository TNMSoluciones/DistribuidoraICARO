<?php
    $data=json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $texto = $data->texto;
    $datosPorPagina = $data->datosPorPagina;
    $paginaActual= $data->paginaActual;
    $sql=$pdo->prepare("SELECT * FROM opiniones WHERE nombreOpinion LIKE '%".$texto."%' ORDER BY nombreOpinion LIMIT :paginaActual, :datosPorPagina");
    $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
    $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
    $sql->execute();
    $sqlCantidad=$pdo->query("SELECT COUNT(idOpinion) as cantidad FROM opiniones WHERE nombreOpinion LIKE '%".$texto."%'")->fetch(PDO::FETCH_ASSOC);
    $json = array();
    while($fila = $sql->fetch(PDO::FETCH_ASSOC)){
        $json[] = array(
            'idOpinion' => $fila['idOpinion'],
            'nombreOpinion' => $fila['nombreOpinion'],
            'correoOpinion' => $fila['correoOpinion'],
            'fecha' => $fila['fecha'],
            'cantidad' => $sqlCantidad['cantidad']
        );
    }
    $jsonString = json_encode($json);
    echo $jsonString;
?>