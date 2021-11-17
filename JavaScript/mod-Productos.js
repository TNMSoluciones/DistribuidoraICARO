let XML = new XMLHttpRequest();
XML.overrideMimeType('text/xml');
let timeoutID;
const re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;

const mostrarMensaje = function(msg) {
    const divEmergente = document.getElementById("divEmergente");
    divEmergente.textContent=msg;
    divEmergente.classList.add("moverDiv");
    if (typeof timeoutID == "number") {
        clearTimeout(timeoutID);
    }
    timeoutID = setTimeout(()=>{
        divEmergente.classList.remove("moverDiv")
        divEmergente.textContent="";
    }, 3000)
}

const agregarProducto = function(){
    let nameProduct = document.getElementById('nameProduct').value.trim();
    let stockProduct = document.getElementById('stockProduct').value;
    let priceProduct = document.getElementById('priceProduct').value;
    let imgProduct = document.getElementById('imgProduct').files[0];
    let desc = document.getElementById('descripcion').value;
    if(nameProduct!=''&&stockProduct!=''&&priceProduct!=''&&desc!='')
    {
        if(!isNaN(stockProduct)) {
            if(!isNaN(priceProduct)) {
                if(imgProduct!=undefined) {
                    let extension = imgProduct.name.split('.').pop().toLowerCase();
                    if(extension=='jpg' || extension=='png' || extension=='jpeg') {
                        if(imgProduct.size<50000000) {
                            const form = document.getElementById('form');
                            XML.onreadystatechange = function() {
                                if(this.readyState==4 && this.status==200) {
                                    if (this.response==1) {
                                        mostrarMensaje('Insertado Correctamente', 'eCorrecto');
                                    }else if(this.response==2){
                                        mostrarMensaje('Error al insertar','eIncorrecto');
                                    }else if(this.response==3){
                                        mostrarMensaje('Producto ya registrado', 'eIncorrecto');
                                    }else{mostrarMensaje('Error Desconocido', 'eIncorrecto')}
                                }
                            }
                            XML.open('POST', '../ajax/producto-mod.php', true);
                            XML.send(new FormData(form));                  
                        }else{mostrarMensaje('El archivo no debe pesar más de 5MB.')}
                    }else{mostrarMensaje('La extensión de la imagen es incorrecta', 'eIncorrecto')}
                }else{mostrarMensaje('No ha seleccionado ninguna imagen', 'ePrecaucion')}
            }else{mostrarMensaje('El precio no es un valor numérico','ePrecaucion')}
        }else{mostrarMensaje('El stock no es un valor numérico','ePrecaucion')}
    }else{mostrarMensaje('Los campos no pueden estar vacíos', 'eIncorrecto')}
}
const eliminarProducto = function(){
    XML.onreadystatechange = function(){
        if(this.status==200 && this.readyState==4)
        {
            if(this.response)
            {
                mostrarMensaje('Eliminado Correctamente', 'eCorrecto');
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
        }
    };
    const form = document.getElementById('form');
    XML.open('POST', 'ajax/producto-mod.php', true);
    XML.send(new FormData(form));
}
const actualizarProducto = function(){
    let nameProduct = document.getElementById('nameProduct').value.trim();
    let stockProduct = document.getElementById('stockProduct').value;
    let priceProduct = document.getElementById('priceProduct').value;
    let desc = document.getElementById('descripcion').value;
    if(nameProduct!=''&&stockProduct!=''&&priceProduct!=''&&desc!='') {
        if(!isNaN(stockProduct)) {
            if (!isNaN(priceProduct)) {
                const form = document.getElementById('form');
                XML.onreadystatechange = function() {
                    if(this.readyState==4 && this.status==200) {
                        if (this.response==1) {
                            mostrarMensaje('Actualizado correctamente','eCorrecto');
                        }else if(this.response==2){
                            mostrarMensaje('Error al actualizar','eIncorrecto');
                        }else if(this.response==3){
                            mostrarMensaje('No existe un articulo con dicha id','ePrecaucion');
                        }else{mostrarMensaje('Error desconocido','eIncorrecto')}
                    }
                }
                XML.open('POST', 'ajax/producto-mod.php', true);
                XML.send(new FormData(form));
            }else{mostrarMensaje('El precio debe ser un valor numérico','ePrecaucion')}
        }else{mostrarMensaje('El stock debe ser un valor numérico','ePrecaucion')}
    }else{mostrarMensaje('Los campos no pueden estar vacíos','eIncorrecto')}
}


if (document.querySelector('.ingresarProducto')!=null || document.querySelector('.actualizarProducto')!=null) {
    document.getElementById('imgProduct').addEventListener('change',()=>{
        document.getElementById('inputFileShow').innerHTML = document.getElementById('imgProduct').files[0]!=undefined?document.getElementById('imgProduct').files[0].name:`Adjuntar Archivo`;
    })
}
if (document.querySelector('.ingresarProducto')!=null) {
    document.getElementById('form').addEventListener('submit',(e)=>{
        e.preventDefault();
        agregarProducto();
    });
}
if (document.querySelector('.actualizarProducto')!=null) {
    document.getElementById('form').addEventListener('submit', (e)=>{
        e.preventDefault();
        actualizarProducto();
    });
}
if(document.querySelector('.eliminarProducto')!=null) {
    document.getElementById('form').addEventListener('submit', e =>{
        e.preventDefault();
        e.submitter.id=='btnCancelarEliminar'?window.location="pagempleado.php":'';
        e.submitter.id=='btnEliminarProducto'?eliminarProducto():'';
    });
}