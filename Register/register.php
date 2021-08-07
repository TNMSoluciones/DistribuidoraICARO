<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300;400&display=swap" rel="stylesheet">
    
    <title>Registrate!</title>
</head>
<body>
    <?php 
        include '../Assets/zonaizquierda.php';
    ?>
    <div id="registerDerecha">
        <form action="comprobarRegister.php" method="POST">
            <label for="nameEmpresa">Nombre de Empresa:</label>
            <input name="name" id="nameEmpresa" minlength="4" maxlength="16" type="text" placeholder="Ingrese el Nombre de su Empresa">
            <label for="correoEmpresa">Correo:</label>
            <input id="correoEmpresa" minlength="2" type="email" placeholder="Ingrese el Correo">
            <label for="passwordEmpresa">Contraseña:</label>
            <input id="passwordEmpresa" type="password" placeholder="Ingrese una contraseña">
            <label for="ciudadEmpresa">Ciudad:</label>
            <input id="ciudadEmpresa" type="text" placeholder="Ingrese la ciudad donde se ubica">
            <label for="direccionEmpresa">Direccion:</label>
            <input id="direccionEmpresa" type="text" placeholder="Ingrese la direccion">
            <label for="direccionNumEmpresa">Numero de calle:</label>
            <input id="direccionNumEmpresa" type="text" placeholder="Ingrese el Numero de la Direccion">
            <label for="postalEmpresa">Codigo Postal:</label>
            <input id="postalEmpresa" type="number" min="0" placeholder="Ingrese codigo postal">
            <label for="departamentoEmpresa">Departamento:</label>
            <select name="departamentos" id="departamentoEmpresa">
                <option value="Artigas">Artigas</option>
                <option value="Canelones">Canelones</option>
                <option value="Cerro Largo">Cerro Largo</option>
                <option value="Colonia">Colonia</option>
                <option value="Durazno">Durazno</option>
                <option value="Flores">Flores</option>
                <option value="Florida">Florida</option>
                <option value="Lavalleja">Lavalleja</option>
                <option value="Maldonado">Maldonado</option>
                <option value="Montevideo">Montevideo</option>
                <option value="Paysandu">Paysandú</option>
                <option value="Rio Negro">Río Negro</option>
                <option value="Rivera">Rivera</option>
                <option value="Rocha">Rocha</option>
                <option value="Salto">Salto</option>
                <option value="San Jose">San José</option>
                <option value="Soriano">Soriano</option>
                <option value="Tacuarembo">Tacuarembó</option>
                <option value="Treinta y Tres">Treinta y Tres</option>
            </select>
            <a href="http://localhost/codigo/Login/login.php">Ir a Iniciar Sesion</a>
            <button id="btn" name="btnReg" type="submit">Registrarse</button>
        </form>
    </div>
</body>
<link rel="stylesheet" href="styleRegister.css">
</html>