<?php
require_once __DIR__ . "/../config/conexion.php";

class Plato {
    private $db;

    public function __construct(){
        $this->db = Database::connect();
    }

    public function agregarPlato($Nombre, $Descripcion, $Precio, $Imagen){
        $sql = "INSERT INTO platillo (Nombre, Descripcion, Precio, Imagen) 
                VALUES (:Nombre, :Descripcion, :Precio, :Imagen)";
        $res = $this->db->prepare($sql);
        $res->bindParam(':Nombre', $Nombre);
        $res->bindParam(':Descripcion', $Descripcion);
        $res->bindParam(':Precio', $Precio);
        $res->bindParam(':Imagen', $Imagen);
        return $res->execute();
    }

    public function listarPlatos(){
        $sql = "SELECT * FROM platillo";
        $res = $this->db->prepare($sql);
        $res->execute();
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPlato($id) {
    $sql = "SELECT * FROM platillo WHERE Id_Platillo = :id";
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

public function actualizarPlato($id, $Nombre, $Descripcion, $Precio, $Imagen) {
    $sql = "UPDATE platillo SET Nombre = :Nombre, Descripcion = :Descripcion, Precio = :Precio, Imagen = :Imagen 
            WHERE Id_Platillo = :id";
    $res = $this->db->prepare($sql);
    $res->bindParam(':Nombre', $Nombre);
    $res->bindParam(':Descripcion', $Descripcion);
    $res->bindParam(':Precio', $Precio);
    $res->bindParam(':Imagen', $Imagen);
    $res->bindParam(':id', $id, PDO::PARAM_INT);
    return $res->execute();
}

}
?>
