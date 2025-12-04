<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/mesa.php";
$mesaModel = new Mesa();
$mesasDisponibles = $mesaModel->listarMesasDisponibles();
// Si no hay mesas con estado 'Libre', mostrar todas disponibles
if (empty($mesasDisponibles)) {
    $mesasDisponibles = $mesaModel->listarMesas();
}
$mesasReservadas = [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hacer Reserva - JapanFood</title>
    <link rel="stylesheet" href="../CSS/crear_plato.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo">📅 Hacer una Reserva</h1>
        
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['mensaje']; unset($_SESSION['mensaje']); ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <form class="formulario" action="../../controlador/reserva_controlador.php" method="POST">
            <input type="hidden" name="accion" value="crear">
            <input type="hidden" name="sucursal_id" value="1">

            <div class="campo">
                <label for="fecha">Fecha de Reserva:</label>
                <input type="date" id="fecha" name="fecha" required 
                       min="<?php echo date('Y-m-d'); ?>"
                       max="<?php echo date('Y-m-d', strtotime('+30 days')); ?>">
            </div>

            <div class="campo">
                <label for="hora">Hora de Reserva:</label>
                <input type="time" id="hora" name="hora" required 
                       min="11:00" max="22:00">
                <small>Horario de atención: 11:00 AM - 10:00 PM</small>
            </div>
            
            <div class="campo">
                <label for="cantidad_personas">Número de Personas:</label>
                <input type="number" id="cantidad_personas" name="cantidad_personas" 
                       required min="1" max="20" placeholder="Ej: 4">
            </div>

            <div class="campo">
                <label for="mesa_id">Seleccionar Mesa (opcional):</label>
                <select id="mesa_id" name="mesa_id">
                    <option value="">Sin preferencia</option>
                    <?php foreach ($mesasDisponibles as $mesa): ?>
                        <option value="<?php echo $mesa['Id_Mesa']; ?>">
                            Mesa <?php echo $mesa['Numero_Mesa']; ?> 
                            (<?php echo $mesa['Capacidad']; ?> personas - <?php echo $mesa['Ubicacion']; ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <small>Las mesas disponibles se muestran arriba</small>
            </div>
            
            <div class="campo">
                <label for="descripcion">Observaciones (opcional):</label>
                <textarea id="descripcion" name="descripcion" rows="4" 
                          placeholder="Ej: Mesa cerca de la ventana, celebración especial, etc."></textarea>
            </div>

            <button type="submit">Confirmar Reserva</button>
            <a href="bienvenida_usuario.php" class="admin-btn">Cancelar</a>
        </form>
    </div>
</body>
</html>