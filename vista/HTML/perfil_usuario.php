<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: perfil.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../CSS/perfil_usuario.css">
</head>
<body>
    <div class="perfil-container">
        <h1>Editar perfil</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <p style="color:green;"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form action="../../controlador/usuario_controlador.php" method="POST">
            <input type="hidden" name="accion" value="actualizar_perfil">
            
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['Nombre']); ?>" required>

            <label>Nueva contraseña (opcional):</label>
            <input type="password" name="password" placeholder="Deja en blanco si no deseas cambiarla">

            <button type="submit">Actualizar perfil</button>
        </form>

        <a href="bienvenida_usuario.php">⬅️ Volver</a>
    </div>
</body>
</html>
