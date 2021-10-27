<?php 
    session_start();
    if(isset($_SESSION['user']['idRol'])){
        include_once 'BD/conBD.php';
        include_once 'Assets/header.php';
        mostrarHeader('Empleados');
        echo '<main>';
        $pdo=pdo_conectar_mysql();
        if ($_SESSION['user']['idRol']==2 || $_SESSION['user']['idRol']==1) {
            $sqlCantidadVentas=$pdo->query('SELECT COUNT(idPedido) FROM pedido')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadVentas=$sqlCantidadVentas['COUNT(idPedido)'];            
            ?>
    <div id="encargado" class="divPrincipal">
        <div>
            <a href="listaPedidosCompleta.php" style="width: 7vw;" class="btnDerecha btnAdd">Lista completa</a>
            <h1>Pedidos</h1>
            <input type="text" class="searchEmpleados"  placeholder="Busca pedido">
        </div>
        <div class="titulosTabla">
            <div>
                <h3>Nombre</h3>
                <h3>Fecha</h3>
                <h3>PrecioTotal</h3>
                <h3>Metodo Pago</h3>
                <h3 class="txtDerecha">Funciones</h3>
            </div>
        </div>
        <div id="pedido"></div>
        <div class="pagination">
            <li><p id="btnPagVentasI">❮</p></li>
            <li><p id="btnPagVentasD">❯</p></li>
        </div>
        <!-- Este div se cambiara por un template -->
        <template id="templateVentas">
            <div class="comprasEncargado">
                <div>
                    <h3>Nombre de la empresa</h3>
                    <h3>Nombre del producto</h3>
                    <h3>CostoTotal</h3>
                    <h3>Cantidad</h3>
                    <a class="btnDerecha btnEliminarVentas">Eliminar</a>
                    <a class="btnDerecha btnModificarVentas">Modificar</a>
                </div>
            </div>  
        </template>
        <!-- Este div acabara un template -->
    </div>
    
    <?php }
        if($_SESSION['user']['idRol']==3 || $_SESSION['user']['idRol']==1){
            $sqlCantidadProductos=$pdo->query('SELECT COUNT(idProducto) FROM producto')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadProductos=$sqlCantidadProductos['COUNT(idProducto)'];
            ?>
    <div id="productos" class="divPrincipal">
        <div>
            <a href="modificarProductos.php?idProducto=0" class="btnDerecha btnAdd">Agregar</a>
            <h1>Productos</h1>
            <input type="text" class="searchEmpleados"  placeholder="Busca producto">
        </div>
        <div class="titulosTabla">
            <div>
                <h3>Nombre</h3>
                <h3>Categoria</h3>
                <h3>Precio</h3>
                <h3>Stock Disponible</h3>
                <h3 class="txtDerecha">Funciones</h3>
            </div>
        </div>
        <div id="product"></div>
            <div class="pagination">
                <li><p id="btnPagProductoI">❮</p></li>
                <li><p id="btnPagProductoD">❯</p></li>
            </div>
        </div>
        <template id="templateProductos">
            <div class="productosEncargado">
                <div>
                    <h3></h3>
                    <h3></h3>
                    <h3></h3>
                    <h3></h3>
                    <a class="btnDerecha btnEliminarProducto">Eliminar</a>
                    <a class="btnDerecha btnModificarProducto">Modificar</a>
                </div>
            </div>  
        </template>
        
        <?php }
        if($_SESSION['user']['idRol']==5 || $_SESSION['user']['idRol']==1){
            $sqlCantidadCliente=$pdo->query('SELECT COUNT(idCliente) FROM cliente')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadCliente=$sqlCantidadCliente['COUNT(idCliente)'];
            $sqlCantidadSugerencias=$pdo->query('SELECT COUNT(idOpinion) FROM opiniones')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadSugerencias=$sqlCantidadSugerencias['COUNT(idOpinion)'];
            ?>
    <div id="cliente" class="divPrincipal">
        <div>
            <h1>Clientes</h1>
            <input type="text" class="searchEmpleados" placeholder="Busca clientes">
        </div>
        <div class="titulosTabla">
            <div>
                <h3>Nombre</h3>
                <h3>Correo</h3>
                <h3>RUT</h3>
                <h3>Estado de cuenta</h3>
                <h3 class="txtDerecha">Funciones</h3>
            </div>
        </div>
        <div id="client"></div>
        <div class="pagination">
            <li><p id="btnPagClienteI">❮</p></li>
            <li><p id="btnPagClienteD">❯</p></li>
        </div>
    </div>
    <div id="sugerencias" class="divPrincipal">
        <div>
            <h1>Sugerencias</h1>
            <input type="text" class="searchEmpleados" placeholder="Busca sugerencias">
        </div>
        <div class="titulosTabla">
            <div>
                <h3>Nombre</h3>
                <h3>Correo</h3>
                <h3>Fecha</h3>
                <h3 class="txtDerecha">Funciones</h3>
            </div>
        </div>
        <div id="sugerencia"></div>
        <div class="pagination">
            <li><p id="btnPagSugI">❮</p></li>
            <li><p id="btnPagSugD">❯</p></li>
        </div>
    </div>
    <template id="templateClientes">
        <div class="clientesEncargado">
            <div>
                <h3></h3>
                <h3></h3>
                <h3></h3>
                <h3></h3>
                <a class="btnDerecha btnEliminarCliente">Eliminar</a>
                <a class="btnDerecha btnModificarCliente">Modificar</a>
            </div>
        </div>
    </template>
    <template id="templateSugerencias">
        <div class="sugerenciasEncargado">
            <div>
                <h3>Nombre</h3>
                <h3>Email</h3>
                <h3>Fecha</h3>
                <a class="btnDerecha btnModificarSugerencia">Ver Mas</a>
            </div>
        </div>
    </template>
    <?php }
        if($_SESSION['user']['idRol']==1){
            $sqlCantidadPersonal=$pdo->query('SELECT COUNT(idPersonal) FROM personal')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadPersonal=$sqlCantidadPersonal['COUNT(idPersonal)'];
            ?>


<div id="personal" class="divPrincipal">
    <div>
        <h1>Empleados</h1>
        <a href="modificarEmpleados.php?idPersonal=0" class="btnDerecha btnAdd">Agregar</a>
        <input type="text" class="searchEmpleados" placeholder="Busca empleados">
    </div>
    <div class="titulosTabla">
        <div>
            <h3>Nombre</h3>
            <h3>Correo</h3>
            <h3>Rol</h3>
            <h3 class="txtDerecha">Funciones</h3>
        </div>
    </div>
    <div id="empleados"></div>
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
            <h3></h3>
            <a class="btnDerecha btnEliminarPersonal">Eliminar</a>
            <a class="btnDerecha btnModificarPersonal">Modificar</a>
        </div>
    </div>  
</template>

<?php }
        if($_SESSION['user']['idRol']==4 || $_SESSION['user']['idRol']==1){
            $sqlCantidadCategorias=$pdo->query('SELECT COUNT(idCategoria) FROM categorias')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadCategorias=$sqlCantidadCategorias['COUNT(idCategoria)'];
            ?>
    <div id="categoriasProduct" class="divPrincipal">
        <div>
            <h1>Categorias</h1>
            <a href="modificarCategorias.php?idCategoria=0" class="btnDerecha btnAdd">Agregar</a>
            <input type="text" class="searchEmpleados"  placeholder="Busca categoría">
        </div>
        <div class="titulosTabla">
            <div>
                <h3>Nombre</h3>
                <h3 class="txtDerecha">Funciones</h3>
            </div>
        </div>
        <div id="catProduct"></div>
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
    
    <?php }
    echo '</main>';
    include_once 'Assets/footer.php';?>
</body>
<link rel="stylesheet" href="Style/pagEmpleadosStyle.css">
<script src="JavaScript/pagEmpleado.js"></script>
<script>
    const cantidadDeCategorias=`<?=isset($sqlCantidadCategorias)?$sqlCantidadCategorias:0?>`;
    const cantidadDePersonal=`<?=isset($sqlCantidadPersonal)?$sqlCantidadPersonal:0?>`;
    const cantidadDeCliente=`<?=isset($sqlCantidadCliente)?$sqlCantidadCliente:0?>`;
    const cantidadDeProductos=`<?=isset($sqlCantidadProductos)?$sqlCantidadProductos:0?>`;
    const cantidadDeSugerencias=`<?=isset($sqlCantidadSugerencias)?$sqlCantidadSugerencias:0?>`;
    const cantidadDeVentas = `<?=isset($sqlCantidadVentas)?$sqlCantidadVentas:0?>`;
    
    const actCantidadDeCategorias = function(){return `<?=isset($sqlCantidadCategorias)?$sqlCantidadCategorias:0?>`;}
    const actCantidadDePersonal = function(){return `<?=isset($sqlCantidadPersonal)?$sqlCantidadPersonal:0?>`;}
    const actCantidadDeCliente = function(){return `<?=isset($sqlCantidadCliente)?$sqlCantidadCliente:0?>`;}
    const actCantidadDeProductos = function(){return `<?=isset($sqlCantidadProductos)?$sqlCantidadProductos:0?>`;}
    const actCantidadDeSugerencias = function(){return `<?=isset($sqlCantidadSugerencias)?$sqlCantidadSugerencias:0?>`;}
    const actCantidadDeVentas = function(){return `<?=isset($sqlCantidadVentas)?$sqlCantidadVentas:0?>`;}

</script>
</html>

<?php 
    }else{header('Location: index.php');}
?>