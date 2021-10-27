<?php
    define('DATABASE_HOST','localhost');
    define('DATABASE_USER','icaroWeb');
    define('DATABASE_PASS','webicaro123');
    define('DATABASE_NAME','icaro');
    function pdo_conectar_mysql() {
        try {
            return new PDO('mysql:host=' . DATABASE_HOST . ';dbname=' . DATABASE_NAME . ';charset=utf8', DATABASE_USER, DATABASE_PASS);
        } catch (PDOException $exception) {
            die($exception);
        }
    }
?>