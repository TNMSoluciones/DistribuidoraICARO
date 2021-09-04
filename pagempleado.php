<!DOCTYPE html>
<main>
<?php 
    session_start();
    include_once 'Assets/header.php';
    include_once 'BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $sqlCantidadCategorias=$pdo->query('SELECT COUNT(idCategoria) FROM categorias')->fetch(PDO::FETCH_ASSOC);
    $sqlCantidadCategorias=$sqlCantidadCategorias['COUNT(idCategoria)'];
    $sqlCantidadPersonal=$pdo->query('SELECT COUNT(idPersonal) FROM personal')->fetch(PDO::FETCH_ASSOC);
    $sqlCantidadPersonal=$sqlCantidadPersonal['COUNT(idPersonal)'];
    $sqlCantidadRoles=$pdo->query('SELECT COUNT(idRol) FROM roles')->fetch(PDO::FETCH_ASSOC);
    $sqlCantidadRoles=$sqlCantidadRoles['COUNT(idRol)'];
    $sqlCantidadCliente=$pdo->query('SELECT COUNT(idCliente) FROM cliente')->fetch(PDO::FETCH_ASSOC);
    $sqlCantidadCliente=$sqlCantidadCliente['COUNT(idCliente)'];
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

    <div id="productos">
        <div>
            <h1>Encargado de Productos</h1>
            <a href="modificarProductos.php?idProducto=0" class="btnDerecha">Agregar</a>
        </div>
        <!-- Este div se cambiara por un template -->
        <div class="productosEncargado">
            <div>
                <img src="img/usuario.png" class="imgproducto" alt="fotoproducto">
                <h3>Nombre del producto</h3>
                <h3>Categoria del producto</h3>
                <input type="submit" value="Eliminar" class="btnDerecha">
                <a href="" class="btnDerecha">Modificar</a>
                <h3 class="txtDerecha">CostoPorUnidad</h3>
                <h3 class="txtDerecha">Cantidad</h3>
            </div>
        </div>  
        <!-- Este div acabara un template --> 
    </div>

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

    <div id="roles">
        <div>
            <h1>Roles</h1>
            <a href="modificarRoles.php?idRol=0" class="btnDerecha">Agregar</a>
        </div>
        <div>
            <!-- Se utilizara el template correspondiente con los datos desde la BD -->
        </div>
        <div class="pagination">
            <li><p id="btnPagRolesI">❮</p></li>
            <li><p id="btnPagRolesD">❯</p></li>
        </div>
    </div>

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


    <?php include 'Assets/footer.php';?>
</main>


<!-- Seccion de los Template -->

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

    <template id="templateRol">
        <div class="rolesParaEmpleado">
            <div>
                <h3></h3>
                <a class="btnDerecha btnEliminarRol">Eliminar</a>
                <a class="btnDerecha btnModificarRol">Modificar</a>
            </div>    
        </div>
    </template> 

    <template id="templateCategoria">
        <div class="categoriaProduct">
            <div>
                <h3></h3>
                <a class="btnDerecha btnEliminarCategoria">Eliminar</a>
                <a class="btnDerecha btnModificarCategoria">Modificar</a>
            </div>    
        </div>
    </template> 
</body>
<link rel="stylesheet" href="Style/pagEmpleadosStyle.css">
<script src="JavaScript/pagEmpleado.js"></script>
<script>
    let cantidadDeCategorias=`<?=$sqlCantidadCategorias?>`;
    let cantidadDePersonal=`<?=$sqlCantidadPersonal?>`;
    let cantidadDeRoles=`<?=$sqlCantidadRoles?>`;
    let cantidadDeCliente=`<?=$sqlCantidadCliente?>`;
</script>
</html>