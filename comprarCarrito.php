<?php 
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Distribuidora ICARO');
    if (isset($_SESSION['user']) && !isset($_SESSION['user']['rol']) && isset($_SESSION['carrito'])) {
        $pdo = pdo_conectar_mysql();
        $sqlProductos = $pdo->prepare("SELECT * FROM producto WHERE idProducto=?");
        $precioTotal = 0;
?>
<main>
    <table>
        <thead>
            <td>Nombre</td>
            <td>Cantidad</td>
            <td>Precio Unitario</td>
            <td>Precio Total</td>
        </thead>
        <tbody>
            <?php foreach($_SESSION['carrito'] as $producto) {
                $sqlProductos->execute([$producto['idProducto']]);
                while ($infoProducto = $sqlProductos->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?=$infoProducto['Nombre']?></td>
                        <td><?=$producto['Cantidad']?></td>
                        <td>$ <?=$infoProducto['Precio']?></td>
                        <td>$ <?=$infoProducto['Precio']*$producto['Cantidad']?></td>
                    </tr>
                    <?php
                    $precioTotal=$precioTotal+($infoProducto['Precio']*$producto['Cantidad']);
                }
            }?>     
            <tr>
                <td></td>
                <td></td>
                <td>Monto Total:</td>
                <td>$ <?=$precioTotal?></td>
            </tr>   
        </tbody>
    </table>
    <input type="radio" id="radioBtnEfectivo" name="metodoPago" value="Efectivo">
    <label for="radioBtnEfectivo">Efectivo</label>
    <input type="radio" id="radioBtnPOS" name="metodoPago" value="POS">
    <label for="radioBtnPOS">POS</label>
    <input type="button" id="btnComprar" value="Confirmar Compra" style="display: block;">
    <?php }else{?><script>history.go(-1)</script><?php }?>
</main>
<?php include_once 'Assets/footer.php';?>
<script src="JavaScript/comprarCarrito.js"></script>