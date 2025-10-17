<?php
require_once __DIR__ . '/../modelo/platos.php';



class PlatoController {

   
    private $platoModel;

    
    public function __construct(){
       
        $this->platoModel = new Plato();
    }

    
    public function agregarPlato() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $imagenPath = null; 

           
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
               $uploadDir = __DIR__ . '/../vista/IMG/platos/';
               $imagenPath = $uploadDir . basename($_FILES['imagen']['name']);

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true); 
                }

                $imagenTmpPath = $_FILES['imagen']['tmp_name']; 
                $imagenName = basename($_FILES['imagen']['name']); 

                
                move_uploaded_file($imagenTmpPath, $imagenPath);
            }

            // Llamar al modelo para agregar el plato
            $this->platoModel->agregarPlato($nombre, $descripcion, $precio, $imagenPath);

            // Redirigir o mostrar un mensaje de éxito
            header("Location: ../vista/HTML/crear_plato.php?success=1");
            exit();
        }
    }
}

// Crear una instancia de la clase y ejecutar el método
$platoController = new PlatoController();
$platoController->agregarPlato();
?>
