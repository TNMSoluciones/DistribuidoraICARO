<?php
    $data=json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if(isset($data)){
        $correoEmpresa = $data->correoEmpresa;
        $sqlConsultaEmpleados=$pdo->prepare("SELECT COUNT(idPersonal) as Cantidad FROM personal WHERE Correo=?");
        $sqlConsultaEmpleados->execute([$correoEmpresa]);
        $sqlConsultaEmpleados = $sqlConsultaEmpleados->fetch(PDO::FETCH_ASSOC);
        $sqlConsultaEmpleados=$sqlConsultaEmpleados['Cantidad'];
        if($sqlConsultaEmpleados==0){
            $nombreEmpresa = $data->nombreEmpresa;
            $password = $data->password;
            $passwordCifrada = password_hash($password, PASSWORD_DEFAULT);
            $rut = $data->RUT;
            $idCiudad = $data->ciudad;
            $codigoPostal = $data->codigoPostal;
            $calle = $data->calle;
            $numCalle = $data->numCalle;
            $sqlSelectCorreo = $pdo->prepare("SELECT COUNT(RUT) FROM cliente WHERE CorreoCliente=?");
            $sqlSelectCorreo->execute([$correoEmpresa]);
            $sqlSelectCorreo = $sqlSelectCorreo->fetch(PDO::FETCH_ASSOC);
            $sqlSelectCorreo = $sqlSelectCorreo['COUNT(RUT)'];
            $sqlSelectRUT = $pdo->prepare("SELECT COUNT(RUT) FROM cliente WHERE RUT=?");
            $sqlSelectRUT->execute([$rut]);
            $sqlSelectRUT = $sqlSelectRUT->fetch(PDO::FETCH_ASSOC);
            $sqlSelectRUT = $sqlSelectRUT['COUNT(RUT)'];
            if ($sqlSelectCorreo==0&&$sqlSelectRUT==0) {
                $SQL=$pdo->prepare('INSERT INTO cliente(NombreEmpresa, CorreoCliente, Password, RUT, idCiudad, CodigoPostal, CalleDir, NumeroDir) VALUES (?,?,?,?,?,?,?,?)');
                $SQL->execute([$nombreEmpresa, $correoEmpresa, $passwordCifrada, $rut, $idCiudad, $codigoPostal, $calle, $numCalle]);
                $res= $SQL ? 1 : 2;
                echo $res;
            }else if($sqlSelectCorreo>0){echo 3;}else if($sqlSelectRUT>0){echo 4;}
        }else{echo 3;}
    }
?>