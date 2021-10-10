<?php
    session_start();
    include_once '../BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    if(isset($_POST)) {
        if (isset($_POST['accion'])) {
            if($_POST['accion'] == 'insertar') {
                //Se desea Insertar
                $nameProduct = $_POST['nameProduct'];
                $sqlConsultaProducto = $pdo->query("SELECT COUNT(idProducto) as Cantidad FROM producto WHERE Nombre='$nameProduct'")->fetch(PDO::FETCH_ASSOC);
                $sqlConsultaProducto=$sqlConsultaProducto['Cantidad'];
                if($sqlConsultaProducto==0) {
                    $stockProduct = $_POST['stockProduct'];
                    $catProduct = $_POST['catProduct'];
                    $priceProduct = $_POST['priceProduct'];
                    $desc = $_POST['desc'];
                    $empleadoMod = $_SESSION['user']['idUsuario'];
                    $extension = $_FILES['imgProduct']['type'];
                    if($extension=='image/jpeg' || $extension=='image/jpg' || $extension=='image/png') {
                        $imgSubida=fopen($_FILES['imgProduct']['tmp_name'], 'r');
                        $binariosImg=fread($imgSubida, $_FILES['imgProduct']['size']);
                        $sqlInsert=$pdo->prepare("INSERT INTO producto(Nombre, Stock, Precio, Imagen, descripcion, idCategoria, idPersonal) VALUES(?,?,?,?,?,?,?)");
                        $sqlInsert->execute([$nameProduct,$stockProduct,$priceProduct,$binariosImg,$desc,$catProduct,$empleadoMod]);
                        fclose($imgSubida);
                        echo $sqlInsert? 1 : 2; 
                    }
                }else{echo 3;}
            }
            //Se desea actualizar
            if($_POST['accion'] == 'actualizar') {
                $nameProduct = $_POST['nameProduct'];
                $sqlConsultaProducto = $pdo->query("SELECT COUNT(idProducto) as Cantidad FROM producto WHERE Nombre='$nameProduct'")->fetch(PDO::FETCH_ASSOC);
                $sqlConsultaProducto=$sqlConsultaProducto['Cantidad'];
                if($sqlConsultaProducto=1) {   
                    $idProduct=$_POST['idProduct'];
                    $stockProduct = $_POST['stockProduct'];
                    $catProduct = $_POST['catProduct'];
                    $priceProduct = $_POST['priceProduct'];
                    $desProduct = isset($_POST['activo'])?1:0;
                    $desc = $_POST['desc'];
                    $empleadoMod = $_SESSION['user']['idUsuario'];
                    if($_FILES['imgProduct']['name']=='') {
                        $sqlUpdate=$pdo->prepare('UPDATE producto SET Nombre=?, Stock=?,Precio=?, Destacado=?, descripcion=?,idCategoria=?,idPersonal=? WHERE idProducto=?');
                        $sqlUpdate->execute([$nameProduct,$stockProduct,$priceProduct,$desProduct,$desc,$catProduct,$empleadoMod,$idProduct]);
                        echo $sqlUpdate?1:2;
                    }else{
                        $extension = $_FILES['imgProduct']['type'];
                        if($extension=='image/jpeg' || $extension=='image/jpg' || $extension=='image/png') {
                            $imgSubida=fopen($_FILES['imgProduct']['tmp_name'], 'r');
                            $binariosImg=fread($imgSubida, $_FILES['imgProduct']['size']);
                            $sqlUpdate=$pdo->prepare('UPDATE producto SET Nombre=?, Stock=?,Precio=?, Imagen=?,idCategoria=?,idPersonal=? WHERE idProducto=?');
                            $sqlUpdate->execute([$nameProduct,$stockProduct,$priceProduct,$binariosImg,$catProduct,$empleadoMod,$idProduct]);
                            fclose($imgSubida);
                            echo $sqlUpdate? 1 : 2;
                        } 
                    }
                }else{echo 3;}
            }
            //Si desea eliminar
            if($_POST['accion']=='eliminar') {
                $idProduct=$_POST['idProduct'];
                $sqlDelete=$pdo->prepare("DELETE FROM producto WHERE idProducto=?");
                $sqlDelete->execute([$idProduct]);
                echo $sqlDelete ? true : false;
            }
        }
    }
?>