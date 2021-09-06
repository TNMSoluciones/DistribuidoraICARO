<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    if (isset($data)) {
        $datosPorPagina = $data->datosPorPagina;
        $paginaActual= $data->paginaActual;
        $sql=$pdo->prepare('SELECT producto.*, categorias.Categoria FROM producto JOIN categorias ON categorias.idCategoria=producto.idCategoria ORDER BY Nombre LIMIT :paginaActual, :datosPorPagina');
        $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
        $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
        $sql->execute();
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[]= array(
                'idProducto' => $fila['idProducto'],
                'nombre' => $fila['Nombre'],
                'precio' => $fila['Precio'],
                'Categoria' => $fila['Categoria'],
                'stock' => $fila['Stock'],
                'urlImagen' => $fila['Imagen']
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }else{
        $sql=$pdo->prepare('SELECT * FROM producto');
        $sql->execute();
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[]= array(
                'idProducto' => $fila['idProducto'],
                'nombre' => $fila['Nombre'],
                'precio' => $fila['Precio'],
                'destacado' => $fila['Destacado']==1?true:false,
                'Categoria' => $fila['Categoria'],
                'stock' => $fila['Stock'],
                'urlImagen' => $fila['Imagen']
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }
?>