<?php
    session_start();
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if(isset($_POST))
    {
        if (isset($_POST['accion']) && $_POST['accion'] == 'insertar')
        {
            $nameProduct = $_POST['nameProduct'];
            $sqlConsultaProducto = $pdo->query("SELECT COUNT(idProducto) as Cantidad FROM producto WHERE Nombre='$nameProduct'")->fetch(PDO::FETCH_ASSOC);
            $sqlConsultaProducto=$sqlConsultaProducto['Cantidad'];
            if($sqlConsultaProducto==0)
            {
                $stockProduct = $_POST['stockProduct'];
                $priceProduct = $_POST['priceProduct'];
                $catProduct = $_POST['catProduct'];
                $empleadoMod = $_SESSION['idUsuario'];
                $extension = strtolower(pathinfo($_FILES['imgProduct']['name'], PATHINFO_EXTENSION));
                if($extension=='jpeg' || $extension=='jpg' || $extension=='png')
                {
                    $bandera=false;
                    foreach (scandir(__DIR__.'/../imgProductos') as $key) {
                        if ($key == $nameProduct) {
                            $bandera=true;
                        }
                    }
                    if(!$bandera){
                        if(move_uploaded_file($_FILES['imgProduct']['tmp_name'], '../imgProductos/'.$nameProduct.'.'.strtolower(pathinfo($_FILES['imgProduct']['name'], PATHINFO_EXTENSION)))){
                            $urlImagen = 'imgProductos/'.$nameProduct.'.'.strtolower(pathinfo($_FILES['imgProduct']['name'], PATHINFO_EXTENSION)); 
                            $sqlInsert=$pdo->prepare("INSERT INTO producto(Nombre, Stock, Precio, Imagen, idCategoria, idPersonal) VALUES('$nameProduct','$stockProduct','$priceProduct','$urlImagen','$catProduct','$empleadoMod')");
                            $sqlInsert->execute();
                            echo $sqlInsert? 1 : 2; 
                        }else{echo 3;}//Error al subir
                    }else{echo 4;}//Archivo ya creado
                }
            }else{echo 5;}
        }
    }
?>