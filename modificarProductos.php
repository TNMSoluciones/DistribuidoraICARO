<!DOCTYPE html>
<?php
    session_start();
    include_once 'BD/conBD.php';
    include_once 'Assets/header.php';
    mostrarHeader('Modificar Productos');
    echo '<main>';
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
                    <label for="descripcion">Descripción:</label>
                    <textarea id="descripcion" placeholder="Ingrese la descripción del producto" readonly></textarea>
                    <input id="btnEnviar" type="submit" value="Actualizar">
                    <input type="hidden" name="accion" value="insertar">
                </form>
            </div>
        </div>
        <?php
    }else if($idProductoSeleccionado<0)
    {
        ?>
            <div id="actualizar">
                <h2 style="text-align:center">ID Inexistente</h2>
                <div>
                    <a href="pagempleado.php"><button>Volver</button></a>
                </div>
            </div>
        <?php
    }else if($idProductoSeleccionado>0)
    {
        $sql=$pdo->prepare('SELECT producto.*, categorias.Categoria, personal.PrimerNombre, personal.SegundoNombre, personal.Apellido FROM producto JOIN categorias ON producto.idCategoria=categorias.idCategoria JOIN personal ON personal.idPersonal=producto.idPersonal WHERE idProducto=?');
        $sql->execute([$idProductoSeleccionado]);
        $producto=$sql->fetch(PDO::FETCH_ASSOC);
        if($producto['SegundoNombre']==NULL){
            $nombreCompleto= $producto['PrimerNombre'].' '.$producto['Apellido'];
        }else{$nombreCompleto= $producto['PrimerNombre'].' '.$producto['SegundoNombre'].' '.$producto['Apellido'];}
        if(!isset($_GET['delete'])){
            ?>
                <div id="actualizar" class="actualizarProducto">
                    <h2>Actualizar Producto: <u><?=$producto['Nombre']?></u></h2>
                    <div>
                        <form id="form" enctype="multipart/form-data">
                            <label for="idProduct">ID</label>
                            <input type="number" name="idProduct" value="<?=$producto['idProducto']?>" id="idProduct" readonly>
                            <label for="nameProduct">Nombre</label>
                            <label for="stockProduct">Stock</label>
                            <input id="nameProduct" name="nameProduct" value="<?=$producto['Nombre']?>" type="text">
                            <input id="stockProduct" name="stockProduct" value="<?=$producto['Stock']?>" type="number">
                            <label for="priceProduct">Precio</label>
                            <label for="catProduct">Categoria</label>
                            <input id="priceProduct" name="priceProduct" value="<?=$producto['Precio']?>" type="number">
                            <select id="catProduct" name="catProduct">
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
                            <input name="activo" id="activo" type="checkbox" value="<?=$producto['Destacado']?>" <?=$producto['Destacado']==1? 'checked': ''?>>
                            <label class="checkbox" for="activo">Producto Destacado:</label>
                            <label for="descripcion" style="width: 100%;">Descripción:</label>
                            <textarea id="descripcion" placeholder="Ingrese la descripción del producto" readonly></textarea>
                            <input id="btnEnviar" type="submit" value="Actualizar">
                            <input type="hidden" name="accion" value="actualizar">
                        </form>
                    </div>
                </div>
            <?php
        }else if(isset($_GET['delete'])) {
            ?>
            <div id="actualizar" class="eliminarProducto">
                <h2>¿Esta seguro que desea eliminar <u><?=$producto['Nombre']?></u>?</h2>
                <div>
                    <form id="form">
                        <label for="idProduct">ID</label>
                        <label for="nameProduct">Nombre</label>
                        <input type="number" value="<?=$producto['idProducto']?>" name="idProduct" id="idProduct" readonly>
                        <input type="text" value="<?=$producto['Nombre']?>" id="nameProduct" readonly>
                        <input type="submit" value="Eliminar" id="btnEliminarProducto">
                        <button id="btnCancelarEliminar">No</button>
                        <input type="hidden" name="accion" value="eliminar">
                    </form>
                </div>
                <div class="insertarAca"></div>
            </div>
            <?php
        }
    }
    echo '</main>';
    include_once 'Assets/footer.php';
?>
<template id="templateRol">
    <option value=""></option>
</template>
<link rel="stylesheet" href="Style/CRUDStyles.css">
<script src="JavaScript/functionCRUD.js"></script>