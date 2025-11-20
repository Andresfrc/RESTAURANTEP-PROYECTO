<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/pedido.php";
require_once __DIR__ . "/../../modelo/mesa.php";
require_once __DIR__ . "/../../modelo/platos.php";

// Usuario model si existe (opcional)
$usuarioModelPath = __DIR__ . "/../../modelo/usuario.php";
if (file_exists($usuarioModelPath)) require_once $usuarioModelPath;

$pedidoModel = new Pedido();
$mesaModel   = new Mesa();

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "ID de pedido no especificado.";
    exit;
}

// Obtener pedido
$pedido = $pedidoModel->obtenerPedido($id);
if (!$pedido) {
    echo "Pedido no encontrado.";
    exit;
}

// Obtener usuario (intento con Usuario model si existe y tiene método; si no, usamos DB directo)
$usuarioNombre = '—';
if (class_exists('Usuario') && method_exists('Usuario', 'obtenerUsuario')) {
    $uModel = new Usuario();
    $u = $uModel->obtenerUsuario($pedido['Usuario_Id']);
    $usuarioNombre = $u['Nombre'] ?? '—';
} else {
    // acceso directo a la BD para consultar nombre del usuario (seguro y sencillo)
    require_once __DIR__ . "/../../config/conexion.php";
    $db = Database::connect();
    $stmt = $db->prepare("SELECT Nombre FROM usuarios WHERE Id_Usuario = ?");
    $stmt->execute([$pedido['Usuario_Id']]);
    $u = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($u && isset($u['Nombre'])) $usuarioNombre = $u['Nombre'];
}

// Obtener mesa si tiene
$mesaTexto = 'Sin asignar';
if (!empty($pedido['Mesa_Id'])) {
    $mesa = $mesaModel->obtenerMesa($pedido['Mesa_Id']);
    if ($mesa) {
        // intenta Nombre o Numero o Numero_Mesa según tu esquema
        $mesaTexto = 'Mesa ' . (
            $mesa['Numero_Mesa'] ?? ($mesa['Numero'] ?? ($mesa['NumeroMesa'] ?? $mesa['Id_Mesa']))
        );
    } else {
        $mesaTexto = 'Mesa #' . htmlspecialchars($pedido['Mesa_Id']);
    }
}

// Obtener detalles del pedido
$detalles = $pedidoModel->obtenerDetalles($id);
if (!$detalles) $detalles = [];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle Pedido #<?php echo htmlspecialchars($pedido['Id_Pedido']); ?></title>
    <link rel="stylesheet" href="../CSS/bienvenida_admin.css">
</head>
<body>
    <h1>Detalle Pedido #<?php echo htmlspecialchars($pedido['Id_Pedido']); ?></h1>

    <p><strong>Usuario:</strong> <?php echo htmlspecialchars($usuarioNombre); ?></p>
    <p><strong>Mesa / Entrega:</strong> <?php echo htmlspecialchars($mesaTexto); ?></p>
    <p><strong>Dirección de entrega:</strong> <?php echo htmlspecialchars($pedido['Direccion_Entrega'] ?? '—'); ?></p>
    <p><strong>Estado:</strong> <?php echo htmlspecialchars($pedido['Estado'] ?? '—'); ?></p>
    <p><strong>Fecha:</strong> <?php echo htmlspecialchars($pedido['Fecha'] ?? '—'); ?></p>

    <h2>Detalles</h2>
    <?php if (!empty($detalles)): ?>
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>Platillo</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $calcSubtotal = 0;
                foreach ($detalles as $d):
                    $nombre = $d['Platillo'] ?? ($d['Nombre'] ?? 'Platillo');
                    $precio = isset($d['PrecioUnitario']) ? (float)$d['PrecioUnitario'] : (float)($d['Precio'] ?? 0);
                    $cantidad = (int)($d['Cantidad'] ?? 0);
                    $sub = $precio * $cantidad;
                    $calcSubtotal += $sub;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($nombre); ?></td>
                    <td>$<?php echo number_format($precio,2); ?></td>
                    <td><?php echo $cantidad; ?></td>
                    <td>$<?php echo number_format($sub,2); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><strong>Subtotal calculado:</strong> $<?php echo number_format($calcSubtotal,2); ?></p>
        <p><strong>Subtotal BD:</strong> $<?php echo number_format($pedido['Subtotal'] ?? 0,2); ?></p>
        <p><strong>Impuestos BD:</strong> $<?php echo number_format($pedido['Impuestos'] ?? 0,2); ?></p>
        <p><strong>Total BD:</strong> $<?php echo number_format($pedido['Total'] ?? 0,2); ?></p>

    <?php else: ?>
        <p>No hay detalles de pedido.</p>
    <?php endif; ?>

    <p>
        <a href="listar_pedidos.php">⬅ Volver al listado</a>
    </p>
</body>
</html>
