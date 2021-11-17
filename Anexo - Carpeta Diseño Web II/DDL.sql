SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE DATABASE IF NOT EXISTS `icaro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `icaro`;
CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `Categoria` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `ciudad` (
  `idCiudad` int(11) NOT NULL,
  `Nombre` varchar(200) NOT NULL,
  `idDepartamento` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `cliente` (
  `RUT` char(12) NOT NULL,
  `NombreEmpresa` varchar(100) NOT NULL,
  `CorreoCliente` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `CodigoPostal` varchar(20) NOT NULL,
  `CalleDir` varchar(100) NOT NULL,
  `NumeroDir` varchar(50) NOT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 0,
  `Latitud` varchar(50) DEFAULT NULL,
  `Longitud` varchar(50) DEFAULT NULL,
  `idCiudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `departamento` (
  `idDepartamento` int(11) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `items` (
  `idPedido` int(11) NOT NULL,
  `idProducto` int(11) NOT NULL,
  `Cantidad` double NOT NULL,
  `PrecioUnidad` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `opiniones` (
  `idOpinion` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `correoOpinion` varchar(100) NOT NULL,
  `nombreOpinion` varchar(100) NOT NULL,
  `Opinion` varchar(401) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `MetodoPago` enum('POS','Efectivo') NOT NULL,
  `PrecioTotal` double NOT NULL,
  `Fecha` date NOT NULL,
  `Confirmacion` enum('0','1') NOT NULL DEFAULT '0',
  `idCliente` char(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `personal` (
  `PrimerNombre` varchar(50) NOT NULL,
  `SegundoNombre` varchar(50) DEFAULT NULL,
  `Apellido` varchar(50) NOT NULL,
  `Correo` varchar(100) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `idPersonal` int(11) NOT NULL,
  `idRol` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `producto` (
  `idProducto` int(11) NOT NULL,
  `Stock` double NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Precio` double NOT NULL,
  `Imagen` mediumblob NOT NULL,
  `descripcion` varchar(500) NOT NULL,
  `Destacado` tinyint(1) NOT NULL DEFAULT 0,
  `idCategoria` int(11) NOT NULL,
  `idPersonal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `roles` (
  `idRol` int(11) NOT NULL,
  `Rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);
ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`idCiudad`),
  ADD KEY `ciudad_idDepartamento` (`idDepartamento`);
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`RUT`) USING BTREE,
  ADD UNIQUE KEY `CorreoCliente` (`CorreoCliente`),
  ADD KEY `idCiudad_Ciudad` (`idCiudad`);
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`idDepartamento`);
ALTER TABLE `items`
  ADD PRIMARY KEY (`idProducto`,`idPedido`),
  ADD KEY `Items_idPedido_Pedido` (`idPedido`);
ALTER TABLE `opiniones`
  ADD PRIMARY KEY (`idOpinion`);
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `Pedido_idCliente_Cliente` (`idCliente`);
ALTER TABLE `personal`
  ADD PRIMARY KEY (`idPersonal`);
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `Producto_idCategoria_Categorias` (`idCategoria`),
  ADD KEY `Producto_idPersonal_Personal` (`idPersonal`);
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `departamento`
  MODIFY `idDepartamento` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `opiniones`
  MODIFY `idOpinion` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `personal`
  MODIFY `idPersonal` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `producto`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `roles`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `ciudad`
  ADD CONSTRAINT `ciudad_idDepartamento` FOREIGN KEY (`idDepartamento`) REFERENCES `departamento` (`idDepartamento`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `cliente`
  ADD CONSTRAINT `fk_idCiudad_Ciudad` FOREIGN KEY (`idCiudad`) REFERENCES `ciudad` (`idCiudad`);
ALTER TABLE `items`
  ADD CONSTRAINT `Items_idPedido_Pedido` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Items_idProducto_Producto` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`) ON UPDATE CASCADE;
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_idCliente_Cliente` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`RUT`) ON DELETE SET NULL ON UPDATE CASCADE;
ALTER TABLE `personal`
  ADD CONSTRAINT `fk_idRol_Roles` FOREIGN KEY (`idRol`) REFERENCES `roles` (`idRol`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `producto`
  ADD CONSTRAINT `Producto_idCategoria_Categoria` FOREIGN KEY (`idCategoria`) REFERENCES `categorias` (`idCategoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Producto_idPersonal_Personal` FOREIGN KEY (`idPersonal`) REFERENCES `personal` (`idPersonal`) ON UPDATE CASCADE;
COMMIT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;