<?php
require_once __DIR__ . "/../config/conexion.php";

class Plato{
    private $db;

    public function __construct(){
        $this->db = Database::connect();
}

public function agregarPlato($Nombre, $Descripcion, $Precio, $Imagen){
        $sql = "INSERT INTO platillo (Nombre, Descripcion, Precio, Imagen) 
                VALUES (:Nombre, :Descripcion, :Precio, :Imagen )";
        $res = $this->db->prepare($sql);
        $res->bindParam(':Nombre', $Nombre);
        $res->bindParam(':Descripcion', $Descripcion);
        $res->bindParam(':Precio', $Precio);
        $res->bindParam(':Imagen', $Imagen);
        return $res->execute();
    }
}

?>