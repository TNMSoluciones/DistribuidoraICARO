<script>
    let XML = new XMLHttpRequest();
    XML.overrideMimeType('text/xml');
    const mostrarMensaje = function(msg, claseCss){
        //Crear el div
        const div = document.createElement('div');
        div.className = `divEmergente ${claseCss}`;
        div.appendChild(document.createTextNode(msg));
        //Mostrar en el DOM
        const contenedor = document.getElementById('actualizarCats');
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
    $idCatSeleccionada=$_GET['idCategoria']!=0 ? $_GET['idCategoria'] : 0;
    //Comprobar si se le dio al boton de agregar
    if ($idCatSeleccionada==0) { 
        ?>
            <div id="actualizarCats">
                <h2>Insertar Nueva Categoria</h2>
                <form id="form" method="POST">
                    <label for="Name">Nombre:</label>
                    <input type="text" name="Categoria" placeholder="Nombre de Categoria" id="Name">
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
                        XML.open('POST', 'ajax/product-mod.php');
                        XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                        XML.send(JSON.stringify(data));
                    }else{
                        mostrarMensaje('El texto no puede estar vacio!', 'eIncorrecto');
                    }
                });
            </script>
        <?php
    }else if($idCatSeleccionada<0){
        ?>
            <div id="actualizarCats">
                <h2 style="text-align:center">ID Inexistente</h2>
            </div>
        <?php
    }else{
        $pdo=pdo_conectar_mysql();
        $sql=$pdo->prepare('SELECT * FROM categorias WHERE idCategoria=?');
        $sql->execute([$idCatSeleccionada]);
        $categoria=$sql->fetch(PDO::FETCH_ASSOC);
        //Si le dio a delete
        if (!isset($_GET['delete'])) {   
            ?>
            <div id="actualizarCats">
                <h2>Actualizar Categoria <?=$categoria['idCategoria']?></h2>
                <form id="form" method="POST">
                    <label for="idCategoria">ID</label>
                    <label for="Name">Nombre</label>
                    <input type="text" name="idCategoria" placeholder="<?=$categoria['idCategoria']?>" value="<?=$categoria['idCategoria']?>" id="idCategoria" readonly>
                    <input type="text" name="Categoria" placeholder="<?=$categoria['Categoria']?>" value="<?=$categoria['Categoria']?>" id="Name">
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
                            XML.open('POST', 'ajax/product-mod.php');
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
            <div id="actualizarCats">
                <h2>¿Esta seguro que desea eliminar <?=$categoria['Categoria']?>?</h2>
                <form method="POST">
                    <label for="idCategoria">ID</label>
                    <input type="text" name="idCategoria" placeholder="<?=$categoria['idCategoria']?>" value="<?=$categoria['idCategoria']?>" id="idCategoria" readonly>
                    <input type="submit" value="Eliminar" id="btnEliminarCategoria">
                    <button id="btnCancelarEliminar">No</button>
                </form>
            </div>
            <script>
                document.getElementById('btnCancelarEliminar').addEventListener('click',(e)=>{
                    e.preventDefault();
                    window.location="pagempleado.php";
                });
                document.getElementById('btnEliminarCategoria').addEventListener('click',(e)=>{
                    e.preventDefault();
                    const data = {
                        idCategoria: document.getElementById('idCategoria').value,
                        delete: true
                    };
                    XML.onreadystatechange = function(){
                        if(this.readyState == 4 && this.status == 200){
                            if (this.response) {
                                mostrarMensaje('Eliminado Correctamente', 'eCorrecto');
                                document.getElementById('actualizarCats').style.pointerEvents='none';
                                setTimeout(()=>{window.location="pagempleado.php";}, 4000);
                            }else{mostrarMensaje('No se pudo eliminar', 'eIncorrecto')}
                        }
                    };
                    XML.open('POST', 'ajax/product-mod.php');
                    XML.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    XML.send(JSON.stringify(data));
                });
            </script>
            <?php
        }
    }
?>


<style>
    #actualizarCats{
        width: 25vw;
        margin: 5vw 0 0 37.5vw;
        font-family: 'Roboto Condensed', sans-serif
    }
    #actualizarCats h2{
        margin: 0;
        padding: 15px 0;
        font-size: 1.6vw;
        border-bottom: 1px solid #e6dfdf;
    }
    #actualizarCats form{padding: 15px 0}
    #actualizarCats form label{
        display: inline-block;
        width: 10vw;
        margin: 10px 2vw 5px 0;
        font-size: 1.2vw;
    }
    #actualizarCats form input{
        padding: 5px 0;
        text-indent: 10px;
        width: 10vw;
        font-size: 100%;
        border: 1px solid #b1acac;
        margin-right: 2vw;
        box-sizing: border-box;
        font-weight: 300;
    }
    #actualizarCats form input:first-of-type:focus-visible{outline: 0}
    #actualizarCats form input[type=submit], #actualizarCats form button {
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
    #actualizarCats form input[type="submit"]:hover, #actualizarCats form button:hover {background-color: #32a367}
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