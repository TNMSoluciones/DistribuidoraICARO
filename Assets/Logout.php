<?php 
    session_start();
    session_destroy();
    header("Location: http://localhost/codigo/index.php");
?>