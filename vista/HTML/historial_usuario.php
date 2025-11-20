<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../controlador/pedido_controlador.php";
$controller = new PedidoController();
$pedidos = $controller->listarPedidosUsuario();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../BOOTSTRAP/bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
    <title>Historial de Pedidos - JapanFood</title>
    <style>
        body { font-family: 'Cinzel', serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .container { max-width: 900px; margin: 50px auto; background: rgba(255, 255, 255, 0.9); padding: 30px; border-radius: 10px; }
        .pedido { background: #f8f9fa; border-left: 4px solid #dc3545; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .estado { padding: 5px 10px; border-radius: 5px; font-weight: bold; color: white; }
        .pendiente { background: #ffc107; color: black; }
        .en-proceso { background: #17a2b8; }
        .entregado { background: #28a745; }
        .cancelado { background: #dc3545; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <img src="../IMG/2995566471.jpg" alt="Avatar Logo" style="width:90px;" class="rounded-pill">
            <h1 style="color: red; font-size:50px;">JapanFood</h1>
            <ul class="navbar-nav">
                <li class="nav-item"><a style="color: red;" class="nav-link" href="index.php">Inicio</a></li>
                <li class="nav-item"><a style="color: red;" class="nav-link" href="Menu.html">Menú</a></li>
                <li class="nav-item"><a style="color: red;" class="nav-link" href="perfil.php">Perfil</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">📦 Mi Historial de Pedidos</h2>
        
        <?php if (!empty($pedidos)): ?>
            <?php foreach ($pedidos as $pedido): ?>
                <div class="pedido">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Pedido #<?php echo $pedido['Id_Pedido']; ?></h5>
                            <p><strong>Fecha:</strong> <?php echo date('d/m/Y H:i', strtotime($pedido['Fecha'])); ?></p>
                            <p><strong>Tipo:</strong> <?php echo htmlspecialchars($pedido['TipoPedido']); ?></p>
                            <p><strong>Total:</strong> $<?php echo number_format($pedido['Total'], 2); ?></p>
                        </div>
                        <div class="col-md-4 text-end">
                            <span class="estado <?php 
                                echo strtolower(str_replace(' ', '-', $pedido['Estado'])); 
                            ?>">
                                <?php echo htmlspecialchars($pedido['Estado']); ?>
                            </span>
                            <br><br>
                            <a href="ver_detalle_pedido.php?id=<?php echo $pedido['Id_Pedido']; ?>" 
                               class="btn btn-sm btn-danger">Ver Detalle</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <h4>No tienes pedidos registrados</h4>
                <p>¡Comienza a ordenar ahora!</p>
                <a href="Menu.html" class="btn btn-danger">Ver Menú</a>
            </div>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="bienvenida_usuario.php" class="btn btn-secondary">⬅️ Volver</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>