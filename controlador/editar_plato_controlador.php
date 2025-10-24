<?php
require_once __DIR__ . "/../modelo/platos.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $platoModel = new Plato();
    $plato = $platoModel->obtenerPlato($id);

    if (!$plato) {
        die("Plato no encontrado.");
    }

    $imagenPath = $plato['Imagen']; // conservar la imagen anterior

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../vista/IMG/platos/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $imagenName = basename($_FILES['imagen']['name']);
        $imagenPath = $uploadDir . $imagenName;

        move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenPath);

        // Borrar la imagen anterior
        if (!empty($plato['Imagen']) && file_exists($plato['Imagen'])) {
            unlink($plato['Imagen']);
        }
    }

    $platoModel->actualizarPlato($id, $nombre, $descripcion, $precio, $imagenPath);
    header("Location: ../vista/HTML/listar_platos.php?msg=Plato actualizado correctamente");
    exit;
}
?>
