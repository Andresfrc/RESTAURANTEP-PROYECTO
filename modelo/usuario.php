<?php
require_once __DIR__ . "/../config/conexion.php";

class Usuario {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function obtener_usuario($email) {
        $sql = "SELECT * FROM usuarios WHERE email=:email LIMIT 1";
        $consult = $this->db->prepare($sql);
        $consult->execute([":email" => $email]);

        return $consult->fetch(PDO::FETCH_ASSOC);
    }

    public function login($email, $pass) {
        $usuario = $this->obtener_usuario($email);
        if ($usuario && password_verify($pass, $usuario['password'])) {
            return $usuario;
        }
        return false;
    }

    public function listar_usuarios() {
        // Por implementar
    }

    public function crear_usuario($nombre, $email, $password, $rol = "Usuario") {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nombre, email, password, rol) 
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
