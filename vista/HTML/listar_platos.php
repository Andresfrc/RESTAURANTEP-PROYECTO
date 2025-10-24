<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['Rol'] !== 'Administrador') {
    header("Location: perfil.php");
    exit;
}

require_once __DIR__ . "/../../modelo/platos.php";
$platoModel = new Plato();
$platos = $platoModel->listarPlatos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Platillos</title>
    <link rel="stylesheet" href="../CSS/listar_platos.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo">Listado de Platillos</h1>

        <div class="botones">
            <a href="crear_plato.php" class="btn-agregar">➕ Agregar nuevo platillo</a>
            <a href="bienvenida_admin.php" class="btn-volver">🏠 Volver al Panel</a>
        </div>

        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Imagen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($platos)): ?>
                    <?php foreach ($platos as $plato): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($plato['Id_Platillo']); ?></td>
                            <td><?php echo htmlspecialchars($plato['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($plato['Descripcion']); ?></td>
                            <td>$<?php echo number_format($plato['Precio'], 2); ?></td>
                            <td>
                                <?php 
                                if (!empty($plato['Imagen'])) {
                                    $rutaImagen = $plato['Imagen'];
                                    $rutaImagen = str_replace('\\', '/', $rutaImagen); // normaliza separadores

                                    // Si la ruta es absoluta (desde XAMPP)
                                    if (strpos($rutaImagen, 'C:/xampp/htdocs/') === 0) {
                                        $rutaRelativa = str_replace('C:/xampp/htdocs/', 'http://localhost/', $rutaImagen);
                                    } 
                                    // Si ya es relativa (ej: vista/IMG/platos/img.jpg)
                                    else if (strpos($rutaImagen, 'http://') === 0 || strpos($rutaImagen, 'https://') === 0) {
                                        $rutaRelativa = $rutaImagen; // ya es una URL
                                    } else {
                                        // Si solo guarda la ruta interna del proyecto
                                        $rutaRelativa = "http://localhost/TT/" . ltrim($rutaImagen, '/');
                                    }

                                    echo "<img src='{$rutaRelativa}' width='100' height='80' style='object-fit:cover;border-radius:5px;'>";
                                } else {
                                    echo "<span style='color:gray;'>Sin imagen</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a href='../../modelo/editar_plato.php?id=<?php echo $plato['Id_Platillo']; ?>' class='btn-editar'>✏️ Editar</a>
                                <a href='../../modelo/eliminar_plato.php?id=<?php echo $plato['Id_Platillo']; ?>' class='btn-eliminar' onclick="return confirm('¿Seguro que quieres eliminar este plato?');">🗑️ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6">No hay platillos registrados</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
