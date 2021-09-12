<?php
    session_start();
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $contador=0;
    if (isset($data)) {
        $email = $data->email;
        $passwd = $data->password;
        $sqlLoginClientes=$pdo->query("SELECT COUNT(idCliente) FROM cliente WHERE CorreoCliente='$email'")->fetch(PDO::FETCH_ASSOC);
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
                        $_SESSION['idUsuario'] = $usuario['idCliente'];
                        $_SESSION['nombre']=$usuario['NombreEmpresa'];
                        $_SESSION['correo']=$usuario['CorreoCliente'];
                        $_SESSION['rut']=$usuario['RUT'];
                        echo 1;
                    }else{echo 2;}
                }else{echo 3;}
            }else{echo 4;}
        }else if($sqlLoginClientes==0){
            $sqlPersonal=$pdo->prepare("SELECT personal.*, roles.Rol FROM personal JOIN roles ON roles.idRol=personal.idRol WHERE Correo=?");
            $sqlPersonal->execute([$email]);
            $usuario=$sqlPersonal->fetch(PDO::FETCH_ASSOC);
            if ($usuario)
            {
                if (password_verify($passwd, $usuario['Password']))
                {
                    $nombreCompleto=$usuario['SegundoNombre']==NULL? $usuario['PrimerNombre'] .' '.$usuario['Apellido']:$usuario['PrimerNombre'] .' '.$usuario['SegundoNombre'].' '.$usuario['Apellido'];
                    $_SESSION['idUsuario'] = $usuario['idPersonal'];
                    $_SESSION['nombre']=$nombreCompleto;
                    $_SESSION['correo']=$usuario['Correo'];
                    $_SESSION['rol']=$usuario['Rol'];
                    echo 1;
                }else{echo 3;}
            }else{echo 4;}
        }

    }
?>