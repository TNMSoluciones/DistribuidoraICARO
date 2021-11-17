<?php
    session_start();
    if (!isset($_SESSION['user'])) {
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300;400&display=swap" rel="stylesheet">
    <title>Regístrate</title>
</head>
<body>
    <?php 
        include 'Assets/zonaizquierda.php';
        include 'BD/conBD.php';
        $db=pdo_conectar_mysql();
        $res = $db->prepare('SELECT * FROM departamento ORDER BY Nombre ASC');
        $res->execute();
    ?>
    <div id="registerDerecha">
        <form id="formRegister">
            <label for="nameEmpresa">Nombre de Empresa:</label>
            <input name="name" id="nameEmpresa" type="text" placeholder="Ingrese el Nombre de su Empresa">
            <label for="correoEmpresa">Correo:</label>
            <input id="correoEmpresa" type="email" placeholder="Ingrese el Correo">
            <label for="passwordEmpresa">Contraseña:</label>
            <input id="passwordEmpresa" autocomplete="off" type="password" placeholder="Ingrese una contraseña">
            <label for="passwordConfirmEmpresa">Confirmar contraseña:</label>
            <input id="passwordConfirmEmpresa" autocomplete="off" type="password" placeholder="Confirme la contraseña">
            <label for="rutEmpresa">RUT:</label>
            <input type="number" step="0" min="0" max="999999999999" id="rutEmpresa" placeholder="Ingrese el RUT">
            <label for="departamentoEmpresa">Departamento:</label>
            <select name="departamentos" id="departamentoEmpresa">
                <?php
                    while ($val=$res->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="'.$val["idDepartamento"].'">'.$val['Nombre'].'</option>';
                    }
                ?>
            </select>
            <label for="ciudadEmpresa">Ciudad:</label>
            <select id="ciudadEmpresa"></select>
            <label for="direccionEmpresa">Dirección:</label>
            <input id="direccionEmpresa" type="text" placeholder="Ingrese la direccion">
            <label for="direccionNumEmpresa">Número de puerta:</label>
            <input id="direccionNumEmpresa" type="text" placeholder="Ingrese el Numero de la Direccion">
            <label for="postalEmpresa">Código Postal:</label>
            <input id="postalEmpresa" type="text" placeholder="Ingrese codigo postal">
            <button class="btnRegister btnRegisterA" name="btnReg" type="submit">Registrarse</button>
            <a class="btnRegister" href="login.php">Ir a iniciar sesión</a>
        </form>
    </div>
    <div id="registerCorrecto">
        <div>
            <h1>Registrado correctamente, espere a que activen su cuenta.</h1>
            <a href="login.php">Ir a iniciar sesión.</a>
            <a href="index.php">Ir a incio.</a>
        </div>
    </div>
    <div id="divEmergente"></div>
    <template id="templateCiudad">
        <option value=""></option>
    </template>
</body>
<link rel="stylesheet" href="Style/RegisterStyle.css">
<script src="JavaScript/register.js"></script>
</html>
<?php 
    }else{
        header("Location: index.php");
    }
?>