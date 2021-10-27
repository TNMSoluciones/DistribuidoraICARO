<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $data=json_decode(file_get_contents("php://input"));
    if (isset($data)) {
        $texto = $data->texto;
        $datosPorPagina = $data->datosPorPagina;
        $paginaActual= $data->paginaActual;
        $sql=$pdo->prepare("SELECT cliente.NombreEmpresa, pedido.Fecha, pedido.idPedido, pedido.PrecioTotal, pedido.MetodoPago FROM pedido JOIN cliente ON pedido.idCliente=cliente.idCliente WHERE cliente.NombreEmpresa LIKE '%".$texto."%' OR cliente.NombreEmpresa IS NULL ORDER BY cliente.NombreEmpresa  LIMIT :paginaActual, :datosPorPagina");
        $sql->bindValue(':paginaActual', $paginaActual, PDO::PARAM_INT);
        $sql->bindValue(':datosPorPagina',$datosPorPagina, PDO::PARAM_INT);
        $sql->execute();
        $sqlCantidad=$pdo->query("SELECT COUNT(idPedido) AS cantidad FROM pedido JOIN cliente ON cliente.idCliente = pedido.idCliente WHERE NombreEmpresa LIKE '%".$texto."%'")->fetch(PDO::FETCH_ASSOC);
        $json = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
            $json[] = array(
                'nombre' => $fila['NombreEmpresa']!=null?$fila['NombreEmpresa']:'Cliente Eliminado',
                'idPedido' => $fila['idPedido'],
                'fecha' => $fila['Fecha'],
                'precio' => $fila['PrecioTotal'],
                'metodo' => $fila['MetodoPago'],
                'cantidad' => isset($sqlCantidad['cantidad'])?$sqlCantidad['cantidad']:0
            );
        }
        $jsonString = json_encode($json);
        echo $jsonString;
    }
?>