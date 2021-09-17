<!DOCTYPE html>
<main>
<?php 
    session_start();
    if(isset($_SESSION['rol'])){
        include_once 'Assets/header.php';
        mostrarHeader('Empleados');
        include_once 'BD/conBD.php';
        $pdo=pdo_conectar_mysql();
        if ($_SESSION['idRol']==2 || $_SESSION['idRol']==1) {
            
?>
    <div id="encargado">
        <div>
            <h1>Encargado de Ventas</h1>
        </div>
        <!-- Este div se cambiara por un template -->
        <div class="comprasEncargado">
            <div>
                <img src="img/usuario.png" class="imgproducto" alt="fotoproducto">
                <h3>Nombre de la empresa</h3>
                <h3>Nombre del producto</h3>
                <input type="submit" value="Eliminar" class="btnDerecha">
                <h3 class="txtDerecha">CostoTotal</h3>
                <h3 class="txtDerecha">Cantidad</h3>
            </div>
        </div>  
        <!-- Este div acabara un template -->
    </div>

    <?php }
        if($_SESSION['idRol']==3 || $_SESSION['idRol']==1){
            $sqlCantidadProductos=$pdo->query('SELECT COUNT(idProducto) FROM producto')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadProductos=$sqlCantidadProductos['COUNT(idProducto)'];
    ?>
    <div id="productos">
        <div>
            <h1>Encargado de Productos</h1>
            <a href="modificarProductos.php?idProducto=0" class="btnDerecha">Agregar</a>
        </div>
        <!-- Este div se cambiara por un template -->
        <div>

        </div>
        <!-- Este div acabara un template --> 
        <div class="pagination">
            <li><p id="btnPagProductoI">❮</p></li>
            <li><p id="btnPagProductoD">❯</p></li>
        </div>
    </div>
    <template id="templateProductos">
        <div class="productosEncargado">
            <div>
                <div class="imgDiv">
                    <img src="" class="imgproducto" alt="fotoproducto">
                </div>
                <h3></h3>
                <h3></h3>
                <h3></h3>
                <h3></h3>
                <div class="aDiv">
                    <a class="btnDerecha btnProductos btnModificarProducto">Modificar</a>
                    <a class="btnDerecha btnProductos btnEliminarProducto">Eliminar</a>
                </div>
            </div>
        </div>  
    </template>

    <?php }
        if($_SESSION['idRol']==5 || $_SESSION['idRol']==1){
            $sqlCantidadCliente=$pdo->query('SELECT COUNT(idCliente) FROM cliente')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadCliente=$sqlCantidadCliente['COUNT(idCliente)'];
    ?>
    <div id="cliente">
        <div>
            <h1>Clientes</h1>
        </div>
        <div>
            <!-- Se utilizara el template correspondiente con los datos desde la BD -->
        </div>
        <div class="pagination">
            <li><p id="btnPagClienteI">❮</p></li>
            <li><p id="btnPagClienteD">❯</p></li>
        </div>
    </div>
    <template id="templateClientes">
        <div class="clientesEncargado">
            <div>
                <h3></h3>
                <h3></h3>
                <h3></h3>
                <a class="btnDerecha btnEliminarCliente">Eliminar</a>
                <a class="btnDerecha btnModificarCliente">Modificar</a>
                <h3 class="txtDerecha"></h3>
            </div>
        </div>
    </template>
    <?php }
        if($_SESSION['idRol']==1){
            $sqlCantidadPersonal=$pdo->query('SELECT COUNT(idPersonal) FROM personal')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadPersonal=$sqlCantidadPersonal['COUNT(idPersonal)'];
    ?>


    <div id="personal">
        <div>
            <h1>Empleados</h1>
            <a href="modificarEmpleados.php?idPersonal=0" class="btnDerecha">Agregar</a>
        </div>
        <div>
            <!-- Se utilizara el template correspondiente con los datos desde la BD -->
        </div>
        <div class="pagination">
            <li><p id="btnPagPersonalI">❮</p></li>
            <li><p id="btnPagPersonalD">❯</p></li>
        </div>
    </div>
    <template id="templatePersonal">
        <div class="empleados">
            <div>
                <h3></h3>
                <h3></h3>
                <a class="btnDerecha btnEliminarPersonal">Eliminar</a>
                <a class="btnDerecha btnModificarPersonal">Modificar</a>
                <h3 class="txtDerecha"></h3>
            </div>
        </div>  
    </template>

    <?php }
        if($_SESSION['idRol']==4 || $_SESSION['idRol']==1){
            $sqlCantidadCategorias=$pdo->query('SELECT COUNT(idCategoria) FROM categorias')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadCategorias=$sqlCantidadCategorias['COUNT(idCategoria)'];
    ?>
    <div id="categoriasProduct">
        <div>
            <h1>Categorias</h1>
            <a href="modificarCategorias.php?idCategoria=0" class="btnDerecha">Agregar</a>
        </div>
        <div id="cats">
            <!-- Se utilizara el template correspondiente con los datos desde la BD -->
        </div>
        <div class="pagination">
            <li><p id="btnPagCatI">❮</p></li>
            <li><p id="btnPagCatD">❯</p></li>
        </div>
    </div>
    <template id="templateCategoria">
        <div class="categoriaProduct">
            <div>
                <h3></h3>
                <a class="btnDerecha btnEliminarCategoria">Eliminar</a>
                <a class="btnDerecha btnModificarCategoria">Modificar</a>
            </div>    
        </div>
    </template> 
    <script></script>

    <?php }
    include_once 'Assets/footer.php';?>
</main>
</body>
<link rel="stylesheet" href="Style/pagEmpleadosStyle.css">
<script src="JavaScript/pagEmpleado.js"></script>
<script>
    let cantidadDeCategorias=`<?=isset($sqlCantidadCategorias)?$sqlCantidadCategorias:0?>`;
    let cantidadDePersonal=`<?=isset($sqlCantidadPersonal)?$sqlCantidadPersonal:0?>`;
    let cantidadDeCliente=`<?=isset($sqlCantidadCliente)?$sqlCantidadCliente:0?>`;
    let cantidadDeProductos=`<?=isset($sqlCantidadProductos)?$sqlCantidadProductos:0?>`;
</script>
</html>

<?php 
    }else{header('Location: index.php');}
?>