<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=icaro1.0','root','');
} catch (MySQLException $e) {echo $e->getMessage();}

?>