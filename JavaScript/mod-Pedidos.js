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

const actualizarPedido = function(){
    const idPedido = document.getElementById('idPedido').textContent;
    let activoActual = document.getElementById('activo').value;
    activoActual = activoActual==1?true:false;
    const activar = document.getElementById('activo').checked;
    if (activoActual!=activar) {
        const data = {
            activo: activar,
            idPedido: idPedido,
            delete: false
        }
        XML.onreadystatechange = function() {
            if (this.readyState==4 && this.status==200) {
                if (this.response) {
                    mostrarMensaje('Actualizado Correctamente');
                    document.getElementById('activo').value = activar ? 1 : 0;
                    const name = document.getElementById('nameEmpresa').textContent;
                    const email = document.getElementById('correoEmpresa').textContent;
                    document.getElementById('activo').value==1?enviarMail(name, email):'';
                }else{mostrarMensaje('No se logró actualizar')}
            }
        }
        XML.open('POST', 'ajax/pedidos-mod.php', true);
        XML.send(JSON.stringify(data));
    }
}
const eliminarPedido = function(){
    const data = { 
        idPedido: document.getElementById('idPedido').textContent,
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
    XML.open('POST', 'ajax/pedidos-mod.php');
    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XML.send(JSON.stringify(data));
}
const enviarMail = function(nombreEmpresaMail, emailEmpresaMail){
    let xmlMail = new XMLHttpRequest();
    xmlMail.overrideMimeType('text/xml');
    const dataMail = {
        nombreEmpresa: nombreEmpresaMail,
        correoEmpresa: emailEmpresaMail,
        forma: 'pedido'
    }
    xmlMail.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200) {
            console.log(this.response);
        }
    }
    xmlMail.open('POST', 'Assets/mail.php', true);
    xmlMail.send(JSON.stringify(dataMail));
}

if (document.querySelector('.actualizarPedido')!=null) {
    document.getElementById('form').addEventListener('submit', e => {
        e.preventDefault();
        e.submitter.id=='btnEnviar'?actualizarPedido():'';
    })
}
if (document.querySelector('.eliminarPedido')!=null) {
    document.getElementById('form').addEventListener('submit', e => {
        e.preventDefault();
        e.submitter.id=='btnEliminarPedido'?eliminarPedido():'';
        e.submitter.id=='btnCancelarEliminar'?history.go(-1):'';
    })
}