<?php
    session_start();
    if (isset($_SESSION['user']['idRol'])) {
        include_once 'BD/conBD.php';
        include_once 'Assets/header.php';
        mostrarHeader('Modificar Clientes');
        echo '<main>'; 
        $pdo=pdo_conectar_mysql();
        $idClienteSeleccionada=isset($_GET['idCliente']) ? $_GET['idCliente'] : 0;
        if ($idClienteSeleccionada>0) {
            $sql=$pdo->prepare('SELECT cliente.*, ciudad.Nombre as Ciudad, departamento.Nombre as Departamento FROM cliente JOIN ciudad ON cliente.idCiudad=ciudad.idCiudad JOIN departamento ON ciudad.idDepartamento=departamento.idDepartamento WHERE RUT=?');
            $sql->execute([$idClienteSeleccionada]);
            $cliente=$sql->fetch(PDO::FETCH_ASSOC);
            if (!isset($_GET['delete'])) {
                if(isset($cliente['RUT'])){
                ?>
                    <div id="actualizar" class="actualizarCliente">
                        <h2>Actualizar Cliente <?=$cliente['NombreEmpresa']?></h2>
                        <div>
                            <form id="form">
                                <label for="rut">RUT:</label>
                                <p id="rut"><?=$cliente['RUT']?></p>
                                <label for="nombreEmpresa">Nombre de la Empresa:</label>
                                <p id="nombreEmpresa"><?=$cliente['NombreEmpresa']?></p>
                                <label for="correoEmpresa">Correo de la empresa:</label>
                                <p id="correoEmpresa"><?=$cliente['CorreoCliente']?></p>
                                <label for="codigoPostal">Código Postal:</label>
                                <p id="codigoPostal"><?=$cliente['CodigoPostal']?></p>
                                <label for="calleDir">Nombre de Calle:</label>
                                <p id="calleDir"><?=$cliente['CalleDir']?></p>
                                <label for="calleNumero">Número de Calle:</label>
                                <p id="calleNumero"><?=$cliente['NumeroDir']?></p>
                                <label for="departamento">Departamento:</label>
                                <p id="departamento"><?=$cliente['Departamento']?></p>
                                <label for="ciudad">Ciudad:</label>
                                <p id="ciudad"><?=$cliente['Ciudad']?></p>
                                <input id="activo" type="checkbox" value="<?=$cliente['Activo']?>" <?=$cliente['Activo']==1? 'checked': ''?>>
                                <label class="checkbox" for="activo">Cuenta Activa:</label>
                                
                                <input id="btnEnviar" type="submit" value="Actualizar">
                            </form>
                        </div>
                        <div class="insertarAca"></div>
                    </div>
                <?php
                }
            }else{
                ?>
                <div id="actualizar" class="eliminarCliente">
                    <h2>¿Esta seguro que desea eliminar <u><?=$cliente['NombreEmpresa']?></u>?</h2>
                    <div>
                        <label for="idCliente">RUT:</label>
                        <p id="idCliente"><?=$cliente['RUT']?></p>
                        <label for="nameCliente">Nombre:</label>
                        <p id="nameCliente"><?=$cliente['NombreEmpresa']?></p>
                        <input type="submit" value="Eliminar" id="btnEliminarCliente">
                        <button id="btnCancelarEliminar">No</button>
                    </div>
                </div>
                <?php
            }
        }
        echo '</main>';
        include_once 'Assets/footer.php';
    ?>
    <div id="divEmergente"></div>

    <link rel="stylesheet" href="Style/CRUDStyles.css">
    <script src="JavaScript/mod-Cliente.js"></script>
<?php 
    }else {
        header("Location: index.php");
    }    
?>