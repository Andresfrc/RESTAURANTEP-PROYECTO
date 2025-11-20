<?php
require_once __DIR__ . "/../config/conexion.php";

class Plato {
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function agregarPlato($Nombre, $Descripcion, $Precio, $Imagen, $CategoriaId = null){
        $sql = "INSERT INTO platillo (Nombre, Descripcion, Precio, Imagen, CategoriaId_Categoria) 
                VALUES (:Nombre, :Descripcion, :Precio, :Imagen, :CategoriaId)";
        $res = $this->db->prepare($sql);
        $res->bindParam(':Nombre', $Nombre);
        $res->bindParam(':Descripcion', $Descripcion);
        $res->bindParam(':Precio', $Precio);
        $res->bindParam(':Imagen', $Imagen);
        $res->bindParam(':CategoriaId', $CategoriaId);
        return $res->execute();
    }

    public function listarPlatos(){
        $sql = "SELECT p.*, c.Nombre as NombreCategoria 
                FROM platillo p 
                LEFT JOIN categoria c ON p.CategoriaId_Categoria = c.Id_Categoria";
        $res = $this->db->prepare($sql);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPlatosPorCategoria($categoriaId){
        $sql = "SELECT * FROM platillo WHERE CategoriaId_Categoria = :categoriaId";
        $res = $this->db->prepare($sql);
        $res->bindParam(':categoriaId', $categoriaId);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPlato($id) {
        $sql = "SELECT p.*, c.Nombre as NombreCategoria 
                FROM platillo p 
                LEFT JOIN categoria c ON p.CategoriaId_Categoria = c.Id_Categoria 
                WHERE p.Id_Platillo = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        $res->execute();
        return $res->fetch(PDO::FETCH_ASSOC);
    }

    public function eliminarPlato($id) {
        $sql = "DELETE FROM platillo WHERE Id_Platillo = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        return $res->execute();
    }

    public function actualizarPlato($id, $Nombre, $Descripcion, $Precio, $Imagen, $CategoriaId = null) {
        $sql = "UPDATE platillo 
                SET Nombre = :Nombre, 
                    Descripcion = :Descripcion, 
                    Precio = :Precio, 
                    Imagen = :Imagen,
                    CategoriaId_Categoria = :CategoriaId
                WHERE Id_Platillo = :id";
        $res = $this->db->prepare($sql);
        $res->bindParam(':Nombre', $Nombre);
        $res->bindParam(':Descripcion', $Descripcion);
        $res->bindParam(':Precio', $Precio);
        $res->bindParam(':Imagen', $Imagen);
        $res->bindParam(':CategoriaId', $CategoriaId);
        $res->bindParam(':id', $id, PDO::PARAM_INT);
        return $res->execute();
    }
}
?>