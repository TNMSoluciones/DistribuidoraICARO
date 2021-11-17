<?php
    session_start();
    if (isset($_SESSION['user']['idRol'])) {
        define('PAG_LIMIT', 20);
        $pagActual = isset($_GET['pag']) && $_GET['pag'] > 0 ? $_GET['pag'] : 1; 
        include_once 'BD/conBD.php';
        include_once 'Assets/header.php';
        mostrarHeader('Todos los pedidos');
        $pdo=pdo_conectar_mysql();
        $allPedidos = $pdo->prepare('SELECT * FROM pedido LIMIT :paginaActual, :datosPorPagina');
        $allPedidos->bindValue(':paginaActual', (($pagActual - 1)*PAG_LIMIT), PDO::PARAM_INT);
        $allPedidos->bindValue(':datosPorPagina', PAG_LIMIT, PDO::PARAM_INT);
        $allPedidos->execute();
        $allPedidos=$allPedidos->fetchAll(PDO::FETCH_ASSOC);
        $cantidadPedidos = $pdo->query('SELECT COUNT(idPedido) as cantidad FROM pedido')->fetch(PDO::FETCH_ASSOC);
        echo "<main>";
        ?>
        <div id="contenedor" class="divPrincipal">
            <div>
                <a onclick="javascript: history.go(-1)" class="btnDerecha">Volver</a>
                <h1>Pedidos</h1>
            </div>
            <div class="titulosTabla">
                <div>
                    <h3>ID Pedido</h3>
                    <h3>Fecha</h3>
                    <h3>Precio total</h3>
                    <h3>Método de pago</h3>
                    <h3 class="txtDerecha">Funciones</h3>
                </div>
            </div>
            <style>
                #contenedor .titulosTabla h3:nth-child(4){
                    display: none;
                }
                #contenedor .btnDerecha:nth-child(1){
                    position: absolute;
                    right: 0;
                    margin-top: 0;
                    top: 50%;
                    transform: translateY(-50%);        
                }
            </style>
            <div>
                <?php
                foreach($allPedidos as $pedido) {
                    ?>
                    <div class="comprasEncargado">
                        <div>
                            <h3><?=$pedido['idPedido']?></h3>
                            <h3><?=$pedido['Fecha']?></h3>
                            <h3><?=$pedido['PrecioTotal']?></h3>
                            <h3><?=$pedido['MetodoPago']?></h3>
                            <a class="btnDerecha btnEliminarVentas" href="modificarPedido.php?idPedido=<?=$pedido['idPedido']?>&delete=true&nuls=true">Eliminar</a>
                            <a class="btnDerecha btnEliminarVentas" href="modificarPedido.php?idPedido=<?=$pedido['idPedido']?>&nuls=true">Modificar</a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <div class="pagination">
            <?php 
                if ($pagActual>1) {
                    $pagNueva = $pagActual-1;
                    echo "<li style='display: inline;'><a href='listaPedidosCompleta.php?pag=$pagNueva'><p id='btnPagVentasI'>❮</p></a></li>";
                }
                $pagNuevaSum = $pagActual+1;
                if (ceil($cantidadPedidos['cantidad']/PAG_LIMIT)>$pagActual) {
                    echo "<li style='display: inline;'><a href='listaPedidosCompleta.php?pag=$pagNuevaSum'><p id='btnPagVentasD'>❯</p></a></li>";
                }
            ?>    
                
            </div>
        </div>
        <?php
    }else {
        header("Location: index.php");
    }
    echo '</main>';
    include_once 'Assets/footer.php';
?>
<link rel="stylesheet" href="Style/pagEmpleadosStyle.css">