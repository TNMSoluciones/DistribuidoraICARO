'use strict';
document.addEventListener('DOMContentLoaded',()=>{
    //Variables
    let paginaActualCategorias = actCantidadDeCategorias()>0?1:0;
    let paginaActualPersonal = actCantidadDePersonal()>0?1:0;
    let paginaActualCliente = actCantidadDeCliente()>0?1:0;
    let paginaActualProducto = actCantidadDeProductos()>0?1:0;
    let paginaActualSugerencias = actCantidadDeSugerencias()>0?1:0;
    const cantidadPorPagina = 4;
    
    let paginaTotalCategorias=cantidadDeCategorias/cantidadPorPagina;
    let paginaTotalPersonal=cantidadDePersonal/cantidadPorPagina;
    let paginaTotalCliente=cantidadDeCliente/cantidadPorPagina;
    let paginaTotalProducto=cantidadDeProductos/cantidadPorPagina;
    let paginaTotalSugerencias=cantidadDeSugerencias/cantidadPorPagina;
    
    if (document.getElementById('encargado')) {
        //Cuando esten programados los eventListener de encargado de ventas
    }
    if (document.getElementById('sugerencias')) {
        const divSugerencias = document.getElementById('sugerencia');
        const templateSugerencias = document.getElementById('templateSugerencias').content;
        const fragmentSugerencias = document.createDocumentFragment();
        const mostrarSugerencias = function(){
            let btnPaginacionSugerenciasIzquierda = document.querySelector('#sugerencias div.pagination li:first-of-type');
            let btnPaginacionSugerenciasDerecha = document.querySelector('#sugerencias div.pagination li:last-of-type');
            paginaActualSugerencias==1?btnPaginacionSugerenciasIzquierda.style.display='none':btnPaginacionSugerenciasIzquierda.style.display='inline';
            paginaActualSugerencias==Math.ceil(paginaTotalSugerencias)?btnPaginacionSugerenciasDerecha.style.display='none':btnPaginacionSugerenciasDerecha.style.display='inline';
            if(paginaActualSugerencias==0) {
                btnPaginacionSugerenciasIzquierda.style.display='none';
                btnPaginacionSugerenciasDerecha.style.display='none';
            }
            if (paginaActualSugerencias!=0) {
                let xmlSugerencias = new XMLHttpRequest();
                xmlSugerencias.overrideMimeType('text/xml');
                const data = {
                    texto: document.querySelector('#sugerencias > div > input[type=text]').value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualSugerencias-1)*cantidadPorPagina
                };
                xmlSugerencias.onreadystatechange = function() {
                    if(this.readyState==4 && this.status==200) {
                        let sugerencias = JSON.parse(this.response);
                        if(sugerencias[0]==undefined || sugerencias[0]['cantidad']<5){
                            btnPaginacionSugerenciasIzquierda.style.display='none';
                            btnPaginacionSugerenciasDerecha.style.display='none';
                        }
                        sugerencias.forEach(sugerencia => {
                            templateSugerencias.querySelector('.sugerenciasEncargado div h3:first-of-type').textContent = sugerencia.nombreOpinion;
                            templateSugerencias.querySelector('.sugerenciasEncargado div h3:nth-of-type(2)').textContent = sugerencia.correoOpinion; 
                            templateSugerencias.querySelector('.sugerenciasEncargado div h3:last-of-type').textContent = sugerencia.fecha;  
                            templateSugerencias.querySelector('.sugerenciasEncargado div a.btnModificarSugerencia').setAttribute('href', `modificarSugerencias.php?idSugerencia=${sugerencia.idOpinion}`);
                            const clon = templateSugerencias.cloneNode(true);
                            fragmentSugerencias.appendChild(clon);
                        });
                        divSugerencias.innerHTML=``;
                        divSugerencias.appendChild(fragmentSugerencias);
                    }
                }
                xmlSugerencias.open('POST', 'ajax/sugerencias-mostrar.php', true);
                xmlSugerencias.send(JSON.stringify(data));
            }
        }
        document.querySelector('#btnPagSugD').addEventListener('click', ()=>{
            paginaActualSugerencias++;
            mostrarSugerencias();
        });
        document.querySelector('#btnPagSugI').addEventListener('click', ()=>{
            paginaActualSugerencias--;
            mostrarSugerencias();
        });
        mostrarSugerencias();
        document.querySelector("#sugerencias > div:nth-child(1) > input").addEventListener('input',()=>{
            paginaActualSugerencias = actCantidadDeSugerencias()>0?1:0;
            mostrarSugerencias();   
        })
    }
    
    if (document.getElementById('productos')) {
        //Cosas necesarias para crear y mostrar los productos
        const divProductos = document.getElementById('product');
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
                const data = {
                    texto: document.querySelector('#productos > div > input[type=text]').value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualProducto-1)*cantidadPorPagina
                };
                xmlProducto.onreadystatechange = function(){
                    if (this.readyState==4 && this.status==200) {
                        let productos = JSON.parse(this.response);
                        if (productos[0]==undefined || productos[0]['cantidad']<5) {
                            btnPaginacionProductoIzquierda.style.display='none';
                            btnPaginacionProductoDerecha.style.display='none';
                        }
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
                        divProductos.appendChild(fragmentProductos);
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
        document.querySelector("#productos > div:nth-child(1) > input").addEventListener('input',()=>{
            paginaActualProducto = actCantidadDeProductos()>0?1:0;
            mostrarProductos();   
        })
    }


    if (document.getElementById('cliente'))
    {
        //Cosas necesarias para crear y mostrar los clientes
        const divCliente = document.getElementById('client');
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
                    texto: document.querySelector("#cliente > div:nth-child(1) > input").value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualCliente-1)*cantidadPorPagina
                };
                xmlCliente.onreadystatechange = function(){
                    if (this.readyState==4 && this.status==200) {
                        let clientes = JSON.parse(this.response);
                        if (clientes[0]==undefined || clientes[0]['cantidad']<5) {
                            btnPaginacionClienteIzquierda.style.display='none';
                            btnPaginacionClienteDerecha.style.display='none';
                        }
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
        document.querySelector("#cliente > div:nth-child(1) > input").addEventListener('input', ()=>{
            paginaActualCliente = actCantidadDeCliente()>0?1:0;
            mostrarClientes();
        })
    }


    if (document.getElementById('personal'))
    {
        //Cosas necesarias para crear y mostrar los Empleados
        const divPersonal = document.getElementById('empleados');
        const templatePersonal = document.querySelector('#templatePersonal').content;
        const fragmentPersonal = document.createDocumentFragment();
        const mostrarPersonal = function()
        {
            let btnPaginacionPersonalIzquierda=document.querySelector('#personal div.pagination li:first-of-type');
            let btnPaginacionPersonalDerecha=document.querySelector('#personal div.pagination li:last-of-type');
            paginaActualPersonal==1?btnPaginacionPersonalIzquierda.style.display='none':btnPaginacionPersonalIzquierda.style.display='inline';
            paginaActualPersonal==Math.ceil(paginaTotalPersonal)?btnPaginacionPersonalDerecha.style.display='none':btnPaginacionPersonalDerecha.style.display='inline';
            if (paginaActualPersonal==0) {
                btnPaginacionPersonalIzquierda.style.display='none';
                btnPaginacionPersonalDerecha.style.display='none';
            }
            if (paginaActualPersonal!=0) {
                let xmlPersonal = new XMLHttpRequest();
                xmlPersonal.overrideMimeType('text/xml');
                const data={
                    texto: document.querySelector('#personal > div > input[type=text]').value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualPersonal-1)*cantidadPorPagina
                };
                xmlPersonal.onreadystatechange = function()
                {
                    if (this.readyState==4 && this.status==200)
                    {
                        let empleados = JSON.parse(this.response);
                        if (empleados[0]==undefined || empleados[0]['cantidad']<5) {
                            btnPaginacionPersonalIzquierda.style.display='none';
                            btnPaginacionPersonalDerecha.style.display='none';
                        }
                        empleados.forEach(empleados =>{
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
        document.querySelector('#personal > div > input').addEventListener('input',()=>{
            paginaActualPersonal = actCantidadDePersonal()>0?1:0;
            mostrarPersonal();   
        });
    }


    if (document.getElementById('categoriasProduct'))
    {
        //Cosas necesarias para crear y mostrar las Categorias
        const divCategorias = document.getElementById('catProduct');
        const templateCategoria = document.querySelector('#templateCategoria').content;
        const fragmentCategorias = document.createDocumentFragment();
        const mostrarCategorias = function()
        {
            let btnPaginacionCategoriasIzquierda=document.querySelector('#categoriasProduct div.pagination li:first-of-type');
            let btnPaginacionCategoriasDerecha=document.querySelector('#categoriasProduct div.pagination li:last-of-type');
            paginaActualCategorias==1?btnPaginacionCategoriasIzquierda.style.display="none":btnPaginacionCategoriasIzquierda.style.display="inline";
            paginaActualCategorias==Math.ceil(paginaTotalCategorias)?btnPaginacionCategoriasDerecha.style.display='none':btnPaginacionCategoriasDerecha.style.display='inline';
            if (paginaActualCategorias==0){
                btnPaginacionCategoriasIzquierda.style.display="none";
                btnPaginacionCategoriasDerecha.style.display='none';
            }
            if (paginaActualCategorias!=0){
                let xmlCat = new XMLHttpRequest();
                xmlCat.overrideMimeType('text/xml');
                const data={
                    texto: document.querySelector('#categoriasProduct > div > input[type=text]').value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualCategorias-1)*cantidadPorPagina
                };
                xmlCat.onreadystatechange = function()
                {
                    if (this.readyState== 4 && this.status ==200){
                        let categoriasProducto = JSON.parse(this.response);
                        if (categoriasProducto[0]==undefined || categoriasProducto[0]['cantidad']<5) {
                            btnPaginacionCategoriasIzquierda.style.display='none';
                            btnPaginacionCategoriasDerecha.style.display='none';
                        }
                        categoriasProducto.forEach(categoria =>{
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
        document.querySelector('#categoriasProduct > div > input[type=text]').addEventListener('input', ()=>{
            paginaActualCategorias = actCantidadDeCategorias()>0?1:0;
            mostrarCategorias();
        })
    }
    
});//Fin de DOMContentLoaded