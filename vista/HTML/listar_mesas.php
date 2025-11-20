<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/mesa.php";
$mesaModel = new Mesa();
$mesas = $mesaModel->listarMesas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Mesas</title>
    <link rel="stylesheet" href="../CSS/listar_mesas.css">
</head>
<body>
<h1>Listado de Mesas</h1>

<?php if(isset($_SESSION['mensaje'])): ?>
    <p class="mensaje"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
<?php endif; ?>
<?php if(isset($_SESSION['error'])): ?>
    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<a href="crear_mesa.php">➕ Crear Nueva Mesa</a>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Número</th>
        <th>Capacidad</th>
        <th>Ubicación</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($mesas as $mesa): ?>
        <tr>
            <td><?php echo $mesa['Id_Mesa']; ?></td>
            <td><?php echo $mesa['Numero_Mesa']; ?></td>
            <td><?php echo $mesa['Capacidad']; ?></td>
            <td><?php echo $mesa['Ubicacion']; ?></td>
            <td><?php echo $mesa['Estado']; ?></td>
            <td>
                <a href="editar_mesa.php?id=<?php echo $mesa['Id_Mesa']; ?>">✏️ Editar</a> |
                <a href="../../controlador/mesa_controlador.php?accion=eliminar&id=<?php echo $mesa['Id_Mesa']; ?>"
                   onclick="return confirm('¿Eliminar mesa?');">🗑 Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<a href="bienvenida_admin.php">⬅ Volver al Panel</a>
</body>
</html>
