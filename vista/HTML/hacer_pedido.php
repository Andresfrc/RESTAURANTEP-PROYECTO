<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Usuario') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/mesa.php";
require_once __DIR__ . "/../../modelo/platos.php";

$mesaModel = new Mesa();
$platoModel = new Plato();

$mesas = $mesaModel->listarMesas();
$platillos = $platoModel->listarPlatos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Hacer Pedido</title>
    <link rel="stylesheet" href="../CSS/hacer_pedido.css">
</head>
<body>

<h2> Hacer Pedido</h2>

<form action="../../controlador/pedido_controlador.php" method="POST">

    <input type="hidden" name="accion" value="crear">

    <label>Tipo de pedido:</label>
    <select id="tipo_pedido" name="tipo_pedido" required>
        <option value="mesa">En mesa</option>
        <option value="domicilio">Domicilio</option>
    </select>

    <!-- Selección de mesa -->
    <div id="section_mesa">
        <label>Seleccionar Mesa:</label>
        <select name="mesa_id">
            <option value="">Sin preferencia</option>
            <?php foreach ($mesas as $mesa): ?>
                <option value="<?= $mesa['Id_Mesa'] ?>">
                    Mesa <?= htmlspecialchars($mesa['Numero_Mesa']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Dirección de entrega -->
    <div id="section_domicilio" style="display:none;">
        <label>Dirección de entrega:</label>
        <input type="text" name="direccion_entrega" placeholder="Calle 123 #45-67">
    </div>

    <h3>Platillos</h3>

    <?php foreach ($platillos as $plato): ?>
        <div class="plato-item">
            <strong><?= htmlspecialchars($plato['Nombre']) ?></strong>
            : $<?= number_format($plato['Precio'], 0) ?>

            <input type="number" 
                   name="platillo[<?= $plato['Id_Platillo'] ?>]" 
                   value="0" 
                   min="0" 
                   style="width:60px;">
        </div>
    <?php endforeach; ?>

    <button type="submit">✔️ Hacer Pedido</button>

</form>

<script>
document.getElementById("tipo_pedido").addEventListener("change", function() {
    if (this.value === "mesa") {
        document.getElementById("section_mesa").style.display = "block";
        document.getElementById("section_domicilio").style.display = "none";
    } else {
        document.getElementById("section_mesa").style.display = "none";
        document.getElementById("section_domicilio").style.display = "block";
    }
});
</script>

</body>
</html>
