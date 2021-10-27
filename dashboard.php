<?php
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    $pdo=pdo_conectar_mysql();
    if(isset($_SESSION['user']['rol'])) {
        mostrarHeader('Estadisticas');
        $ganadoMesActual = $pdo->query("SELECT * FROM ganadomesactual")->fetch(PDO::FETCH_ASSOC);
        $ganadoYearActual = $pdo->query("SELECT * FROM ganadoyearactual")->fetch(PDO::FETCH_ASSOC);
        $menosProductosStock = $pdo->query("SELECT * FROM menosproductosstock"); 
        $mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][$ganadoMesActual['mes'] - 1];
        ?>
        <main>
            
            <div id="ganadoM">
                <h1>Ganado en el mes de <?=$mes?></h1>
                <h1>$ <?=$ganadoMesActual['total']?></h1>
                <select name="" id=""><option value="">Meses del año</option></select>
            </div>
            <div id="ganadoY">
                <h1>Ganado en el año de <?=date('Y')?></h1>
                <h1>$ <?=$ganadoYearActual['total']?></h1>
                <select name="" id=""><option value="">Últimos cinco años</option></select>
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
            <div id="divGraficaPorMes">
                <canvas id="myChart" style="width:100%;"></canvas>
            </div>
            <div></div>
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