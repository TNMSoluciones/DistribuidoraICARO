<?php
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if(isset($_POST))
    {
        if (isset($_POST['accion']) && $_POST['accion'] == 'insertar')
        {
            $nameProduct = $_POST['nameProduct'];
            $stockProduct = $_POST['stockProduct'];
            $priceProduct = $_POST['priceProduct'];
            $catProduct = $_POST['catProduct'];
        }
    }
?>