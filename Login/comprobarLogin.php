<?php 
    session_start();
    include '../BD/bd.php';
    if (isset($_POST["botonLg"]) && $_SERVER["REQUEST_METHOD"] == "POST" ) {
        foreach ($user as $key => $value) {
            if ($_POST['emailLogin'] == $value && $_POST["passwdLogin"] == $pswd[$key]) {
                $_SESSION['email']=$_POST['emailLogin'];
                $_SESSION['rol']=$roles[$key];
                ?>
                <script>alert("Sesion inciada correctamente")</script>
                <?php
                header("Location: http://localhost/codigo/index.php");
                die();
            }
            else{
                ?>
                <script>alert("Error al iniciar la Sesion")</script>
                <?php
                header("Location: http://localhost/codigo/Login/login.php");
            }    

        }
    }

?>