<?php
require_once __DIR__ . "/../modelo/mesa.php";

class MesaController {
    private $mesaModel;

    public function __construct() {
        $this->mesaModel = new Mesa();
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $numeroMesa = $_POST['numero_mesa'] ?? '';
            $capacidad = $_POST['capacidad'] ?? '';
            $ubicacion = $_POST['ubicacion'] ?? '';
            $estado = $_POST['estado'] ?? 'Libre';

            $resultado = $this->mesaModel->registrarMesa($numeroMesa, $capacidad, $ubicacion, $estado);

            session_start();
            if ($resultado) {
                $_SESSION['mensaje'] = "Mesa registrada correctamente.";
            } else {
                $_SESSION['error'] = "Error al registrar la mesa.";
            }

            header("Location: ../vista/HTML/admin/listar_mesas.php");
            exit;
        }
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $numeroMesa = $_POST['numero_mesa'] ?? '';
            $capacidad = $_POST['capacidad'] ?? '';
            $ubicacion = $_POST['ubicacion'] ?? '';
            $estado = $_POST['estado'] ?? 'Libre';

            $resultado = $this->mesaModel->actualizarMesa($id, $numeroMesa, $capacidad, $ubicacion, $estado);

            session_start();
            if ($resultado) {
                $_SESSION['mensaje'] = "Mesa actualizada correctamente.";
            } else {
                $_SESSION['error'] = "Error al actualizar la mesa.";
            }

            header("Location: ../vista/HTML/admin/listar_mesas.php");
            exit;
        }
    }

    public function actualizarEstado() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $estado = $_POST['estado'] ?? '';

            $resultado = $this->mesaModel->actualizarEstado($id, $estado);

            session_start();
            if ($resultado) {
                $_SESSION['mensaje'] = "Estado actualizado correctamente.";
            } else {
                $_SESSION['error'] = "Error al actualizar el estado.";
            }

            header("Location: ../vista/HTML/admin/listar_mesas.php");
            exit;
        }
    }

    public function eliminar() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $resultado = $this->mesaModel->eliminarMesa($id);

            session_start();
            if ($resultado) {
                $_SESSION['mensaje'] = "Mesa eliminada correctamente.";
            } else {
                $_SESSION['error'] = "Error al eliminar la mesa.";
            }

            header("Location: ../vista/HTML/listar_mesas.php");
            exit;
        }
    }
}

$controller = new MesaController();

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'registrar':
            $controller->registrar();
            break;
        case 'actualizar':
            $controller->actualizar();
            break;
        case 'actualizar_estado':
            $controller->actualizarEstado();
            break;
    }
} elseif (isset($_GET['accion']) && $_GET['accion'] === 'eliminar') {
    $controller->eliminar();
}
?>