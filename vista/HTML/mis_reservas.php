<?php
session_start();
require_once __DIR__ . "/../../modelo/reserva.php";
require_once __DIR__ . "/../../modelo/mesa.php";

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit();
}

$reservaModel = new Reserva();
$mesaModel = new Mesa();

$usuarioId = $_SESSION['usuario']['Id_Usuario'];
$reservas = $reservaModel->listarReservasUsuario($usuarioId);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reservas</title>
    <link rel="stylesheet" href="../CSS/mis_reservas.css">
</head>
<body>

<h2>Mis Reservas</h2>

<?php if (isset($_SESSION['mensaje'])): ?>
    <p class="mensaje"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Mesa</th>
        <th>Personas</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($reservas as $row): 
        $mesa = $row['Mesa_Id'] ? $mesaModel->obtenerMesa($row['Mesa_Id']) : null;
    ?>
        <tr>
            <td><?php echo $row['Id_Reserva']; ?></td>
            <td><?php echo $row['Fecha']; ?></td>
            <td><?php echo $row['Hora']; ?></td>
            <td><?php echo $mesa ? 'Mesa '.$mesa['Numero_Mesa'] : 'Sin preferencia'; ?></td>
            <td><?php echo $row['Cantidad_Personas']; ?></td>
            <td><?php echo $row['Descripcion'] ?: '—'; ?></td>
            <td>
                <?php
                    $estado = $row['Estado'];
                    if ($estado == 'Pendiente') echo "<span style='color: orange;'>Pendiente</span>";
                    if ($estado == 'Confirmada') echo "<span style='color: green;'>Confirmada</span>";
                    if ($estado == 'Cancelada') echo "<span style='color: red;'>Cancelada</span>";
                ?>
            </td>
            <td>
                <?php if ($row['Estado'] == 'Pendiente'): ?>
                    <a href="../../controlador/reserva_controlador.php?accion=cancelar&id=<?php echo $row['Id_Reserva']; ?>"
                       onclick="return confirm('¿Seguro que deseas cancelar esta reserva?');">
                       ❌ Cancelar
                    </a>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>

</table>

<a href="bienvenida_usuario.php">⬅ Hacer otra reserva</a>

</body>
</html>
