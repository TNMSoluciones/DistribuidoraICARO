'use strict';
document.addEventListener('DOMContentLoaded',()=>{




    //Variables
    let paginaActualCategorias = cantidadDeCategorias>0?1:0;
    let paginaActualPersonal = cantidadDePersonal>0?1:0;
    let paginaActualCliente = cantidadDeCliente>0?1:0;
    let paginaActualProducto = cantidadDeProductos>0?1:0;
    let cantidadPorPagina = 4;
    
    let paginaTotalCategorias=cantidadDeCategorias/cantidadPorPagina;
    let paginaTotalPersonal=cantidadDePersonal/cantidadPorPagina;
    let paginaTotalCliente=cantidadDeCliente/cantidadPorPagina;
    let paginaTotalProducto=cantidadDeProductos/cantidadPorPagina;

















    if (document.getElementById('encargado')) {
        //Cuando esten programados los eventListener de encargado de ventas
    }
    if (document.getElementById('productos'))
    {
        //Cosas necesarias para crear y mostrar los productos
        const divProductos = document.querySelector('#productos div:nth-of-type(2)');
        const templateProductos = document.getElementById('templateProductos').content;
        const fragmentProductos = document.createDocumentFragment();
        const mostrarProductos = function()
        {
            let btnPaginacionProductoIzquierda = document.querySelector('#productos div.pagination li:first-of-type');
            let btnPaginacionProductoDerecha = document.querySelector('#productos div.pagination li:last-of-type');
            paginaActualProducto==1?btnPaginacionProductoIzquierda.style.display='none':btnPaginacionProductoIzquierda.style.display='inline';
            paginaActualProducto==Math.ceil(paginaTotalProducto)?btnPaginacionProductoDerecha.style.display='none':btnPaginacionProductoDerecha.style.display='inline';
            if (paginaActualProducto==0) {
                btnPaginacionProductoIzquierda.style.display='none';
                btnPaginacionProductoDerecha.style.display='none';
            }
            if(paginaActualProducto!=0){
                let xmlProducto = new XMLHttpRequest();
                xmlProducto.overrideMimeType('text/xml');
                const  data = {
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualProducto-1)*cantidadPorPagina
                };
                xmlProducto.onreadystatechange = function(){
                    if (this.readyState==4 && this.status==200) {
                        let productos = JSON.parse(this.response);
                        productos.forEach(producto =>{
                            templateProductos.querySelector('.productosEncargado div img').setAttribute('src', producto.urlImagen);
                            templateProductos.querySelector('.productosEncargado div h3:first-of-type').textContent=producto.nombre;
                            templateProductos.querySelector('.productosEncargado div h3:nth-of-type(2)').textContent=producto.Categoria;
                            templateProductos.querySelector('.productosEncargado div h3:nth-of-type(3)').textContent='$'+producto.precio;
                            templateProductos.querySelector('.productosEncargado div h3:nth-of-type(4)').textContent='Stock disponible: '+producto.stock;
                            templateProductos.querySelector('.productosEncargado div a.btnEliminarProducto').setAttribute('href', `modificarProductos.php?idProducto=${producto.idProducto}&delete=true`);
                            templateProductos.querySelector('.productosEncargado div a.btnModificarProducto').setAttribute('href', `modificarProductos.php?idProducto=${producto.idProducto}`);
                            const clon = templateProductos.cloneNode(true);
                            fragmentProductos.appendChild(clon);
                        });
                        divProductos.innerHTML=``;
                        divProductos.appendChild(fragmentProductos)
                    }
                }
                xmlProducto.open('POST', 'ajax/producto-mostrar.php', true);
                xmlProducto.send(JSON.stringify(data));
            }
        }
        document.querySelector('#btnPagProductoD').addEventListener('click', ()=>{
            paginaActualProducto++;
            mostrarProductos();
        });
        document.querySelector('#btnPagProductoI').addEventListener('click', ()=>{
            paginaActualProducto--;
            mostrarProductos();
        });
        mostrarProductos();
    }
    if (document.getElementById('cliente'))
    {
        //Cosas necesarias para crear y mostrar los clientes
        const divCliente = document.querySelector('#cliente div:nth-of-type(2)');
        const templateCliente = document.getElementById('templateClientes').content;
        const fragmentCliente = document.createDocumentFragment();
        const mostrarClientes = function()
        {
            let btnPaginacionClienteIzquierda=document.querySelector('#cliente div.pagination li:first-of-type');
            let btnPaginacionClienteDerecha=document.querySelector('#cliente div.pagination li:last-of-type');
            paginaActualCliente==1?btnPaginacionClienteIzquierda.style.display='none':btnPaginacionClienteIzquierda.style.display='inline';
            paginaActualCliente==Math.ceil(paginaTotalCliente)?btnPaginacionClienteDerecha.style.display='none':btnPaginacionClienteDerecha.style.display='inline';
            if(paginaActualCliente==0){
                btnPaginacionClienteIzquierda.style.display='none';
                btnPaginacionClienteDerecha.style.display='none';
            }
            if(paginaActualCliente!=0){
                let xmlCliente = new XMLHttpRequest();
                xmlCliente.overrideMimeType('text/xml');
                const data = {
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualCliente-1)*cantidadPorPagina
                };
                xmlCliente.onreadystatechange = function(){
                    if (this.readyState==4 && this.status==200) {
                        let clientes = JSON.parse(this.response);
                        clientes.forEach(cliente =>
                            {
                                templateCliente.querySelector('.clientesEncargado div h3:first-of-type').textContent=cliente.nombreEmpresa;
                                templateCliente.querySelector('.clientesEncargado div h3:nth-of-type(2)').textContent=cliente.correoEmpresa;
                                templateCliente.querySelector('.clientesEncargado div h3:nth-of-type(3)').textContent=cliente.rut;
                                templateCliente.querySelector('.clientesEncargado div h3:nth-of-type(4)').textContent=cliente.activo==1? 'Cuenta Activada': 'Cuenta Desactivada';
                                templateCliente.querySelector('.clientesEncargado div a.btnEliminarCliente').setAttribute('href', `modificarCliente.php?idCliente=${cliente.idCliente}&delete=true`);
                                templateCliente.querySelector('.clientesEncargado div a.btnModificarCliente').setAttribute('href', `modificarCliente.php?idCliente=${cliente.idCliente}`);
                                const clon = templateCliente.cloneNode(true);
                                fragmentCliente.appendChild(clon);
                            });
                            divCliente.innerHTML=``;
                            divCliente.appendChild(fragmentCliente);
                    }
                }
                xmlCliente.open('POST', 'ajax/cliente-mostrar.php', true);
                xmlCliente.send(JSON.stringify(data));
            }
        }
        document.querySelector('#btnPagClienteD').addEventListener('click', ()=>{
            paginaActualCliente++;
            mostrarClientes();
        });
        document.querySelector('#btnPagClienteI').addEventListener('click', ()=>{
            paginaActualCliente--;
            mostrarClientes();
        });
        mostrarClientes();
    }
    if (document.getElementById('personal'))
    {
        //Cosas necesarias para crear y mostrar los Empleados
        const divPersonal = document.querySelector('#personal div:nth-of-type(2)');
        const templatePersonal = document.querySelector('#templatePersonal').content;
        const fragmentPersonal = document.createDocumentFragment();
        const mostrarPersonal = function()
        {
            let btnPaginacionPersonalIzquierda=document.querySelector('#personal div.pagination li:first-of-type');
            let btnPaginacionPersonalDerecha=document.querySelector('#personal div.pagination li:last-of-type');
            paginaActualPersonal==1?btnPaginacionPersonalIzquierda.style.display='none':btnPaginacionPersonalIzquierda.style.display='inline';
            paginaActualPersonal==Math.ceil(paginaTotalPersonal)?btnPaginacionPersonalDerecha.style.display='none':btnPaginacionPersonalDerecha.style.display='inline';
            if (paginaActualPersonal==0) {
                btnPaginacionPersonalIzquierda.style.display="none";
                btnPaginacionPersonalDerecha.style.display='none';
            }
            if (paginaActualPersonal!=0) {
                let xmlPersonal = new XMLHttpRequest();
                xmlPersonal.overrideMimeType('text/xml');
                const data={
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualPersonal-1)*cantidadPorPagina
                };
                xmlPersonal.onreadystatechange = function()
                {
                    if (this.readyState==4 && this.status==200)
                    {
                        let empleados = JSON.parse(this.response);
                        empleados.forEach(empleados =>
                        {
                            let nombreCompleto = empleados.sName=='NULL'?empleados.fName + ' ' + empleados.lastName:empleados.fName + ' ' + empleados.sName + ' '+ empleados.lastName;
                            templatePersonal.querySelector('.empleados div h3:first-of-type').textContent=nombreCompleto;
                            templatePersonal.querySelector('.empleados div h3:nth-of-type(2)').textContent=empleados.email;
                            templatePersonal.querySelector('.empleados div h3:last-of-type').textContent=empleados.rolPersonal;
                            templatePersonal.querySelector('.empleados div a.btnModificarPersonal').setAttribute('href', `modificarEmpleados.php?idPersonal=${empleados.idPersonal}`);
                            templatePersonal.querySelector('.empleados div a.btnEliminarPersonal').setAttribute('href', `modificarEmpleados.php?idPersonal=${empleados.idPersonal}&delete=true`);
                            const clon = templatePersonal.cloneNode(true);
                            fragmentPersonal.appendChild(clon);
                        });
                        divPersonal.innerHTML=``;
                        divPersonal.appendChild(fragmentPersonal);
                    }
                };
                xmlPersonal.open('POST', 'ajax/personal-mostrar.php', true);
                xmlPersonal.send(JSON.stringify(data));
            }
    
        }
        document.querySelector('#btnPagPersonalD').addEventListener('click', ()=>{
            paginaActualPersonal++;
            mostrarPersonal();
        });
        document.querySelector('#btnPagPersonalI').addEventListener('click', ()=>{
            paginaActualPersonal--;
            mostrarPersonal();
        });
        mostrarPersonal();
    }
    if (document.getElementById('categoriasProduct'))
    {
        //Cosas necesarias para crear y mostrar las Categorias
        const divCategorias = document.querySelector('#cats');
        const templateCategoria = document.querySelector('#templateCategoria').content;
        const fragmentCategorias = document.createDocumentFragment();
        const mostrarCategorias = function()
        {
            let btnPaginacionCategoriasIzquierda=document.querySelector('#categoriasProduct div.pagination li:first-of-type');
            let btnPaginacionCategoriasDerecha=document.querySelector('#categoriasProduct div.pagination li:last-of-type');
            paginaActualCategorias==1?btnPaginacionCategoriasIzquierda.style.display="none":btnPaginacionCategoriasIzquierda.style.display="inline";
            paginaActualCategorias==Math.ceil(paginaTotalCategorias)?btnPaginacionCategoriasDerecha.style.display='none':btnPaginacionCategoriasDerecha.style.display='inline';
            if (paginaActualCategorias==0)
            {
                btnPaginacionCategoriasIzquierda.style.display="none";
                btnPaginacionCategoriasDerecha.style.display='none';
            }
            if (paginaActualCategorias!=0)
            {
                let xmlCat = new XMLHttpRequest();
                xmlCat.overrideMimeType('text/xml');
                const data={
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualCategorias-1)*cantidadPorPagina
                };
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
                        divCategorias.innerHTML=``;
                        divCategorias.appendChild(fragmentCategorias);
                    }
                };
                xmlCat.open('POST', 'ajax/categories-mostrar.php', true);
                xmlCat.send(JSON.stringify(data));
            }
        }
        document.querySelector('#btnPagCatD').addEventListener('click', ()=>{
            paginaActualCategorias++;
            mostrarCategorias();
        });
        document.querySelector('#btnPagCatI').addEventListener('click', ()=>{
            paginaActualCategorias--;
            mostrarCategorias();
        });
        mostrarCategorias();
    }
    
});//Fin de DOMContentLoaded