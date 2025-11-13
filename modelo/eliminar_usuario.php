<?php
require_once __DIR__ . "/../modelo/usuario.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $usuarioModel = new Usuario();

 
    $usuario = $usuarioModel->obtener_usuario_por_id($id);

    if ($usuario) {
     
        session_start();
        if (isset($_SESSION['usuario']) && $_SESSION['usuario']['Id_Usuario'] == $id) {
            die("No puedes eliminar tu propia cuenta mientras estás conectado.");
        }

        if ($usuarioModel->borrar_usuario($id)) {
            header("Location: ../vista/HTML/bienvenida_admin.php?msg=Usuario eliminado correctamente");
            exit;
        } else {
            die("Error al eliminar el usuario.");
        }
    } else {
        die("Usuario no encontrado.");
    }
} else {
    die("ID no especificado.");
}
?>