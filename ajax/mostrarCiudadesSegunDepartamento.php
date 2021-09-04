<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    $idDepartamento = $data->departamentoActual;
    $sql=$pdo->prepare('SELECT * FROM ciudad WHERE idDepartamento=:idDepartamento ORDER BY Nombre');
    $sql->bindValue(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
    $sql->execute();
    $json = array();
    while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
        $json[]= array(
            'idCiudad' => $fila['idCiudad'],
            'Nombre' => $fila['Nombre']
        );
    }
    $jsonString = json_encode($json);
    echo $jsonString;
?>