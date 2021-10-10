<!DOCTYPE html>
<?php 
    session_start();
    include_once 'BD/conBD.php';
    if(isset($_SESSION['user']['rol'])){
        include_once 'Assets/header.php';
        mostrarHeader('Empleados');
        echo '<main>';
        $pdo=pdo_conectar_mysql();
        if ($_SESSION['user']['idRol']==2 || $_SESSION['user']['idRol']==1) {
            
            ?>
    <div id="encargado" class="divPrincipal">
        <div>
            <h1>Ventas</h1>
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
        if($_SESSION['user']['idRol']==3 || $_SESSION['user']['idRol']==1){
            $sqlCantidadProductos=$pdo->query('SELECT COUNT(idProducto) FROM producto')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadProductos=$sqlCantidadProductos['COUNT(idProducto)'];
            ?>
    <div id="productos" class="divPrincipal">
        <div>
            <h1>Productos</h1>
            <input type="text" class="searchEmpleados"  placeholder="Busca producto">
            <a href="modificarProductos.php?idProducto=0" class="btnDerecha">Agregar</a>
        </div>
        <!-- Este div se cambiara por un template -->
        <div id="product">
            
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
                        <img src="" alt="fotoproducto">
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
        <div id="client">
            <!-- Se utilizara el template correspondiente con los datos desde la BD -->
        </div>
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
        <div id="sugerencia">
            <!-- Se utilizara el template correspondiente con los datos de sde la BD -->
        </div>
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
                <a class="btnDerecha btnEliminarCliente">Eliminar</a>
                <a class="btnDerecha btnModificarCliente">Modificar</a>
                <h3 class="txtDerecha"></h3>
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
        <input type="text" class="searchEmpleados" placeholder="Busca empleados">
        <a href="modificarEmpleados.php?idPersonal=0" class="btnDerecha">Agregar</a>
    </div>
    <div id="empleados">
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
        if($_SESSION['user']['idRol']==4 || $_SESSION['user']['idRol']==1){
            $sqlCantidadCategorias=$pdo->query('SELECT COUNT(idCategoria) FROM categorias')->fetch(PDO::FETCH_ASSOC);
            $sqlCantidadCategorias=$sqlCantidadCategorias['COUNT(idCategoria)'];
            ?>
    <div id="categoriasProduct" class="divPrincipal">
        <div>
            <h1>Categorias</h1>
            <input type="text" class="searchEmpleados"  placeholder="Busca categoría">
            <a href="modificarCategorias.php?idCategoria=0" class="btnDerecha">Agregar</a>
        </div>
        <div id="catProduct">
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
    
    <?php }
    echo '</main>';
    include_once 'Assets/footer.php';?>
</body>
<link rel="stylesheet" href="Style/pagEmpleadosStyle.css">
<script src="JavaScript/pagEmpleado.js"></script>
<script>
    let cantidadDeCategorias=`<?=isset($sqlCantidadCategorias)?$sqlCantidadCategorias:0?>`;
    let cantidadDePersonal=`<?=isset($sqlCantidadPersonal)?$sqlCantidadPersonal:0?>`;
    let cantidadDeCliente=`<?=isset($sqlCantidadCliente)?$sqlCantidadCliente:0?>`;
    let cantidadDeProductos=`<?=isset($sqlCantidadProductos)?$sqlCantidadProductos:0?>`;
    let cantidadDeSugerencias=`<?=isset($sqlCantidadSugerencias)?$sqlCantidadSugerencias:0?>`;
    const actCantidadDeCategorias = function(){return `<?=isset($sqlCantidadCategorias)?$sqlCantidadCategorias:0?>`;}
    const actCantidadDePersonal = function(){return `<?=isset($sqlCantidadPersonal)?$sqlCantidadPersonal:0?>`;}
    const actCantidadDeCliente = function(){return `<?=isset($sqlCantidadCliente)?$sqlCantidadCliente:0?>`;}
    const actCantidadDeProductos = function(){return `<?=isset($sqlCantidadProductos)?$sqlCantidadProductos:0?>`;}
    const actCantidadDeSugerencias = function(){return `<?=isset($sqlCantidadSugerencias)?$sqlCantidadSugerencias:0?>`;}
</script>
</html>

<?php 
    }else{header('Location: index.php');}
    ?>