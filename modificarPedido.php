<?php
    session_start();
    if (isset($_SESSION['user']['idRol'])) {
        include_once 'BD/conBD.php';
        include_once 'Assets/header.php';
        mostrarHeader('Modificar Pedido');
        echo "<main>";
        $pdo=pdo_conectar_mysql();
        $idPedidoSeleccionado=isset($_GET['idPedido']) ?$_GET['idPedido']:0;
        if ($idPedidoSeleccionado>0) {
            if (isset($_GET['nuls']) && $_GET['nuls']) {
                $sql=$pdo->prepare('SELECT pedido.* FROM pedido WHERE pedido.idPedido=?');
            }else {
                $sql=$pdo->prepare('SELECT pedido.*, cliente.NombreEmpresa, cliente.CorreoCliente FROM pedido JOIN cliente ON pedido.idCliente = cliente.idCliente WHERE pedido.idPedido=?');
            }
            $sql->execute([$idPedidoSeleccionado]);
            $pedido=$sql->fetch(PDO::FETCH_ASSOC);
            if ($sql->rowCount()==1) {
                if (isset($_GET['delete']) && $_GET['delete']) {
                    ?>
                    <div id="actualizar" class="eliminarPedido">
                        <h2>¿Esta seguro que desea eliminar el pedido de <u><?=isset($pedido['NombreEmpresa'])?$pedido['NombreEmpresa']:'\'Cliente Eliminado\''?></u>?</h2>
                        <div>
                            <form id="form">
                                <label for="idPedido">ID</label>
                                <p id="idPedido"><?=$pedido['idPedido']?></p>
                                <label for="nameCliente">Nombre</label>
                                <p id="nameCliente"><?=isset($pedido['NombreEmpresa'])?$pedido['NombreEmpresa']:'Cliente Eliminado'?></p>
                                <input type="submit" value="Eliminar" id="btnEliminarPedido">
                                <button id="btnCancelarEliminar">Volver</button>
                                <input type="hidden" name="accion" value="eliminar">
                            </form>
                        </div>
                    </div>
                    <?php
                }else {
                    $allProduct = $pdo->prepare('SELECT producto.Nombre, items.Cantidad, items.PrecioUnidad FROM items JOIN producto ON items.idProducto=producto.idProducto WHERE items.idPedido=?');
                    $allProduct->execute([$idPedidoSeleccionado]);
                    $allProduct=$allProduct->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div id="actualizar" class="actualizarPedido">
                        <h2>Informacion sobre pedido de: <u><?=isset($pedido['NombreEmpresa'])?$pedido['NombreEmpresa']:'\'Cliente Eliminado\''?></u></h2>
                        <div>
                            <form id="form">
                                <label for="idPedido">ID del pedido:</label>
                                <p id="idPedido"><?=$pedido['idPedido']?></p>
                                <label for="nameEmpresa">Nombre de la empresa:</label>
                                <p id="nameEmpresa"><?=isset($pedido['NombreEmpresa'])?$pedido['NombreEmpresa']:'Cliente Eliminado'?></p>
                                <label for="correoEmpresa">Correo de la empresa:</label>
                                <p id="correoEmpresa"><?=isset($pedido['CorreoCliente'])?$pedido['CorreoCliente']:'Cliente Eliminado'?></p>
                                <label for="metodoPago">Metodo Pago:</label>
                                <p id="metodoPago"><?=$pedido['MetodoPago']?></p>
                                <label for="precioTotal">Monto Total:</label>
                                <p id="precioTotal"><?=$pedido['PrecioTotal']?></p>
                                <label for="fecha">Fecha:</label>
                                <p id="fecha"><?=$pedido['Fecha']?></p>
                                <label style="display: block;">Productos:</label>
                                <div class="productos">
                                    <div class="carritompra">
                                        <h1>Nombre</h1>
                                        <p>Cantidad</p>
                                        <p>Precio Unitario</p>
                                    </div>
                                    <?php
                                    foreach ($allProduct as $key) {
                                    ?>
                                    <div class="carritompra">
                                        <h1><?=$key['Nombre']?></h1>
                                        <p><?=$key['Cantidad']?></p>
                                        <p>$ <?=$key['PrecioUnidad']?></p>
                                    </div>
                                    <?php }?>
                                </div>
                                <?php
                                    if (isset($pedido['NombreEmpresa'])) {
                                        ?>
                                        <input id="activo" type="checkbox" value="<?=$pedido['Confirmacion']?>" <?=$pedido['Confirmacion']==1? 'checked': ''?>>
                                        <label class="checkbox" for="activo">Pedido confirmado:</label>
                                        <input id="btnEnviar" type="submit" value="Actualizar">
                                        <?php
                                    }else {
                                        ?>
                                           <button onclick="javascript: history.go(-1)"><a>Volver</a></button>
                                        <?php
                                    }
                                ?>

                            </form>
                        </div>
                    </div>
                    <?php
                }
            }else {
                ?>
                <div id="actualizar">
                    <h2 style="text-align:center">ID Inexistente</h2>
                    <div>
                        <a onclick="javascript: history.go(-1)"><button>Volver</button></a>
                    </div>
                </div>
                <?php
            }
        }else {
            ?>
            <div id="actualizar">
                <h2 style="text-align:center">ID Inexistente</h2>
                <div>
                    <a onclick="javascript: history.go(-1)"><button>Volver</button></a>
                </div>
            </div>
            <?php
        }
        echo '</main>';
        include_once 'Assets/footer.php';
    }else {
        header("Location: index.php");
    }
    ?>    
<div id="divEmergente"></div>
<link rel="stylesheet" href="Style/CRUDStyles.css">
<script src="JavaScript/mod-Pedidos.js"></script>