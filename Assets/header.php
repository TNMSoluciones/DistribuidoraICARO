<?php
$pdoCats=pdo_conectar_mysql();
$sqlCats=$pdoCats->query("SELECT idCategoria, Categoria FROM categorias");
function mostrarHeader($title){
    echo '
        <!DOCTYPE html>
            <html lang="es-ES">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="Style/header.css">
                <title>'.$title.'</title>
            </head>
            <body>
            <header>
                <img id="btnCat" src="img/menu.png">
                <a href="index.php"><img src="img/logoconfondochico.png" id="logo" alt="Foto de Logo"></a>
                <div id="buscador">
                    <form id="formSearch" action="productos.php" method="GET" onSubmit="return comprobarInput()">
                        <select onchange="location = this.value">
                            <option value="productos.php">Todas las Categorias</option>
                            ';
                        while($cat = $GLOBALS['sqlCats']->fetch(PDO::FETCH_ASSOC)){
                            ?>
                            <option value="productos.php?query_cat=<?=$cat['idCategoria']?>"><?=$cat['Categoria']?></option>
                            <?php
                        }
                    echo '</select>    
                        <input name="query_search" type="text" placeholder="Busca tu producto!" autocomplete="off">
                        <img src="img/lupa.png" alt="Lupa">
                        <input id="search" type="submit" value="Buscar">
                    </form>
                </div>
                <div id="carrito">
                    <a href="carrito.php" id="perfilusr"><img id="carrito" src="img/carrito-de-compras.png"></a> 	
                    <p>aaaaaa</p>
                    <a href="carrito.php"><h1>Carrito</h1></a>
                </div>
                <div id="perfil">
                    <a href="login.php" id="perfilusr"><img src="img/usuario.png" id="perfil"></a>
                    <p>aaaaaa</p>
                    <a href="login.php"><h1>Iniciar Sesion</h1></a>   
                </div>
            </header>
            <div id="categorias">
                <a href="login.php"><p>Iniciar Sesion</p></a>
                <a href="carrito.php"><p>Carrito</p></a>
                <a href="index.php"><p>Inicio</p></a>
                <a href="contactanos.php"><p>Contactanos</p></a>
                <a href="productos.php"><p>Productos</p></a>
        ';
        echo isset($_SESSION['rol'])?'<a href="pagempleado.php"><p>Empleados</p></a>':'';
        echo '</div>';
    if (isset($_SESSION["nombre"])) {
        ?><script>
            document.querySelector('header #perfil p').innerHTML= "<?php echo $_SESSION['nombre']?>";
            document.querySelector('header #perfil h1').innerHTML= "Cerrar Sesion";
            document.querySelector('header #perfil a:first-of-type').setAttribute('href', 'Assets/logout.php');
            document.querySelector('header #perfil a:last-of-type').setAttribute('href', 'Assets/logout.php');
            document.querySelector('div#categorias a:first-of-type').innerHTML = "<p>Cerrar Sesion</p>";
            document.querySelector('div#categorias a:first-of-type').setAttribute('href','Assets/logout.php');
        </script><?php
    }
    ?>
        <script>
            const comprobarInput = function(){
                return document.querySelector('#buscador form input[type=text]').value.length>0? true:false ;
            }
            let estadoLogin = `<?php if(isset($_SESSION['email'])){echo "1";}else{echo "0";}?>`;
            document.querySelector('header #perfil h1').addEventListener('click', ()=>{
                if (estadoLogin==0) {
                    location.href = "login.php";
                }else if (estadoLogin==1) {
                    location.href = "Assets/Logout.php";    
                }
            });
            const lastSlash = window.location.pathname.lastIndexOf('/');
            const url = window.location.pathname.slice(lastSlash+1);
            switch(url) {
                case 'index.php': document.querySelector("#categorias > a:nth-child(3) > p").classList.add('selected');
                    break;
                case 'contactanos.php': document.querySelector("#categorias > a:nth-child(4) > p").classList.add('selected');
                    break;
                case 'productos.php': document.querySelector("#categorias > a:nth-child(5) > p").classList.add('selected');
                    break;
                case 'pagempleado.php': document.querySelector("#categorias > a:nth-child(6) > p").classList.add('selected');
                    break;
                case '': document.querySelector("#categorias > a:nth-child(3) > p").classList.add('selected');
                    break;
                }
        </script>
    <?php
    include_once 'Assets/menuDesplegable.php';
}

?>

