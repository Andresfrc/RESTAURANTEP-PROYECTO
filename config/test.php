<?php
require_once "conexion.php";

try{
    $db= Database::connect();
    echo "Conexion exitosa";
}catch(Exception $e){
    echo "Error de conexion: ".$e->getMessage();
}



?>