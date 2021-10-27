<?php 
    session_start();    
    if (isset($_SESSION['user']['idRol'])) {
        include_once 'BD/conBD.php';
        include_once 'Assets/header.php';
        mostrarHeader('Modificar Categorias');
        echo '<main>';
        $idCatSeleccionada=$_GET['idCategoria']!=0 ? $_GET['idCategoria'] : 0;
        //Comprobar si se le dio al boton de agregar
        if ($idCatSeleccionada==0) { 
            ?>
                <div id="actualizar" class="ingresarCategoria">
                    <h2>Insertar Nueva Categoria</h2>
                    <div>
                        <label for="Name">Nombre:</label>
                        <input type="text" name="Categoria" placeholder="Nombre de Categoria" id="Name">
                        <input id="btnEnviar" type="submit" value="Insertar">
                    </div>
                    <div class="insertarAca"></div>
                </div>
                <?php
        }else if($idCatSeleccionada<0){
            ?>
                <div id="actualizar">
                    <h2 style="text-align:center">ID Inexistente</h2>
                </div>
                <?php
        }else{
            $pdo=pdo_conectar_mysql();
            $sql=$pdo->prepare('SELECT * FROM categorias WHERE idCategoria=?');
            $sql->execute([$idCatSeleccionada]);
            $categoria=$sql->fetch(PDO::FETCH_ASSOC);
            if (!isset($_GET['delete'])) {   
                ?>
                <div id="actualizar" class="actualizarCategoria">
                    <h2>Actualizar Categoria <?=$categoria['idCategoria']?></h2>
                    <div>
                        <label for="idCategoria">ID:</label>
                        <input type="text" name="idCategoria" placeholder="<?=$categoria['idCategoria']?>" value="<?=$categoria['idCategoria']?>" id="idCategoria" readonly>
                        <label for="Name">Nombre:</label>
                        <input type="text" name="Categoria" placeholder="<?=$categoria['Categoria']?>" value="<?=$categoria['Categoria']?>" id="Name">
                        <input id="btnEnviar" type="submit" value="Actualizar">
                    </div>
                    <div class="insertarAca"></div>
                </div>
                <?php
            }else{
                ?>
                <div id="actualizar" class="eliminarCategoria">
                    <h2>¿Esta seguro que desea eliminar <u><?=$categoria['Categoria']?></u>?</h2>
                    <div>
                        <label for="idCategoria">ID:</label>
                        <p id="idCategoria"><?=$categoria['idCategoria']?></p>
                        <label for="nameCategoria">Nombre:</label>
                        <p id="nameCategoria"><?=$categoria['Categoria']?></p>
                        <input type="submit" value="Eliminar" id="btnEliminarCategoria">
                        <button id="btnCancelarEliminar">No</button>
                    </div>
                    <div class="insertarAca"></div>
                </div>
                <?php
            }
        }
        echo '</main>';
        include_once 'Assets/footer.php';
    ?>
    <div id="divEmergente"></div>
    <link rel="stylesheet" href="Style/CRUDStyles.css">
    <script src="JavaScript/mod-Categorias.js"></script>
<?php 
    }else {
        header("Location: index.php");
    }    
?>