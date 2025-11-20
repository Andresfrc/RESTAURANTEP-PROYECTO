<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/mesa.php";
$mesaModel = new Mesa();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero_mesa'] ?? null;
    $capacidad = $_POST['capacidad'] ?? null;
    $ubicacion = $_POST['ubicacion'] ?? null;

    if ($numero && $capacidad && $ubicacion) {
        $ok = $mesaModel->registrarMesa($numero, $capacidad, $ubicacion);
        $_SESSION['mensaje'] = $ok ? "Mesa registrada correctamente." : "Error al registrar la mesa.";
        header("Location: listar_mesas.php");
        exit;
    } else {
        $_SESSION['error'] = "Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Mesa</title>
    <link rel="stylesheet" href="../CSS/crear_mesa.css">
</head>
<body>
<h1>Crear Nueva Mesa</h1>

<?php if(isset($_SESSION['mensaje'])): ?>
    <p class="mensaje"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></p>
<?php endif; ?>
<?php if(isset($_SESSION['error'])): ?>
    <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Número de Mesa:</label>
    <input type="number" name="numero_mesa" required>
    
    <label>Capacidad:</label>
    <input type="number" name="capacidad" required>
    
    <label>Ubicación:</label>
    <input type="text" name="ubicacion" required>
    
    <button type="submit">Crear Mesa</button>
</form>

<a href="listar_mesas.php">⬅ Volver a Listar Mesas</a>
</body>
</html>
