<!DOCTYPE html>
<script src="JavaScript/functionCRUD.js"></script>
<?php 
    session_start();
    include_once 'Assets/header.php';
    include_once 'BD/conBD.php';
    $idRolSeleccionada=$_GET['idRol']!=0 ? $_GET['idRol'] : 0;
    //Comprobar si se le dio al boton de agregar
    if ($idRolSeleccionada==0) { 
        ?>
            <div id="actualizar" class="ingresarRol">
                <h2>Insertar Nuevo Rol</h2>
                <div>
                    <label for="Name">Nombre:</label>
                    <input type="text" name="Rol" placeholder="Nombre de Rol" id="Name">
                    <input id="btnEnviar" type="submit" value="Insertar">
                </div>
                <div class="insertarAca"></div>
            </div>
        <?php
    }else if($idRolSeleccionada<0){
        ?>
            <div id="actualizar">
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
            <div id="actualizar" class="actualizarRol">
                <h2>Actualizar Rol <?=$rol['idRol']?></h2>
                <div>
                    <label for="idRol">ID</label>
                    <label for="Name">Nombre</label>
                    <input type="text" name="idRol" placeholder="<?=$rol['idRol']?>" value="<?=$rol['idRol']?>" id="idRol" readonly>
                    <input type="text" name="Rol" placeholder="<?=$rol['Rol']?>" value="<?=$rol['Rol']?>" id="Name">
                    <input id="btnEnviar" type="submit" value="Actualizar">
                </div>
                <div class="insertarAca"></div>
            </div>
            <?php
        }else{
            ?>
            <div id="actualizar" class="eliminarRol">
                <h2>¿Esta seguro que desea eliminar <u><?=$rol['Rol']?></u>?</h2>
                <div>
                    <label for="idRol">ID</label>
                    <label for="nameRol">Rol</label>
                    <p id="idRol"><?=$rol['idRol']?></p>
                    <p id="nameRol"><?=$rol['Rol']?></p>
                    <input type="submit" value="Eliminar" id="btnEliminarRol">
                    <button id="btnCancelarEliminar">No</button>
                </div>
                <div class="insertarAca"></div>
            </div>
            <?php
        }
    }
?>
<link rel="stylesheet" href="Style/CRUDStyles.css">