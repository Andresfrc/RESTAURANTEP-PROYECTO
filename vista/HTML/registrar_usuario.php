<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../controlador/UsuarioController.php";

$controller = new UsuarioController();

// Procesar borrar usuario
if (isset($_GET['borrar'])) {
    $idBorrar = intval($_GET['borrar']);
    $controller->borrar_usuario($idBorrar);
    $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
    header("Location: registrar_usuario.php");
    exit;
}

// Procesar creación de usuario (formulario POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'crear') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $rol = $_POST['rol'] ?? 'Usuario';

    $exito = $controller->crear_usuario_admin($nombre, $email, $password, $rol);
    if ($exito) {
        $_SESSION['mensaje'] = "Usuario creado con éxito.";
    } else {
        $_SESSION['error'] = "Error al crear usuario.";
    }
    header("Location: registrar_usuario.php");
    exit;
}

// Obtener lista usuarios
$usuarios = $controller->listar_usuarios();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel Registro Usuarios - Admin</title>
    <link rel="stylesheet" href="../CSS/bienvenida_admin.css"> <!-- Tu CSS -->
</head>
<body class="admin-body">
    <div class="admin-container">
        <h1>Panel de Registro y Gestión de Usuarios</h1>

        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="mensaje-exito"><?php echo htmlspecialchars($_SESSION['mensaje']); ?></div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="mensaje-error"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Formulario Crear Usuario -->
        <h2>Crear nuevo usuario</h2>
        <form method="POST" action="registrar_usuario.php">
            <input type="hidden" name="accion" value="crear" />
            <label>Nombre:</label><br>
            <input type="text" name="nombre" required /><br><br>

            <label>Email:</label><br>
            <input type="email" name="email" required /><br><br>

            <label>Contraseña:</label><br>
            <input type="password" name="password" required /><br><br>

            <label>Rol:</label><br>
            <select name="rol">
                <option value="Usuario">Usuario</option>
                <option value="Administrador">Administrador</option>
            </select><br><br>

            <button type="submit">Crear Usuario</button>
        </form>

        <!-- Listado de usuarios -->
        <h2>Usuarios registrados</h2>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['id']); ?></td>
                        <td><?php echo htmlspecialchars($u['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($u['email']); ?></td>
                        <td><?php echo htmlspecialchars($u['rol']); ?></td>
                        <td>
                            <!-- Botón borrar -->
                            <?php if ($u['id'] != $_SESSION['usuario']['id']): ?>
                                <a href="registrar_usuario.php?borrar=<?php echo $u['id']; ?>" onclick="return confirm('¿Seguro que deseas borrar este usuario?');">Borrar</a>
                            <?php else: ?>
                                (Tu usuario)
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <br>
        <a href="bienvenida_admin.php" class="admin-btn">Volver al panel principal</a>
    </div>
</body>
</html>
