<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../controlador/usuario_controlador.php"; // Solo incluye la clase

$usuarioModel = new Usuario();
$usuarios = $usuarioModel->listar_usuarios();
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Bienvenida Admin</title>
    <link rel="stylesheet" href="../CSS/bienvenida_admin.css" />
</head>
<body class="admin-body">
    <div class="admin-container">
        <h1 class="admin-titulo">¡Bienvenido Administrador, <?php echo htmlspecialchars($usuario['Nombre']); ?>!</h1>
        <p class="admin-texto">Esta es tu página de administración.</p>
        
        <h2>Gestión de Usuarios</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $user) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($user['Email']); ?></td>
                        <td><?php echo htmlspecialchars($user['Rol']); ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $user['Id_Usuario']; ?>">Editar</a> |
                            <a href="../../modelo/eliminar_usuario.php?id=<?php echo $user['Id_Usuario']; ?>">Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="admin-links">
            <a href="crear_usuario.php" class="admin-btn">Crear Nuevo Usuario</a>
            <a href="crear_plato.php" class="admin-btn">Agregar plato nuevo</a>
            <a href="index.php" class="admin-btn">Ir al panel principal</a>
            <a href="./perfil.php" class="admin-btn btn-rojo">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
