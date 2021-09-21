<?php
    define('DATABASE_HOST','localhost');
    define('DATABASE_USER','root');
    define('DATABASE_PASS','');
    define('DATABASE_NAME','icaro1.0');
    function pdo_conectar_mysql() {
        try {
            return new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USER, DATABASE_PASS);
        } catch (PDOException $exception) {
            ?>
                <script>
                    alert('Error conectando a la base de datos!')
                    window.location="index.php"
                </script>
            <?php    
        }
    }
?>