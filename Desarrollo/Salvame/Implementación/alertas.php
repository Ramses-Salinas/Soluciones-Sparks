<?php
session_start();
require './conexion_bd.php';
//obteniendo las fechas de las alertas
$query = $conn->prepare("SELECT  * FROM  alerta");
$query->execute();
$data = $query->fetchAll();
//pasando las fechas a un arreglo
$fechal = array_unique(array_column($data, 'fecha'));
//Verificando el inicio de sesion
if (isset($_SESSION['id_usuario'])) {
    $records = $conn->prepare('SELECT id_usuario, correo, contrasenia FROM usuario WHERE id_usuario = :id_usuario');
    $records->bindParam(':id_usuario', $_SESSION['id_usuario']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);
    $user = null;
    /*comprobando que no esta vacio*/
    if (count($results) > 0) {
        $user = $results;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilos/estiloalertas.css" />
    <script src="https://code.jquery.com/jquery-3.6.1.js"
        integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>



    <title>Salvame-Alertas</title>

</head>

<body>
    <header>
        <div class="nav-logo">
            <a class="boton-logo" href="./index.php"><img src="./imagenes/logo_colores.jpg" alt="" /></a>
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

    <section id="contenido">
        <h1 class="titulo1">Ver Alertas</h1>
        <div id="opciones" class="opciones">
            <form action="alertas.php" method="post">
                <select id="departamento" name="departamento">
                    <option>Regiones</option>
                    <option>Amazonas</option>
                    <option>Ancash</option>
                    <option>Apurimac</option>
                    <option>Arequipa</option>
                    <option>Ayacucho</option>
                    <option>Cajamarca</option>
                    <option>Callao</option>
                    <option>Cusco</option>
                    <option>Huancavelica</option>
                    <option>Huanuco</option>
                    <option>Ica</option>
                    <option>Junín</option>
                    <option>La Libertad</option>
                    <option>Lambayeque</option>
                    <option>Lima</option>
                    <option>Loreto</option>
                    <option>Madre de Dios</option>
                    <option>Moquegua</option>
                    <option>Pasco</option>
                    <option>Piura</option>
                    <option>Puno</option>
                    <option>San Martín</option>
                    <option>Tacna</option>
                    <option>Tumbes</option>
                    <option>Ucayali</option>
                </select>
                <select id="fechas" name="fechas">
                    <option value="Fechas">Fechas</option>
                    <?php
                    foreach ($fechal as $valores) :
                        echo '<option value="' . $valores . '">' . $valores . '</option>';
                    endforeach;
                    ?>
                </select>
                <button type="submit" name="buscar">Buscar</button>
            </form>
        </div>
        <div id="multi">
            <div id="imagenes">
                <?php
                if (!isset($_POST['buscar']) || $_POST['fechas'] == 'Fechas') {
                    foreach ($data as $valores) :
                        if ($valores["nombre"] == null) {
                            $valores["nombre"] = "Anonima";
                        }
                        if ($valores["nombre_animal"] == null) {
                            $valores["nombre_animal"] = "Nombre Animal";
                        }
                        //para asiganr identificador unico a cada div generado
                        $id = $valores["id_alerta"];
                        echo "<button onclick='openForm($id)'><img src='data: image/jpeg; base64, " . base64_encode($valores["imagen_prueba"]) . "'> </button>
                        
        <div class='info' id='$id'>
        <div class='cabecera'>
            <div class='imagen'>
            <img src='data: image/jpeg; base64, " . base64_encode($valores["imagen_prueba"]) . "'></div>
            <div class='infocabecera'>
            <div class='blanco'>
                <label class='numero'>Alerta " . $valores["id_alerta"] . "</label><br>
                <label class='usuario'>" . $valores["nombre"] . "</label><br>
                <label class='fecha'>Fecha: " . $valores["fecha"] . "</label><br>
            </div>
            </div>
            <button class='btncerrar'onclick='closeForm($id)'><img src='./imagenes/chevrone.png'></button>
        </div>
        
        <div class='nombreAnimal'>
            <label class='blanco'>" . $valores["nombre_animal"] . "</label>
            </div>
            
            <div class='descripciones'>
                <div class='Animal'>
                <div class='solido'>
                    <label>Animal afectado </label>
                    
                </div>
                <div class='parrafo'>
                    <p>" . $valores["descri_animal"] . "</p>
            </div>
                    </div>
            <div class='hechos'>
            <div class='solido'>
                <label>Hechos</label>
                </div>
                <div class='parrafo'>
                <p>" . $valores["descri_hechos"] . "</p>
            </div></div>
        </div>
        </div>";

                    endforeach;
                } else
        if (isset($_POST['buscar'])) {
                    $fecha = $_POST['fechas'];
                    foreach ($data as $valores) :
                        if ($valores["fecha"] == $fecha) {
                            $id = $valores["id_alerta"];
                            echo "<button onclick='openForm($id)'><img src='data: image/jpeg; base64, " . base64_encode($valores["imagen_prueba"]) . "'> </button>
                        
        <div class='info' id='$id'>
        <div class='cabecera'>
            <div class='imagen'>
            <img src='data: image/jpeg; base64, " . base64_encode($valores["imagen_prueba"]) . "'></div>
            <div class='infocabecera'>
                <label>Alerta " . $valores["id_alerta"] . "</label><br>
                <label>" . $valores["nombre"] . "</label><br>
                <label>Fecha:" . $valores["fecha"] . "</label><br>
            </div>
            <button onclick='closeForm($id)'><img src='./imagenes/logo_colores.jpg'></button>
        </div>
        
        <div class='nombreAnimal'>
            <label>" . $valores["nombre_animal"] . "</label>
            </div>
            <div class='descripciones'>
                <div class='Animal'>
                    <label>Animal afectado <img src='#'></label>
                    <p>" . $valores["descri_animal"] . "</p>
            </div>
            <div class='hechos'>
                <label>Hechos<img src='#'></label>
                <p>" . $valores["descri_hechos"] . "</p>
            </div>
        </div>
        </div>";
                        }
                    endforeach;
                }
                ?>
                <!-- <img src="./imagenes/image 52.png"> -->
            </div>
            <div id="mapa">

            </div>
            <script src="./js/alertas.js">
            </script>
            <script async
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFwt7lkRXa-tIUzTvzxhUlEq5nmHO_Ui0&callback=initMap"
                defer>
            </script>
        </div>
    </section>
    <script>
    function openForm(id) {
        console.log(id);
        document.getElementById(id).style.display = "block";
    }

    function closeForm(id) {
        document.getElementById(id).style.display = "none";
    }
    </script>
    <footer>
        <div class="footer">
            <div>
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
            <div>
                <h4>Nosotros</h4>
                <ul class="footer-datos">
                    <li><a href="#">¿Por qué Suscribirme a Sálvame?</a></li>
                </ul>
            </div>
            <div>
                <h4>Información</h4>
                <ul class="footer-datos">
                    <li><a href="#">Ver Alertas</a></li>
                </ul>
            </div>
            <div>
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