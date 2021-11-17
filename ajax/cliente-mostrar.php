<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    if (isset($data)) {
        $texto = $data->texto;
        $datosPorPagina = $data->datosPorPagina;
        $paginaActual= $data->paginaActual;
        $sql=$pdo->prepare("SELECT cliente.*, ciudad.Nombre as Ciudad, departamento.Nombre as Departamento FROM cliente JOIN ciudad ON cliente.idCiudad=ciudad.idCiudad JOIN departamento ON ciudad.idDepartamento=departamento.idDepartamento WHERE cliente.NombreEmpresa LIKE '%".$texto."%' ORDER BY NombreEmpresa LIMIT :paginaActual, :datosPorPagina");
        $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
        $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
        $sql->execute();
        $sqlCantidad=$pdo->query("SELECT COUNT(RUT) AS cantidad FROM cliente WHERE NombreEmpresa LIKE '%".$texto."%'")->fetch(PDO::FETCH_ASSOC);
        $json = array();
        while($fila = $sql->fetch(PDO::FETCH_ASSOC)){
            $json[] = array(
                'idCliente' => $fila['RUT'],
                'nombreEmpresa' => $fila['NombreEmpresa'],
                'correoEmpresa' => $fila['CorreoCliente'],
                'activo' => $fila['Activo'],
                'cantidad' => $sqlCantidad['cantidad']
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }
?>