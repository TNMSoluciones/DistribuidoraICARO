'use strict';
document.addEventListener('DOMContentLoaded',()=>{
    const cantidadPorPagina = 10;
    //Variables
    let paginaActualCategorias = actCantidadDeCategorias()>0?1:0;
    let paginaActualPersonal = actCantidadDePersonal()>0?1:0;
    let paginaActualCliente = actCantidadDeCliente()>0?1:0;
    let paginaActualProducto = actCantidadDeProductos()>0?1:0;
    let paginaActualSugerencias = actCantidadDeSugerencias()>0?1:0;
    let paginaActualVentas = actCantidadDeVentas()>0?1:0;
    let keyUpInterval;
    
    if (document.getElementById('encargado')) {
        const divVentas = document.getElementById('pedido');
        const templateVentas = document.getElementById('templateVentas').content;
        const fragmentVentas = document.createDocumentFragment();
        const mostrarVentas = function() {
            const btnPaginacionVentasIzquierda = document.querySelector('#encargado div.pagination li:first-of-type')
            const btnPaginacionVentasDerecha = document.querySelector('#encargado div.pagination li:last-of-type');
            if (cantidadDeVentas>0) {
                let xmlVentas = new XMLHttpRequest();
                xmlVentas.overrideMimeType('text/xml');
                const data = {
                    texto: document.querySelector('#encargado > div >input[type=text]').value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualVentas-1)*cantidadPorPagina
                };
                xmlVentas.onreadystatechange = function() {
                    if (this.readyState==4 && this.status==200) {
                        let ventas = JSON.parse(this.response);
                        paginaActualVentas>1?btnPaginacionVentasIzquierda.style.display="inline":btnPaginacionVentasIzquierda.style.display='none';
                        if (ventas[0]!=undefined) {
                            paginaActualVentas<Math.ceil(ventas[0]['cantidad']/cantidadPorPagina)?btnPaginacionVentasDerecha.style.display="inline":btnPaginacionVentasDerecha.style.display='none';
                        }else {
                            btnPaginacionVentasDerecha.style.display='none'
                            btnPaginacionVentasIzquierda.style.display='none'
                        }
                        ventas.forEach(venta => {
                            templateVentas.querySelector('.comprasEncargado div h3:first-of-type').textContent =  venta.nombre;
                            templateVentas.querySelector('.comprasEncargado div h3:nth-of-type(2)').textContent = venta.fecha;
                            templateVentas.querySelector('.comprasEncargado div h3:nth-of-type(3)').textContent = venta.precio;
                            templateVentas.querySelector('.comprasEncargado div h3:nth-of-type(4)').textContent = venta.metodo;
                            templateVentas.querySelector('.comprasEncargado div a.btnEliminarVentas').setAttribute('href', `modificarPedido.php?idPedido=${venta.idPedido}&delete=true`);
                            templateVentas.querySelector('.comprasEncargado div a.btnModificarVentas').setAttribute('href', `modificarPedido.php?idPedido=${venta.idPedido}`);
                            const clon = templateVentas.cloneNode(true);
                            fragmentVentas.appendChild(clon);
                        })
                        divVentas.innerHTML=``;
                        divVentas.appendChild(fragmentVentas);
                    }
                }
                xmlVentas.open('POST','ajax/pedidos-mostrar.php', true);
                xmlVentas.send(JSON.stringify(data));
            }
        }
        mostrarVentas();
        document.querySelector('#btnPagVentasD').addEventListener('click', ()=>{
            paginaActualVentas++;
            mostrarVentas();
        });
        document.querySelector('#btnPagVentasI').addEventListener('click', ()=>{
            paginaActualVentas--;
            mostrarVentas();
        });
        document.querySelector("#encargado > div:nth-child(1) > input").addEventListener("keyup", function() {
            clearInterval(keyUpInterval);
            keyUpInterval = setInterval(function(){
                paginaActualVentas = actCantidadDeVentas()>0?1:0
                mostrarVentas();
                clearInterval(keyUpInterval);
            }, 800);
        }, false);
    }
    if (document.getElementById('productos')) {
        const divProductos = document.getElementById('product');
        const templateProductos = document.getElementById('templateProductos').content;
        const fragmentProductos = document.createDocumentFragment();
        const mostrarProductos = function() {
            let btnPaginacionProductoIzquierda = document.querySelector('#productos div.pagination li:first-of-type');
            let btnPaginacionProductoDerecha = document.querySelector('#productos div.pagination li:last-of-type');
            if(cantidadDeProductos>0){
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
                        paginaActualProducto>1?btnPaginacionProductoIzquierda.style.display='inline':btnPaginacionProductoIzquierda.style.display='none';
                        if (productos[0]!=undefined) {
                            paginaActualProducto<Math.ceil(productos[0]['cantidad']/cantidadPorPagina)?btnPaginacionProductoDerecha.style.display="inline":btnPaginacionProductoDerecha.style.display='none';
                        }else {
                            btnPaginacionProductoIzquierda.style.display='none'
                            btnPaginacionProductoDerecha.style.display='none'
                        }
                        productos.forEach(producto =>{
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
        mostrarProductos();
        document.querySelector('#btnPagProductoD').addEventListener('click', ()=>{
            paginaActualProducto++;
            mostrarProductos();
        });
        document.querySelector('#btnPagProductoI').addEventListener('click', ()=>{
            paginaActualProducto--;
            mostrarProductos();
        });
        document.querySelector("#productos > div:nth-child(1) > input").addEventListener('keyup',()=>{
            clearInterval(keyUpInterval);
            keyUpInterval = setInterval(function(){
                paginaActualProducto = actCantidadDeProductos()>0?1:0
                mostrarProductos();
                clearInterval(keyUpInterval);
            }, 800);
        }, false);
    }
    if (document.getElementById('sugerencias')) {
        const divSugerencias = document.getElementById('sugerencia');
        const templateSugerencias = document.getElementById('templateSugerencias').content;
        const fragmentSugerencias = document.createDocumentFragment();
        const mostrarSugerencias = function(){
            let btnPaginacionSugerenciasIzquierda = document.querySelector('#sugerencias div.pagination li:first-of-type');
            let btnPaginacionSugerenciasDerecha = document.querySelector('#sugerencias div.pagination li:last-of-type');
            if (cantidadDeSugerencias>0) {
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
                        paginaActualSugerencias>1?btnPaginacionSugerenciasIzquierda.style.display='inline':btnPaginacionSugerenciasIzquierda.style.display='none';
                        if(sugerencias[0]==undefined){
                            paginaActualSugerencias>Math.ceil(sugerencias[0]['cantidad']/cantidadPorPagina)?btnPaginacionSugerenciasDerecha.style.display='inline':btnPaginacionSugerenciasDerecha.style.display='none';
                        } else {
                            btnPaginacionSugerenciasDerecha.style.display='none'
                            btnPaginacionSugerenciasIzquierda.style.display='none'
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
        mostrarSugerencias();
        document.querySelector('#btnPagSugD').addEventListener('click', ()=>{
            paginaActualSugerencias++;
            mostrarSugerencias();
        });
        document.querySelector('#btnPagSugI').addEventListener('click', ()=>{
            paginaActualSugerencias--;
            mostrarSugerencias();
        });
        document.querySelector("#sugerencias > div:nth-child(1) > input").addEventListener("keyup", function() {
            clearInterval(keyUpInterval);
            keyUpInterval = setInterval(function(){
                paginaActualSugerencias = actCantidadDeSugerencias()>0?1:0
                mostrarSugerencias();
                clearInterval(keyUpInterval);
            }, 800);
        }, false);
    }
    


    if (document.getElementById('cliente')) {
        const divCliente = document.getElementById('client');
        const templateCliente = document.getElementById('templateClientes').content;
        const fragmentCliente = document.createDocumentFragment();
        const mostrarClientes = function() {
            let btnPaginacionClienteIzquierda=document.querySelector('#cliente div.pagination li:first-of-type');
            let btnPaginacionClienteDerecha=document.querySelector('#cliente div.pagination li:last-of-type');
            if(cantidadDeCliente>0){
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
                        paginaActualCliente>1?btnPaginacionClienteIzquierda.style.display="inline":btnPaginacionClienteIzquierda.style.display='none';
                        if (clientes[0]!=undefined) {
                            paginaActualCliente<Math.ceil(clientes[0]['cantidad']/cantidadPorPagina)?btnPaginacionClienteDerecha.style.display="inline":btnPaginacionClienteDerecha.style.display='none';
                        }else {
                            btnPaginacionClienteDerecha.style.display='none'
                            btnPaginacionClienteIzquierda.style.display='none'
                        }
                        clientes.forEach(cliente => {
                            console.log(cliente);
                                templateCliente.querySelector('.clientesEncargado div h3:first-of-type').textContent=cliente.nombreEmpresa;
                                templateCliente.querySelector('.clientesEncargado div h3:nth-of-type(2)').textContent=cliente.correoEmpresa;
                                templateCliente.querySelector('.clientesEncargado div h3:nth-of-type(3)').textContent=cliente.idCliente;
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
        mostrarClientes();
        document.querySelector('#btnPagClienteD').addEventListener('click', ()=>{
            paginaActualCliente++;
            mostrarClientes();
        });
        document.querySelector('#btnPagClienteI').addEventListener('click', ()=>{
            paginaActualCliente--;
            mostrarClientes();
        });
        document.querySelector("#cliente > div:nth-child(1) > input").addEventListener('keyup', ()=>{
            clearInterval(keyUpInterval);
            keyUpInterval = setInterval(function(){
                paginaActualCliente = actCantidadDeCliente()>0?1:0
                mostrarClientes();
                clearInterval(keyUpInterval);
            }, 800);
        }, false);
    }


    if (document.getElementById('personal')) {
        const divPersonal = document.getElementById('empleados');
        const templatePersonal = document.querySelector('#templatePersonal').content;
        const fragmentPersonal = document.createDocumentFragment();
        const mostrarPersonal = function() {
            let btnPaginacionPersonalIzquierda=document.querySelector('#personal div.pagination li:first-of-type');
            let btnPaginacionPersonalDerecha=document.querySelector('#personal div.pagination li:last-of-type');
            if (cantidadDePersonal>0) {
                let xmlPersonal = new XMLHttpRequest();
                xmlPersonal.overrideMimeType('text/xml');
                const data={
                    texto: document.querySelector('#personal > div > input[type=text]').value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualPersonal-1)*cantidadPorPagina
                };
                xmlPersonal.onreadystatechange = function() {
                    if (this.readyState==4 && this.status==200) {
                        let empleados = JSON.parse(this.response);
                        paginaActualPersonal>1?btnPaginacionPersonalIzquierda.style.display="inline":btnPaginacionPersonalIzquierda.style.display='none';
                        if (empleados[0]!=undefined) {
                            paginaActualPersonal<Math.ceil(empleados[0]['cantidad']/cantidadPorPagina)?btnPaginacionPersonalDerecha.style.display="inline":btnPaginacionPersonalDerecha.style.display='none';
                        }else {
                            btnPaginacionPersonalDerecha.style.display='none'
                            btnPaginacionPersonalIzquierda.style.display='none'
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
        mostrarPersonal();
        document.querySelector('#btnPagPersonalD').addEventListener('click', ()=>{
            paginaActualPersonal++;
            mostrarPersonal();
        });
        document.querySelector('#btnPagPersonalI').addEventListener('click', ()=>{
            paginaActualPersonal--;
            mostrarPersonal();
        });
        document.querySelector('#personal > div > input').addEventListener("keyup", function() {
            clearInterval(keyUpInterval);
            keyUpInterval = setInterval(function(){
                paginaActualPersonal = actCantidadDePersonal()>0?1:0
                mostrarPersonal();
                clearInterval(keyUpInterval);
            }, 800);
        }, false);
    }


    if (document.getElementById('categoriasProduct')) {
        const divCategorias = document.getElementById('catProduct');
        const templateCategoria = document.querySelector('#templateCategoria').content;
        const fragmentCategorias = document.createDocumentFragment();
        const mostrarCategorias = function() {
            let btnPaginacionCategoriasIzquierda=document.querySelector('#categoriasProduct div.pagination li:first-of-type');
            let btnPaginacionCategoriasDerecha=document.querySelector('#categoriasProduct div.pagination li:last-of-type');
            if (cantidadDeCategorias>0){
                let xmlCat = new XMLHttpRequest();
                xmlCat.overrideMimeType('text/xml');
                const data={
                    texto: document.querySelector('#categoriasProduct > div > input[type=text]').value,
                    datosPorPagina: cantidadPorPagina,
                    paginaActual: (paginaActualCategorias-1)*cantidadPorPagina
                };
                xmlCat.onreadystatechange = function() {
                    if (this.readyState== 4 && this.status ==200){
                        let categoriasProducto = JSON.parse(this.response);
                        paginaActualCategorias>1?btnPaginacionCategoriasIzquierda.style.display="inline":btnPaginacionCategoriasIzquierda.style.display='none';
                        if (categoriasProducto[0]!=undefined) {
                            paginaActualCategorias<Math.ceil(categoriasProducto[0]['cantidad']/cantidadPorPagina)?btnPaginacionCategoriasDerecha.style.display="inline":btnPaginacionCategoriasDerecha.style.display='none';
                        }else {
                            btnPaginacionCategoriasDerecha.style.display='none'
                            btnPaginacionCategoriasIzquierda.style.display='none'
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
        mostrarCategorias();
        document.querySelector('#btnPagCatD').addEventListener('click', ()=>{
            paginaActualCategorias++;
            mostrarCategorias();
        });
        document.querySelector('#btnPagCatI').addEventListener('click', ()=>{
            paginaActualCategorias--;
            mostrarCategorias();
        });
        document.querySelector('#categoriasProduct > div > input[type=text]').addEventListener("keyup", function() {
            clearInterval(keyUpInterval);
            keyUpInterval = setInterval(function(){
                paginaActualCategorias = actCantidadDeCategorias()>0?1:0
                mostrarCategorias();
                clearInterval(keyUpInterval);
            }, 800);
        }, false);
    }
    
});//Fin de DOMContentLoaded