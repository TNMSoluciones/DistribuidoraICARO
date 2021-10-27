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
const actualizarCliente = function(){
    let activoActual = document.getElementById('activo').value;
    activoActual = activoActual==1?true:false;
    let activar = document.getElementById('activo').checked;
    if (activoActual !== activar) {
        const data = {
            activo: activar,
            idCliente: document.getElementById('idEmpresa').textContent,
            delete: false
        }
        XML.onreadystatechange = function(){
            if (this.readyState == 4 && this.status==200) {
                if (this.response) {
                    mostrarMensaje('Actualizado Correctamente');
                    document.getElementById('activo').value = activar ? 1 : 0;
                    document.getElementById('activo').value == 1?enviarMail(document.getElementById('nombreEmpresa').textContent, document.getElementById('correoEmpresa').textContent):null;
                }else{mostrarMensaje('No se logro actualizar')}
            }
        };
        XML.open('POST', 'ajax/cliente-mod.php', true);
        XML.send(JSON.stringify(data));
    }
}
const eliminarCliente = function(){
    const data = {
        idCliente: document.getElementById('idCliente').textContent,
        delete: true
    };
    XML.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200) {
            if (this.response) {
                mostrarMensaje('Eliminado Correctamente', 'eCorrecto')
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
        }
    };
    XML.open('POST', 'ajax/cliente-mod.php');
    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XML.send(JSON.stringify(data));   
}
const enviarMail = function(nombreEmpresaMail, emailEmpresaMail){
    let xmlMail = new XMLHttpRequest();
    xmlMail.overrideMimeType('text/xml');
    const dataMail = {
        nombreEmpresa: nombreEmpresaMail,
        correoEmpresa: emailEmpresaMail,
        forma: 'cliente'
    }
    xmlMail.open('POST', 'Assets/mail.php', true);
    xmlMail.send(JSON.stringify(dataMail));
}

if (document.querySelector('.actualizarCliente')!=null) {
    document.getElementById('btnEnviar').addEventListener('click',e=>{
        e.preventDefault();
        actualizarCliente();
    });
}
if(document.querySelector('.eliminarCliente')!=null){
    document.getElementById('btnCancelarEliminar').addEventListener('click', ()=>{window.location="pagempleado.php";});
    document.getElementById('btnEliminarCliente').addEventListener('click', eliminarCliente);

}