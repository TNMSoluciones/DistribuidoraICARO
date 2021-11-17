document.addEventListener('DOMContentLoaded', () => {
    let timeoutID;
    const mostrarMensaje = function(msg, time) {
        const divEmergente = document.getElementById("divEmergente");
        divEmergente.innerHTML = msg;
        divEmergente.classList.add("moverDiv");
        if (typeof timeoutID == "number") {
            clearTimeout(timeoutID);
        }
        timeoutID = setTimeout(()=>{
            divEmergente.classList.remove("moverDiv")
            divEmergente.innerHTML="";
        }, time)
    }
    const btnComprar = document.getElementById('btnComprar');
    if (btnComprar!=null) {
        btnComprar.addEventListener('click', e => {
            let metodoPago;
            if (radioBtnEfectivo.checked) {
                metodoPago='Efectivo';
            }else if(radioBtnPOS.checked) {
                metodoPago='POS';
            }else{
                metodoPago=0;
            }
            if (metodoPago!=0) {
                let XML = new XMLHttpRequest();
                XML.overrideMimeType('text/xml');
                XML.onreadystatechange = function() {
                    if (this.status==200 && this.readyState==4) {
                        console.log(this.response);
                        if (this.response==1) {
                            location.href = "pedidoAceptado.php?estado=true";
                        }else if (this.response==2) {
                            mostrarMensaje("Error al comprar, no queda stock suficiente.", 2500);
                        }else if(this.response==3) {   
                            mostrarMensaje("Error, metodo de pago incorrecto.", 2500);
                        }else if(this.response==4) {
                            mostrarMensaje("Debe iniciar sesion para comprar, <a href='login.php'>Ir a iniciar Sesion.</a>", 10000);
                        }else {   
                            mostrarMensaje("Error desconocido.", 2500);
                        }
                    }
                }
                XML.open('POST', 'ajax/nuevoPedido.php', true);
                XML.send(metodoPago);
            }else {
                mostrarMensaje("Debe seleccionar el metodo de pago.", 2500);
            }   
        });//Fin del evento Click al boton de comprar
    }
});//Fin del DOMContentLoaded
