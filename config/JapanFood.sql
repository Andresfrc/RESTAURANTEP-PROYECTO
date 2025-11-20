DROP DATABASE IF EXISTS JapanFood;
CREATE DATABASE JapanFood;
USE JapanFood;

-- --------------------------------------------------------
-- Tabla: categoria
-- --------------------------------------------------------
CREATE TABLE categoria (
  Id_Categoria INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: usuarios
-- --------------------------------------------------------
CREATE TABLE usuarios (
  Id_Usuario INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(100) NOT NULL,
  Email VARCHAR(100) NOT NULL UNIQUE,
  Password VARCHAR(255) NOT NULL,
  Rol VARCHAR(20) NOT NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: mesa
-- --------------------------------------------------------
CREATE TABLE mesa (
    Id_Mesa INT AUTO_INCREMENT PRIMARY KEY,
    Numero_Mesa INT NOT NULL,
    Capacidad INT NOT NULL,
    Ubicacion VARCHAR(50) NOT NULL,
    Estado ENUM('Libre', 'Ocupada', 'Reservada') DEFAULT 'Libre'
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: platillo
-- --------------------------------------------------------
CREATE TABLE platillo (
  Id_Platillo INT AUTO_INCREMENT PRIMARY KEY,
  Nombre VARCHAR(50) NOT NULL,
  Descripcion VARCHAR(255),
  Precio DECIMAL(10,2),
  Imagen VARCHAR(255),
  CategoriaId_Categoria INT,
  FOREIGN KEY (CategoriaId_Categoria) REFERENCES categoria(Id_Categoria) ON DELETE SET NULL
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: pedido
-- --------------------------------------------------------
CREATE TABLE pedido (
  Id_Pedido INT AUTO_INCREMENT PRIMARY KEY,
  Fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Estado ENUM('Pendiente','En Preparación','Entregado','Cancelado') DEFAULT 'Pendiente',
  Subtotal DECIMAL(10,2) DEFAULT 0,
  Impuestos DECIMAL(10,2) DEFAULT 0,
  Total DECIMAL(10,2) DEFAULT 0,
  Direccion_Entrega VARCHAR(255) DEFAULT NULL,
  Telefono_Entrega VARCHAR(20) DEFAULT NULL,
  Usuario_Id INT NOT NULL,
  Mesa_Id INT NULL,
  FOREIGN KEY (Usuario_Id) REFERENCES usuarios(Id_Usuario),
  FOREIGN KEY (Mesa_Id) REFERENCES mesa(Id_Mesa)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: detallepedido
-- --------------------------------------------------------
CREATE TABLE detallepedido (
  Id_Detalle INT AUTO_INCREMENT PRIMARY KEY,
  Pedido_Id INT NOT NULL,
  Platillo_Id INT NOT NULL,
  Cantidad INT NOT NULL,
  PrecioUnitario DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (Pedido_Id) REFERENCES pedido(Id_Pedido) ON DELETE CASCADE,
  FOREIGN KEY (Platillo_Id) REFERENCES platillo(Id_Platillo)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: pago
-- --------------------------------------------------------
CREATE TABLE pago (
  Id_Pago INT AUTO_INCREMENT PRIMARY KEY,
  Monto DECIMAL(10,2) NOT NULL,
  TipoPago VARCHAR(50) NOT NULL,
  Estado VARCHAR(20) DEFAULT 'Pendiente',
  PedidoId_Pedido INT,
  FOREIGN KEY (PedidoId_Pedido) REFERENCES pedido(Id_Pedido) ON DELETE CASCADE
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Tabla: reserva
-- --------------------------------------------------------
CREATE TABLE reserva (
    Id_Reserva INT AUTO_INCREMENT PRIMARY KEY,
    Usuario_Id INT NOT NULL,
    Mesa_Id INT NULL,
    Fecha DATE NOT NULL,
    Hora TIME NOT NULL,
    Cantidad_Personas INT NOT NULL,
    Descripcion TEXT NULL,
    Estado ENUM('Pendiente', 'Confirmada', 'Cancelada') DEFAULT 'Pendiente',
    Fecha_Creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Usuario_Id) REFERENCES usuarios(Id_Usuario),
    FOREIGN KEY (Mesa_Id) REFERENCES mesa(Id_Mesa)
) ENGINE=InnoDB;

-- --------------------------------------------------------
-- Datos iniciales
-- --------------------------------------------------------
INSERT INTO categoria (Nombre) VALUES
('Entradas'), ('Platos Fuertes'), ('Postres'), ('Bebidas');
