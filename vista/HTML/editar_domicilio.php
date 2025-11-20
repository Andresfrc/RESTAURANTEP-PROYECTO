<?php
require_once "../../modelo/pedido.php";
$pedidoModel = new Pedido();

$id = $_GET["id"] ?? null;

if (!$id) {
    echo "ID no válido.";
    exit;
}

$pedido = $pedidoModel->obtenerPedidoPorId($id);

if (!$pedido) {
    echo "Pedido no encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Domicilio</title>
    <link rel="stylesheet" href="../CSS/editar_domicilio.css">
</head>
<body>

<h2>Editar Domicilio</h2>

<form action="../../controlador/pedido_controlador.php" method="POST">
    <input type="hidden" name="accion" value="editar_domicilio">
    <input type="hidden" name="id" value="<?= $pedido['Id_Pedido'] ?>">

    <label>Dirección:</label>
    <input type="text" name="direccion" value="<?= $pedido['Direccion_Entrega'] ?>">

    <!-- Como NO existe Telefono_Entrega en la BD, quitamos esto -->
    <!-- <label>Teléfono:</label>
    <input type="text" name="telefono" value=""> -->

    <button type="submit">Guardar Cambios</button>
</form>

<a href="lista_domicilios.php">⬅ Cancelar</a>

</body>
</html>
