<?php
session_start();
require_once __DIR__ . "/../modelo/reserva.php";
require_once __DIR__ . "/../modelo/mesa.php";

$reservaModel = new Reserva();
$mesaModel = new Mesa();

$accion = $_POST['accion'] ?? $_GET['accion'] ?? null;

switch ($accion) {

    case 'crear':
        $usuarioId = $_SESSION['usuario']['Id_Usuario'];
        $fecha = $_POST['fecha'] ?? null;
        $hora = $_POST['hora'] ?? null;
        $cantidad = $_POST['cantidad_personas'] ?? null;
        $mesaId = $_POST['mesa_id'] ?: null;  // opcional
        $descripcion = $_POST['descripcion'] ?? '';

        // Validaciones básicas
        if (!$fecha || !$hora || !$cantidad) {
            $_SESSION['error'] = "Fecha, hora y cantidad de personas son obligatorios.";
            header("Location: ../vista/HTML/bienvenida_usuario.php");
            exit;
        }

        // Solo validar la mesa si se seleccionó
        if ($mesaId) {
            $mesa = $mesaModel->obtenerMesa($mesaId);
            if (!$mesa || $mesa['Estado'] !== 'Disponible') {
                $_SESSION['error'] = "La mesa seleccionada no está disponible.";
                header("Location: ../vista/HTML/bienvenida_usuario.php");
                exit;
            }

            if ($reservaModel->existeReservaEnMesa($mesaId, $fecha, $hora)) {
                $_SESSION['error'] = "La mesa ya está reservada a esa hora.";
                header("Location: ../vista/HTML/bienvenida_usuario.php");
                exit;
            }
        }

        // Crear la reserva
        $ok = $reservaModel->crearReserva($usuarioId, $mesaId, $fecha, $hora, $cantidad, $descripcion);

        if ($ok && $mesaId) {
            $mesaModel->actualizarEstado($mesaId, "Reservada");
        }

        $_SESSION['mensaje'] = $ok ? "Reserva creada correctamente." : "Error al crear la reserva.";
        header("Location: ../vista/HTML/mis_reservas.php");
        exit;

    case 'cancelar':
    $reservaId = $_GET['id'];
    $usuarioId = $_SESSION['usuario']['Id_Usuario'] ?? null; // opcional para usuario

    $reserva = $reservaModel->obtenerReserva($reservaId);

    if ($reserva['Mesa_Id']) {
        $mesaModel->actualizarEstado($reserva['Mesa_Id'], "Disponible");
    }

    $reservaModel->cancelarReserva($reservaId, $usuarioId);

    $_SESSION['mensaje'] = "Reserva cancelada.";

    // Diferenciar redirección según rol
    if ($_SESSION['usuario']['Rol'] === 'Administrador') {
        header("Location: ../vista/HTML/listar_reservas.php");
    } else {
        header("Location: ../vista/HTML/mis_reservas.php");
    }
    exit;


    case 'actualizar':
    $reservaId = $_GET['id'] ?? null;
    $nuevoEstado = $_GET['estado'] ?? null;

    if ($reservaId && $nuevoEstado) {
        $reservaModel->actualizarEstado($reservaId, $nuevoEstado);

        // Si la reserva se confirma, también podemos actualizar la mesa
        $reserva = $reservaModel->obtenerReserva($reservaId);
        if ($nuevoEstado == 'Confirmada' && $reserva['Mesa_Id']) {
            $mesaModel->actualizarEstado($reserva['Mesa_Id'], 'Reservada');
        } elseif ($nuevoEstado == 'Cancelada' && $reserva['Mesa_Id']) {
            $mesaModel->actualizarEstado($reserva['Mesa_Id'], 'Disponible');
        }

        $_SESSION['mensaje'] = "Reserva actualizada a '$nuevoEstado' correctamente.";

        // 👉 Redirigir a la página de admin, no usuario
        header("Location: ../vista/HTML/listar_reservas.php");
        exit;
    }
    break;
    

    default:
        header("Location: ../index.php");
        exit;
}
?>
