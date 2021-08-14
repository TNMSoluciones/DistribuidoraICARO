<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="Assets/header.css">
    <title>Distribuidora ICARO</title>
</head>
<body>
<header>
    <img id="btnCat" src="img/menu.png">
    <a href="/codigo"><img src="img/logoconfondochico.png" id="logo" alt="Foto de Logo"></a>
    
    <div id="buscador">
        <p>Todas las categorias</p>
        <input type="text" placeholder="Busca tu producto!" autocomplete="off">
        <img src="img/lupa.png" alt="Lupa">
        <p>Buscar</p>
    </div>
    
    <div id="carrito">
    	<img id="carrito" src="img/carrito-de-compras.png">    	
    	<p>aaaaaa</p>
    	<h1>Carrito</h1>
    </div>
    <div id="perfil">
		<a href="login.php" id="perfilusr"><img src="img/usuario.png" id="perfil"></a>
    	<p>aaaaaa</p>
    	<h1>Iniciar Sesion</h1>
    </div>
</header>
<div id="categorias">
    <a href="login.php"><p>Iniciar Sesion</p></a>
    <a href=""><p>Carrito</p></a>
    <a href="/codigo"><p>Inicio</p></a>
    <a href=""><p>Contactanos</p></a>
    <a href=""><p>Sobre Nosotros</p></a>
    <a href="productos.php"><p>Producto</p></a>
    <a href=""><p>Servicios</p></a>
    <a href="pagempleado.php"><p>Empleados</p></a>
</div>


<?php include 'Assets/menuDesplegable.php';
    if (isset($_SESSION["email"])) {
        ?><script>
            document.querySelector('header #perfil p').innerHTML= "<?php echo $_SESSION['email']?>";
            document.querySelector('header #perfil h1').innerHTML= "Cerrar Sesion";
            document.querySelector('header #perfil h1').setAttribute('href', 'Assets/logout.php');
            document.querySelector('header #perfil a').setAttribute('href', 'Assets/logout.php');
            document.querySelector('div#categorias a:first-of-type p').innerHTML = "Cerrar Sesion";
            document.querySelector('div#categorias a:first-of-type').setAttribute('href','Assets/logout.php');
        </script><?php
    }

?>
<script>
    let estadoLogin = `<?php if(isset($_SESSION['email'])){echo "1";}else{echo "0";}?>`;
    document.querySelector('header #perfil h1').addEventListener('click', ()=>{
        if (estadoLogin==0) {
            location.href = "login.php";
        }else if (estadoLogin==1) {
            location.href = "Assets/Logout.php";    
        }
    });
</script>