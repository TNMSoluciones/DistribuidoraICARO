<?php include 'Assets/header.php';?>

<form id="agregarProductos">
    <h1>Agregar Producto</h1>
    <label for="sImagen">Agregar Imagen(16/9)</label>
    <input type="file" id="sImagen" accept="image/png, image/gif, image/jpeg">
    <input type="text" placeholder="Nombre del Producto">
    <select>
        <option value="categoria1">Categoria1</option>
        <option value="categorias2">Categoria2</option>
    </select>
    <input type="number" placeholder="Precio del Producto" min="0" step=".1">
    <input type="number" placeholder="Cantidad del Producto" min="0">
    <input type="submit" class="btnProductos" value="Agregar">
    <input type="button" id="cerrarProductos" class="btnProductos" value="Salir">
</form>
<form id="agregarEmpleado">
    <h1>Agregar Empleado</h1>
    <input type="text" placeholder="Nombre del Empleado">
    <input type="text" placeholder="Correo del Empleado">
    <select>
        <option value="EncargadoProducto">Encargado De Producto</option>
        <option value="EncargadoVentas">Encargado De Ventas</option>
    </select>
    <input type="submit" class="btnEmpleado" value="Agregar">
    <input type="button" id="cerrarEmpleado" class="btnEmpleado" value="Salir">
</form>

<div id="modificarProductos">
    <h1>Agregar Producto</h1>
    <label for="sImagen">Agregar Imagen</label>
    <input type="file" id="sImagen" accept="image/png, image/gif, image/jpeg">
    <input type="text" placeholder="Nombre del Producto" value="Harina">
    <select>
        <option value="categoria1">Categoria1</option>
        <option value="categoria2">Categoria2</option>
    </select>
    <input type="number" placeholder="Precio del Producto" min="0" step=".1" value="54">
    <input type="number" placeholder="Cantidad del Producto" min="0" value="352">
    <input type="submit" class="btnProductos" value="Agregar">
    <input type="button" id="cerrarModProductos" class="btnProductos" value="Salir">
</div>

<main>
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
                <input type="submit" value="Eliminar">
                <h3>CostoTotal</h3>
                <h3>Cantidad</h3>
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
                <input type="submit" value="Eliminar">
                <input type="submit" id="modProductos" value="Modificar">
                <h3>CostoPorUnidad</h3>
                <h3>Cantidad</h3>
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
                <input type="submit" value="Eliminar">
                <input type="submit" value="Modificar">
                <h3>Rol del empleado</h3>
            </div>
        </div>  
        <!-- Este div acabara un template --> 
    </div>
</main>
<?php include 'Assets/footer.php';?>

    
</body>
<script>
    const main=document.querySelector('main');
    const header=document.querySelector('header');
    const categorias=document.querySelector('#categorias');
    const agregarProductos=document.getElementById('agregarProductos');
    const agregarEmpleado=document.getElementById('agregarEmpleado');
    const modificarProductos=document.getElementById('modificarProductos');
    document.getElementById('agrProduct').addEventListener('click',()=>{
        main.classList.add('mainBlur');
        header.classList.add('mainBlur');
        categorias.classList.add('mainBlur');
        agregarProductos.style.display='block';
    });
    document.querySelector('form#agregarProductos #cerrarProductos').addEventListener('click',()=>{
        main.classList.remove('mainBlur');
        header.classList.remove('mainBlur');
        categorias.classList.remove('mainBlur');
        agregarProductos.style.display='none';
    });
    document.getElementById('agrEmpleado').addEventListener('click',()=>{
        main.classList.add('mainBlur');
        header.classList.add('mainBlur');
        categorias.classList.add('mainBlur');
        agregarEmpleado.style.display='block';
    });
    document.querySelector('form#agregarEmpleado #cerrarEmpleado').addEventListener('click',()=>{
        main.classList.remove('mainBlur');
        header.classList.remove('mainBlur');
        categorias.classList.remove('mainBlur');
        agregarEmpleado.style.display='none';
    });
    document.getElementById('modProductos').addEventListener('click',()=>{
        main.classList.add('mainBlur');
        header.classList.add('mainBlur');
        categorias.classList.add('mainBlur');
        modificarProductos.style.display='block';
    });
    document.querySelector('div#modificarProductos #cerrarModProductos').addEventListener('click',()=>{
        main.classList.remove('mainBlur');
        header.classList.remove('mainBlur');
        categorias.classList.remove('mainBlur');
        modificarProductos.style.display='none';
    });
</script>
<link rel="stylesheet" href="Style/pagEmpleadosStyle.css">
</html>