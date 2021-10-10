let XML = new XMLHttpRequest();
XML.overrideMimeType('text/xml');
const re=/^([\da-z_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/;
const mostrarMensaje = function(msg, claseCss){
    //Crear el div
    const div = document.createElement('div');
    div.className = `divEmergente ${claseCss}`;
    div.appendChild(document.createTextNode(msg));
    //Mostrar en el DOM
    const contenedor = document.getElementById('actualizar');
    const dondeInsertar = document.querySelector('.insertarAca');
    contenedor.insertBefore(div, dondeInsertar);
    //Eliminar el div del DOM a los 3 segundos
    setTimeout(function() {
        document.querySelector('.divEmergente').remove();
    }, 4000);
}

document.addEventListener('DOMContentLoaded', ()=>{
    if(document.querySelector('.eliminarSugerencia')!=null) {
        document.getElementById('form').addEventListener('submit', e =>{
            e.preventDefault();
            e.submitter.id=='btnCancelarEliminar'?window.location="pagempleado.php":'';
            e.submitter.id=='btnEliminarSugerencia'?eliminarSugerencia():'';
        })
    }

    if (document.querySelector('.ingresarProducto')!=null || document.querySelector('.actualizarProducto')!=null) {
        document.getElementById('imgProduct').addEventListener('change',()=>{
            document.getElementById('inputFileShow').innerHTML = document.getElementById('imgProduct').files[0]!=undefined?document.getElementById('imgProduct').files[0].name:`Adjuntar Archivo`;
        })
    }
    if (document.querySelector('.ingresarProducto')!=null) {
        document.getElementById('form').addEventListener('submit',(e)=>{
            e.preventDefault();
            agregarProducto();
        });
    }
    if (document.querySelector('.actualizarProducto')!=null) {
        document.getElementById('form').addEventListener('submit', (e)=>{
            e.preventDefault();
            actualizarProducto();
        });
    }
    if(document.querySelector('.eliminarProducto')!=null) {
        document.getElementById('form').addEventListener('submit', e =>{
            e.preventDefault();
            e.submitter.id=='btnCancelarEliminar'?window.location="pagempleado.php":'';
            e.submitter.id=='btnEliminarProducto'?eliminarProducto():'';
        });
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


    if (document.querySelector('.ingresarCategoria')!=null) {
        document.getElementById('btnEnviar').addEventListener('click',agregarCategoria);
    }
    if (document.querySelector('.actualizarCategoria')!=null) {
        document.getElementById('btnEnviar').addEventListener('click',actualizarCategoria);
    }
    if (document.querySelector('.eliminarCategoria')!=null) {
        document.getElementById('btnCancelarEliminar').addEventListener('click',()=>{window.location="pagempleado.php";});
        document.getElementById('btnEliminarCategoria').addEventListener('click', eliminarCategoria);
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
});

const eliminarSugerencia = function() {
    XML.onreadystatechange = function() {
        if (this.status==200 && this.readyState==4) {
            if (this.response) {
                mostrarMensaje('Eliminado Correctamente', 'eCorrecto');
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
        }
    };
    const data = {
        delete: true,
        idSugerencia: document.getElementById('idSugerencia').textContent
    };
    XML.open('POST', 'ajax/sugerencias-mod.php', true);
    XML.send(JSON.stringify(data));
}

const eliminarProducto = function(){
    XML.onreadystatechange = function(){
        if(this.status==200 && this.readyState==4)
        {
            if(this.response)
            {
                mostrarMensaje('Eliminado Correctamente', 'eCorrecto');
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
        }
    };
    const form = document.getElementById('form');
    XML.open('POST', 'ajax/producto-mod.php', true);
    XML.send(new FormData(form));
}
const actualizarProducto = function(){
    let nameProduct = document.getElementById('nameProduct').value.trim();
    let stockProduct = document.getElementById('stockProduct').value;
    let priceProduct = document.getElementById('priceProduct').value;
    let desc = document.getElementById('descripcion').value;
    if(nameProduct!=''&&stockProduct!=''&&priceProduct!=''&&desc!='') {
        if(!isNaN(stockProduct)) {
            if (!isNaN(priceProduct)) {
                const form = document.getElementById('form');
                XML.onreadystatechange = function() {
                    if(this.readyState==4 && this.status==200) {
                        if (this.response==1) {
                            mostrarMensaje('Actualizado correctamente','eCorrecto');
                        }else if(this.response==2){
                            mostrarMensaje('Error al actualizar','eIncorrecto');
                        }else if(this.response==3){
                            mostrarMensaje('No existe un articulo con dicha id','ePrecaucion');
                        }else{mostrarMensaje('Error desconocido','eIncorrecto')}
                    }
                }
                XML.open('POST', 'ajax/producto-mod.php', true);
                XML.send(new FormData(form));
            }else{mostrarMensaje('El precio debe ser un valor numerico','ePrecaucion')}
        }else{mostrarMensaje('El stock debe ser un valor numerico','ePrecaucion')}
    }else{mostrarMensaje('Los campos no pueden estar vacios','eIncorrecto')}
}

const agregarProducto = function(){
    let nameProduct = document.getElementById('nameProduct').value.trim();
    let stockProduct = document.getElementById('stockProduct').value;
    let priceProduct = document.getElementById('priceProduct').value;
    let imgProduct = document.getElementById('imgProduct').files[0];
    let desc = document.getElementById('descripcion').value;
    if(nameProduct!=''&&stockProduct!=''&&priceProduct!=''&&desc!='')
    {
        if(!isNaN(stockProduct))
        {
            if(!isNaN(priceProduct))
            {
                if(imgProduct!=undefined)
                {
                    let extension = imgProduct.name.split('.').pop().toLowerCase();
                    if(extension=='jpg' || extension=='png' || extension=='jpeg')
                    {
                        if(imgProduct.size<50000000)
                        {
                            const form = document.getElementById('form');
                            XML.onreadystatechange = function()
                            {
                                if(this.readyState==4 && this.status==200) {
                                    if (this.response==1) {
                                        mostrarMensaje('Insertado Correctamente', 'eCorrecto');
                                    }else if(this.response==2){
                                        mostrarMensaje('Error al insertar','eIncorrecto');
                                    }else if(this.response==3){
                                        mostrarMensaje('Producto ya registrado', 'eIncorrecto');
                                    }else{mostrarMensaje('Error Desconocido', 'eIncorrecto')}
                                }
                            }
                            XML.open('POST', 'ajax/producto-mod.php', true);
                            XML.send(new FormData(form));                  
                        }else{mostrarMensaje('El archivo no debe pesar mas de 5MB.')}
                    }else{mostrarMensaje('La extension de la imagen es incorrecta', 'eIncorrecto')}
                }else{mostrarMensaje('No ha seleccionado ninguna imagen', 'ePrecaucion')}
            }else{mostrarMensaje('El precio no es un valor numerico','ePrecaucion')}
        }else{mostrarMensaje('El stock no es un valor numerico','ePrecaucion')}
    }else{mostrarMensaje('Los campos no pueden estar vacios!', 'eIncorrecto')}
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
                    mostrarMensaje('Actualizado Correctamente', 'eCorrecto');
                    document.getElementById('activo').value = activar ? 1 : 0;
                    document.getElementById('activo').value == 1?enviarMail(document.getElementById('nombreEmpresa').textContent, document.getElementById('correoEmpresa').textContent):null;
                }else{mostrarMensaje('No se logro actualizar', 'eIncorrecto')}
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
        if(this.readyState == 4 && this.status == 200){
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
        activa: true
    }
    xmlMail.open('POST', 'Assets/mail.php', true);
    xmlMail.send(JSON.stringify(dataMail));
}

const agregarCategoria = function(){
    let name = document.getElementById('Name').value;
    name= name.trim();
    if (name!='') {
        const data = {
            categoria: document.getElementById('Name').value,
            insert: true
        };
        XML.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                if (this.response) {
                    mostrarMensaje('Insertado Correctamente', 'eCorrecto');
                }else{mostrarMensaje('Error al momento de Insertar', 'eIncorrecto')}
            }
        };
        XML.open('POST', 'ajax/categories-mod.php');
        XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        XML.send(JSON.stringify(data));
    }else{
        mostrarMensaje('El texto no puede estar vacio!', 'eIncorrecto');
    }
}

const actualizarCategoria = function(){
    let name = document.getElementById('Name').value;
    name = name.trim();
    if (name!='') {
        let namePlaceholder = document.getElementById('Name').placeholder;
        if (name!=namePlaceholder) {
            const data = {
                idCategoria: document.getElementById('idCategoria').value,
                categoria: document.getElementById('Name').value,
                insert: false
            };
            XML.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    if (this.response) {
                        mostrarMensaje('Actualizacion Correcta', 'eCorrecto');
                        document.getElementById('Name').placeholder = document.getElementById('Name').value;
                    }else{mostrarMensaje('Actualizacion Incorrecta', 'eIncorrecto')}
                }
            };
            XML.open('POST', 'ajax/categories-mod.php');
            XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            XML.send(JSON.stringify(data));
        }else{
            mostrarMensaje('Intenta guardar el mismo texto que el actual', 'ePrecaucion');
        }
    }else{mostrarMensaje('El texto no puede estar vacio!', 'eIncorrecto');}
}

const eliminarCategoria = function(){
    const data = {
        idCategoria: document.getElementById('idCategoria').textContent,
        delete: true
    };
    XML.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){
            if (this.response) {
                mostrarMensaje('Eliminado Correctamente', 'eCorrecto');
                document.getElementById('actualizar').style.pointerEvents='none';
                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
        }
    };
    XML.open('POST', 'ajax/categories-mod.php');
    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    XML.send(JSON.stringify(data));
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
            }else{mostrarMensaje('La contraseña debe poseer 8 o mas caracteres','ePrecaucion')}

        }else{mostrarMensaje('Email invalido', 'ePrecaucion')}


    }else{mostrarMensaje('Los campos no pueden estar vacios!', 'eIncorrecto')}
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
                    }else{mostrarMensaje('Actualizacion Incorrecta', 'eIncorrecto')}
                }
            };
            XML.open('POST', 'ajax/personal-mod.php', true);
            XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            XML.send(JSON.stringify(data));
        }else{mostrarMensaje('La contraseña debe poseer 8 caracteres o mas', 'eIncorrecto')}
    }else{mostrarMensaje('Los campos no pueden estar vacios', 'eIncorrecto')}
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