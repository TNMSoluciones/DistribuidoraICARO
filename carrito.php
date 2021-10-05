<?php 
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Distribuidora ICARO');
    $pdo = pdo_conectar_mysql();
    $selectProductos = $pdo->prepare('SELECT idProducto, Nombre, Precio FROM producto WHERE idProducto=?');
    ?>    
<table id="table">
    <tr>
        <th>Nombre</th>
        <th>Cantidad</th>
        <th>Precio C/U</th>
        <th>Precio Total</th>
        <th></th>
        <th></th>
    </tr>
    <?php
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $key) {
                $selectProductos->execute([$key['idProducto']]);
                $datosProducto = $selectProductos->fetch(PDO::FETCH_ASSOC);
                ?>
                <tr>
                    <td><?=$datosProducto['Nombre']?></td>
                    <td><?=$key['Cantidad']?></td>
                    <td>$ <?=$datosProducto['Precio']?></td>
                    <td>$ <?=$datosProducto['Precio']*$key['Cantidad']?></td>
                    <td class="btnEliminar" id="<?=$datosProducto['idProducto']?>"></td>
                    <td></td>
                </tr>
                <?php
            }
        }else{
            ?>
            <script>console.log("Nada en el carrito")</script>
            <?php
        }
    ?>
</table>
<?php include_once 'Assets/footer.php';?>
</body>
<style>
    .btnEliminar{
        width: 22px;
        height: 22px;
        display: inline-block;
        background: url('svg/trash.svg');
        background-repeat: no-repeat;
        background-size: contain;
        cursor: pointer;
    }

    th {
        width: 150px;
        text-align: left;
    }
</style>
<script defer>
    document.getElementById('table').addEventListener('click', e => {
        if (e.target.classList[0]=='btnEliminar') {
            let idProducto = e.target.id;
            location.href = `ajax/modCart.php?remove=true&idProducto=${idProducto}`;
        }
    })
</script>
</html>