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

const eliminarSugerencia = function() {
    XML.onreadystatechange = function() {
        if (this.status==200 && this.readyState==4) {
            if (this.response) {
                mostrarMensaje('Eliminado Correctamente', 'eCorrecto');
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
        }
    };
    const data = {
        delete: true,
        idSugerencia: document.getElementById('idSugerencia').textContent
    };
    XML.open('POST', 'ajax/sugerencias-mod.php', true);
    XML.send(JSON.stringify(data));
}

if(document.querySelector('.eliminarSugerencia')!=null) {
    document.getElementById('form').addEventListener('submit', e =>{
        e.preventDefault();
            e.submitter.id=='btnCancelarEliminar'?window.location="pagempleado.php":'';
            e.submitter.id=='btnEliminarSugerencia'?eliminarSugerencia():'';
        })
    }

