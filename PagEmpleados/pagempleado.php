<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jura:wght@300;400&display=swap" rel="stylesheet">
    <title>Document</title>
</head>
<body>
<?php include '../Assets/header.php';?>

    <div id="encargado">
        <h1>Encargado de Ventas</h1>
        

        <!-- Este div se cambiara por un template -->
        <div class="productosEncargado">
            <div>
                <img src="../img/usuario.png" class="imgproducto" alt="fotoproducto">
                <h3>Nombre de la empresa</h3>
                <br>
                <h3>Nombre del producto</h3>
                <h3>X</h3>
                <h3>CostoTotal</h3>
                <h3>Cantidad</h3>
            </div>
        </div>  
        <!-- Este div acabara un template -->
    </div>


    <div></div>
    <div></div>
    <?php include '../Assets/footer.php';?>

    
</body>
<link rel="stylesheet" href="../Assets/header.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="style_movil.css">
<link rel="stylesheet" href="../Assets/footer.css">
<?php include '../Assets/menuDesplegable.php'?>
</html>