<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/reserva.php";
require_once __DIR__ . "/../../modelo/mesa.php";
require_once __DIR__ . "/../../modelo/usuario.php";

$reservaModel = new Reserva();
$mesaModel = new Mesa();
$usuarioModel = new Usuario();

$reservas = $reservaModel->listarTodasReservas(); // Necesitamos agregar este método
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Reservas</title>
    <link rel="stylesheet" href="../CSS/listar_reservas.css">
</head>
<body>
<h1>Listado de Reservas</h1>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Mesa</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Personas</th>
        <th>Descripción</th>
        <th>Estado</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($reservas as $res): 
        $usuario = $usuarioModel->obtenerUsuario($res['Usuario_Id']);
        $mesa = $res['Mesa_Id'] ? $mesaModel->obtenerMesa($res['Mesa_Id']) : null;
    ?>
    <tr>
        <td><?php echo $res['Id_Reserva']; ?></td>
        <td><?php echo $usuario['Nombre'] ?? '—'; ?></td>
        <td><?php echo $mesa ? 'Mesa '.$mesa['Numero_Mesa'] : 'Sin preferencia'; ?></td>
        <td><?php echo $res['Fecha']; ?></td>
        <td><?php echo $res['Hora']; ?></td>
        <td><?php echo $res['Cantidad_Personas']; ?></td>
        <td><?php echo $res['Descripcion'] ?: '—'; ?></td>
        <td><?php echo $res['Estado']; ?></td>
        <td>
            <?php if($res['Estado']=='Pendiente'): ?>
                <a href="../../controlador/reserva_controlador.php?accion=actualizar&id=<?php echo $res['Id_Reserva']; ?>&estado=Confirmada">✔ Confirmar</a> |
                <a href="../../controlador/reserva_controlador.php?accion=cancelar&id=<?php echo $res['Id_Reserva']; ?>" 
                   onclick="return confirm('Cancelar reserva?');">❌ Cancelar</a>
            <?php else: ?>
                —
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="bienvenida_admin.php">⬅ Volver al Panel</a>
</body>
</html>
