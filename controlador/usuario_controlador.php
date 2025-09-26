<?php
require_once __DIR__ . "/../modelo/usuario.php";

class UsuarioController {
    private $modelusuario;

    public function __construct() {
        $this->modelusuario = new Usuario();
    }

   
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $resultado = $this->modelusuario->crear_usuario($nombre, $email, $password);

            if ($resultado) {
                session_start();
                $_SESSION['mensaje'] = "Usuario registrado con éxito.";
                header("Location: ../vista/HTML/perfil.php"); // redirige al login
                exit;
            } else {
                session_start();
                $_SESSION['error'] = "Error al registrar usuario.";
                header("Location: ../vista/registro/HTML/registro.php");
                exit;
            }
        }
    }

    
    public function validarusu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = $this->modelusuario->login($_POST['email'], $_POST['password']); 

            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;
                header("Location: ../vista/HTML/index.php");
                exit;
            } else {
                session_start();
                $_SESSION['error'] = "Credenciales incorrectas";
                header("Location: ../vista/HTML/perfil.php");
                exit;
            }
        }
    }

   
    public function cerrar_sesion() {
        session_start();
        session_destroy();
        header("Location: ../vista/HTML/perfil.php");
        exit;
    }
}

$controller = new UsuarioController();

if (isset($_POST['accion'])) {
    if ($_POST['accion'] === 'registro') {
        $controller->registrar();
    } elseif ($_POST['accion'] === 'login') {
        $controller->validarusu();
    }
}
?>
