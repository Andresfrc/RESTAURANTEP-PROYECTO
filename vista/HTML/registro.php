<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Restaurante Delicias</title>
  <link rel="stylesheet" href="../style/registro.css">
</head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
      <img src="../IMG/2995566471.jpg" alt="Avatar Logo" style="width:90px;" class="rounded-pill">
      <h1 style="color: red; font-size:50px; font-family:monospace;font-family: Cinzel; ">JapanFood</h1>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a style="color: red;" class="nav-link" href="../HTML/index.html">Inicio</a>
        </li>
        <li class="nav-item">
          <a style="color: red;" class="nav-link" href="../HTML/Menu.html">Menu</a>
        </li>
        <li class="nav-item">
          <a style="color: red;" class="nav-link" href="../HTML/Contacto.html">Contacto</a>
        </li>
        <li class="nav-item">
          <a style="color: red;" class="nav-link" href="../HTML/sobrenos.html">Sobre nosotros</a>
        </li>
        <li class="nav-item">
          <a style="color: red;" class="nav-link" href="../HTML/reservas.html">Reserva</a>
        </li>
        <li style="z-index: 1050;;" class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" style="color: red;" href="#" id="menuDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Domicilios
          </a>
          <ul style="position: absolute; z-index: 1050;" class="dropdown-menu dropdown-menu-end"
            aria-labelledby="menuDropdown">
            <li><a class="dropdown-item" href="../HTML/perfil.html">Perfil</a></li>
            <li><a class="dropdown-item" href="../HTML/Menu.html">Menu</a></li>
            <li><a class="dropdown-item" href="../HTML/carrito.html">Carrito</a></li>
            <li><a class="dropdown-item" href="../HTML/historial.html">Historial de pedidos</a></li>
          </ul>
        </li>
      </ul>
      </a>
    </div>
  </nav>
  <main class="container">
    <div class="form-box">
      <h1>Crear cuenta</h1>
      <form id="formRegistro">
        <div class="input-group">
          <label for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="input-group">
          <label for="apellido">Apellido</label>
          <input type="text" id="apellido" name="apellido" required>
        </div>

        <div class="input-group">
          <label for="correo">Correo</label>
          <input type="email" id="correo" name="correo" required>
        </div>

        <div class="input-group">
          <label for="telefono">Teléfono</label>
          <input type="text" id="telefono" name="telefono">
        </div>

        <div class="input-group">
          <label for="contraseña">Contraseña</label>
          <input type="password" id="contraseña" name="contraseña" required>
        </div>

        <button type="submit" class="btn">Registrarse</button>
      </form>

      <p class="redirect">
        ¿Ya tienes cuenta? <a href="login.html">Inicia sesión</a>
      </p>
    </div>
  </main>
</body>
</html>