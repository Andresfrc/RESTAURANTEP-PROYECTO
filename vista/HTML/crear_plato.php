<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Platillos</title>
    <link rel="stylesheet" href="../CSS/crear_plato.css">
</head>
<body>
    <div class="container">
        <h1 class="titulo"> Agregar Platillo</h1>
        <form class="formulario" action="../../controlador/plato_controlador.php" method="POST" enctype="multipart/form-data">

            <div class="campo">
                <label for="nombre">Nombre del Platillo:</label>
                <input placeholder="Ej: Sushi" type="text" id="nombre" name="nombre" required maxlength="50">
            </div>
            
            <div class="campo">
                <label for="descripcion">Descripción:</label>
                <textarea placeholder="Describe los ingredientes y sabor del platillo..." id="descripcion" name="descripcion" rows="4" cols="50"></textarea>
            </div>
            
            <div class="campo">
                <label for="precio">Precio:</label>
                <input placeholder="0.00" type="number" id="precio" name="precio" step="0.01" min="0" required>
            </div>
            
            <div class="campo">
                <label for="imagen">Imagen del Platillo:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*">
            </div>

            <button type="submit">Agregar Platillo</button>
            <a href="bienvenida_admin.php" class="admin-btn">Volver al Panel</a>
        </form>
    </div>
</body>
</html>
