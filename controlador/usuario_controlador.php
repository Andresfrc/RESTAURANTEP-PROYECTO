<?php
require_once "../../conexion.php";

class UsuarioController{
    private $modelusuario;

    public function __construct(){
        $this->modelusuario= new Usuario();
    }

    public function validarusu(){
        if($_SERVER['REQUEST_METHOD']==='POST'){

            $usuario=$this->modelusuario->login($_POST['email'],$_POST)
            if($usuario){
                session_start();
                $_SESSION['usarios']=$usuario;
                header("Location: ../../vista/registro.php")

            }else{
                echo "Credenciales incorrectas"
                header ("Location: ../../vista/perfil.php")
            }
        }
    }

    public function cerrar_sesion(){
        $usuario=$this->modelusuario->
    }



}
$objeto = new UsuarioController();
$objeto-> validarusu();


?>