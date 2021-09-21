<?php
    $data=json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if (!isset($data->delete)) {
        if (!$data->insert) {
            //Si desea actualizar
            $idPersonal = $data->idPersonal;
            $fName = $data->fName;
            $sName = isset($data->sName)?$data->sName:NULL;
            $lastName = $data->lastName;
            $email = $data->email;
            $passwd = $data->passwd;
            $rolPersonal = $data->rolPersonal;
            if($passwd==''){
                $sql=$pdo->prepare("UPDATE personal SET PrimerNombre='$fName', SegundoNombre='$sName', Apellido='$lastName', Correo='$email', idRol='$rolPersonal' WHERE idPersonal='$idPersonal'");
            }else{
                $passwdCifrada = password_hash($passwd, PASSWORD_DEFAULT);
                $sql=$pdo->prepare("UPDATE personal SET PrimerNombre='$fName', SegundoNombre='$sName', Apellido='$lastName', Correo='$email', Password='$passwdCifrada', idRol='$rolPersonal' WHERE idPersonal='$idPersonal'");
            }
            $sql->execute();
            $res = $sql ? true : false;
            echo $res;
        }else{
            //Si se desea insertar
            $email = $data->email;
            $sqlConsultaClientes=$pdo->query("SELECT COUNT(idCliente) as Cantidad FROM cliente WHERE CorreoCliente='$email'")->fetch(PDO::FETCH_ASSOC);
            $sqlConsultaClientes=$sqlConsultaClientes['Cantidad'];
            if ($sqlConsultaClientes==0) {
                $fName = $data->fName;
                $sName = isset($data->sName)?$data->sName:NULL;
                $lastName = $data->lastName;
                $passwd = $data->passwd;
                $passwdCifrada = password_hash($passwd, PASSWORD_DEFAULT);
                $rolPersonal = $data->rolPersonal;
                $sqlInsert = $pdo->prepare("INSERT INTO personal(PrimerNombre, SegundoNombre, Apellido, Correo, Password, idRol) VALUES('$fName', '$sName', '$lastName', '$email', '$passwdCifrada', '$rolPersonal')");
                $sqlInsert->execute();
                echo 1;
            }else{echo 2;}
        }
    }else{
        //Si se desea eliminar
        $idPersonal= $data->idPersonal;
        $sqlDelete=$pdo->prepare('DELETE FROM personal WHERE idPersonal=?');
        $sqlDelete->execute([$idPersonal]);
        $resDelete= $sqlDelete ? true : false;
        echo $resDelete;
    }
?>