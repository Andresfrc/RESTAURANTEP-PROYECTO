<?php

require_once "conexion.php";

try{
    $db= Database::connect();
    $email="pepe21@gmail.com";

    $consul=$db->prepare("SELECT * FROM usuarios WHERE email=:email");
    $consul->execute([":email"=>$email]);

    if(!$consul->fetch()){
        $pass =password_hash("admin1234",PASSWORD_BCRYPT);
        $sql ="INSERT INTO usuarios (nombre,email,password,rol) VALUES ('Admin',:email,:clave,'Administrador')";
        $consult =$db->prepare($sql);
        $consult->execute([":email"=>$email,":clave"=>$pass]);
        echo "Usuario admin creado";

    }else{
        echo "El usuario ya existe";
    }
    
}
catch(PDOException $e){
          die("Error".$e->getMessage());

}
    


?>