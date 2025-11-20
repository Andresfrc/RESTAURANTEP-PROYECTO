<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/mesa.php";
$mesaModel = new Mesa();

$id = $_GET['id'] ?? null;
if(!$id) {
    header("Location: listar_mesas.php");
    exit;
}

$mesa = $mesaModel->obtenerMesa($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST['numero_mesa'] ?? null;
    $capacidad = $_POST['capacidad'] ?? null;
    $ubicacion = $_POST['ubicacion'] ?? null;
    $estado = $_POST['estado'] ?? 'Disponible';

    $ok = $mesaModel->actualizarMesa($id, $numero, $capacidad, $ubicacion);
    $mesaModel->actualizarEstado($id, $estado);

    $_SESSION['mensaje'] = $ok ? "Mesa actualizada correctamente." : "Error al actualizar la mesa.";
    header("Location: listar_mesas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Mesa</title>
    <link rel="stylesheet" href="../CSS/editar_mesa.css">
</head>
<body>
<h1>Editar Mesa</h1>

<form method="POST">
    <label>Número de Mesa:</label>
    <input type="number" name="numero_mesa" value="<?php echo $mesa['Numero_Mesa']; ?>" required>
    
    <label>Capacidad:</label>
    <input type="number" name="capacidad" value="<?php echo $mesa['Capacidad']; ?>" required>
    
    <label>Ubicación:</label>
    <input type="text" name="ubicacion" value="<?php echo $mesa['Ubicacion']; ?>" required>
    
    <label>Estado:</label>
    <select name="estado">
        <option value="Disponible" <?php if($mesa['Estado']=='Disponible') echo 'selected'; ?>>Disponible</option>
        <option value="Reservada" <?php if($mesa['Estado']=='Reservada') echo 'selected'; ?>>Reservada</option>
    </select>
    
    <button type="submit">Actualizar Mesa</button>
</form>

<a href="listar_mesas.php">⬅ Volver al listado</a>
</body>
</html>
