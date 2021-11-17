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
const agregarCategoria = function(){
    let name = document.getElementById('Name').value;
    name= name.trim();
    if (name!='') {
        const data = {
            categoria: document.getElementById('Name').value,
            insert: true
        };
        XML.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                if (this.response) {
                    mostrarMensaje('Insertado Correctamente');
                }else{mostrarMensaje('Error al momento de Insertar')}
            }
        };
        XML.open('POST', 'ajax/categories-mod.php');
        XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XML.send(JSON.stringify(data));
    }else{
        mostrarMensaje('El texto no puede estar vacío');
    }
}

const actualizarCategoria = function(){
    let name = document.getElementById('Name').value;
    name = name.trim();
    if (name!='') {
        let namePlaceholder = document.getElementById('Name').placeholder;
        if (name!=namePlaceholder) {
            const data = {
                idCategoria: document.getElementById('idCategoria').value,
                categoria: document.getElementById('Name').value,
                insert: false
            };
            XML.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if (this.response) {
                        mostrarMensaje('Actualizado Correctamente.');
                        document.getElementById('Name').placeholder = document.getElementById('Name').value;
                    }else{mostrarMensaje('Actualización Incorrecta')}
                }
            };
            XML.open('POST', 'ajax/categories-mod.php');
            XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            XML.send(JSON.stringify(data));
        }else{
            mostrarMensaje('Intenta guardar el mismo texto que el actual');
        }
    }else{mostrarMensaje('El texto no puede estar vacío');}
}

const eliminarCategoria = function(){
    const data = {
        idCategoria: document.getElementById('idCategoria').textContent,
        delete: true
    };
    XML.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            if (this.response) {
                mostrarMensaje('Eliminado Correctamente');
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar')}
        }
    };
    XML.open('POST', 'ajax/categories-mod.php');
    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XML.send(JSON.stringify(data));
}

if (document.querySelector('.ingresarCategoria')!=null) {
    document.getElementById('btnEnviar').addEventListener('click',agregarCategoria);
}
if (document.querySelector('.actualizarCategoria')!=null) {
    document.getElementById('btnEnviar').addEventListener('click',actualizarCategoria);
}
if (document.querySelector('.eliminarCategoria')!=null) {
    document.getElementById('btnCancelarEliminar').addEventListener('click',()=>{window.location="pagempleado.php";});
    document.getElementById('btnEliminarCategoria').addEventListener('click', eliminarCategoria);
}