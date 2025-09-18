<?php
require_once "../../conexion.php";
class Usuario{
    $db;
    private function__construct(){
        this->db=Datbase::connect();
    }

    public function obtener_usuario($email){
        $sql="SELECT * FROM usuarios WHERE email=:email LIMIT 1";
        $consult=$this->db->prepare($sql);
        $consult->execute([":email"=>$email,]);

        return $consult->fetch();

    }

    public function login($email,$pass){
        $usuario = $this->obtener_usuario($email);
        if($usuario && password_verify($pass,$usuario['Password']))
            return $usuario;
    }
    return false;


    public function listar_usuarios(){

    }

    public function crear_usuarios(){

    }

}




?>
