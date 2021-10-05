<?php
    $data=json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if(isset($data->delete) && $data->delete) {
        $idSugerencia = $data->idSugerencia;
        $sqlDelete=$pdo->prepare("DELETE FROM opiniones WHERE idOpinion=?");
        $sqlDelete->execute([$idSugerencia]);
        echo $sqlDelete?true:false;
    }