<?php
require_once "../../modelo/pedido.php";
$pedidoModel = new Pedido();
$domicilios = $pedidoModel->listarDomicilios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Domicilios</title>
    <link rel="stylesheet" href="../CSS/lista_domicilios.css">
</head>
<body>

<h2>Domicilios</h2>

<?php if (empty($domicilios)): ?>
    <p>No hay domicilios.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($domicilios as $d): ?>
            <tr>
                <td><?= $d['Id_Pedido'] ?></td>
                <td><?= $d['Direccion_Entrega'] ?></td>
                <td><?= $d['Telefono_Entrega'] ?></td>
                <td>$<?= number_format($d['Total'], 2) ?></td>
                <td><?= $d['Estado'] ?></td>
                <td>
                    <?php if ($d['Estado'] !== "Entregado"): ?>
                        <a href="../../controlador/pedidoControlador.php?accion=marcar_entregado&id=<?= $d['Id_Pedido'] ?>">
                            Marcar Entregado
                        </a>
                    <?php endif; ?>

                    <a href="editar_domicilio.php?id=<?= $d['Id_Pedido'] ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<a href="bienvenida_admin.php">⬅ Volver al Panel</a>

</body>
</html>
