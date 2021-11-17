<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../Assets/PHPMailer/Exception.php';
    require '../Assets/PHPMailer/PHPMailer.php';
    require '../Assets/PHPMailer/SMTP.php';

    $data = json_decode(file_get_contents("php://input"));
    $mensaje = '';
    if (isset($data)) {
        $nombreEmpresa = $data->nombreEmpresa;
        $emailEmpresa = $data->correoEmpresa;
        $forma = $data->forma;
        switch ($forma) {
            case 'register':
                $mensaje = 'Gracias por utilizar Distribuidora ICARO, su registro se realizó correctamente.<br>Te avisaremos a esta dirección de correo electrónico cuando su cuenta sea activada.';
            break;
            case 'cliente':
                $mensaje = 'Gracias por utilizar Distribuidora ICARO, su cuenta ha sido activada.<br> Te invitamos a ver nuestros productos más recientes en nuestra página web.';
            break;
            case 'pedido':
                $mensaje = 'Su pedido ha sido confirmado, para mas información, lea el siguiente archivo.';
            break;
            default:
                $mensaje = '';
            break;
        }

        if ($mensaje!='') {
            echo sendmail($nombreEmpresa, $emailEmpresa, $mensaje);
        }
    }


    function sendmail($name , $email, $msg) {

        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 1;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tnmsoluciones@gmail.com';
            $mail->Password = 'a1b1c1D1';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
        
            //Recipients
            $mail->setFrom('tnmsoluciones@gmail.com', 'noreply');
            $mail->addAddress($email, $name);
        
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Distribuidora ICARO';
            $mail->Body = $msg;
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }