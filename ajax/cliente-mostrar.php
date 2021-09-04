<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    if (isset($data)) {
        $datosPorPagina = $data->datosPorPagina;
        $paginaActual= $data->paginaActual;
        $sql=$pdo->prepare('SELECT cliente.*, ciudad.Nombre as Ciudad, departamento.Nombre as Departamento FROM cliente JOIN ciudad ON cliente.idCiudad=ciudad.idCiudad JOIN departamento ON ciudad.idDepartamento=departamento.idDepartamento ORDER BY NombreEmpresa LIMIT :paginaActual, :datosPorPagina');
        $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
        $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
        $sql->execute();
        $json = array();
        while($fila = $sql->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'idCliente' => $fila['idCliente'],
                'nombreEmpresa' => $fila['NombreEmpresa'],
                'correoEmpresa' => $fila['CorreoCliente'],
                'rut' => $fila['RUT'],
                'activo' => $fila['Activo'],
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }
?>