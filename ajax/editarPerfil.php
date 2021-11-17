<?php
    session_start();
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (isset($data)) {
        if (isset($data->nombreCalle)) {
            $selectUser = $pdo->prepare("SELECT NombreEmpresa, CorreoCliente, Password, RUT, CodigoPostal, CalleDir, NumeroDir, Latitud, Longitud, Departamento.Nombre as Departamento, Ciudad.Nombre as Ciudad FROM cliente JOIN Ciudad ON cliente.idCiudad=ciudad.idCiudad JOIN Departamento ON Departamento.idDepartamento=Ciudad.idDepartamento WHERE RUT = ?");
            $selectUser->execute([$_SESSION['user']['idUsuario']]);
            $selectUser = $selectUser->fetch(PDO::FETCH_ASSOC);
            if ($data->passwdA!='') {
                if (password_verify($data->passwdA, $selectUser['Password'])) {
                    if ($data->passwdN==$data->passwdN2) {
                        $actualizarUser = $pdo->prepare("UPDATE cliente SET NombreEmpresa=?, Password=?, CalleDir=?, NumeroDir=?, Latitud=?, Longitud=?, idCiudad=? WHERE RUT = ?");
                        $passwordEncriptada=password_hash($data->passwdN, PASSWORD_DEFAULT);
                        $actualizarUser->execute([$data->nameN, $passwordEncriptada, $data->nombreCalle, $data->numeroCalle, $data->lat, $data->lng, $data->ciudad, $_SESSION['user']['idUsuario']]);
                        echo $actualizarUser?1:5;
                    }else {
                        echo 2;
                    }
                }else {
                    echo 3;
                }
            }else {
                if ($data->passwdN!=''||$data->passwdN2) {
                    echo 4;
                }else {
                    $actualizarUser = $pdo->prepare("UPDATE cliente SET NombreEmpresa=?, CalleDir=?, NumeroDir=?, Latitud=?, Longitud=?, idCiudad=? WHERE RUT = ?");
                    $actualizarUser->execute([$data->nameN, $data->nombreCalle, $data->numeroCalle, $data->lat, $data->lng, $data->ciudad, $_SESSION['user']['idUsuario']]);
                    echo $actualizarUser?1:5;
                }
            }
            if ($actualizarUser) {
                $sqlClientes=$pdo->prepare("SELECT NombreEmpresa, CorreoCliente, RUT, Activo, Password FROM cliente WHERE RUT=?");
                $sqlClientes->execute([$_SESSION['user']['idUsuario']]);
                $usuario=$sqlClientes->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user']['idUsuario'] = $usuario['RUT'];
                $_SESSION['user']['nombre']=$usuario['NombreEmpresa'];
                $_SESSION['user']['correo']=$usuario['CorreoCliente'];
                $_SESSION['user']['rut']=$usuario['RUT'];
            }
        }else {
            $selectUser = $pdo->prepare("SELECT * FROM personal WHERE idPersonal = ?");
            $selectUser->execute([$_SESSION['user']['idUsuario']]);
            $selectUser = $selectUser->fetch(PDO::FETCH_ASSOC);
            if ($data->passwdA!='') {
                if (password_verify($data->passwdA, $selectUser['Password'])) {
                    if ($data->passwdN==$data->passwdN2) {
                        $actualizarUser = $pdo->prepare("UPDATE personal SET PrimerNombre=?, SegundoNombre=?, Apellido=?, Password=? WHERE idPersonal = ?");
                        $passwordEncriptada=password_hash($data->passwdN, PASSWORD_DEFAULT);
                        $actualizarUser->execute([$data->nameN, $data->segundoNombre, $data->apellido, $passwordEncriptada, $_SESSION['user']['idUsuario']]);
                        echo $actualizarUser?1:5;
                    }else {
                        echo 2;
                    }
                }else {
                    echo 3;
                }
            }else {
                if ($data->passwdN!=''||$data->passwdN2) {
                    echo 4;
                }else {
                    $actualizarUser = $pdo->prepare("UPDATE personal SET PrimerNombre=?, SegundoNombre=?, Apellido=? WHERE idPersonal = ?");
                    $actualizarUser->execute([$data->nameN, $data->segundoNombre, $data->apellido, $_SESSION['user']['idUsuario']]);
                    echo $actualizarUser?1:5;
                }
            }
            if (isset($actualizarUser) && $actualizarUser) {
                $sqlPersonal=$pdo->prepare("SELECT personal.*, roles.* FROM personal JOIN roles ON roles.idRol=personal.idRol WHERE idPersonal=?");
                $sqlPersonal->execute([$_SESSION['user']['idUsuario']]);
                $usuario=$sqlPersonal->fetch(PDO::FETCH_ASSOC);
                $nombreCompleto=$usuario['SegundoNombre']==NULL? $usuario['PrimerNombre'] .' '.$usuario['Apellido']:$usuario['PrimerNombre'] .' '.$usuario['SegundoNombre'].' '.$usuario['Apellido'];
                $_SESSION['user']['idUsuario'] = $usuario['idPersonal'];
                $_SESSION['user']['nombre']=$nombreCompleto;
                $_SESSION['user']['correo']=$usuario['Correo'];
                $_SESSION['user']['idRol']=$usuario['idRol'];
                $_SESSION['user']['rol']=$usuario['Rol'];
            }
        }
    }
?>