<?php
session_start();
require_once __DIR__ . "/../modelo/pedido.php";

$pedidoModel = new Pedido();

$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;

switch ($accion) {

    case 'actualizar':
        $id = $_POST['pedido_id'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        $pedidoModel->actualizarInformacionEntrega($id, $direccion, $telefono);
        $_SESSION['mensaje'] = "Información de entrega actualizada.";
        break;

    case 'entregar':
        $id = $_GET['id'];
        $pedidoModel->actualizarEstado($id, 'Entregado');

        $_SESSION['mensaje'] = "Pedido marcado como entregado.";
        break;
}

header("Location: ../vista/HTML/lista_domicilios.php");
exit;
?>
