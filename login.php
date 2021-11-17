<?php
    session_start();
    if (!isset($_SESSION['user'])) {
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Iniciar Sesión</title>
    </head>
    <body>
        <?php include 'Assets/zonaizquierda.php';?>
        <div id="loginDerecha">
            <form id="login">
                <label for="email">Correo:</label>
                <input id="email" type="text" placeholder="Ingrese su correo">
            <label for="password">Contraseña:</label>
            <input id="password" autocomplete="off" type="password" placeholder="Ingrese su contraseña">
            <button name="botonLg" class="btnLogin btnLoginA" type="submit">Iniciar Sesión</button>
            <a href="register.php" class="btnLogin">Ir a Registrarse</a>
        </form>
    </div>
    <div id="divEmergente"></div>
</body>
<link rel="stylesheet" href="Style/LoginStyle.css">
<script src="JavaScript/login.js"></script>
</html>
<?php 
    }else{
        header("Location: index.php");
    }
?>