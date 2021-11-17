<?php
    session_start();
    if (isset($_SESSION['user'])) {
        include_once 'BD/conBD.php';
        include_once 'Assets/header.php';
        mostrarHeader('Editar perfil');
        $pdo = pdo_conectar_mysql();
        if (isset($_SESSION['user']['idRol'])) {
            $infoUser = $pdo->prepare("SELECT PrimerNombre, SegundoNombre, Apellido FROM personal WHERE idPersonal=?");
            $bandera=true;
        }else {
            $bandera=false;
            $infoUser = $pdo->prepare("SELECT NombreEmpresa, CorreoCliente, CalleDir, NumeroDir, Latitud, Longitud, departamento.idDepartamento, departamento.Nombre as Departamento, ciudad.idCiudad, ciudad.Nombre as Ciudad FROM cliente JOIN ciudad ON ciudad.idCiudad = cliente.idCiudad JOIN departamento ON departamento.idDepartamento = ciudad.idDepartamento  WHERE RUT=?");
        }
        $infoUser->execute([$_SESSION['user']['idUsuario']]);
        $infoUser=$infoUser->fetch(PDO::FETCH_ASSOC);
        if ($bandera) {
            $nombre=$infoUser['PrimerNombre'];
            $segundoNombre=$infoUser['SegundoNombre'];
            $apellido=$infoUser['Apellido'];
            $fullName = $segundoNombre==''? $nombre.' '.$apellido:$nombre.' '.$segundoNombre.' '.$apellido;
        }else {
            $nombre=$infoUser['NombreEmpresa'];
            $nombreCalle=$infoUser['CalleDir'];
            $numeroCalle=$infoUser['NumeroDir'];
            $latitud=$infoUser['Latitud'];
            $longitud=$infoUser['Longitud'];
            $departamentos = $pdo->query("SELECT * FROM departamento WHERE idDepartamento !=".$infoUser['idDepartamento']);
            $ciudades = $pdo->query("SELECT * FROM ciudad WHERE idDepartamento=".$infoUser['idDepartamento']." AND idCiudad !=".$infoUser['idCiudad']);
        }
?>
<link rel="stylesheet" href="Style/Editarperfil.css">
<main id="main">
    <div class="Editarperfil">
        <div>
            <form id="form">
                <h3><?=$bandera?$fullName:$nombre?></h3>
                <label for="name"><?=$bandera?'Primer Nombre:':'Nombre:'?></label>
                <input type="text" id="name" value="<?=$nombre?>">
                <?php if($bandera){?>
                    <label for="sName">Segundo Nombre:</label>
                    <input type="text" id="sName" value="<?=$segundoNombre?>">
                    <label for="lName">Apellido:</label>
                    <input type="text" id="lName" value="<?=$apellido?>">
                <?php }?>
                <label for="passwdAntigua">Contraseña anterior</label>
                <input type="password" id="passwdAntigua" autocomplete="none">
                <label for="passwdNueva">Contraseña nueva</label>
                <input type="password" id="passwdNueva" autocomplete="none">
                <label for="passwdNueva2">Confirmar contraseña nueva</label>
                <input type="password" id="passwdNueva2" autocomplete="none">
                <?php if(!isset($_SESSION['user']['idRol'])){?>
                <label for="nombreCalle">Nombre de calle</label>
                <input type="text" id="nombreCalle" value="<?=$nombreCalle?>">
                <label for="numeroCalle">Número de calle</label>
                <input type="text" id="numeroCalle" value="<?=$numeroCalle?>">
                <label for="departamentos">Departamento:</label>
                <select id="departamentos">
                    <option value="<?=$infoUser['idDepartamento']?>"><?=$infoUser['Departamento']?></option>
                    <?php while($dep = $departamentos->fetch(PDO::FETCH_ASSOC)){?>
                        <option value="<?=$dep['idDepartamento']?>"><?=$dep['Nombre']?></option>
                    <?php }?>
                </select>
                <label for="ciudades">Ciudad:</label>
                <select id="ciudades">
                    <option value="<?=$infoUser['idCiudad']?>"><?=$infoUser['Ciudad']?></option>
                    <?php while($ciud = $ciudades->fetch(PDO::FETCH_ASSOC)){?>
                        <option value="<?=$ciud['idCiudad']?>"><?=$ciud['Nombre']?></option>
                    <?php }?>
                </select>
                <label for="mapa">Seleccione su ubicación:</label>
                <div id="mapa"></div>
                <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC5Pqbhh0y7lSrWl6gG6xZjoKy797xrB0w&callback=initMap&v=weekly" async></script>
                <?php }?>
                <br><input type="submit" id="btn">
            </form>
        </div>
    </div>
</main>
<div id="divEmergente"></div>
<template id="templateCiudad">
        <option value=""></option>
</template>
<?php include_once 'Assets/footer.php';?>
<script>
    const name = "<?=$nombre?>";
    <?php if(!$bandera){?>
        const nombreCalle = "<?=isset($nombreCalle)?$nombreCalle:''?>";
        const numeroCalle = "<?=isset($numeroCalle)?$numeroCalle:''?>";
        const latitud = "<?=isset($latitud)?$latitud:''?>";
        const longitud = "<?=isset($longitud)?$longitud:''?>";
    <?php }else{?>
        const nombreCalle = null;
        const numeroCalle = null;
        const latitud = null;
        const longitud = null;
    <?php }?>
</script>
<script src="JavaScript/editarPerfil.js" defer></script>
<?php 
    }else{
        header("Location: index.php");
    }
?>