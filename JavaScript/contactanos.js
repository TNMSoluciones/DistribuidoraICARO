'use strict';
const re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
document.addEventListener('DOMContentLoaded',()=>{
    const mostrarMensaje = function(id, msg){
        //Obtener campo correcto
        let placeholder = document.getElementById(id).placeholder;
        let input = document.querySelector('#'+id);
        input.placeholder=msg;
        input.classList.add('formContactoError');
        //Eliminar el div del DOM a los 3 segundos
        setTimeout(function() {
            input.placeholder=placeholder;
            input.classList.remove ('formContactoError');
        }, 4000);
    }
    const comprobarCaracteres = function(){
        const formContacto = document.getElementById('formMsgContacto');
        const cantCar = document.querySelector("#formContacto > p");
        let cantidadCaracteres = formContacto.value.length;
        formContacto.value = formContacto.value.slice(0, 400);
        cantidadCaracteres>399?cantCar.textContent='Caracteres Restantes: 400/400':cantCar.textContent = 'Caracteres Restantes: '+ cantidadCaracteres +'/400';
    }
    document.getElementById('formMsgContacto').addEventListener('input',comprobarCaracteres);

    document.getElementById('formContacto').addEventListener('submit', e=>{
        e.preventDefault();
        let name = document.getElementById('formNameContacto').value;
        let email = document.getElementById('formEmailContacto').value;
        let msg = document.getElementById('formMsgContacto').value;
        let comprobacionUno=false;
        let comprobacionDos=false;
        let comprobacionTres=false;
        name!=''?comprobacionUno=true:mostrarMensaje('formNameContacto','Campo Vacio!');
        email!=''?comprobacionDos=true:mostrarMensaje('formEmailContacto','Campo Vacio!');
        msg!=''?comprobacionTres=true:mostrarMensaje('formMsgContacto','Campo Vacio!');
        if (comprobacionUno&&comprobacionDos&&comprobacionTres) {
            if (re.exec(email)) {
                let today = new Date();
                let fullDate = today.getFullYear() + '-' + (today.getMonth()+1) + '-' + today.getDate();
                const data = {
                    email: email,
                    name: name,
                    opinion: msg,
                    date: fullDate
                }
                let XML = new XMLHttpRequest();
                XML.overrideMimeType('text/xml');
                XML.onreadystatechange = function() {
                    if(this.readyState==4 && this.status==200) {
                        console.log(this.response);
                        if (this.response) {
                            console.log('Si');
                        }else{console.log('No');}
                    }
                }
                XML.open('POST', 'ajax/opinionUser.php', true);
                XML.send(JSON.stringify(data));
            }else{
                document.getElementById('formEmailContacto').value=''
                mostrarMensaje('formEmailContacto', 'Correo Incorrecto!');
            }
        }
    });
});//Fin del DOMContentLoaded