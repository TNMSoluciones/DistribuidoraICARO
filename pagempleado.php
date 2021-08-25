<script>
    document.addEventListener('DOMContentLoaded',()=>{
        //Cosas necesarias para crear y mostrar las categorias
        const divCategorias = document.querySelector('#categoriasProduct');
        const templateCategoria = document.querySelector('#templateCategoria').content;
        const fragmentCategorias = document.createDocumentFragment();
        //Cosas necesarias para crear y mostrar los roles
        const divRoles = document.querySelector('#roles');
        const templateRol = document.querySelector('#templateRol').content;
        const fragmentRol = document.createDocumentFragment();



        mostrarCategorias();
        mostrarRoles();
        
        function mostrarRoles(){
            let xmlRol = new XMLHttpRequest();
            xmlRol.overrideMimeType('text/xml');
            xmlRol.onreadystatechange = function()
            {
                if (this.readyState== 4 && this.status ==200)
                {
                    let rolesEmpleado = JSON.parse(this.response);
                    rolesEmpleado.forEach(roles =>
                    {
                        templateRol.querySelector('.rolesParaEmpleado div h3').textContent=roles.Rol;
                        templateRol.querySelector('.rolesParaEmpleado div a.btnModificarRol').setAttribute('href', `modificarRoles.php?idRol=${roles.idRol}`);
                        templateRol.querySelector('.rolesParaEmpleado div a.btnEliminarRol').setAttribute('href', `modificarRoles.php?idRol=${roles.idRol}&delete=true`);
                        const clon = templateRol.cloneNode(true);
                        fragmentRol.appendChild(clon);
                    });
                    divRoles.appendChild(fragmentRol);
                }
            };
            xmlRol.open('GET', 'ajax/rol-mostrar.php', true);
            xmlRol.send();
        }

        function mostrarCategorias(){
            let xmlCat = new XMLHttpRequest();
            xmlCat.overrideMimeType('text/xml');
            xmlCat.onreadystatechange = function()
            {
                if (this.readyState== 4 && this.status ==200)
                {
                    let categoriasProducto = JSON.parse(this.response);
                    categoriasProducto.forEach(categoria =>
                    {
                        templateCategoria.querySelector('.categoriaProduct div h3').textContent=categoria.Categoria;
                        templateCategoria.querySelector('.categoriaProduct div a.btnModificarCategoria').setAttribute('href', `modificarCategorias.php?idCategoria=${categoria.idCategoria}`);
                        templateCategoria.querySelector('.categoriaProduct div a.btnEliminarCategoria').setAttribute('href', `modificarCategorias.php?idCategoria=${categoria.idCategoria}&delete=true`);
                        const clon = templateCategoria.cloneNode(true);
                        fragmentCategorias.appendChild(clon);
                    });
                    divCategorias.appendChild(fragmentCategorias);
                }
            };
            xmlCat.open('GET', 'ajax/product-mostrar.php', true);
            xmlCat.send();
        }
    });



</script>
<main>
<?php 
    session_start();
    include_once 'Assets/header.php';
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
            <input type="submit" value="Agregar" id="agrProduct" class="btnAdd">
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
            <a href="modificarRoles.php?idRol=0" class="btnDerecha">Agregar</a>
        </div>
        <!-- Se utilizara el template correspondiente con los datos desde la BD -->
    </div>

    <div id="categoriasProduct">
        <div>
            <h1>Categorias</h1>
            <a href="modificarCategorias.php?idCategoria=0" class="btnDerecha">Agregar</a>
        </div>
        <!-- Se utilizara el template correspondiente con los datos desde la BD -->
    </div>


    <?php include 'Assets/footer.php';?>
</main>


<!-- Seccion de los Template -->

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
</html>