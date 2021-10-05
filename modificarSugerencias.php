<!DOCTYPE html>
<?php
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Ver sugerencia');
    echo '<main>';
    $pdo=pdo_conectar_mysql();
    $idSugerenciaSeleccionada=isset($_GET['idSugerencia']) ? $_GET['idSugerencia']:0;
    if($idSugerenciaSeleccionada<0) {
        ?>
        <div id="actualizar">
            <h2 style="text-align:center">ID Inexistente</h2>
            <div>
                <a href="pagempleado.php"><button>Volver</button></a>
            </div>
        </div>
        <?php
    }else {
        $sqlCantidad=$pdo->query("SELECT COUNT(idOpinion) as cantidad FROM opiniones WHERE idOpinion='".$idSugerenciaSeleccionada."'")->fetch(PDO::FETCH_ASSOC);
        $sqlCantidad=$sqlCantidad['cantidad'];
        if ($sqlCantidad==1) {
            $sql=$pdo->prepare("SELECT * FROM opiniones WHERE idOpinion=?");
            $sql->execute([$idSugerenciaSeleccionada]);
            $sugerencia=$sql->fetch(PDO::FETCH_ASSOC);
            ?>
            <div id="actualizar" class="eliminarSugerencia">
                <h2>Eliminar Sugerencia de: <u><?=$sugerencia['nombreOpinion']?></u></h2>
                <div>
                    <form id="form">
                        <label for="idSugerencia">ID</label>
                        <p id="idSugerencia"><?=$sugerencia['idOpinion']?></p>
                        <label for="nameSugerencia">Nombre:</label>
                        <p id="nameSugerencia"><?=$sugerencia['nombreOpinion']?></p>
                        <label for="emailSugerencia">Correo:</label>
                        <p id="emailSugerencia"><?=$sugerencia['correoOpinion']?></p>
                        <label for="fechaSugerencia">Fecha:</label>
                        <p id="fechaSugerencia"><?=$sugerencia['fecha']?></p>
                        <label for="sugerencia">Sugerencia:</label>
                        <textarea id="sugerencia" readonly><?=$sugerencia['Opinion']?></textarea>
                        <input type="submit" value="Eliminar" id="btnEliminarSugerencia">
                        <button id="btnCancelarEliminar">Volver</button>
                    </form>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div id="actualizar">
                <h2 style="text-align:center">ID Inexistente</h2>
                <div>
                    <a href="pagempleado.php"><button>Volver</button></a>
                </div>
            </div>
            <?php
        }
    }
    echo '</main>';
    include_once 'Assets/footer.php';
?>
<link rel="stylesheet" href="Style/CRUDStyles.css">
<script src="JavaScript/functionCRUD.js"></script>