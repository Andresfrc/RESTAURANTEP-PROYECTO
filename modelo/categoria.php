<?php
require_once __DIR__ . "/../config/conexion.php";

class Categoria {
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function listarCategorias(){
        $sql = "SELECT * FROM categoria";
        $res = $this->db->prepare($sql);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerCategoria($id) {
        $sql = "SELECT * FROM categoria WHERE Id_Categoria = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        $res->execute();
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarCategoria($nombre){
        $sql = "INSERT INTO categoria (Nombre) VALUES (:nombre)";
        $res = $this->db->prepare($sql);
        $res->bindParam(':nombre', $nombre);
        return $res->execute();
    }

    public function actualizarCategoria($id, $nombre) {
        $sql = "UPDATE categoria SET Nombre = :nombre WHERE Id_Categoria = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(':nombre', $nombre);
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        return $res->execute();
    }

    public function eliminarCategoria($id) {
        $sql = "DELETE FROM categoria WHERE Id_Categoria = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        return $res->execute();
    }
}
?>