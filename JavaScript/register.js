'use strict';
const re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
const selectCiudades = document.getElementById('ciudadEmpresa');
const templateCiudades = document.getElementById('templateCiudad').content;
const fragmentCiudades = document.createDocumentFragment();
let timeoutId;

document.addEventListener('DOMContentLoaded',()=>{
    mostrarCiudad();
    document.getElementById('departamentoEmpresa').addEventListener('change', ()=>{
        mostrarCiudad();
    });
    document.getElementById('formRegister').addEventListener('submit', (e)=>{
        e.preventDefault();
        registar();
    });

});




const mostrarMensaje = function(msg, time) {
    const divEmergente = document.getElementById("divEmergente");
    divEmergente.textContent=msg;
    divEmergente.classList.add("moverDiv");
    typeof timeoutID == 'number' ? clearTimeout(timeoutID):'';
    timeoutID = setTimeout(()=>{
        divEmergente.classList.remove("moverDiv")
        divEmergente.textContent="";
    }, time)
}

function mostrarCiudad(){
    let xml = new XMLHttpRequest();
    xml.overrideMimeType('text/xml');
    const data ={
        departamentoActual: document.getElementById('departamentoEmpresa').value
    }
    xml.onreadystatechange = function (){
        if (this.status==200 && this.readyState==4){
            let ciudades=JSON.parse(this.response);
            ciudades.forEach(ciudad => {
                templateCiudades.querySelector('option').value=ciudad.idCiudad;
                templateCiudades.querySelector('option').textContent=ciudad.Nombre;
                const clon =templateCiudades.cloneNode(true);
                fragmentCiudades.appendChild(clon);
            });            
            selectCiudades.innerHTML=``;
            selectCiudades.appendChild(fragmentCiudades);
        }
    }
    xml.open('POST', 'ajax/mostrarCiudadesSegunDepartamento.php', true);
    xml.send(JSON.stringify(data));
}

function registar(){
    let xml = new XMLHttpRequest();
    xml.overrideMimeType('text/xml');
    let nombreEmpresa = document.getElementById('nameEmpresa').value.trim();
    let emailEmpresa = document.getElementById('correoEmpresa').value.trim();
    let passwd = document.getElementById('passwordEmpresa').value;
    let passwdConfirm = document.getElementById('passwordConfirmEmpresa').value;
    let ciudad = document.getElementById('ciudadEmpresa').value;
    let calle = document.getElementById('direccionEmpresa').value;
    let numCalle = document.getElementById('direccionNumEmpresa').value;
    let codigoPostal = document.getElementById('postalEmpresa').value;
    let rutEmpresa = document.getElementById('rutEmpresa').value;
    if (nombreEmpresa!=''&&emailEmpresa!=''&&passwd!=''&&passwdConfirm!=''&&ciudad!=''&&calle!=''&&numCalle!=''&&codigoPostal!='') {
        if (re.exec(emailEmpresa)) {
            if (Number.isInteger(parseFloat(codigoPostal))&&codigoPostal.length==5) {
                if (Number.isInteger(parseFloat(rutEmpresa))&&rutEmpresa.length==12) {
                    if (passwd.search(' ')==-1) {
                        if (passwd.length>5) {
                            if (passwd==passwdConfirm) {
                                const data = {
                                    nombreEmpresa: nombreEmpresa,
                                    correoEmpresa: emailEmpresa,
                                    password: passwd,
                                    RUT: rutEmpresa,
                                    ciudad: ciudad,
                                    calle: calle,
                                    numCalle: numCalle,
                                    codigoPostal: codigoPostal
                                }
                                xml.onreadystatechange = function() {
                                    if (this.readyState==4 && this.status==200) {
                                        if (this.response=='1') {
                                            mostrarMensaje('Registrado correctamente, espere a que activen su cuenta.', 15000);
                                            enviarMail(nombreEmpresa, emailEmpresa);
                                        }else if(this.response=='2'){
                                            mostrarMensaje('Error al momento de insertar', 3000);
                                        }else if(this.response=='3'){
                                            mostrarMensaje('Correo ya registrado', 3000);
                                        }else if(this.response=='4'){mostrarMensaje('RUT ya registrado', 3000)}
                                    }
                                }
                                xml.open('POST', 'ajax/guardarRegister.php', true);
                                xml.send(JSON.stringify(data));

                            }else{mostrarMensaje('Las contraseñas no coinciden.', 3000)}
                        }else{mostrarMensaje('La contrasela debe tener mas de 6 caracteres.', 3000)}
                    }else{mostrarMensaje('Las contraseñas no deben poseer espacios.', 3000)}
                }else{mostrarMensaje('RUT invalido.', 3000)}
            }else{mostrarMensaje('Codigo postal invalido.', 3000)}
        }else{mostrarMensaje('Ha ingresado un correo invalido.', 3000)}
    }else{mostrarMensaje('No deben haber campos vacios.', 3000)}
}

const enviarMail = function(nombreEmpresaMail, emailEmpresaMail){
    let xmlMail = new XMLHttpRequest();
    xmlMail.overrideMimeType('text/xml');
    const dataMail = {
        nombreEmpresa: nombreEmpresaMail,
        correoEmpresa: emailEmpresaMail,
        forma: 'register'
    }
    xmlMail.onreadystatechange = function() {
        if(this.readyState==4 && this.status==200) {
            console.log(this.response);
        }
    }
    xmlMail.open('POST', 'Assets/mail.php', true);
    xmlMail.send(JSON.stringify(dataMail));
}

const numeros = /^([0-9])/;
const num = document.getElementById('direccionNumEmpresa');
const postal = document.getElementById('postalEmpresa');

postal.addEventListener('input', () => {
    !numeros.exec(postal.value.slice(-1)) ? postal.value = postal.value.slice(0,-1):'';
    postal.value.length>5? postal.value = postal.value.slice(0, -1):''
});
num.addEventListener('input', () => {
    !numeros.exec(num.value.slice(-1)) ? num.value = num.value.slice(0,-1):'';
    num.value.length>5? num.value = num.value.slice(0, -1):''
});