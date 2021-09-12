<!DOCTYPE html>
<?php 
    session_start();    
    include_once 'Assets/header.php';
    mostrarHeader('Modificar Categorias');
    include_once 'BD/conBD.php';
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
        //Si le dio a delete
        if (!isset($_GET['delete'])) {   
            ?>
            <div id="actualizar" class="actualizarCategoria">
                <h2>Actualizar Categoria <?=$categoria['idCategoria']?></h2>
                <div>
                    <label for="idCategoria">ID</label>
                    <label for="Name">Nombre</label>
                    <input type="text" name="idCategoria" placeholder="<?=$categoria['idCategoria']?>" value="<?=$categoria['idCategoria']?>" id="idCategoria" readonly>
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
                    <label for="idCategoria">ID</label>
                    <label for="nameCategoria">Nombre</label>
                    <p id="idCategoria"><?=$categoria['idCategoria']?></p>
                    <p id="nameCategoria"><?=$categoria['Categoria']?></p>
                    <input type="submit" value="Eliminar" id="btnEliminarCategoria">
                    <button id="btnCancelarEliminar">No</button>
                </div>
                <div class="insertarAca"></div>
            </div>
            <?php
        }
    }
    ?>
<link rel="stylesheet" href="Style/CRUDStyles.css">
<script src="JavaScript/functionCRUD.js"></script>