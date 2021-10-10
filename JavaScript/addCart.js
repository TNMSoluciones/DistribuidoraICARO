const mostrarMensaje = function(msg, claseCss){
    //Crear el div
    const div = document.createElement('div');
    div.className = `divEmergente ${claseCss}`;
    div.appendChild(document.createTextNode(msg));
    //Mostrar en el DOM
    const contenedor = document.querySelector('.producto');
    const dondeInsertar = document.querySelector('.divImg');
    contenedor.insertBefore(div, dondeInsertar);
    //Eliminar el div del DOM a los 2 segundos
    setTimeout(function() {
        document.querySelector('.divEmergente').remove();
    }, 2000);
}
if (document.getElementById('btnAddCart')!=undefined) {
    document.getElementById('btnAddCart').addEventListener('click', () => {
        const cantidad = parseInt(document.getElementById('cantidad').value);
        if (cantidad>0) {
            const idProducto = document.querySelector('.producto').id;
            const producto = {
                idProducto,
                cantidad
            }
            let XML = new XMLHttpRequest();
            XML.overrideMimeType('text/xml');
            XML.onreadystatechange = function(){
                if(this.status==200 && this.readyState==4) {
                    switch(this.response){
                        case '1':
                            let cantidad = document.querySelector("#carrito > p").textContent.split(' ')[0] = parseInt(document.querySelector("#carrito > p").textContent.split(' ')[0])+1;
                            document.querySelector("#carrito > p").textContent = ''+cantidad + (cantidad==1?' item':' items')
                            mostrarMensaje('Producto agregado correctamente', 'eCorrecto');
                            break;
                        case '2':
                            mostrarMensaje('Sumado Correctamente', 'eCorrecto')
                            break;
                        case '3':
                            mostrarMensaje('Error al agregar', 'eIncorrecto')
                            break;
                        default:
                            
                    }
                }
            };
            XML.open('POST', 'ajax/modCart.php', true);
            XML.send(JSON.stringify(producto));
        }else {
            document.getElementById('cantidad').classList.add('errorCantidad');
            setTimeout(()=>{document.getElementById('cantidad').classList.remove('errorCantidad');}, 400)
        }
    });
}