<?php
    $data = json_decode(file_get_contents("php://input"));
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if(isset($data)){
        $email = $data->email;
        $name = $data->name;
        $opinion = $data->opinion;
        $date = $data->date;
        if (strlen($date)<=400) {
            $sqlInsert=$pdo->prepare("INSERT INTO opiniones(correoOpinion, nombreOpinion, fecha, Opinion) VALUES(?,?,?,?)");
            $sqlInsert->execute([$email, $name, $date, $opinion]);
            echo $sqlInsert ? true : false; 
        }
    }
?>