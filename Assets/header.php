<?php
$pdoCats=pdo_conectar_mysql();
$sqlCats=$pdoCats->query("SELECT idCategoria, Categoria FROM categorias");
function mostrarHeader($title){
    ?>
        <!DOCTYPE html>
            <html lang="es-ES">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
                <link rel="preconnect" href="https://fonts.googleapis.com">
                <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
                <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400&display=swap" rel="stylesheet">
                <link rel="stylesheet" href="Style/header.css">
                <link rel="icon" href="img/icon.ico">
                <title><?=$title?></title>
            </head>
            <body>
            <header>
                <img id="btnCat" src="img/menu.png">
                <div id="headerDivImg">
                    <a href="index.php"><img src="img/logoconfondochico.png" id="logo" alt="Foto de Logo"></a>
                </div>

                <div id="buscador">
                    <form id="formSearch" action="productos.php" method="GET" onSubmit="return comprobarInput()">
                        <select oninput="location = this.value">
                            <option>Lista de Categorías</option>
                            <option value="productos.php">Todas las Categorías</option>
                            <?php while($cat = $GLOBALS['sqlCats']->fetch(PDO::FETCH_ASSOC)){?>
                            <option value="productos.php?query_cat=<?=$cat['idCategoria']?>"><?=$cat['Categoria']?></option>
                            <?php }?>
                    </select>    
                        <input name="query_search" type="text" placeholder="Busca tu producto" autocomplete="off">
                        <label for="search" id="forSearch"></label>
                        <input id="search" type="submit" value="Buscar">
                    </form>
                </div>
                
                <?php
                $cantidad = isset($_SESSION['carrito'])?count($_SESSION['carrito']):0;
                $palabraCantidad = $cantidad==1?'ítem':'ítems';
                if (!isset($_SESSION['user']['rol'])) {
                    ?>
                    <div id='carrito'>
                        <a href='carrito.php' id='perfilusr'><img id='carrito' src='img/carrito-de-compras.png'></a> 	
                        <p><?=$cantidad?> <?=$palabraCantidad?>.</p>
                        <a href='carrito.php'><h1>Carrito</h1></a>
                    </div>
                    <?php }?>
                <div id="perfil">
                    <a href="<?=isset($_SESSION['user']["nombre"])?'Assets/logout.php':'login.php'?>" id="perfilusr"><img src="img/usuario.png" id="perfil"></a>
                    <p><?=isset($_SESSION['user']["nombre"])?$_SESSION['user']["nombre"]:''?></p>
                    <a href="<?=isset($_SESSION['user']["nombre"])?'Assets/logout.php':'login.php'?>"><h1><?=isset($_SESSION['user']["nombre"])?'Cerrar Sesión':'Iniciar Sesión'?></h1></a>   
                </div>
            </header>
            <div id="categorias">
                <a href="<?=isset($_SESSION['user']["nombre"])?'Assets/logout.php':'login.php'?>"><p class="movilSuperior"><?=isset($_SESSION['user']["nombre"])?'Cerrar Sesión':'Iniciar Sesión'?></p></a>
                <?=isset($_SESSION['user']['rol'])?"<a><p></p></a>":'<a href="carrito.php"><p>Carrito</p></a>'?>
                <a href="index.php"><p id="inicioHeader">Inicio</p></a>
                <a href="productos.php"><p id="productosHeader">Catálogo de Productos</p></a>
                <a href="contactanos.php"><p id="contactanosHeader">Contáctanos</p></a>

        <?php
            if (isset($_SESSION['user']['rol'])) {
                echo '<a href="pagempleado.php"><p id="empleadosHeader">Empleados</p></a>';
                echo '<a href="dashboard.php"><p id="dashboard">Dashboard</p></a>';
            }
            if (isset($_SESSION['user']['nombre'])) {
                echo '<a href="perfilUsuario.php"><p id="miperfilHeader">Mi perfil</p></a>';
            }
        ?>
        </div>
        <script>    
        let menuBandera = false;
        document.getElementById('btnCat').addEventListener('click',()=>{
            if (menuBandera)
            {
                document.getElementById('btnCat').style.transform= 'rotate(0deg)';
                document.getElementById('categorias').style.marginLeft = '-100vw';
            }
            else
            {
                document.getElementById('btnCat').style.transform= 'rotate(-90deg)';
                document.getElementById('categorias').style.marginLeft = '0vw';
            }
            menuBandera = !menuBandera;
        });
            const comprobarInput = function(){
                return document.querySelector('#buscador form input[type=text]').value.length>0? true:false ;
            }
            let estadoLogin = `<?php if(isset($_SESSION['user']['email'])){echo "1";}else{echo "0";}?>`;
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
                case 'index.php': document.getElementById('inicioHeader').classList.add('selected');
                    break;
                case 'productos.php': document.getElementById('productosHeader').classList.add('selected');
                    break;
                case 'contactanos.php': document.getElementById('contactanosHeader').classList.add('selected');
                    break;
                case 'pagempleado.php': document.getElementById('empleadosHeader').classList.add('selected');
                    break;
                case 'perfilUsuario.php': document.getElementById('miperfilHeader').classList.add('selected');
                    break;
                case 'dashboard.php': document.getElementById('dashboard').classList.add('selected')
                    break;
                case '': document.getElementById('inicioHeader').classList.add('selected');
                    break;
                }
        </script>
    <?php
}

?>

