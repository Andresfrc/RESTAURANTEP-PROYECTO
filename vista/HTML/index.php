<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../BOOTSTRAP/bootstrap-5.3.3-dist/css/bootstrap.min.css">
  <script src="../BOOTSTRAP/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <link rel="stylesheet" href="../CSS/index.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
  <title>JapanFood</title>
</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
      <img src="../IMG/2995566471.jpg" alt="Avatar Logo" style="width:90px;" class="rounded-pill">
      <h1 style="color: red; font-size:50px; font-family:monospace;font-family: Cinzel; ">JapanFood</h1>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a style="color: red;" class="nav-link" href="../HTML/index.php">Inicio</a>
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
            <li><a class="dropdown-item" href="../HTML/perfil.php">Perfil</a></li>
            <li><a class="dropdown-item" href="../HTML/Menu.html">Menu</a></li>
            <li><a class="dropdown-item" href="../HTML/carrito.html">Carrito</a></li>
            <li><a class="dropdown-item" href="../HTML/historial.html">Historial de pedidos</a></li>



          </ul>
        </li>
      </ul>
      </a>
    </div>
  </nav>
  <section id="carouselExample" class="carousel slide" data-bs-ride="carousel">
    
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true"
        aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <!-- Imágenes del carrusel -->
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="../IMG/Ahi_Tuna_Sashimi_Seafood_Recipe_1024x.webp" class="d-block w-100"
          alt="Interior del Restaurante">
        <div class="carousel-caption d-none d-md-block">
          <h1 class="text-white bg-danger p-2">Bienvenido a JapanFood</h1>
          <p class="fs-4">Más de 10 años de tradición en ofrecer una experiencia gastronómica única.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="../IMG/Interior del restaurante.jpg" class="d-block w-100" alt="Plato Japonés">
        <div class="carousel-caption d-none d-md-block">
          <h1 class="text-white bg-danger p-2">Auténtica Comida Japonesa</h1>
          <p class="fs-4">Disfruta de nuestros platillos preparados con ingredientes frescos.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="../IMG/mochis.png" class="d-block w-100" alt="Variedad de Sushi">
        <div class="carousel-caption d-none d-md-block">
          <h1 class="text-white bg-danger p-2">Descubre Nuestro Menú</h1>
          <p class="fs-4">Explora una amplia variedad de sushi, ramen y más.</p>
        </div>
      </div>
    </div>


    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Siguiente</span>
    </button>
  </section>

  <div style="padding: 20px;" class="container">
    <h5 style="text-align:center ; color:white; background-color: red; font-family: Cinzel;">Platos representativos</h5>
  </div>
  <div class="d-flex flex-wrap justify-content-center gap-3">
    <div class="card" style="width:400px; color: red;">
      <img style="height: 300px;" class="card-img-top" src="../IMG/miso-shiru-soup.jpg" alt="Card image">
      <div class="card-body">
        <h4 style="font-family:Cinzel ;" class="card-title">Sopa Miso</h4>
        <p style="font-family: Cinzel; " class="card-text">Una exquisita y reconfortante sopa tradicional japonesa,
          preparada con un delicado caldo dashi infusionado con pasta de miso fermentada, que ofrece un sabor umami
          profundo y suave. Acompañada de finas láminas de tofu suave, cebollín fresco picado y algas wakame. <br
            style="color: green;">Precio:$20.000</p>
        <a style="border: 1px; background-color: red" href="../HTML/carrito.html" class="btn btn-primary">Comprar</a>
        <samp style="font-weight: bold; color: green;" class="precio">$23.950</samp>
      </div>
    </div>
    <div class="card" style="width:400px; color: red;">
      <img style="height: 300px;" class="card-img-top" src="../IMG/mochis.png" alt="Card image">
      <div class="card-body">
        <h4 style="font-family: Cinzel;" class="card-title">Mochis</h4>
        <p style="font-family: Cinzel;" class="card-text">Deliciosos y suaves, nuestros mochis son dulces tradicionales
          japoneses hechos a base de arroz glutinoso, que envuelven un relleno cremoso y sabroso en su interior. Cada
          bocado es una mezcla de texturas: la suavidad y elasticidad del arroz complementada por el relleno de pasta de
          frijoles rojos anko, helado de té verde o incluso frutas frescas, creando una experiencia única. </p>
        <a style="background-color: red; border: 1px " href="../HTML/carrito.html" class="btn btn-primary">Comprar</a>
        <samp style="font-weight: bold; color: green;" class="precio">$13.950</samp>
      </div>
    </div>
    <div class="card" style="width:400px; color: red;">
      <img style="height: 300px;" class="card-img-top" src="../IMG/whatisamazake_01.jpg" alt="Card image">
      <div class="card-body">
        <h4 style="font-family: Cinzel;" class="card-title">Amazake</h4>
        <p style="font-family: Cinzel;" class="card-text">Una bebida tradicional japonesa dulce y reconfortante, el
          amazake es un suave y espeso brebaje elaborado a base de arroz fermentado, que destaca por su sabor suave y
          ligeramente dulce. </p>
        <a style="background-color: red; border: 1px " href="../HTML/carrito.html" class="btn btn-primary">Comprar</a>
        <samp style="font-weight: bold; color: green;" class="precio">$17.900</samp>
      </div>
    </div>

    <footer class="bg-dark text-white text-center py-5 w-100">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <ul class="list-unstyled">
              <li><a href=# class="text-white">Sobre nosotros</a></li>
              <li><a href=# class="text-white">Cra93#5a</a></li>
              <li><a href=# class="text-white">315226756</a></li>
              <li><a href=# class="text-white">JapanFood@gmail.com</a></li>
            </ul>
          </div>
          <div class="col-md-4">
            <h5>Síguenos</h5>
            <a href="https://es-la.facebook.com/login/device-based/regular/login/"><img src="../IMG/facebook.png" alt=""
                width="50"></a>
            <a href="https://x.com/?lang=es"><img src="../IMG/gorjeo.png" alt="" width="50"></a>
            <a href="https://www.instagram.com/"><img src="../IMG/instagram.png" alt="" width="50"></a>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-12">
            <p>&copy; 2025 JapanFood. Todos los derechos reservados.</p>
          </div>
        </div>
      </div>
    </footer>
</body>