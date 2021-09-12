'use strict';
const re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
document.addEventListener('DOMContentLoaded', ()=>{
    document.getElementById('login').addEventListener('submit',(e)=>{
        e.preventDefault();
        login();
    });
});

const mostrarMensaje = function(msg, claseCss){
    //Crear el div
    const div = document.createElement('div');
    div.className = `divEmergente ${claseCss}`;
    div.appendChild(document.createTextNode(msg));
    //Mostrar en el DOM
    const contenedor = document.getElementById('login');
    const label = document.querySelector('#login label:first-of-type');
    contenedor.insertBefore(div, label);
    //Eliminar el div del DOM a los 3 segundos
    setTimeout(function() {
        document.querySelector('.divEmergente').remove();
    }, 4000);
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
                        // mostrarMensaje('Inicio Sesion', 'eCorrecto');
                        document.getElementById('loginDerecha').style.pointerEvents='none';
                        setTimeout(function() {window.location="index.php";}, 4000);
                    }else if(this.response==2){
                        mostrarMensaje('Cuenta no activada', 'ePrecaucion');
                    }else if(this.response==3 || this.response==4){
                        mostrarMensaje('Correo y/o contraseña equivocada', 'eIncorrecto')
                    }
                }
            }
            xml.open('POST', 'ajax/comprobarLogin.php', true);
            xml.send(JSON.stringify(data))

        }else{mostrarMensaje('No ha ingresao una contraseña','eIncorrecto')}
    }else{mostrarMensaje('No ha ingresado un email valido','eIncorrecto')}
}