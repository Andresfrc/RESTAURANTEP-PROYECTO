<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro</title>
  <link rel="stylesheet" href="../CSS/registro.css"> 
</head>
<body>
  <div class="registro-container">
    <h2>Crear Cuenta</h2>
    <form action="../controlador/usuario_controlador.php" method="POST" class="form-registro">
  <input type="hidden" name="accion" value="registro">

  <label for="nombre">Nombre</label>
  <input type="text" id="nombre" name="nombre" class="input" required>

  <label for="email">Correo electrónico</label>
  <input type="email" id="email" name="email" class="input" required>

  <label for="password">Contraseña</label>
  <input type="password" id="password" name="password" class="input" required>

  <button type="submit" class="btn">Registrarse</button>
</form>


    <p class="redirect">
      ¿Ya tienes cuenta? <a href="perfil.php">Inicia sesión</a>
    </p>
  </div>
</body>
</html>
