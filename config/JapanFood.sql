CREATE DATABASE JapanFood;

USE JapanFood;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `categoria`
-- --------------------------------------------------------
CREATE TABLE `categoria` (
  `Id_Categoria` INT(5) NOT NULL,
  `Nombre` VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `usuario`
-- --------------------------------------------------------
CREATE TABLE `usuarios` (
  `Id_Usuario` INT(5) NOT NULL,
  `Nombre` VARCHAR(100) NOT NULL,
  `Email` VARCHAR(100) NOT NULL UNIQUE,
  `Password` VARCHAR(255) NOT NULL,
  `Rol` VARCHAR(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `detallepedido`
-- --------------------------------------------------------
CREATE TABLE `detallepedido` (
  `Id_Detalle` INT(5) NOT NULL,
  `Cantidad` INT(10) NOT NULL,
  `PrecioUnitario` DECIMAL(10,2) NOT NULL,
  `PedidoId_Pedido` INT(5) DEFAULT NULL,
  `PlatilloId_Platillo` INT(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `pago`
-- --------------------------------------------------------
CREATE TABLE `pago` (
  `Id_Pago` INT(5) NOT NULL,
  `Monto` DECIMAL(10,2) NOT NULL,
  `TipoPago` VARCHAR(50) NOT NULL,
  `PedidoId_Pedido` INT(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `pedido`
-- --------------------------------------------------------
CREATE TABLE `pedido` (
  `Id_Pedido` INT(5) NOT NULL,
  `Fecha` DATE NOT NULL,
  `TipoPedido` VARCHAR(20) NOT NULL,
  `Estado` VARCHAR(50) NOT NULL,
  `Subtotal` DECIMAL(10,2) DEFAULT NULL,
  `Impuestos` DECIMAL(10,2) DEFAULT NULL,
  `ClienteId_Cliente` INT(5) DEFAULT NULL,
  `SucursalId` INT(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `platillo`
-- --------------------------------------------------------
CREATE TABLE `platillo` (
  `Id_Platillo` INT(5) NOT NULL,
  `Nombre` VARCHAR(50) NOT NULL,
  `Descripcion` VARCHAR(255) DEFAULT NULL,
  `Precio` DECIMAL(10,2) DEFAULT NULL,
  `Imagen` VARCHAR(255) DEFAULT NULL,
  `CategoriaId_Categoria` INT(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `reserva`
-- --------------------------------------------------------
CREATE TABLE `reserva` (
  `Id_Reserva` INT(5) NOT NULL,
  `Fecha` DATE NOT NULL,
  `Hora` TIME NOT NULL,
  `Cantidad_Personas` INT(2) NOT NULL,
  `Descripcion` VARCHAR(255) DEFAULT NULL,
  `ClienteId_Cliente` INT(5) DEFAULT NULL,
  `SucursalId` INT(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Estructura de tabla para la tabla `sucursal`
-- --------------------------------------------------------
CREATE TABLE `sucursal` (
  `Id_Sucursal` INT(5) NOT NULL,
  `Nombre` VARCHAR(30) DEFAULT NULL,
  `Direccion` VARCHAR(255) DEFAULT NULL,
  `Ciudad` VARCHAR(20) DEFAULT NULL,
  `Imagen` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Índices para tablas volcadas
-- --------------------------------------------------------

-- Índices de la tabla `categoria`
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id_Categoria`);

-- Índices de la tabla `usuario`
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id_Usuario`);

-- Índices de la tabla `detallepedido`
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`Id_Detalle`),
  ADD KEY `PedidoId_Pedido` (`PedidoId_Pedido`),
  ADD KEY `PlatilloId_Platillo` (`PlatilloId_Platillo`);

-- Índices de la tabla `pago`
ALTER TABLE `pago`
  ADD PRIMARY KEY (`Id_Pago`),
  ADD KEY `PedidoId_Pedido` (`PedidoId_Pedido`);

-- Índices de la tabla `pedido`
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`Id_Pedido`),
  ADD KEY `ClienteId_Cliente` (`ClienteId_Cliente`),
  ADD KEY `SucursalId` (`SucursalId`);

-- Índices de la tabla `platillo`
ALTER TABLE `platillo`
  ADD PRIMARY KEY (`Id_Platillo`),
  ADD KEY `CategoriaId_Categoria` (`CategoriaId_Categoria`);

-- Índices de la tabla `reserva`
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`Id_Reserva`),
  ADD KEY `ClienteId_Cliente` (`ClienteId_Cliente`),
  ADD KEY `SucursalId` (`SucursalId`);

-- Índices de la tabla `sucursal`
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`Id_Sucursal`);

-- --------------------------------------------------------
-- Restricciones para tablas volcadas
-- --------------------------------------------------------

-- Filtros para la tabla `detallepedido`
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`PedidoId_Pedido`) REFERENCES `pedido` (`Id_Pedido`),
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`PlatilloId_Platillo`) REFERENCES `platillo` (`Id_Platillo`);

-- Filtros para la tabla `pago`
ALTER TABLE `pago`
  ADD CONSTRAINT `pago_ibfk_1` FOREIGN KEY (`PedidoId_Pedido`) REFERENCES `pedido` (`Id_Pedido`);

-- Filtros para la tabla `pedido`
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ClienteId_Cliente`) REFERENCES `usuario` (`Id_Usuario`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`SucursalId`) REFERENCES `sucursal` (`Id_Sucursal`);

-- Filtros para la tabla `platillo`
ALTER TABLE `platillo`
  ADD CONSTRAINT `platillo_ibfk_1` FOREIGN KEY (`CategoriaId_Categoria`) REFERENCES `categoria` (`Id_Categoria`);

-- Filtros para la tabla `reserva`
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`ClienteId_Cliente`) REFERENCES `usuario` (`Id_Usuario`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`SucursalId`) REFERENCES `sucursal` (`Id_Sucursal`);

COMMIT;
