<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Platillos</title>
</head>
<body>
    <h1>Agregar Platillo</h1>
    <form action="../../controlador/plato_controlador.php" method="POST" enctype="multipart/form-data">
        <div>
            <label for="nombre">Nombre del Platillo:</label>
            <input type="text" id="nombre" name="nombre" required maxlength="50">
        </div>
        
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea>
        </div>
        
        <div>
            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" step="0.01" min="0" required>
        </div>
        
        <div>
            <label for="imagen">Imagen del Platillo:</label>
            <input type="file" id="imagen" name="imagen" accept="image/*">
        </div>
        >

        <div>
            <button type="submit">Agregar Platillo</button>
        </div>
    </form>
</body>
</html>
