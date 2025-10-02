<?php

require_once __DIR__ . "/../modelo/usuario.php";

class UsuarioController {
    private $modelusuario;

    public function __construct() {
        $this->modelusuario = new Usuario();
    }

    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $resultado = $this->modelusuario->crear_usuario($nombre, $email, $password);

            if ($resultado) {
                // Obtener datos del usuario recién creado para iniciar sesión automáticamente
                $usuario = $this->modelusuario->login($email, $password);

                if ($usuario) {
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['mensaje'] = "Usuario registrado con éxito.";

                    if ($usuario['Rol'] === 'Administrador') {
                        header("Location: ../vista/HTML/bienvenida_admin.php");
                    } else {
                        header("Location: ../vista/HTML/bienvenida_usuario.php");
                    }
                    exit;
                } else {
                    session_start();
                    $_SESSION['error'] = "Error al iniciar sesión después del registro.";
                    header("Location: ../vista/HTML/perfil.php");
                    exit;
                }
            } else {
                session_start();
                $_SESSION['error'] = "Error al registrar usuario.";
                header("Location: ../vista/registro/HTML/registro.php");
                exit;
            }
        }
    }

    private function redirigir_por_rol($usuario) {
        session_start();
        $_SESSION['usuario'] = $usuario;

        if ($usuario['Rol'] === 'Administrador') {
            header("Location: ../vista/HTML/bienvenida_admin.php");
        } else {
            header("Location: ../vista/HTML/bienvenida_usuario.php");
        }
        exit;
    }

    public function validarusu() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $usuario = $this->modelusuario->login($email, $password);

            if ($usuario) {
                session_start();
                $_SESSION['usuario'] = $usuario;

                if ($usuario['Rol'] === 'Administrador') {
                    header("Location: ../vista/HTML/bienvenida_admin.php");
                    exit;
                } else {
                    header("Location: ../vista/HTML/bienvenida_usuario.php");
                    exit;
                }
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
