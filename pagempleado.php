<main>
<?php include_once 'Assets/header.php';?>
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
            <input type="submit" value="Agregar" id="agrProduct" class="btnAdd">
        </div>
        <!-- Este div se cambiara por un template -->
        <div class="productosEncargado">
            <div>
                <img src="img/usuario.png" class="imgproducto" alt="fotoproducto">
                <h3>Nombre del producto</h3>
                <h3>Categoria del producto</h3>
                <input type="submit" value="Eliminar" class="btnDerecha">
                <a href="updateProduct.php" class="btnDerecha">Modificar</a>
                <h3 class="txtDerecha">CostoPorUnidad</h3>
                <h3 class="txtDerecha">Cantidad</h3>
            </div>
        </div>  
        <!-- Este div acabara un template --> 
    </div>

    <div id="personal">
        <div>
            <h1>Empleados</h1>
            <input type="submit" value="Agregar" id="agrEmpleado" class="btnAdd">
        </div>
        <!-- Este div se cambiara por un template -->
        <div class="empleados">
            <div>
                <h3>NombreDelEmpleado</h3>
                <h3>CorreoDelEmpleado</h3>
                <input type="submit" value="Eliminar" class="btnDerecha">
                <input type="submit" value="Modificar" class="btnDerecha">
                <h3 class="txtDerecha">Rol del empleado</h3>
            </div>
        </div>  
        <!-- Este div acabara un template --> 
    </div>

    <div id="roles">
        <div>
            <h1>Roles</h1>
            <input type="submit" value="Agregar" class="btnDerecha">
        </div>
        <div class="rolesParaEmpleado">
            <div>
                <h3>RolEmpleado</h3>
                <input type="submit" value="Eliminar" class="btnDerecha">
                <input type="submit" value="Modificar" class="btnDerecha">
            </div>    
        </div>
    </div>

    <div id="categoriasProduct">
        <div>
            <h1>Categorias</h1>
            <input type="submit" value="Agregar" class="btnDerecha">
        </div>
        <div class="categoriasProduct">
            <div>
                <h3>NombreCategoria</h3>
                <input type="submit" value="Eliminar" class="btnDerecha">
                <input type="submit" value="Modificar" class="btnDerecha">
            </div>    
        </div>
    </div>
    <?php include 'Assets/footer.php';?>
</main>


    
</body>
<link rel="stylesheet" href="Style/pagEmpleadosStyle.css">
</html>