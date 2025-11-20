<?php
session_start();
require_once __DIR__ . "/../modelo/pedido.php";
require_once __DIR__ . "/../modelo/platos.php";

$pedidoModel = new Pedido();
$platoModel = new Plato();

$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;

/* ============================================================
   🟢 ACCIÓN: CREAR PEDIDO
   ============================================================ */
if ($accion === 'crear') {

    $usuarioId = $_SESSION['usuario']['Id_Usuario'];
    $tipo = $_POST['tipo_pedido'];

    // Tipo mesa o domicilio
    $mesaId = ($tipo === "mesa") ? ($_POST['mesa_id'] ?? null) : null;
    $direccion = ($tipo === "domicilio") ? ($_POST['direccion_entrega'] ?? null) : null;

    // Platillos
    $platillos = $_POST['platillo'] ?? [];
    $detalles = [];

    foreach ($platillos as $idPlatillo => $cantidad) {
        if ($cantidad > 0) {
            $plato = $platoModel->obtenerPlato($idPlatillo);
            $detalles[] = [
                "Platillo_Id" => $idPlatillo,
                "Cantidad" => $cantidad,
                "PrecioUnitario" => $plato['Precio']
            ];
        }
    }

    if (empty($detalles)) {
        $_SESSION['error'] = "Seleccione al menos un platillo.";
        header("Location: ../vista/HTML/hacer_pedido.php");
        exit;
    }

    // Se envían los 4 parámetros correctos
    $pedidoId = $pedidoModel->crearPedido($usuarioId, $mesaId, $direccion, $detalles);

    if ($pedidoId) {
        $_SESSION['mensaje'] = "Pedido realizado correctamente!";
        header("Location: ../vista/HTML/mis_pedidos.php");
        exit;
    } else {
        $_SESSION['error'] = "Hubo un error al registrar el pedido.";
        header("Location: ../vista/HTML/hacer_pedido.php");
        exit;
    }
}

/* ============================================================
   🔵 ACCIÓN: ACTUALIZAR ESTADO DEL PEDIDO
   ============================================================ */
if ($accion === 'actualizar_estado') {

    $idPedido = $_GET['id'] ?? null;
    $nuevoEstado = $_GET['estado'] ?? null;

    if (!$idPedido || !$nuevoEstado) {
        $_SESSION['error'] = "Datos incompletos para actualizar el estado.";
        header("Location: ../vista/HTML/listar_pedidos.php");
        exit;
    }

    $pedidoModel->actualizarEstado($idPedido, $nuevoEstado);

    $_SESSION['mensaje'] = "Estado actualizado correctamente.";
    header("Location: ../vista/HTML/listar_pedidos.php");
    exit;
}
if ($accion === "editar_domicilio") {

    $id = $_POST["id"];
    $direccion = $_POST["direccion"];

    $stmt = $pedidoModel->actualizarDireccion($id, $direccion);

    $_SESSION["mensaje"] = "Domicilio actualizado correctamente";
    header("Location: ../vista/HTML/bienvenida_admin.php");
    exit;
}


?>
