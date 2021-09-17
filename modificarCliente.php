<!DOCTYPE html>
<?php
    session_start();
    include_once 'Assets/header.php';
    mostrarHeader('Modificar Clientes');
    include_once 'BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $idClienteSeleccionada=isset($_GET['idCliente']) ? $_GET['idCliente'] : 0;
    if ($idClienteSeleccionada>0) {
        $sql=$pdo->prepare('SELECT cliente.*, ciudad.Nombre as Ciudad, departamento.Nombre as Departamento FROM cliente JOIN ciudad ON cliente.idCiudad=ciudad.idCiudad JOIN departamento ON ciudad.idDepartamento=departamento.idDepartamento WHERE idCliente=?');
        $sql->execute([$idClienteSeleccionada]);
        $cliente=$sql->fetch(PDO::FETCH_ASSOC);
        if (!isset($_GET['delete'])) {
            //Cuando le da a actualizar
            if(isset($cliente['idCliente'])){
            ?>
                <div id="actualizar" class="actualizarCliente">
                    <h2>Actualizar Cliente <?=$cliente['NombreEmpresa']?></h2>
                    <div>
                        <form id="form">
                            <label for="idEmpresa">ID:</label>
                            <p id="idEmpresa"><?=$cliente['idCliente']?></p>
                            <label for="nombreEmpresa">Nombre de la Empresa:</label>
                            <label for="correoEmpresa">Correo de la empresa:</label>
                            <p id="nombreEmpresa"><?=$cliente['NombreEmpresa']?></p>
                            <p id="correoEmpresa"><?=$cliente['CorreoCliente']?></p>
                            <label for="rut">RUT:</label>
                            <label for="codigoPostal">Codigo Postal:</label>
                            <p id="rut"><?=$cliente['RUT']?></p>
                            <p id="codigoPostal"><?=$cliente['CodigoPostal']?></p>
                            <label for="calleDir">Nombre de Calle:</label>
                            <label for="calleNumero">Numero de Calle:</label>
                            <p id="calleDir"><?=$cliente['CalleDir']?></p>
                            <p id="calleNumero"><?=$cliente['NumeroDir']?></p>
                            <label for="departamento">Departamento:</label>
                            <label for="ciudad">Ciudad:</label>
                            <p id="departamento"><?=$cliente['Departamento']?></p>
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
                    <label for="idCliente">ID</label>
                    <label for="nameCliente">Nombre</label>
                    <p id="idCliente"><?=$cliente['idCliente']?></p>
                    <p id="nameCliente"><?=$cliente['NombreEmpresa']?></p>
                    <input type="submit" value="Eliminar" id="btnEliminarCliente">
                    <button id="btnCancelarEliminar">No</button>
                </div>
            </div>
            <?php
        }
    }
    include_once 'Assets/footer.php';
?>


<link rel="stylesheet" href="Style/CRUDStyles.css">
<script src="JavaScript/functionCRUD.js"></script>