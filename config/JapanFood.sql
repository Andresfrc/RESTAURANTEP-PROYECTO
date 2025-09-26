CREATE DATABASE JapanFood;
USE JapanFood;

-- --------------------------------------------------------
-- Tabla: categoria
-- --------------------------------------------------------
CREATE TABLE `categoria` (
  `Id_Categoria` INT(5) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`Id_Categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: usuarios
-- --------------------------------------------------------
CREATE TABLE `usuarios` (
  `Id_Usuario` INT(5) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(100) NOT NULL,
  `Email` VARCHAR(100) NOT NULL UNIQUE,
  `Password` VARCHAR(255) NOT NULL,
  `Rol` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`Id_Usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: detallepedido
-- --------------------------------------------------------
CREATE TABLE `detallepedido` (
  `Id_Detalle` INT(5) NOT NULL AUTO_INCREMENT,
  `Cantidad` INT(10) NOT NULL,
  `PrecioUnitario` DECIMAL(10,2) NOT NULL,
  `PedidoId_Pedido` INT(5) DEFAULT NULL,
  `PlatilloId_Platillo` INT(5) DEFAULT NULL,
  PRIMARY KEY (`Id_Detalle`),
  KEY `PedidoId_Pedido` (`PedidoId_Pedido`),
  KEY `PlatilloId_Platillo` (`PlatilloId_Platillo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: pago
-- --------------------------------------------------------
CREATE TABLE `pago` (
  `Id_Pago` INT(5) NOT NULL AUTO_INCREMENT,
  `Monto` DECIMAL(10,2) NOT NULL,
  `TipoPago` VARCHAR(50) NOT NULL,
  `PedidoId_Pedido` INT(5) DEFAULT NULL,
  PRIMARY KEY (`Id_Pago`),
  KEY `PedidoId_Pedido` (`PedidoId_Pedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: pedido
-- --------------------------------------------------------
CREATE TABLE `pedido` (
  `Id_Pedido` INT(5) NOT NULL AUTO_INCREMENT,
  `Fecha` DATE NOT NULL,
  `TipoPedido` VARCHAR(20) NOT NULL,
  `Estado` VARCHAR(50) NOT NULL,
  `Subtotal` DECIMAL(10,2) DEFAULT NULL,
  `Impuestos` DECIMAL(10,2) DEFAULT NULL,
  `ClienteId_Cliente` INT(5) DEFAULT NULL,
  `SucursalId` INT(5) DEFAULT NULL,
  PRIMARY KEY (`Id_Pedido`),
  KEY `ClienteId_Cliente` (`ClienteId_Cliente`),
  KEY `SucursalId` (`SucursalId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: platillo
-- --------------------------------------------------------
CREATE TABLE `platillo` (
  `Id_Platillo` INT(5) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(50) NOT NULL,
  `Descripcion` VARCHAR(255) DEFAULT NULL,
  `Precio` DECIMAL(10,2) DEFAULT NULL,
  `Imagen` VARCHAR(255) DEFAULT NULL,
  `CategoriaId_Categoria` INT(5) DEFAULT NULL,
  PRIMARY KEY (`Id_Platillo`),
  KEY `CategoriaId_Categoria` (`CategoriaId_Categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: reserva
-- --------------------------------------------------------
CREATE TABLE `reserva` (
  `Id_Reserva` INT(5) NOT NULL AUTO_INCREMENT,
  `Fecha` DATE NOT NULL,
  `Hora` TIME NOT NULL,
  `Cantidad_Personas` INT(2) NOT NULL,
  `Descripcion` VARCHAR(255) DEFAULT NULL,
  `ClienteId_Cliente` INT(5) DEFAULT NULL,
  `SucursalId` INT(5) DEFAULT NULL,
  PRIMARY KEY (`Id_Reserva`),
  KEY `ClienteId_Cliente` (`ClienteId_Cliente`),
  KEY `SucursalId` (`SucursalId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Tabla: sucursal
-- --------------------------------------------------------
CREATE TABLE `sucursal` (
  `Id_Sucursal` INT(5) NOT NULL AUTO_INCREMENT,
  `Nombre` VARCHAR(30) DEFAULT NULL,
  `Direccion` VARCHAR(255) DEFAULT NULL,
  `Ciudad` VARCHAR(20) DEFAULT NULL,
  `Imagen` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`Id_Sucursal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Relaciones (FOREIGN KEYS)
-- --------------------------------------------------------

ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`PedidoId_Pedido`) REFERENCES `pedido` (`Id_Pedido`),
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`PlatilloId_Platillo`) REFERENCES `platillo` (`Id_Platillo`);

ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`PedidoId_Pedido`) REFERENCES `pedido` (`Id_Pedido`);

ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ClienteId_Cliente`) REFERENCES `usuarios` (`Id_Usuario`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`SucursalId`) REFERENCES `sucursal` (`Id_Sucursal`);

ALTER TABLE `platillo`
  ADD CONSTRAINT `platillo_ibfk_1` FOREIGN KEY (`CategoriaId_Categoria`) REFERENCES `categoria` (`Id_Categoria`);

ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`ClienteId_Cliente`) REFERENCES `usuarios` (`Id_Usuario`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`SucursalId`) REFERENCES `sucursal` (`Id_Sucursal`);

COMMIT;
