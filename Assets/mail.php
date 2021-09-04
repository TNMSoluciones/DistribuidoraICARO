<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../Assets/PHPMailer/Exception.php';
    require '../Assets/PHPMailer/PHPMailer.php';
    require '../Assets/PHPMailer/SMTP.php';

    $data=json_decode(file_get_contents("php://input"));

    if (isset($data)) {
        $nombreEmpresa = $data->nombreEmpresa;
        $emailEmpresa = $data->correoEmpresa;
        $register = $data->register;
        if ($register) {
            enviarMailRegisterCorrecto($emailEmpresa, $nombreEmpresa);
        }
        if($data->activa){
            enviarMailCuentaAceptada($data->correoEmpresa, $data->nombreEmpresa);
        }
    }

    function enviarMailRegisterCorrecto($destinatario,$nombreDestinatario){
        $mail = new PHPMailer(true);
        $mensaje = 'Gracias por utilizar Distribuidora ICARO, su registro se realizo correctamente.<br>Te avisaremos a esta direccion de correo electronico cuando su cuenta sea activada.';
        try {
            //Configuracion
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tnmsoluciones@gmail.com';
            $mail->Password = 'tnmsOLUCIONES';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
    
            //De quien y para quien/es
            $mail->setFrom('tnmsoluciones@gmail.com', 'noreply');
            $mail->addAddress($destinatario, $nombreDestinatario);
    
            //Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Distribuidora ICARO';
            $mail->Body = $mensaje;
            $mail->AltBody = $mensaje;
            //Enviar archivos extras
            //$mail->addAttachment('');
            //Enviar email
            $mail->send();
            echo true;
        } catch (Exception $e) {
            //Mensaje en caso de error
            echo false;
        }
    }
    function enviarMailCuentaAceptada($destinatario,$nombreDestinatario){
        $mail = new PHPMailer(true);
        $mensaje = 'Gracias por utilizar Distribuidora ICARO, su cuenta ha sido activada.<br> Te invitamos a ver nuestros productos mas recientes en nuestra pagina web.';
        try {
            //Configuracion
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tnmsoluciones@gmail.com';
            $mail->Password = 'tnmsOLUCIONES';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
    
            //De quien y para quien/es
            $mail->setFrom('tnmsoluciones@gmail.com', 'noreply');
            $mail->addAddress($destinatario, $nombreDestinatario);
    
            //Contenido
            $mail->isHTML(true);
            $mail->Subject = 'Distribuidora ICARO';
            $mail->Body = $mensaje;
            $mail->AltBody = $mensaje;

            //Enviar archivos extras
            //$mail->addAttachment('');

            //Enviar email
            $mail->send();
        } catch (Exception $e) {
            //Mensaje en caso de error
        }
    }