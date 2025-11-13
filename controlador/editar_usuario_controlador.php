<?php
require_once __DIR__ . "/../modelo/usuario.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->obtener_usuario_por_id($id);

    if (!$usuario) {
        die("Usuario no encontrado.");
    }

    // Actualizar usuario con todos los campos
    $usuarioModel->actualizar_usuario_completo($id, $nombre, $rol, $password);

    header("Location: ../vista/bienvenida_admin.php?msg=Usuario actualizado correctamente");
    exit;
}
?>