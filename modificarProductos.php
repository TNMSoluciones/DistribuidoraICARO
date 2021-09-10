<!DOCTYPE html>
<script src="JavaScript/functionCRUD.js"></script>
<?php
    session_start();
    include_once 'Assets/header.php';
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
                    <input id="nameProduct" name="nameProduct" type="text" placeholder="Ingrese el primer del producto">
                    <input id="stockProduct" name="stockProduct" type="number" min="0" step="1" placeholder="Ingrese el stock del producto">
                    <label for="priceProduct">Precio</label>
                    <label for="catProduct">Categoria</label>
                    <input id="priceProduct" name="priceProduct" type="text" placeholder="Ingrese el precio del producto">
                    <select id="catProduct" name="catProduct">
                        <?php
                             while ($val=$sqlCategorias->fetch(PDO::FETCH_ASSOC)) {
                                echo '<option value="'.$val["idCategoria"].'">'.$val['Categoria'].'</option>';
                            }
                        ?>
                    </select>
                    <label class="labelFile" for="imgProduct">Seleccione una imagen</label>
                    <input type="file" name="imgProduct" id="imgProduct" accept="image/*">
                    <label id="inputFileShow" class="labelFile" for="imgProduct">Adjuntar Archivo</label>
                    <input id="btnEnviar" type="submit" value="Actualizar">
                    <input type="hidden" name="accion" value="insertar">
                </form>
            </div>
        </div>



        <?php
    }
    ?>
<template id="templateRol">
    <option value=""></option>
</template>
<link rel="stylesheet" href="Style/CRUDStyles.css">