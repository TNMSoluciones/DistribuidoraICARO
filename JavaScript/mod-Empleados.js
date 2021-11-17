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

if (document.querySelector('.ingresarEmpleado')!=null) {
    document.getElementById('form').addEventListener('submit',(e)=>{
        e.preventDefault();
        agregarEmpleado();
    });
}
if (document.querySelector('.actualizarEmpleado')!=null) {
    document.getElementById('form').addEventListener('submit',(e)=>{
        e.preventDefault();
        actualizarEmpleado();
    });
}
if (document.querySelector('.eliminarEmpleado')!=null) {
    document.getElementById('btnCancelarEliminar').addEventListener('click',()=>{window.location="pagempleado.php";});
    document.getElementById('btnEliminarPersonal').addEventListener('click', eliminarEmpleado);
}
const agregarEmpleado = function(){
    let fName = document.getElementById('primerNombre').value.trim();
    let sName = document.getElementById('segundoNombre').value.trim();
    let lastName = document.getElementById('apellidoEmpleado').value.trim();
    let email = document.getElementById('email').value.trim();
    let passwd = document.getElementById('passwd').value.trim();
    let passwdConfirm = document.getElementById('passwdConfirm').value.trim();
    let rolPersonal = document.getElementById('rolPersonal').value;
    if (fName!='' && lastName!='' && email!='' && passwd!='' && passwdConfirm!='') {
        if (re.exec(email)) {
            if (passwd.length>7) {
                const data = {
                    fName: fName,
                    sName: sName,
                    lastName: lastName,
                    email: email,
                    passwd: passwd,
                    rolPersonal: rolPersonal,
                    insert: true
                };
                if (passwd==passwdConfirm) {
                    XML.onreadystatechange = function(){
                        if (this.readyState == 4 && this.status == 200) {
                            if (this.response==1) {
                                mostrarMensaje('Insertado correctamente', 'eCorrecto');
                            }else if(this.response==2){
                                mostrarMensaje('Correo ya registrado', 'eIncorrecto');
                            }else{mostrarMensaje('Error al momento de insertar','eIncorrecto')}
                        }
                    };
                    XML.open('POST', 'ajax/personal-mod.php', true);
                    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    XML.send(JSON.stringify(data));
                }else{mostrarMensaje('Las contraseñas no coinciden', 'eIncorrecto')}
            }else{mostrarMensaje('La contraseña debe poseer 8 o mas carácteres','ePrecaucion')}

        }else{mostrarMensaje('Email invalido', 'ePrecaucion')}


    }else{mostrarMensaje('Los campos no pueden estar vacíos', 'eIncorrecto')}
}

const actualizarEmpleado = function(){
    let fName = document.getElementById('primerNombre').value.trim();
    let sName = document.getElementById('segundoNombre').value.trim();
    let lastName = document.getElementById('apellidoEmpleado').value.trim();
    let email = document.getElementById('email').value.trim();
    let passwd = document.getElementById('passwd').value.trim();
    let rolPersonal = document.getElementById('rolPersonal');
    if (fName!=''&&lastName!=''&&email!='') {
        if (passwd.length>7 || passwd.length==0) {
            const data = {
                idPersonal: document.getElementById('idPersonal').value,
                fName: fName,
                sName: sName,
                lastName: lastName,
                email: email,
                passwd: passwd.length==0?'':passwd,
                rolPersonal: rolPersonal.value,
                insert: false
            };
            XML.onreadystatechange = function(){
                if (this.readyState==4&&this.status==200) {
                    if (this.response) {
                        mostrarMensaje("Actualizado correctamente", "eCorrecto");
                    }else{mostrarMensaje('Actualización Incorrecta', 'eIncorrecto')}
                }
            };
            XML.open('POST', 'ajax/personal-mod.php', true);
            XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            XML.send(JSON.stringify(data));
        }else{mostrarMensaje('La contraseña debe poseer 8 caracteres o mas', 'eIncorrecto')}
    }else{mostrarMensaje('Los campos no pueden estar vacíos', 'eIncorrecto')}
}

const eliminarEmpleado = function(){
    const data = {
        idPersonal: document.getElementById('idPersonal').value,
        delete: true
    };
    XML.onreadystatechange = function()
    {
        if(this.readyState == 4 && this.status == 200)
        {
            if (this.response)
            {
                mostrarMensaje('Eliminado Correctamente', 'eCorrecto');
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
        }
    };
    XML.open('POST', 'ajax/personal-mod.php');
    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XML.send(JSON.stringify(data));
}