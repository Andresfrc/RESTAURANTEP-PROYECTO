CREATE DATABASE JapanFood

use JapanFood;  

CREATE TABLE `categoria` (
  `Id_Categoria` int(5) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cliente`
--

CREATE TABLE `cliente` (
  `Id_Cliente` int(5) NOT NULL,
  `Nombre` varchar(5) NOT NULL,
  `Telefono` varchar(15) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Direccion` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `Id_Detalle` int(5) NOT NULL,
  `Cantidad` int(10) NOT NULL,
  `PrecioUnitario` int(10) NOT NULL,
  `PedidoId_Pedido` int(5) DEFAULT NULL,
  `PlatilloId_Platillo` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `Id_Categoria` int(5) NOT NULL,
  `Nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `Id_Pedido` int(5) NOT NULL,
  `Fecha` int(10) NOT NULL,
  `TipoPedido` varchar(20) NOT NULL,
  `Estado` varchar(50) NOT NULL,
  `Subtotal` int(10) DEFAULT NULL,
  `Impuestos` varchar(50) DEFAULT NULL,
  `ClienteId_Cliente` int(5) DEFAULT NULL,
  `SucursalColumn` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platillo`
--

CREATE TABLE `platillo` (
  `Id_Platillo` int(5) NOT NULL,
  `Nombre` varchar(50) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `Precio` int(15) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL,
  `CategoriaId_Categoria` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `Id_Reserva` int(5) NOT NULL,
  `Fecha` int(10) NOT NULL,
  `Hora` int(10) NOT NULL,
  `Cantidad_Personas` int(2) NOT NULL,
  `Descripcion` varchar(255) DEFAULT NULL,
  `ClienteId_Cliente` int(5) DEFAULT NULL,
  `SucursalColumn` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `Id_Sucursal` int(5) NOT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `Direccion` varchar(20) DEFAULT NULL,
  `Ciudad` varchar(20) DEFAULT NULL,
  `Imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`Id_Categoria`);

--
-- Indices de la tabla `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`Id_Cliente`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`Id_Detalle`),
  ADD KEY `PedidoId_Pedido` (`PedidoId_Pedido`),
  ADD KEY `PlatilloId_Platillo` (`PlatilloId_Platillo`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`Id_Categoria`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`Id_Pedido`),
  ADD KEY `ClienteId_Cliente` (`ClienteId_Cliente`),
  ADD KEY `SucursalColumn` (`SucursalColumn`);

--
-- Indices de la tabla `platillo`
--
ALTER TABLE `platillo`
  ADD PRIMARY KEY (`Id_Platillo`),
  ADD KEY `CategoriaId_Categoria` (`CategoriaId_Categoria`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`Id_Reserva`),
  ADD KEY `ClienteId_Cliente` (`ClienteId_Cliente`),
  ADD KEY `SucursalColumn` (`SucursalColumn`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`Id_Sucursal`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `detallepedido_ibfk_1` FOREIGN KEY (`PedidoId_Pedido`) REFERENCES `pedido` (`Id_Pedido`),
  ADD CONSTRAINT `detallepedido_ibfk_2` FOREIGN KEY (`PlatilloId_Platillo`) REFERENCES `platillo` (`Id_Platillo`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`ClienteId_Cliente`) REFERENCES `cliente` (`Id_Cliente`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`SucursalColumn`) REFERENCES `sucursal` (`Id_Sucursal`);

--
-- Filtros para la tabla `platillo`
--
ALTER TABLE `platillo`
  ADD CONSTRAINT `platillo_ibfk_1` FOREIGN KEY (`CategoriaId_Categoria`) REFERENCES `categoria` (`Id_Categoria`);

--
-- Filtros para la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`ClienteId_Cliente`) REFERENCES `cliente` (`Id_Cliente`),
  ADD CONSTRAINT `reserva_ibfk_2` FOREIGN KEY (`SucursalColumn`) REFERENCES `sucursal` (`Id_Sucursal`);
COMMIT;
