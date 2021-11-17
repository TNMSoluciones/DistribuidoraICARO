let timeoutID, timeoutID2, timeoutIDpasswdFail, timeoutIDpasswdFail2, timeoutIDnombreCalle, timeoutIDnumeroCalle, timeoutpasswdNueva, timeoutpasswdAntigua, timeoutIDsName, timeoutIDlName;
let mapa;
let marcadores = [];
const selectCiudades = document.getElementById('ciudades');
const templateCiudades = document.getElementById('templateCiudad').content;
const fragmentCiudades = document.createDocumentFragment();
function initMap() {
    coord = { lat: parseFloat(latitud), lng: parseFloat(longitud)};
    mapa = new google.maps.Map(document.getElementById("mapa"), {
        center: coord,
        zoom: 10,
    });
    const marcador = new google.maps.Marker({
        position: {lat: parseFloat(latitud), lng: parseFloat(longitud)},
        map: mapa
    });
    marcadores.push(marcador)
    mapa.addListener('click', (e) => {
        agregarMarcador(e.latLng);
    });
}
function agregarMarcador(position) {
    eliminarMarcadores()
    const marcador = new google.maps.Marker({
        position: position,
        map: mapa
    });
    marcadores.push(marcador);
}
function eliminarMarcadores() {
    mostrarMarcadores(null);
    marcadores = []
}
function mostrarMarcadores(mapa) {
    for (let i = 0; i < marcadores.length; i++) {
        marcadores[i].setMap(mapa);
    }
}


document.getElementById('form').addEventListener('submit', e => {
    e.preventDefault();
    const user = document.getElementById('nombreCalle')!=null;
    const nameN = document.getElementById('name').value;
    const passwdA = document.getElementById('passwdAntigua').value;
    const passwdN = document.getElementById('passwdNueva').value;
    const passwdN2 = document.getElementById('passwdNueva2').value;
    const coordenadas = marcadores[0]==undefined?null: JSON.stringify(marcadores[0].internalPosition, null, 2)
    const data = {
        nameN,
        passwdA,
        passwdN,
        passwdN2,
        lat: JSON.parse(coordenadas)!=null?JSON.parse(coordenadas).lat:null,
        lng: JSON.parse(coordenadas)!=null?JSON.parse(coordenadas).lng:null
    }
    if (user) {
        const nombreCalle = document.getElementById('nombreCalle').value;
        const numeroCalle = document.getElementById('numeroCalle').value;
        const departamento = document.getElementById('departamentos').value;
        const ciudad = document.getElementById('ciudades').value;
        if (nombreCalle!=''&&numeroCalle!='') {
            data.nombreCalle=nombreCalle;
            data.numeroCalle=numeroCalle;
            data.departamento=departamento;
            data.ciudad=ciudad;
        }else{
            if (nombreCalle=='') {
                document.getElementById('nombreCalle').classList.add('errorCantidad');
                typeof timeoutIDnombreCalle=="number"?clearTimeout(timeoutIDnombreCalle):'';
                timeoutIDnombreCalle = setTimeout(()=>{document.getElementById('nombreCalle').classList.remove('errorCantidad');}, 3000)
            }
            if (numeroCalle=='') {
                document.getElementById('numeroCalle').classList.add('errorCantidad');
                typeof timeoutIDnumeroCalle=="number"?clearTimeout(timeoutIDnumeroCalle):'';
                timeoutIDnumeroCalle = setTimeout(()=>{document.getElementById('numeroCalle').classList.remove('errorCantidad');}, 3000)
            }
            scrollTo(0,181)
            mostrarMensaje("No pueden haber campos vacíos.", 3000);
            return;
        }
    }else {
        if (document.getElementById('sName')!=null) {
            const segundoNombre = document.getElementById('sName').value;
            const apellido = document.getElementById('lName').value;
            if (apellido!='') {
                data.segundoNombre=segundoNombre;
                data.apellido=apellido;
            }else {
                document.getElementById('lName').classList.add('errorCantidad');
                typeof timeoutIDlName=="number"?clearTimeout(timeoutIDlName):'';
                timeoutIDlName = setTimeout(()=>{document.getElementById('lName').classList.remove('errorCantidad');}, 3000)
                scrollTo(0,181)
                mostrarMensaje("No pueden haber campos vacíos.", 3000);
                return;
            }
            
        }
    }
    if (nameN!='') {
        if (passwdA!='') {
            if (passwdN.length>5&&passwdN2.length>5 && passwdA.length>0) {
                if (!(passwdN!=''&&passwdN==passwdN2)) {
                    scrollTo(0,181)
                    document.getElementById('passwdNueva').classList.add('errorCantidad');
                    typeof timeoutIDpasswdFail=="number"?clearTimeout(timeoutIDpasswdFail):'';
                    timeoutIDpasswdFail = setTimeout(()=>{document.getElementById('passwdNueva').classList.remove('errorCantidad');}, 3000)
                    document.getElementById('passwdNueva2').classList.add('errorCantidad');
                    typeof timeoutIDpasswdFail2=="number"?clearTimeout(timeoutIDpasswdFail2):'';
                    timeoutIDpasswdFail = setTimeout(()=>{document.getElementById('passwdNueva2').classList.remove('errorCantidad');}, 3000)
                    mostrarMensaje("Las contraseñas a cambiar deben ser iguales.", 3000);
                    return;
                }
                if (passwdN.search(' ')!=-1) {
                    scrollTo(0,181)
                    document.getElementById('passwdNueva').classList.add('errorCantidad');
                    typeof timeoutIDpasswdFail=="number"?clearTimeout(timeoutIDpasswdFail):'';
                    timeoutIDpasswdFail = setTimeout(()=>{document.getElementById('passwdNueva').classList.remove('errorCantidad');}, 3000)
                    document.getElementById('passwdNueva2').classList.add('errorCantidad');
                    typeof timeoutIDpasswdFail2=="number"?clearTimeout(timeoutIDpasswdFail2):'';
                    timeoutIDpasswdFail = setTimeout(()=>{document.getElementById('passwdNueva2').classList.remove('errorCantidad');}, 3000)
                    mostrarMensaje('Las contraseñas no deben poseer espacios.', 3000);
                    return
                }
            }else {
                scrollTo(0,181)
                document.getElementById('passwdNueva').classList.add('errorCantidad');
                typeof timeoutIDpasswdFail=="number"?clearTimeout(timeoutIDpasswdFail):'';
                timeoutIDpasswdFail = setTimeout(()=>{document.getElementById('passwdNueva').classList.remove('errorCantidad');}, 3000)
                document.getElementById('passwdNueva2').classList.add('errorCantidad');
                typeof timeoutIDpasswdFail2=="number"?clearTimeout(timeoutIDpasswdFail2):'';
                timeoutIDpasswdFail = setTimeout(()=>{document.getElementById('passwdNueva2').classList.remove('errorCantidad');}, 3000)
                mostrarMensaje("La contraseña deben tener 6 o mas carácteres.", 3000);
                return;
            }
        }
    }else {
        mostrarMensaje("No pueden haber campos vacíos.", 3000);
        return;
    }
    let XML = new XMLHttpRequest();
    XML.overrideMimeType('text/xml');
    XML.onreadystatechange = function() {
        if (this.status==200 && this.readyState==4) {
            if (this.response==1) {
                mostrarMensaje("Guardado Correctamente, para aplicarlos, recargue la página.", 12000);
            }else if(this.response==2) {
                mostrarMensaje("Las contraseñas deben ser iguales, inténtelo nuevamente.", 3000)
            }else if(this.response==3) {
                scrollTo(0,181)
                document.getElementById('passwdAntigua').classList.add('errorCantidad');
                typeof timeoutpasswdAntigua=="number"?clearTimeout(timeoutpasswdAntigua):'';
                timeoutpasswdAntigua = setTimeout(()=>{document.getElementById('passwdAntigua').classList.remove('errorCantidad');}, 3000)
                mostrarMensaje("Contraseña incorrecta, inténtelo nuevamente.", 3000)
            }else if(this.response==4) {
                scrollTo(0,181)
                document.getElementById('passwdAntigua').classList.add('errorCantidad');
                typeof timeoutpasswdNueva=="number"?clearTimeout(timeoutpasswdNueva):'';
                timeoutpasswdNueva = setTimeout(()=>{document.getElementById('passwdAntigua').classList.remove('errorCantidad');}, 3000)
                mostrarMensaje("Contraseña incorrecta, inténtelo nuevamente.", 3000)
            }else if(this.response==5) {
                mostrarMensaje("Error desconocido, inténtelo nuevamente.", 3000);
            } 
        }
    }
    XML.open('POST', 'ajax/editarPerfil.php', true);
    XML.send(JSON.stringify(data));
})





const mostrarMensaje = function(msg, time) {
    const divEmergente = document.getElementById("divEmergente");
    divEmergente.textContent=msg;
    divEmergente.classList.add("moverDiv");
    if (typeof timeoutID == "number") {
        clearTimeout(timeoutID);
    }
    timeoutID = setTimeout(()=>{
        divEmergente.classList.remove("moverDiv")
        divEmergente.textContent="";
    }, time)
}
if (document.getElementById('departamentos')!=null) {
    function mostrarCiudad(){
        let xml = new XMLHttpRequest();
        xml.overrideMimeType('text/xml');
        const data ={
            departamentoActual: document.getElementById('departamentos').value,
            ciudadInicial: document.getElementById('ciudades').value
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
    
    document.getElementById('departamentos').addEventListener('change', ()=>{
        mostrarCiudad();
    });
}