<?php
require_once __DIR__ . "/../config/conexion.php";

class Pedido {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Crear pedido con mesa o domicilio
    public function crearPedido($usuarioId, $mesaId, $direccionEntrega, $detalles) {
        try {
            $this->db->beginTransaction();

            // Calcular totales
            $subtotal = 0;
            foreach ($detalles as $d) {
                $subtotal += $d['Cantidad'] * $d['PrecioUnitario'];
            }

            $impuestos = $subtotal * 0.19;
            $total = $subtotal + $impuestos;

            // Insertar pedido
            $stmt = $this->db->prepare(
                "INSERT INTO pedido (Usuario_Id, Mesa_Id, Direccion_Entrega, Subtotal, Impuestos, Total)
                 VALUES (?, ?, ?, ?, ?, ?)"
            );

            $stmt->execute([
                $usuarioId,
                $mesaId,
                $direccionEntrega,
                $subtotal,
                $impuestos,
                $total
            ]);

            $pedidoId = $this->db->lastInsertId();

            // Insertar detalles
            $stmtDetalle = $this->db->prepare(
                "INSERT INTO detallepedido (Pedido_Id, Platillo_Id, Cantidad, PrecioUnitario)
                 VALUES (?, ?, ?, ?)"
            );

            foreach ($detalles as $d) {
                $stmtDetalle->execute([
                    $pedidoId,
                    $d['Platillo_Id'],
                    $d['Cantidad'],
                    $d['PrecioUnitario']
                ]);
            }

            $this->db->commit();
            return $pedidoId;

        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    // Pedidos de un usuario
    public function listarPedidosUsuario($usuarioId) {
        $stmt = $this->db->prepare("SELECT * FROM pedido WHERE Usuario_Id = ? ORDER BY Fecha DESC");
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function listarPedidos() {
    $stmt = $this->db->prepare("SELECT * FROM pedido ORDER BY Fecha DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function obtenerDetalles($pedidoId) {
    $stmt = $this->db->prepare("
        SELECT d.*, p.Nombre AS Platillo, p.Precio 
        FROM detallepedido d
        INNER JOIN platillo p ON d.Platillo_Id = p.Id_Platillo
        WHERE d.Pedido_Id = ?
    ");
    $stmt->execute([$pedidoId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // Obtener un pedido por ID
    public function obtenerPedido($pedidoId) {
        $stmt = $this->db->prepare("SELECT * FROM pedido WHERE Id_Pedido = ?");
        $stmt->execute([$pedidoId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
   public function actualizarEstado($idPedido, $nuevoEstado) {
    $stmt = $this->db->prepare("UPDATE pedido SET Estado = ? WHERE Id_Pedido = ?");
    $stmt->execute([$nuevoEstado, $idPedido]);
}
public function obtenerPedidoPorId($id) {
    $stmt = $this->db->prepare("SELECT * FROM pedido WHERE Id_Pedido = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function actualizarDireccion($idPedido, $direccion) {
    $stmt = $this->db->prepare("UPDATE pedido SET Direccion_Entrega = ? WHERE Id_Pedido = ?");
    return $stmt->execute([$direccion, $idPedido]);
}








    // Listar pedidos a domicilio
    public function listarDomicilios() {
        $stmt = $this->db->prepare("SELECT * FROM pedido WHERE Direccion_Entrega IS NOT NULL ORDER BY Fecha DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
