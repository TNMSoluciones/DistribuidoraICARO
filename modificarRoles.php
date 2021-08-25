<script>
    let XML = new XMLHttpRequest();
    XML.overrideMimeType('text/xml');
    const mostrarMensaje = function(msg, claseCss){
        //Crear el div
        const div = document.createElement('div');
        div.className = `divEmergente ${claseCss}`;
        div.appendChild(document.createTextNode(msg));
        //Mostrar en el DOM
        const contenedor = document.getElementById('actualizarRol');
        const h2 = document.querySelector('h2');
        contenedor.insertBefore(div, h2);
        //Eliminar el div del DOM a los 3 segundos
        setTimeout(function() {
            document.querySelector('.divEmergente').remove();
        }, 4000);
    }

</script>
<?php 
    include_once 'Assets/header.php';
    include_once 'BD/conBD.php';
    $idRolSeleccionada=$_GET['idRol']!=0 ? $_GET['idRol'] : 0;
    //Comprobar si se le dio al boton de agregar
    if ($idRolSeleccionada==0) { 
        ?>
            <div id="actualizarRol">
                <h2>Insertar Nuevo Rol</h2>
                <form id="form" method="POST">
                    <label for="Name">Nombre:</label>
                    <input type="text" name="Rol" placeholder="Nombre de Rol" id="Name">
                    <input id="btnEnviar" type="submit" value="Insertar">
                </form>
            </div>
            <script>
                document.getElementById('form').addEventListener('submit', (e)=>{
                    e.preventDefault();
                    let name = document.getElementById('Name').value;
                    name= name.trim();
                    if (name!='') {
                        const data = {
                            rol: name,
                            insert: true
                        };
                        XML.onreadystatechange = function(){
                            if (this.readyState == 4 && this.status == 200) {
                                if (this.response) {
                                    mostrarMensaje('Insertado Correctamente', 'eCorrecto');
                                }else{mostrarMensaje('Error al momento de Insertar', 'eIncorrecto')}
                            }
                        };
                        XML.open('POST', 'ajax/rol-mod.php');
                        XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        XML.send(JSON.stringify(data));
                    }else{
                        mostrarMensaje('El texto no puede estar vacio!', 'eIncorrecto');
                    }
                });
            </script>
        <?php
    }else if($idRolSeleccionada<0){
        ?>
            <div id="actualizarRol">
                <h2 style="text-align:center">ID Inexistente</h2>
            </div>
        <?php
    }else{
        $pdo=pdo_conectar_mysql();
        $sql=$pdo->prepare('SELECT * FROM roles WHERE idRol=?');
        $sql->execute([$idRolSeleccionada]);
        $rol=$sql->fetch(PDO::FETCH_ASSOC);
        //Comprobar si le dio a delete
        if (!isset($_GET['delete'])) {   
            ?>
            <div id="actualizarRol">
                <h2>Actualizar Rol <?=$rol['idRol']?></h2>
                <form id="form" method="POST">
                    <label for="idRol">ID</label>
                    <label for="Name">Nombre</label>
                    <input type="text" name="idRol" placeholder="<?=$rol['idRol']?>" value="<?=$rol['idRol']?>" id="idRol" readonly>
                    <input type="text" name="Rol" placeholder="<?=$rol['Rol']?>" value="<?=$rol['Rol']?>" id="Name">
                    <input id="btnEnviar" type="submit" value="Actualizar">
                </form>
            </div>
            <script>
                document.getElementById('form').addEventListener('submit', (e)=>{
                    e.preventDefault();
                    let name = document.getElementById('Name').value;
                    name = name.trim();
                    if (name!='') {
                        namePlaceholder = document.getElementById('Name').placeholder;
                        if (name!=namePlaceholder) {
                            const data = {
                                idRol: document.getElementById('idRol').value,
                                rol: name,
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
                            XML.open('POST', 'ajax/rol-mod.php');
                            XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                            XML.send(JSON.stringify(data));
                        }else{
                            mostrarMensaje('Intenta guardar el mismo texto que el actual', 'ePrecaucion');
                        }
                    }else{
                        mostrarMensaje('El texto no puede estar vacio!', 'eIncorrecto');
                    }
                });
            </script>
            <?php
        }else{
            ?>
            <div id="actualizarRol">
                <h2>¿Esta seguro que desea eliminar <?=$rol['Rol']?>?</h2>
                <form method="POST">
                    <label for="idRol">ID</label>
                    <input type="text" name="idRol" placeholder="<?=$rol['idRol']?>" value="<?=$rol['idRol']?>" id="idRol" readonly>
                    <input type="submit" value="Eliminar" id="btnEliminarRol">
                    <button id="btnCancelarEliminar">No</button>
                </form>
            </div>
            <script>
                document.getElementById('btnCancelarEliminar').addEventListener('click',(e)=>{
                    e.preventDefault();
                    window.location="pagempleado.php";
                });
                document.getElementById('btnEliminarRol').addEventListener('click',(e)=>{
                    e.preventDefault();
                    const data = {
                        idRol: document.getElementById('idRol').value,
                        delete: true
                    };
                    XML.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            if (this.response) {
                                mostrarMensaje('Eliminado Correctamente', 'eCorrecto')
                                document.getElementById('actualizarRol').style.pointerEvents='none';
                                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
                            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
                        }
                    };
                    XML.open('POST', 'ajax/rol-mod.php');
                    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    XML.send(JSON.stringify(data));   
                });
            </script>
            <?php
        }
    }
?>


<style>
    #actualizarRol{
        width: 25vw;
        margin: 5vw 0 0 37.5vw;
        font-family: 'Roboto Condensed', sans-serif
    }
    #actualizarRol h2{
        margin: 0;
        padding: 15px 0;
        font-size: 1.6vw;
        border-bottom: 1px solid #e6dfdf;
    }
    #actualizarRol form{padding: 15px 0}
    #actualizarRol form label{
        display: inline-block;
        width: 10vw;
        margin: 10px 2vw 5px 0;
        font-size: 1.2vw;
    }
    #actualizarRol form input{
        padding: 5px 0;
        text-indent: 10px;
        width: 10vw;
        font-size: 100%;
        border: 1px solid #b1acac;
        margin-right: 2vw;
        box-sizing: border-box;
        font-weight: 300;
    }
    #actualizarRol form input:first-of-type:focus-visible{outline: 0}
    #actualizarRol form input[type=submit], #actualizarRol form button {
        display: inline-block;
        background-color: #38b673;
        border: 0;
        font-weight: 700;
        font-size: 1vw;
        color: #FFFFFF;
        cursor: pointer;
        width: 10vw;
        height: 2vw;
        margin-top: 15px;
    }
    #actualizarRol form input[type="submit"]:hover, #actualizarRol form button:hover {background-color: #32a367}
    .divEmergente{
        width: 25vw;
        height: 2vw;
        line-height: 2vw;
        margin: 30px 0 0 0;
        text-indent: 10px;
        color: white;
    }
    .eCorrecto{background: #32a367}
    .eIncorrecto{background: red}
    .ePrecaucion{background: #5564eb}
</style>