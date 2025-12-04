<?php
require_once __DIR__ . "/../config/conexion.php";

class Mesa {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    // Registrar mesa
    public function registrarMesa($numero, $capacidad, $ubicacion) {
        $query = "INSERT INTO mesa (Numero_Mesa, Capacidad, Ubicacion, Estado) 
                  VALUES (?, ?, ?, 'Libre')";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$numero, $capacidad, $ubicacion]);
    }

    // Listar todas las mesas
    public function listarMesas() {
        $query = "SELECT * FROM mesa ORDER BY Numero_Mesa ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Listar solo disponibles
    public function listarMesasDisponibles() {
        // Mostrar mesas que estén Libres o Ocupadas (no Reservadas completamente)
        $query = "SELECT * FROM mesa WHERE Estado IN ('Libre', 'Ocupada') ORDER BY Numero_Mesa ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar estado
    public function actualizarEstado($idMesa, $estado) {
        $query = "UPDATE mesa SET Estado = ? WHERE Id_Mesa = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$estado, $idMesa]);
    }

    // Obtener una mesa por ID
    public function obtenerMesa($idMesa) {
        $query = "SELECT * FROM mesa WHERE Id_Mesa = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idMesa]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Actualizar datos de una mesa
    public function actualizarMesa($idMesa, $numero, $capacidad, $ubicacion) {
        $query = "UPDATE mesa SET Numero_Mesa=?, Capacidad=?, Ubicacion=? WHERE Id_Mesa=?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$numero, $capacidad, $ubicacion, $idMesa]);
    }

    // Eliminar mesa
    public function eliminarMesa($idMesa) {
        $query = "DELETE FROM mesa WHERE Id_Mesa = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$idMesa]);
    }
}
?>
