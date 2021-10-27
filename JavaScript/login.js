'use strict';
const re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
let timeoutId;
document.addEventListener('DOMContentLoaded', ()=>{
    document.getElementById('login').addEventListener('submit',(e)=>{
        e.preventDefault();
        login();
    });
});

const mostrarMensaje = function(msg) {
    const divEmergente = document.getElementById("divEmergente");
    divEmergente.textContent=msg;
    divEmergente.classList.add("moverDiv");
    if (typeof timeoutId == 'number') {
        clearTimeout(timeoutId);
    }
    timeoutID = setTimeout(()=>{
        divEmergente.classList.remove("moverDiv")
        divEmergente.textContent="";
    }, 3000)
}

const login = function(){
    let email = document.getElementById('email').value;
    let passwd = document.getElementById('password').value;
    let xml = new XMLHttpRequest();
    xml.overrideMimeType('text/xml');
    
    if (email!='' && re.exec(email)) {
        if (passwd!='') {

            const data = {
                email: email,
                password: passwd
            }
            xml.onreadystatechange = function(){
                if (this.status==200 && this.readyState==4) {
                    if (this.response==1) {
                        location.href='index.php';
                        document.getElementById('loginDerecha').style.pointerEvents='none';
                        setTimeout(function() {window.location="index.php";}, 4000);
                    }else if(this.response==2){
                        mostrarMensaje('Cuenta no activada.');
                    }else if(this.response==3 || this.response==4){
                        mostrarMensaje('Correo y/o contraseña equivocada.')
                    }
                }
            }
            xml.open('POST', 'ajax/comprobarLogin.php', true);
            xml.send(JSON.stringify(data))

        }else{mostrarMensaje('No ha ingresado una contraseña.')}
    }else{mostrarMensaje('No ha ingresado un email valido.')}
}