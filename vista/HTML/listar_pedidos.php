<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/pedido.php";
require_once __DIR__ . "/../../modelo/mesa.php";
require_once __DIR__ . "/../../modelo/usuario.php";

$pedidoModel = new Pedido();
$mesaModel = new Mesa();
$usuarioModel = new Usuario();

$pedidos = $pedidoModel->listarPedidos(); // Todos los pedidos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Pedidos - Admin</title>
    <link rel="stylesheet" href="../CSS/bienvenida_admin.css">
</head>
<body>
<h1>Listado de Pedidos</h1>

<?php if (isset($_SESSION['mensaje'])): ?>
    <div class="alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Mesa</th>
        <th>Fecha</th>
        <th>Estado</th>
        <th>Total</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($pedidos as $p): 
        $usuario = $usuarioModel->obtenerUsuario($p['Usuario_Id']);
        $mesa = $p['Mesa_Id'] ? $mesaModel->obtenerMesa(idMesa: $p['Mesa_Id']) : null;
    ?>
    <tr>
        <td><?php echo $p['Id_Pedido']; ?></td>
        <td><?php echo $usuario['Nombre'] ?? '—'; ?></td>
        <td><?php echo $mesa ? 'Mesa '.$mesa['Numero_Mesa'] : 'Sin asignar'; ?></td>
        <td><?php echo $p['Fecha']; ?></td>
        <td><?php echo $p['Estado']; ?></td>
        <td><?php echo number_format($p['Total'],2); ?></td>
        <td>
            <a href="detalle_pedido.php?id=<?php echo $p['Id_Pedido']; ?>">Ver Detalle</a> |
            <select onchange="location = this.value;">
                <option value="#">Cambiar estado</option>
                <option value="../../controlador/pedido_controlador.php?accion=actualizar_estado&id=<?php echo $p['Id_Pedido']; ?>&estado=Pendiente">Pendiente</option>
                <option value="../../controlador/pedido_controlador.php?accion=actualizar_estado&id=<?php echo $p['Id_Pedido']; ?>&estado=En Preparación">En Preparación</option>
                <option value="../../controlador/pedido_controlador.php?accion=actualizar_estado&id=<?php echo $p['Id_Pedido']; ?>&estado=Entregado">Entregado</option>
                <option value="../../controlador/pedido_controlador.php?accion=actualizar_estado&id=<?php echo $p['Id_Pedido']; ?>&estado=Cancelado">Cancelado</option>
            </select>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="bienvenida_admin.php">⬅ Volver al Panel</a>
</body>
</html>
