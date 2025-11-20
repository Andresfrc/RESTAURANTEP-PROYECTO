<?php
require_once __DIR__ . "/platos.php";
require_once __DIR__ . "/categoria.php";

$platoModel = new Plato();
$categoriaModel = new Categoria();

if (!isset($_GET['id'])) {
    die("ID no especificado.");
}

$id = intval($_GET['id']);
$plato = $platoModel->obtenerPlato($id);
$categorias = $categoriaModel->listarCategorias();

if (!$plato) {
    die("Plato no encontrado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Platillo</title>
    <link rel="stylesheet" href="../vista/CSS/editar_plato.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo">✏️ Editar Platillo</h1>
        <form class="formulario" action="/RESTAURANTEP-PROYECTO/controlador/editar_plato_controlador.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $plato['Id_Platillo']; ?>">

            <div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($plato['Nombre']); ?>" required>
            </div>

            <div class="campo">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" rows="4"><?php echo htmlspecialchars($plato['Descripcion']); ?></textarea>
            </div>

            <div class="campo">
                <label for="precio">Precio:</label>
                <input type="number" step="0.01" id="precio" name="precio" value="<?php echo htmlspecialchars($plato['Precio']); ?>" required>
            </div>

            <div class="campo">
                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria">
                    <option value="">Sin categoría</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['Id_Categoria']; ?>" 
                            <?php echo ($plato['CategoriaId_Categoria'] == $cat['Id_Categoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['Nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label>Imagen actual:</label><br>
                <?php 
                if (!empty($plato['Imagen']) && file_exists($plato['Imagen'])) {
                    $rutaRelativa = str_replace(__DIR__ . '/../../', '../', $plato['Imagen']);
                    echo "<img src='{$rutaRelativa}' width='120' height='90' style='object-fit:cover;border-radius:5px;'>";
                } else {
                    echo "<span>Sin imagen</span>";
                }
                ?>
            </div>

            <div class="campo">
                <label for="imagen">Nueva Imagen (opcional):</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>

            <button type="submit">Actualizar Platillo</button>
            <a href="../vista/HTML/listar_platos.php" class="admin-btn">Volver</a>
        </form>
    </div>
</body>
</html>