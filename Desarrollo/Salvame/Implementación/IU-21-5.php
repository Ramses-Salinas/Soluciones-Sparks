<?php
session_start();

require './conexion_bd.php';
if (isset($_SESSION['id_usuario'])) {
  $records = $conn->prepare('SELECT id_usuario, correo, contrasenia FROM usuario WHERE id_usuario = :id_usuario');
  $records->bindParam(':id_usuario', $_SESSION['id_usuario']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);
  $user = null;
  if (count($results) > 0) {
    $user = $results;
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FichaAnimal</title>
    <link rel="shortcut icon" href="imagenes/logo_colores.jpg" type="image/x-icon" />
    <link rel="stylesheet" href="estilos/estiloIU-21.css" />
</head>

<body>
    <header>
        <div class="nav-logo">
            <a class="boton-logo" href="./index.php"><img src="./imagenes/logo_colores.png" alt="" /></a>
        </div>
        <div class="menu-cambia">
            <ul class="menu">
                <?php if (!empty($user)) : ?>
                <nav>
                    <a class="boton" href="./cerrarsesion.php">Cerrar Sesion</a>
                </nav>
                <?php else : ?>
                <nav>
                    <a class="boton" href="registrarse.php">Registrarme</a>
                    <a class="boton" href="iniciarsesion.php">Iniciar Sesión</a>
                </nav>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <main class="main">
        <!-- /*Portada*/ -->
        <div class="Portada">
            <img class="Portada__imagen" src="imagenes/Gibon.jpg" alt="" />
        </div>

        <section class="main-contenedor">
            <div class="main-contenedor__descripcion">
                <h2>GIBÓN PLATEADO"</h2>
                <h4>Familia: Hylobatidae</h4>
                <h4>Especie: Primate hominoideoo</h4>
                <p class="Descripcion">
                    Integer eleifend dui sed lectus lacinia, non ultricies neque rutrum.
                    Donec lorem elit, condimentum sed porta molestie, bibendum et ex.
                    Donec augue lacus, consectetur a maximus id, lobortis at turpis.
                    Nullam aliquam rutrum hendrerit. Fusce maximus eros arcu, vel
                    venenatis elit mollis vitae.
                </p>

                <h4>Departamento: Amazonas</h4>

                <h4>Provincia: Chachapoyas</h4>
            </div>

            <div class="main-contenedor__mapa">
                <img class="main-contenedor__imagen" src="imagenes/AmazonasMapa.jpg" alt="" />
            </div>
        </section>

        <div class="boton-Atras">
            <a class="boton" href="./IU-20.php"> Atrás </a>
        </div>
    </main>

    <footer>
        <div class="footer">
            <div class="footer_contacto">
                <div class="nav-logo">
                    <img src="imagenes/logo_colores.png" alt="" />
                </div>
                <ul class="integrantes">
                    <li>Alata Gutierrez, Rodolfo</li>
                    <li>Camana Huapaya, Ariana</li>
                    <li>Ccanto Flores, Rosmeri</li>
                    <li>Mitac Saavedra, Milena Diana</li>
                    <li>Rivera Inche, Erly</li>
                    <li>Rosas Sequeiros, Fabricio</li>
                    <li>Salinas Mejías, Ramses</li>
                </ul>
                <div class="redes">
                    <a href="#"><img src="imagenes/icons8-facebook-f-24.png" alt="" /></a>
                    <a href="#"><img src="imagenes/instagram.png" alt="" /></a>
                    <a href="#"><img src="imagenes/gorjeo.png" alt="" /></a>
                </div>
            </div>
            <div class="footer_info">
                <h4>Nosotros</h4>
                <ul class="footer-datos">
                    <li><a href="#">¿Por qué Suscribirme a Sálvame?</a></li>
                </ul>
            </div>
            <div class="footer_info">
                <h4>Información</h4>
                <ul class="footer-datos">
                    <li><a href="#">Ver Alertas</a></li>
                </ul>
            </div>
            <div class="footer_info">
                <h4>Únete</h4>
                <ul class="footer-datos">
                    <li><a href="#">Postular a Moderador</a></li>
                </ul>
            </div>
        </div>
        <p>© 2022 Sálvame. ALL RIGHT RESERVED.</p>
    </footer>
</body>

</html>