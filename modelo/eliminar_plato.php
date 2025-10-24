<?php
require_once __DIR__ . "/../modelo/platos.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $platoModel = new Plato();

    // Obtener el plato para borrar su imagen también
    $plato = $platoModel->obtenerPlato($id);

    if ($plato) {
        // Eliminar de la BD
        if ($platoModel->eliminarPlato($id)) {
            // Eliminar imagen si existe
            if (!empty($plato['Imagen']) && file_exists($plato['Imagen'])) {
                unlink($plato['Imagen']);
            }
            header("Location: ../vista/HTML/listar_platos.php?msg=Plato eliminado correctamente");
            exit;
        } else {
            die("Error al eliminar el plato.");
        }
    } else {
        die("Plato no encontrado.");
    }
} else {
    die("ID no especificado.");
}
?>
