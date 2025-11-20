<?php
require_once __DIR__ . "/../config/conexion.php";

class Reserva {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // ================================
    // Crear una nueva reserva
    // ================================
    public function crearReserva($usuarioId, $mesaId, $fecha, $hora, $cantidadPersonas, $descripcion = null) {
        $query = "INSERT INTO reserva (Usuario_Id, Mesa_Id, Fecha, Hora, Cantidad_Personas, Descripcion, Estado, Fecha_Creacion)
                  VALUES (?, ?, ?, ?, ?, ?, 'Pendiente', NOW())";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$usuarioId, $mesaId, $fecha, $hora, $cantidadPersonas, $descripcion]);
    }

    // ================================
    // Listar reservas de un usuario
    // ================================
    public function listarReservasUsuario($usuarioId) {
        $query = "SELECT * FROM reserva WHERE Usuario_Id = ? ORDER BY Fecha DESC, Hora DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$usuarioId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================================
    // Actualizar estado de reserva
    // ================================
    public function actualizarEstado($idReserva, $estado) {
        $query = "UPDATE reserva SET Estado = ? WHERE Id_Reserva = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$estado, $idReserva]);
    }

    // ================================
    // Obtener datos de una reserva
    // ================================
    public function obtenerReserva($idReserva) {
        $query = "SELECT * FROM reserva WHERE Id_Reserva = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idReserva]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================================
    // Validar si la mesa ya tiene reserva a la misma fecha y hora
    // ================================
    public function existeReservaEnMesa($mesaId, $fecha, $hora) {
        $query = "SELECT COUNT(*) FROM reserva 
                  WHERE Mesa_Id = ? AND Fecha = ? AND Hora = ? AND Estado != 'Cancelada'";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$mesaId, $fecha, $hora]);
        return $stmt->fetchColumn() > 0;
    }
    // Listar todas las reservas (Administrador)
    public function listarTodasReservas() {
        $query = "SELECT * FROM reserva ORDER BY Fecha DESC, Hora DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// ================================
// Cancelar una reserva
// ================================
public function cancelarReserva($idReserva, $usuarioId = null) {
    // Opcional: solo cancelar si pertenece al usuario (para seguridad)
    if ($usuarioId) {
        $query = "UPDATE reserva SET Estado='Cancelada' WHERE Id_Reserva=? AND Usuario_Id=?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idReserva, $usuarioId]);
    } else {
        // Para admin, puede cancelar cualquier reserva
        $query = "UPDATE reserva SET Estado='Cancelada' WHERE Id_Reserva=?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idReserva]);
    }
}


}
?>
