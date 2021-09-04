<?php
    session_start();
    $data=json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $datosPorPagina = $data->datosPorPagina;
    $paginaActual= $data->paginaActual;
    $sql=$pdo->prepare('SELECT personal.idPersonal, personal.PrimerNombre, personal.SegundoNombre, personal.Apellido, personal.Correo, roles.Rol FROM personal JOIN roles ON personal.idRol=roles.idRol ORDER BY PrimerNombre  LIMIT :paginaActual, :datosPorPagina');
    $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
    $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
    $sql->execute();
    $json = array();
    while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
        $json[]= array(
            'idPersonal' => $fila['idPersonal'],
            'fName' => $fila['PrimerNombre'],
            'sName' => $fila['SegundoNombre'],
            'lastName' => $fila['Apellido'],
            'email' => $fila['Correo'],
            'rolPersonal' => $fila['Rol']
        );
    }
    $jsonString = json_encode($json);
    echo $jsonString;
?>