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

            if ($resultado === "email_duplicado") {
                session_start();
                $_SESSION['error'] = "El email ya está registrado.";
                header("Location: ../vista/HTML/registro.php");
                exit;
            } elseif ($resultado) {
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
                header("Location: ../vista/HTML/registro.php");
                exit;
            }
        }
    }

    public function crear_desde_admin() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $rol = $_POST['rol'] ?? 'Usuario';

        $resultado = $this->modelusuario->crear_usuario($nombre, $email, $password, $rol);

        session_start();
        if ($resultado) {
            $_SESSION['mensaje'] = "Usuario creado correctamente.";
        } else {
            $_SESSION['error'] = "Error al crear el usuario.";
        }

        header("Location: ../vista/HTML/bienvenida_admin.php");
        exit;
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

    public function actualizar_perfil() {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['usuario'])) {
            $id = $_SESSION['usuario']['Id_Usuario'];
            $nombre = $_POST['nombre'] ?? '';
            $password = $_POST['password'] ?? '';

            $resultado = $this->modelusuario->actualizar_perfil($id, $nombre, $password ?: null);

            if ($resultado) {
                // Actualizar los datos de sesión
                $_SESSION['usuario']['Nombre'] = $nombre;
                $_SESSION['mensaje'] = "Perfil actualizado correctamente.";
            } else {
                $_SESSION['error'] = "Error al actualizar el perfil.";
            }

            header("Location: ../vista/HTML/perfil_usuario.php");
            exit;
        }
    }
} 
    





$controller = new UsuarioController();

if (isset($_POST['accion'])) {
    switch ($_POST['accion']) {
        case 'registro':
            $controller->registrar();
            break;
        case 'login':
            $controller->validarusu();
            break;
        case 'crear_desde_admin':
            $controller->crear_desde_admin();
            break;
        case 'actualizar_perfil':
            $controller->actualizar_perfil();
            break;
    
    }
}

?>
