<?php
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    $pdo=pdo_conectar_mysql();
    if(isset($_SESSION['user']['rol'])) {
        mostrarHeader('Estadisticas');
        $ganadoMesActual = $pdo->query("SELECT MONTH(pedido.Fecha) AS mes, SUM(pedido.PrecioTotal) AS total FROM pedido WHERE YEAR(pedido.Fecha) = YEAR(curdate()) AND MONTH(pedido.Fecha) = MONTH(curdate())")->fetch(PDO::FETCH_ASSOC);
        $ganadoYearActual = $pdo->query("SELECT SUM(pedido.PrecioTotal) AS total FROM pedido WHERE YEAR(pedido.Fecha) = YEAR(curdate())")->fetch(PDO::FETCH_ASSOC);
        $menosProductosStock = $pdo->query("SELECT producto.Nombre AS Nombre, producto.Stock AS Stock FROM producto ORDER BY producto.Stock limit 5"); 
        $vendidoMesActual = $pdo->query("SELECT MONTH(Fecha) as mes, COUNT(idPedido) as cantidad FROM pedido WHERE Confirmacion=1 AND MONTH(Fecha) = MONTH(curdate())")->fetch(PDO::FETCH_ASSOC);        
        $productosMasFacturados = $pdo->query("SELECT producto.Nombre AS Nombre, SUM(items.Cantidad) as Cantidad FROM producto JOIN items ON items.idProducto = producto.idProducto GROUP BY producto.Nombre ORDER BY SUM(items.Cantidad) DESC LIMIT 5;");
        
        $mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][date('m')-1];
    ?>
        <main>
            
            <div id="ganadoM" class="dashboard">
                <?php if (isset($ganadoMesActual['mes'])) {
                ?>
                <h1>Facturado en el mes de <?=$mes?></h1>
                <h1>$ <?=$ganadoMesActual['total']?></h1>
                <?php }else {?>
                <h1>No ha facturado nada este mes</h1>
                <?php }?>
            </div>
            <div id="ganadoY" class="dashboard">
            <?php if (isset($ganadoYearActual['total'])) {?>
                <h1>Facturado en el año de <?=date('Y')?></h1>
                <h1>$ <?=$ganadoYearActual['total']?></h1>
                            
                <?php }else {?>
                <h1>No ha vendido nada este año</h1>
                <?php }?>
            </div>
            <div id="pedidoM" class="dashboard">
                <?php if (isset($vendidoMesActual['mes'])) {
                    ?>
                    <h1>Total de pedidos facturados en <?=$mes?></h1>
                    <h1><?=$vendidoMesActual['cantidad']?></h1>
                <?php }else {?>
                    <h1>No ha facturado nada este mes</h1>
                <?php }?>
            </div>
            <div id="divGraficaPorMes">
                <canvas id="myChart" style="width:100%;"></canvas>
            </div>
            <div id="productosMenorStock" class="dashboard doble">
                <h1>Menor stock</h1>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </tr>
                <?php
                    while($fila = $menosProductosStock->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?=$fila['Nombre']?></td>
                        <td><?=$fila['Stock']?></td>
                    </tr>
                <?php
                    }
                ?>
            </table>
            </div>

            <div id="productosMasFacturados" class="dashboard">
                <h1>Más facturados</h1>
                <table>
                    <tr>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                    </tr>
                <?php
                    while($fila = $productosMasFacturados->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?=$fila['Nombre']?></td>
                        <td><?=$fila['Cantidad']?></td>
                    </tr>
                <?php
                    }
                ?>
            </table>
            </div>
            </table>
            </div>
        </main>
        <?php
    }else {
        header('Location: index.php');
    }
    include_once 'Assets/footer.php';
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="JavaScript/dashboard.js" defer></script>
<link rel="stylesheet" href="Style/dashboard.css">