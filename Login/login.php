<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>
<body>
    <?php include 'http://localhost/codigo/Assets/zonaizquierda.php';?>

    <div id="loginDerecha">
        <div>
            <form action="comprobarLogin.php" method="POST">
                <label for="email">Correo:</label>
                <input id="email" type="text" name="emailLogin" placeholder="Ingrese su correo">
                <label for="password">Contraseña:</label>
                <input id="password" type="password" name="passwdLogin" placeholder="Ingrese su contraseña">
                <a href="http://localhost/codigo/Register/register.php">Ir a Registrarse</a>
                <button name="botonLg" id="" type="submit">Iniciar Sesion</button>
            </form>
        </div>
    </div>
</body>
<link rel="stylesheet" href="stylelogin.css">
<link rel="stylesheet" href="http://localhost/codigo/Assets/zonaizquierda.css">
</html>