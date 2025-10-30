<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Usuario') {
    header("Location: perfil.php");
    exit;
}

$usuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Bienvenida Usuario</title>
    <link rel="stylesheet" href="../CSS/bienvenida_usuario.css"> <!-- 🔗 Enlace al CSS -->
</head>
<body class="user-body">
    <div class="user-container">
        <h1 class="user-titulo">¡Bienvenido, <?php echo htmlspecialchars($usuario['Nombre']); ?>!</h1>
        <p class="user-texto">Has iniciado sesión correctamente.</p>
        <div class="user-links">
            <a href="./listar_platos.php" class="user-btn">Ir al panel</a>
            <a href="./perfil.php" class="user-btn btn-rojo">Cerrar sesión</a>
            <a href="perfil_usuario.php" class="user-btn">Editar perfil</a>

        </div>
    </div>
</body>
</html>
