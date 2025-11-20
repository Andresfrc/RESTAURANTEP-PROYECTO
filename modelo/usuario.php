<?php
require_once __DIR__ . "/../config/conexion.php";

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function obtener_usuario($email) {
        $sql = "SELECT * FROM usuarios WHERE Email = :email LIMIT 1";
        $consult = $this->db->prepare($sql);
        $consult->execute([":email" => $email]);
        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $pass) {
        $usuario = $this->obtener_usuario($email);
        if ($usuario && password_verify($pass, $usuario['Password'])) {
            return $usuario;
        }
        return false;
    }

    public function listar_usuarios() {
        $stmt = $this->db->query("SELECT * FROM usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function borrar_usuario($id) {
        $sql = "DELETE FROM usuarios WHERE Id_Usuario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }

    public function obtener_usuario_por_id($id) {
        $sql = "SELECT * FROM usuarios WHERE Id_Usuario = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function obtenerUsuario($idUsuario) {
    $query = "SELECT * FROM usuarios WHERE Id_Usuario = ?";
    $stmt = $this->db->prepare($query);
    $stmt->execute([$idUsuario]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    public function actualizar_usuario($id, $nombre, $email, $rol) {
        $sql = "UPDATE usuarios SET Nombre = :nombre, Email = :email, Rol = :rol WHERE Id_Usuario = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":email" => $email,
            ":rol" => $rol,
            ":id" => $id
        ]);
    }

    // MÉTODO FALTANTE - usado por editar_usuario_controlador.php
    public function actualizar_usuario_completo($id, $nombre, $rol, $password = null) {
        if ($password) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET Nombre = :nombre, Rol = :rol, Password = :password WHERE Id_Usuario = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ":nombre" => $nombre,
                ":rol" => $rol,
                ":password" => $hash,
                ":id" => $id
            ]);
        } else {
            $sql = "UPDATE usuarios SET Nombre = :nombre, Rol = :rol WHERE Id_Usuario = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ":nombre" => $nombre,
                ":rol" => $rol,
                ":id" => $id
            ]);
        }
    }

    public function actualizar_perfil($id, $nombre, $password = null) {
        if ($password) {
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE usuarios SET Nombre = :nombre, Password = :password WHERE Id_Usuario = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ":nombre" => $nombre,
                ":password" => $hash,
                ":id" => $id
            ]);
        } else {
            $sql = "UPDATE usuarios SET Nombre = :nombre WHERE Id_Usuario = :id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ":nombre" => $nombre,
                ":id" => $id
            ]);
        }
    }

    public function crear_usuario($nombre, $email, $password, $rol = "Usuario") {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (Nombre, Email, Password, Rol) 
                VALUES (:nombre, :email, :password, :rol)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ":nombre" => $nombre,
            ":email" => $email,
            ":password" => $hash,
            ":rol" => $rol
        ]);
    }
}
?>