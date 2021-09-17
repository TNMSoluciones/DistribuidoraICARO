<!DOCTYPE html>
<?php
    session_start();
    include_once 'Assets/header.php';
    mostrarHeader('Modificar Productos');
    include_once 'BD/conBD.php';
    $pdo=pdo_conectar_mysql();
    $idProductoSeleccionado=isset($_GET['idProducto']) ? $_GET['idProducto']:0;
    $sqlCategorias = $pdo->query('SELECT * FROM categorias');
    if ($idProductoSeleccionado==0) {
        ?>
        <div id="actualizar" class="ingresarProducto">
            <h2>Ingresar un nuevo producto</h2>
            <div>
                <form id="form" enctype="multipart/form-data">
                <label for="nameProduct">Nombre</label>
                <label for="stockProduct">Stock</label>
                <input id="nameProduct" name="nameProduct" type="text" placeholder="Ingrese el nombre del producto">
                <input id="stockProduct" name="stockProduct" type="number" min="0" step="1" placeholder="Ingrese el stock del producto">
                <label for="priceProduct">Precio</label>
                <label for="catProduct">Categoria</label>
                <input id="priceProduct" name="priceProduct" type="number" placeholder="Ingrese el precio del producto">
                <select id="catProduct" name="catProduct">
                    <?php
                        while ($val=$sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="'.$val["idCategoria"].'">'.$val['Categoria'].'</option>';
                        }
                    ?>
                    </select>
                    <label class="labelFile" for="imgProduct">Seleccione una imagen</label>
                    <input type="file" name="imgProduct" id="imgProduct" accept="image/*">
                    <label id="inputFileShow" class="labelFile labelFileSecond" for="imgProduct">Adjuntar Archivo</label>
                    <input id="btnEnviar" type="submit" value="Actualizar">
                    <input type="hidden" name="accion" value="insertar">
                </form>
            </div>
        </div>
        <?php
    }else if($idProductoSeleccionado<0){
        ?>
            <div id="actualizar">
                <h2 style="text-align:center">ID Inexistente</h2>
                <div>
                    <a href="pagempleado.php"><button>Volver</button></a>
                </div>
            </div>
        <?php
    }else if($idProductoSeleccionado>0){
        $sql=$pdo->prepare('SELECT producto.*, categorias.Categoria, personal.PrimerNombre, personal.SegundoNombre, personal.Apellido FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria JOIN personal ON personal.idPersonal=producto.idPersonal WHERE idProducto=?');
        $sql->execute([$idProductoSeleccionado]);
        $producto=$sql->fetch(PDO::FETCH_ASSOC);
        if($producto['SegundoNombre']==NULL){
            $nombreCompleto= $producto['PrimerNombre'].' '.$producto['Apellido'];
        }else{$nombreCompleto= $producto['PrimerNombre'].' '.$producto['SegundoNombre'].' '.$producto['Apellido'];}
        if(!isset($_GET['delete'])){
            ?>
                <div id="actualizar" class="actualizarProducto">
                    <h2>Actualizar Producto: <?=$producto['Nombre']?></h2>
                    <div>
                        <form id="form">
                            <label for="idProduct">ID</label>
                            <p id="idProduct"><?=$producto['idProducto']?></p>
                            <label for="nameProduct">Nombre</label>
                            <label for="stockProduct">Stock</label>
                            <input id="nameProduct" value="<?=$producto['Nombre']?>" type="text">
                            <input id="stockProduct" value="<?=$producto['Stock']?>" type="number">
                            <label for="priceProduct">Precio</label>
                            <label for="catProduct">Categoria</label>
                            <input id="priceProduct" value="<?=$producto['Precio']?>" type="number">
                            <select id="catProduct">
                                <option value="<?=$producto['idCategoria']?>"><?=$producto['Categoria']?></option>
                                <?php
                                    foreach($pdo->query("SELECT * FROM categorias WHERE idCategoria!=".$producto['idCategoria']) as $categoria){
                                        echo '<option value="'.$categoria['idCategoria'].'">'.$categoria['Categoria'].'</option>';
                                    }
                                ?>
                            </select>
                            <label for="lastModProduct">Ultima Modificaciόn:</label>
                            <p id="lastModProduct"><?=$nombreCompleto?></p>
                            <label class="labelFile" for="imgProduct">Seleccione una imagen</label>
                            <input type="file" name="imgProduct" id="imgProduct" accept="image/*">
                            <label id="inputFileShow" class="labelFile labelFileSecond" for="imgProduct">Adjuntar Archivo</label>
                            <input id="activo" type="checkbox" value="<?=$producto['Destacado']?>" <?=$producto['Destacado']==1? 'checked': ''?>>
                            <label class="checkbox" for="activo">Producto Destacado:</label>
                            <input id="btnEnviar" type="submit" value="Actualizar">
                        </form>
                    </div>
                </div>
            <?php
        }
    }
    include_once 'Assets/footer.php';
?>
<template id="templateRol">
    <option value=""></option>
</template>
<link rel="stylesheet" href="Style/CRUDStyles.css">
<script src="JavaScript/functionCRUD.js"></script>