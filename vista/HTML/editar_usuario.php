<?php
require_once __DIR__ . "/../../modelo/usuario.php"; 

$usuarioModel = new Usuario();

if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

$id = intval($_GET['id']);
$usuario = $usuarioModel->obtener_usuario_por_id($id);

if (!$usuario) {
    die("Usuario no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../CSS/editar_usuario.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo">✏️ Editar Usuario</h1>
        <form class="formulario" action="../../controlador/editar_usuario_controlador.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $usuario['Id_Usuario']; ?>">

            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['Nombre']); ?>" required>
            </div>

            <div class="campo">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['Email']); ?>" disabled style="background-color: #f0f0f0; cursor: not-allowed;">
                <small style="color: #666; font-size: 0.9em;">El correo no puede ser modificado</small>
            </div>

            <div class="campo">
                <label for="rol">Rol:</label>
                <select id="rol" name="rol" required>
                    <option value="Usuario" <?php echo ($usuario['Rol'] == 'Usuario') ? 'selected' : ''; ?>>Usuario</option>
                    <option value="Administrador" <?php echo ($usuario['Rol'] == 'Administrador') ? 'selected' : ''; ?>>Administrador</option>
                </select>
            </div>

            <div class="campo">
                <label for="password">Nueva Contraseña (opcional):</label>
                <input type="password" id="password" name="password" placeholder="Dejar en blanco para mantener la actual">
                <small style="color: #666; font-size: 0.9em;">Solo completa si deseas cambiar la contraseña</small>
            </div>

            <button type="submit">Actualizar Usuario</button>
            <a href="bienvenida_admin.php" class="admin-btn">Volver</a>
        </form>
    </div>
</body>
</html>