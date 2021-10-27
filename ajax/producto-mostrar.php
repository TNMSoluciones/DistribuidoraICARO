<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    if (isset($data)) {
        $texto = $data->texto;
        $datosPorPagina = $data->datosPorPagina;
        $paginaActual= $data->paginaActual;
        $sql=$pdo->prepare("SELECT producto.*, categorias.Categoria FROM producto JOIN categorias ON categorias.idCategoria=producto.idCategoria WHERE producto.Nombre LIKE '%".$texto."%' ORDER BY Nombre LIMIT :paginaActual, :datosPorPagina");
        $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
        $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
        $sql->execute();
        $sqlCantidad=$pdo->query("SELECT COUNT(idProducto) AS cantidad FROM producto WHERE Nombre LIKE '%".$texto."%'")->fetch(PDO::FETCH_ASSOC);
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[] = array(
                'idProducto' => $fila['idProducto'],
                'nombre' => $fila['Nombre'],
                'precio' => $fila['Precio'],
                'Categoria' => $fila['Categoria'],
                'stock' => $fila['Stock'],
                'cantidad' => isset($sqlCantidad['cantidad'])?$sqlCantidad['cantidad']:0
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }
?>