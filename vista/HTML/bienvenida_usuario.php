<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Usuario') {
    header("Location: perfil.php");
    exit;
}

$usuario = $_SESSION['usuario'];
$clienteId = $usuario['Id_Usuario'];

// cargar modelos
require_once __DIR__ . "/../../modelo/reserva.php";
if (file_exists(__DIR__ . "/../../modelo/pedido.php")) {
    require_once __DIR__ . "/../../modelo/pedido.php";
}

// Instanciar modelos
$reservaModel = new Reserva();
$misReservas = $reservaModel->listarReservasUsuario($clienteId) ?: [];

$misPedidos = [];
if (class_exists('Pedido')) {
    $pedidoModel = new Pedido();
    if (method_exists($pedidoModel, 'listarPedidosUsuario')) {
        $misPedidos = $pedidoModel->listarPedidosUsuario($clienteId) ?: [];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Mi Cuenta - JapanFood</title>
    <link rel="stylesheet" href="../CSS/bienvenida_usuario.css">
</head>
<body class="user-body">
<div class="user-container">
    <h1 class="user-titulo">¡Bienvenido, <?php echo htmlspecialchars($usuario['Nombre']); ?>! 🏮</h1>
    <p class="user-texto">Gestiona tus reservas y pedidos desde tu panel personal</p>

    <div class="dashboard">
        <!-- Tarjeta de Acciones Rápidas -->
        <div class="card">
            <h3>⚡ Acciones Rápidas</h3>
            <div class="user-links">
                <a href="reserva_usuario.php" class="user-btn">📅 Hacer Reserva</a>
                <a href="hacer_pedido.php" class="user-btn">🛒 Hacer Pedido</a>
                <a href="perfil_usuario.php" class="user-btn">👤 Editar Perfil</a>
            </div>
        </div>

        <!-- Tarjeta de Mis Reservas -->
        <div class="card">
            <h3>📅 Mis Reservas Recientes</h3>
            <?php if (!empty($misReservas)): ?>
                <ul class="lista-items">
                    <?php foreach (array_slice($misReservas, 0, 3) as $reserva): ?>
                        <li>
                            <div>
                                <strong><?php echo date('d/m/Y', strtotime($reserva['Fecha'])); ?></strong><br>
                                <small><?php echo date('H:i', strtotime($reserva['Hora'])); ?> - <?php echo htmlspecialchars($reserva['Cantidad_Personas']); ?> personas</small>
                            </div>
                            <span class="badge badge-<?php echo strtolower($reserva['Estado']); ?>">
                                <?php echo htmlspecialchars($reserva['Estado']); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="mis_reservas.php" style="color: #dc3545; text-decoration: none;">Ver todas →</a>
            <?php else: ?>
                <p>No tienes reservas. <a href="hacer_reserva.php">Haz tu primera reserva</a></p>
            <?php endif; ?>
        </div>

        <!-- Tarjeta de Mis Pedidos -->
        <div class="card">
            <h3>🍽️ Mis Pedidos Recientes</h3>
            <?php if (!empty($misPedidos)): ?>
                <ul class="lista-items">
                    <?php foreach (array_slice($misPedidos, 0, 3) as $pedido): ?>
                        <li>
                            <div>
                                <strong>Pedido #<?php echo htmlspecialchars($pedido['Id_Pedido'] ?? $pedido['Id']); ?></strong><br>
                                <small><?php echo isset($pedido['Fecha']) ? date('d/m/Y', strtotime($pedido['Fecha'])) : ''; ?> - $<?php echo number_format($pedido['Total'] ?? 0, 2); ?></small>
                            </div>
                            <span class="badge badge-<?php echo strtolower(str_replace(' ', '-', $pedido['Estado'] ?? '')); ?>">
                                <?php echo htmlspecialchars($pedido['Estado'] ?? ''); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <a href="mis_pedidos.php" style="color: #dc3545; text-decoration: none;">Ver todos →</a>
            <?php else: ?>
                <p>No tienes pedidos. <a href="hacer_pedido.php">Haz tu primer pedido</a></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="user-links" style="margin-top: 30px;">
        <a href="index.php" class="user-btn">🏠 Ir al Sitio Principal</a>
        <a href="./perfil.php" class="user-btn btn-rojo">🚪 Cerrar sesión</a>
    </div>
</div>
</body>
</html>
