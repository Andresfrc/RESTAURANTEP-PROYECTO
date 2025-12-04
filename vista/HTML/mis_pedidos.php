<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Usuario') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/pedido.php";

$usuarioId = $_SESSION['usuario']['Id_Usuario'];

$pedidoModel = new Pedido();
$pedidos = $pedidoModel->listarPedidosUsuario($usuarioId);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../CSS/mis_pedidos.css">
    <meta charset="UTF-8">
    <title>Mis Pedidos</title>
</head>

<body>

<h1>Mis Pedidos</h1>

<?php if (isset($_SESSION['mensaje'])): ?>
    <div style="color:green;"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<?php if (!empty($pedidos)): ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Mesa</th>
            <th>Fecha</th>
            <th>Estado</th>
            <th>Total</th>
        </tr>

        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?php echo $pedido['Id_Pedido']; ?></td>
                <td><?php echo $pedido['Mesa_Id'] ?? '—'; ?></td>
                <td><?php echo $pedido['Fecha']; ?></td>
                <td><?php echo $pedido['Estado']; ?></td>
                <td>$<?php echo number_format($pedido['Total'], 2); ?></td>
            </tr>
        <?php endforeach; ?>

    </table>

<?php else: ?>
    <p>No tienes pedidos registrados.</p>
<?php endif; ?>




<a href="bienvenida_usuario.php">⬅ Volver al Panel</a>

</body>
</html>
