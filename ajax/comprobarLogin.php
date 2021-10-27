<?php
    session_start();
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $contador=0;
    if (isset($data)) {
        $email = $data->email;
        $passwd = $data->password;
        $sqlLoginClientes=$pdo->prepare("SELECT COUNT(idCliente) FROM cliente WHERE CorreoCliente=?");
        $sqlLoginClientes->execute([$email]);
        $sqlLoginClientes = $sqlLoginClientes->fetch(PDO::FETCH_ASSOC);
        $sqlLoginClientes=$sqlLoginClientes['COUNT(idCliente)'];
        if ($sqlLoginClientes==1)
        {
            $sqlClientes=$pdo->prepare("SELECT idCliente, NombreEmpresa, CorreoCliente, RUT, Activo, Password FROM cliente WHERE CorreoCliente=?");
            $sqlClientes->execute([$email]);
            $usuario=$sqlClientes->fetch(PDO::FETCH_ASSOC);
            if ($usuario)
            {
                if (password_verify($passwd, $usuario['Password']))
                {
                    if ($usuario['Activo']==1)
                    {
                        $_SESSION['user']['idUsuario'] = $usuario['idCliente'];
                        $_SESSION['user']['nombre']=$usuario['NombreEmpresa'];
                        $_SESSION['user']['correo']=$usuario['CorreoCliente'];
                        $_SESSION['user']['rut']=$usuario['RUT'];
                        echo 1;
                    }else{echo 2;}
                }else{echo 3;}
            }else{echo 4;}
        }else if($sqlLoginClientes==0){
            $sqlPersonal=$pdo->prepare("SELECT personal.*, roles.* FROM personal JOIN roles ON roles.idRol=personal.idRol WHERE Correo=?");
            $sqlPersonal->execute([$email]);
            $usuario=$sqlPersonal->fetch(PDO::FETCH_ASSOC);
            if ($usuario)
            {
                if (password_verify($passwd, $usuario['Password']))
                {
                    $nombreCompleto=$usuario['SegundoNombre']==NULL? $usuario['PrimerNombre'] .' '.$usuario['Apellido']:$usuario['PrimerNombre'] .' '.$usuario['SegundoNombre'].' '.$usuario['Apellido'];
                    $_SESSION['user']['idUsuario'] = $usuario['idPersonal'];
                    $_SESSION['user']['nombre']=$nombreCompleto;
                    $_SESSION['user']['correo']=$usuario['Correo'];
                    $_SESSION['user']['idRol']=$usuario['idRol'];
                    $_SESSION['user']['rol']=$usuario['Rol'];
                    echo 1;
                }else{echo 3;}
            }else{echo 4;}
        }

    }
?>