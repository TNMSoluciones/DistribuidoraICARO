<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>
<body>
    <?php include 'Assets/zonaizquierda.php';?>

    <div id="loginDerecha">
        <form id="login">
            <label for="email">Correo:</label>
            <input id="email" type="text" placeholder="Ingrese su correo">
            <label for="password">Contraseña:</label>
            <input id="password" autocomplete="off" type="password" placeholder="Ingrese su contraseña">
            <a href="register.php" class="btnLogin btnLoginA">Ir a Registrarse</a>
            <button name="botonLg" class="btnLogin" type="submit">Iniciar Sesion</button>
        </form>
    </div>
</body>
<link rel="stylesheet" href="Style/LoginStyle.css">
<script src="JavaScript/login.js"></script>
</html>