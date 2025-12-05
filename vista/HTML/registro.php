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
    
    <?php
      session_start();
      if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-error">' . htmlspecialchars($_SESSION['error']) . '</div>';
        unset($_SESSION['error']);
      }
      if (isset($_SESSION['mensaje'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
        unset($_SESSION['mensaje']);
      }
    ?>

    <form action="../../controlador/usuario_controlador.php" method="POST" class="form-registro">
      <input type="hidden" name="accion" value="registro">

      <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" class="input" placeholder="Tu nombre completo" required>
      </div>

      <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" class="input" placeholder="tu@email.com" required>
      </div>

      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" class="input" placeholder="••••••••" required>
      </div>

      <button type="submit" class="btn">Registrarse</button>
    </form>

    <p class="redirect">
      ¿Ya tienes cuenta? <a href="perfil.php">Inicia sesión</a>
    </p>
  </div>
</body>
</html>