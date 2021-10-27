<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    $idDepartamento = $data->departamentoActual;
    if (!isset($data->ciudadInicial)) {
        $sql=$pdo->prepare('SELECT * FROM ciudad WHERE idDepartamento=:idDepartamento ORDER BY Nombre');
        $sql->bindValue(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
        $sql->execute();
    }else if(isset($data->ciudadInicial)) {
        $idCiudad = $data->ciudadInicial;
        $sql=$pdo->prepare('SELECT * FROM ciudad WHERE idDepartamento=:idDepartamento AND idCiudad!=:idCiudad ORDER BY Nombre');
        $sql->bindValue(':idDepartamento', $idDepartamento, PDO::PARAM_INT);
        $sql->bindValue(':idCiudad', $idCiudad, PDO::PARAM_INT);
        $sql->execute();
    }
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