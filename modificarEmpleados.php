<?php
    session_start();
    if (isset($_SESSION['user']['idRol'])) {
        include_once 'BD/conBD.php';
        include_once 'Assets/header.php';
        mostrarHeader('Modificar Empleados');
        echo '<main>';
        $pdo=pdo_conectar_mysql();
        $idEmpleadoSeleccionado=isset($_GET['idPersonal']) ? $_GET['idPersonal'] : 0;
        if ($idEmpleadoSeleccionado==0) {
            ?>
                <div id="actualizar" class="ingresarEmpleado">
                    <h2>Ingresar nuevo empleado</h2>
                    <div>
                        <form id="form">
                            <label for="primerNombre">Primer Nombre</label>
                            <input id="primerNombre" type="text" placeholder="Ingrese el primer nombre">
                            <label for="segundoNombre">Segundo Nombre</label>
                            <input id="segundoNombre" type="text" placeholder="Ingrese el segundo nombre">
                            <label for="apellidoEmpleado">Apellido</label>
                            <input id="apellidoEmpleado" type="text" placeholder="Ingrese el apellido">
                            <label for="email">Correo</label>
                            <input id="email" autocomplete="username" type="email" placeholder="Ingrese el correo">
                            <label for="passwd">Escriba la contraseña</label>
                            <input id="passwd" autocomplete="new-password" type="password" placeholder="Ingrese la contraseña">
                            <label for="passwdConfirm">Confirme la contraseña</label>
                            <input id="passwdConfirm" autocomplete="new-password" type="password" placeholder="Confirme la contraseña">
                            <label for="rolPersonal" style="margin-top: 20px;">¿A cual rol pertenecera?</label>
                            <select id="rolPersonal">
                            <?php 
                                foreach($pdo->query('SELECT * FROM roles ORDER BY Rol') as $rol)
                                {
                                    echo '<option value="'.$rol['idRol'].'">'.$rol['Rol'].'</option>';
                                }
                            ?>
                            </select>
                            <input id="btnEnviar" type="submit" value="Agregar">
                        </form>
                    </div>
                    <div class="insertarAca"></div>
                </div>
            <?php
        }else if ($idEmpleadoSeleccionado<0) {
            ?>
                <div id="actualizar">
                    <h2 style="text-align:center">ID Inexistente</h2>
                </div>
            <?php
        }else{
            $sql=$pdo->prepare('SELECT personal.idPersonal, personal.PrimerNombre, personal.SegundoNombre, personal.Apellido, personal.Correo, personal.Password, roles.idRol, roles.Rol FROM personal JOIN roles ON roles.idRol=personal.idRol WHERE idPersonal=?');
            $sql->execute([$idEmpleadoSeleccionado]);
            $empleado=$sql->fetch(PDO::FETCH_ASSOC);
            if (!isset($_GET['delete'])) { 
                //Cuando quiere actualizar
                ?>
                    <div id="actualizar" class="actualizarEmpleado">
                        <h2>Actualizar Empleado: <?=$empleado['PrimerNombre']?></h2>
                        <div>
                            <form id="form">
                                <label for="idPersonal">ID:</label>
                                <input id="idPersonal" type="text" value="<?=$empleado['idPersonal']?>" readonly>
                                <label for="primerNombre">Primer nombre:</label>
                                <input id="primerNombre" type="text" placeholder="<?=$empleado['PrimerNombre']?>" value="<?=$empleado['PrimerNombre']?>">
                                <label for="segundoNombre">Segundo nombre:</label>
                                <input id="segundoNombre" type="text" placeholder="<?=$empleado['SegundoNombre']?>" value="<?=$empleado['SegundoNombre']?>">
                                <label for="apellidoEmpleado">Apellido:</label>
                                <input id="apellidoEmpleado" type="text" placeholder="<?=$empleado['Apellido']!=''?$empleado['Apellido']:'Ingrese el segundo nombre'?>" value="<?=$empleado['Apellido']?>">
                                <label for="email">Correo:</label>
                                <input id="email" autocomplete="username" type="email" placeholder="<?=$empleado['Correo']?>" value="<?=$empleado['Correo']?>">
                                <label for="passwd">Escriba la nueva contraseña:</label>
                                <input id="passwd" autocomplete="new-password" type="password" placeholder="Ingrese su nueva contraseña">
                                <label for="rolPersonal">Rol:</label>
                                <select id="rolPersonal">
                                    <option value="<?=$empleado['idRol']?>"><?=$empleado['Rol']?></option>
                                    <?php 
                                        foreach($pdo->query("SELECT * FROM roles WHERE idRol!='".$empleado['idRol']."' ORDER BY Rol ") as $rol)
                                        {
                                            echo '<option value="'.$rol['idRol'].'">'.$rol['Rol'].'</option>'; 
                                        }
                                    ?>
                                </select>
                                <input id="btnEnviar" type="submit" value="Actualizar">
                            </form>
                        </div>
                    </div>
                <?php
            }else{
                if($empleado['SegundoNombre']==NULL){
                    $nombreCompleto= $empleado['PrimerNombre'].' '.$empleado['Apellido'];
                }else{$nombreCompleto= $empleado['PrimerNombre'].' '.$empleado['SegundoNombre'].' '.$empleado['Apellido'];}
                ?>
                    <div id="actualizar" class="eliminarEmpleado">
                        <h2>¿Esta seguro que desea eliminar <u><?=$empleado['PrimerNombre']?></u>?</h2>
                        <div>
                            <label for="idPersonal">ID:</label>
                            <input type="text" value="<?=$empleado['idPersonal']?>" id="idPersonal" readonly>
                            <label for="nombreCompleto">Nombre:</label>
                            <input type="text" value="<?=$nombreCompleto?>" readonly>
                            <input type="submit" value="Eliminar" id="btnEliminarPersonal">
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
    <template id="templateRol">
        <option value=""></option>
    </template>
    <link rel="stylesheet" href="Style/CRUDStyles.css">
    <script src="JavaScript/mod-Empleados.js"></script>
<?php 
    }else {
        header("Location: index.php");
    }    
?>