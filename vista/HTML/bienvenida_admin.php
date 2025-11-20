<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/usuario.php";
$usuarioModel = new Usuario();
$usuarios = $usuarioModel->listar_usuarios();
$usuario = $_SESSION['usuario'];

// Cargar modelo pedido y obtener domicilios (si existe)
$domicilios = [];
if (file_exists(__DIR__ . "/../../modelo/pedido.php")) {
    require_once __DIR__ . "/../../modelo/pedido.php";
    if (class_exists('Pedido')) {
        $pedidoModel = new Pedido();
        // Si el método existe, úsalo; si no, $domicilios queda vacío
        if (method_exists($pedidoModel, 'listarDomicilios')) {
            $domicilios = $pedidoModel->listarDomicilios() ?: [];
        }
    }
}
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
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

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
                            <a href="../../modelo/eliminar_usuario.php?id=<?php echo $user['Id_Usuario']; ?>" 
                               onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Borrar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if (!empty($domicilios)): ?>
    <table>
        <h2>Gestion de Domicilios</h2>
        <thead>
            <tr>
                <th>ID</th><th>Cliente</th><th>Dirección</th><th>Teléfono</th><th>Estado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($domicilios as $d): ?>
                <tr>
                    <td><?php echo htmlspecialchars($d['Id_Pedido']); ?></td>
                    <td><?php echo htmlspecialchars($d['Usuario_Nombre'] ?? '—'); ?></td>
                    <td><?php echo htmlspecialchars($d['Direccion_Entrega']); ?></td>
                    <td><?php echo htmlspecialchars($d['Telefono_Entrega'] ?? '—'); ?></td>
                    <td><?php echo htmlspecialchars($d['Estado']); ?></td>
                    <td>
                        <a href="editar_domicilio.php?id=<?php echo $d['Id_Pedido']; ?>">✏️ Editar</a>
                        <a href="../../controlador/domiciliosControlador.php?accion=entregar&id=<?php echo $d['Id_Pedido']; ?>"
                           onclick="return confirm('Marcar como entregado?');">✔ Entregar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay pedidos a domicilio.</p>
<?php endif; ?>


        <div class="admin-links">
          
            <a href="crear_usuario.php" class="admin-btn">➕ Crear Nuevo Usuario</a>
            
            
            <a href="crear_plato.php" class="admin-btn">🍱 Agregar Platillo Nuevo</a>
            <a href="listar_platos.php" class="admin-btn">📋 Ver Lista de Platillos</a>
            
           
            <a href="listar_pedidos.php" class="admin-btn">📦 Ver Todos los Pedidos</a>
            
            
            <a href="index.php" class="admin-btn">🏠 Ir al Panel Principal</a>
           

              

    
    <a href="crear_mesa.php" class="admin-btn">➕ Crear Mesa</a>
    <a href="listar_mesas.php" class="admin-btn">📋 Listado de Mesas</a>

   
    <a href="listar_reservas.php" class="admin-btn">📋 Consultar Reservas</a>

    <div class="admin-links">
        <a href="index.php" class="admin-btn">🏠 Ir al Panel Principal</a>
        <a href="perfil.php" class="admin-btn btn-rojo">🚪 Cerrar Sesión</a>
    </div>
        </div>
    </div>
</body>
</html>