<head>
    <link rel="stylesheet" href="http://localhost/codigo/Assets/header.css">
</head>
<header>
    <img id="btnCat" src="http://localhost/codigo/img/menu.png">
    <a href="http://localhost/codigo/"><img src="http://localhost/codigo/img/logoconfondochico.png" id="logo" alt="Foto de Logo"></a>
    
    <div id="buscador">
        <p>Todas las categorias</p>
        <input type="text" placeholder="Busca tu producto!" autocomplete="off">
        <img src="http://localhost/codigo/img/lupa.png" alt="Lupa">
        <p>Buscar</p>
    </div>
    
    <div id="carrito">
    	<img id="carrito" src="http://localhost/codigo/img/carrito-de-compras.png">    	
    	<p>aaaaaa</p>
    	<h1>Carrito</h1>
    </div>
    <div id="perfil">
		<a href="http://localhost/codigo/Login/login.php" id="perfilusr"><img src="http://localhost/codigo/img/usuario.png" id="perfil"></a>
    	<p>aaaaaa</p>
    	<h1>Iniciar Sesion</h1>
    </div>
</header>
<div id="categorias">
    <a href="http://localhost/codigo/Login/login.php"><p>Iniciar Sesion</p></a>
    <a href=""><p>Carrito</p></a>
    <a href="http://localhost/codigo"><p>Inicio</p></a>
    <a href=""><p>Contactanos</p></a>
    <a href=""><p>Sobre Nosotros</p></a>
    <a href="http://localhost/codigo/Productos/productos.php"><p>Producto</p></a>
    <a href=""><p>Servicios</p></a>
    <a href="http://localhost/codigo/PagEmpleados/pagempleado.php"><p>Empleados</p></a>
</div>


<?php include 'http://localhost/codigo/Assets/menuDesplegable.php';
    if (isset($_SESSION["email"])) {
        ?><script>
            document.querySelector('header #perfil p').innerHTML= "<?php echo $_SESSION['email']?>";
            document.querySelector('header #perfil h1').innerHTML= "Cerrar Sesion";
            document.querySelector('header #perfil h1').setAttribute('href', 'http://localhost/codigo/Assets/logout.php');
            document.querySelector('header #perfil a').setAttribute('href', 'http://localhost/codigo/Assets/logout.php');
            document.querySelector('div#categorias a:first-of-type p').innerHTML = "Cerrar Sesion";
            document.querySelector('div#categorias a:first-of-type').setAttribute('href','http://localhost/codigo/Assets/logout.php');
        </script><?php
    }

?>
<script>
    let estadoLogin = `<?php if(isset($_SESSION['email'])){echo "1";}else{echo "0";}?>`;
    document.querySelector('header #perfil h1').addEventListener('click', ()=>{
        if (estadoLogin==0) {
            location.href = "http://localhost/codigo/Login/login.php";
        }else if (estadoLogin==1) {
            location.href = "http://localhost/codigo/Assets/Logout.php";    
        }
    });
</script>