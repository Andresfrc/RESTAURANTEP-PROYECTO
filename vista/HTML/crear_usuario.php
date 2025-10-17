<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../CSS/crear_usuario.css"> <!-- Usa tu CSS existente -->
</head>
<body class="admin-body">
    <div class="admin-container">
        <h1 class="admin-titulo">Crear Nuevo Usuario</h1>

        <form method="POST" action="../../controlador/usuario_controlador.php">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>

            <label for="rol">Rol:</label>
            <select name="rol" required>
                <option value="Usuario">Usuario</option>
                <option value="Administrador">Administrador</option>
            </select>

            <input type="hidden" name="accion" value="crear_desde_admin">
            <button type="submit">Crear Usuario</button>
        </form>

        <a href="bienvenida_admin.php" class="admin-btn">Volver al Panel</a>
    </div>
</body>
</html>
