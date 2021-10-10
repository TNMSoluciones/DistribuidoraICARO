document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('btnComprar').addEventListener('click', () => {
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
                    switch(this.response){
                        case 1: 
                            document.querySelector('#carrito > p').textContent = '0 items'
                            console.log('Correcto');
                            break;
                        case 2: console.log('Falso');
                            break;
                        case 3: console.log('3');
                            break;
                    }
                }
            }
            XML.open('POST', 'ajax/nuevoPedido.php', true);
            XML.send(metodoPago);
        }
    });//Fin del evento Click al boton de comprar
});//Fin del DOMContentLoaded