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
        $vendidoMesActual = $pdo->query("SELECT COUNT(idPedido) as cantidad FROM pedido WHERE Confirmacion=1")->fetch(PDO::FETCH_ASSOC);        
    ?>
        <main>
            
            <div id="ganadoM">
                <?php if (isset($ganadoMesActual['mes'])) {
                    $mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][$ganadoMesActual['mes'] - 1];
                ?>
                <h1>Ganado en el mes de <?=$mes?></h1>
                <h1>$ <?=$ganadoMesActual['total']?></h1>
                <select name="" id=""><option value="">Meses del año</option></select>
            
                <?php }else {?>
                <h1>No ha vendido nada este mes</h1>
                <?php }?>
            </div>
            <div id="ganadoY">
            <?php if (isset($ganadoYearActual['total'])) {?>
                <h1>Ganado en el año de <?=date('Y')?></h1>
                <h1>$ <?=$ganadoYearActual['total']?></h1>
                <select name="" id=""><option value="">Últimos cinco años</option></select>
                            
                <?php }else {?>
                <h1>No ha vendido nada este año</h1>
                <?php }?>
            </div>
            <div id="pedidoM">
                <?php if (isset($vendidoMesActual['cantidad'])) {
                    ?>
                    <h1>Total de pedidos Vendidos en <?date('m')?></h1>
                    <?php
                } 

                ?>
            </div>
            <div id="divGraficaPorMes">
                <canvas id="myChart" style="width:100%;"></canvas>
            </div>
            <div id="productosMenorStock">
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