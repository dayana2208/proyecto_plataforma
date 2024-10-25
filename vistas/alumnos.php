<?php
// Incluir la conexión a la base de datos
include '../config/conexion_be.php';  // Asegúrate de que la ruta sea correcta

session_start();

if(!isset($_SESSION['usuario']))  //si no existe la variable de sesion usuario
{
    echo '
        <script>
            alert("Debes iniciar sesión");
            window.location = "../login.php";
        </script>
    ';
    session_destroy();
    die();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/estilo_alumnos.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Alumnos</title>
</head>

<body>
    <header>
        <div class="header_container">
            <div class="logo_container">
                <img src="../assets/images/logo.png" alt="Logo" class="logo">
                <h1>PROYECTO GUADALUPE</h1>
            </div>

            <nav class="nav_links">
                <a href="../alumno/cursos.php">Cursos</a>
                <a href="#">Evaluaciones</a>
                <a href="#">Recursos</a>
                <a href="#">Reuniones</a>
            </nav>

            <div class="user_profile">
                <i class='bx bx-user icon_user' id="userIcon"></i>
                <div class="user_menu" id="userMenu">
                    <a href="#">Editar Perfil</a>
                    <a href="../php/cerrar_sesion.php">Cerrar Sesión</a>
                </div>
            </div>
        </div>
    </header>
    <section class="home">
        <div class="text">FORMANDO EVANGELIZADORES EUCARÍSTICOS PARA EL MUNDO MODERNO</div>
        <div class="container">
            <div class="image-container">
                <img src="../assets/images/imagen3.jpg" alt="Tu imagen">
            </div>
            <div class="text-container">
                <h2>NUESTRA MISIÓN</h2>
                <p>Formar un centro regional de evangelización que forme líderes católicos para convertirse en Evangelizadores Eucarísticos. Trabajando dentro de la iniciativa trienal de los Obispos, Renacimiento Eucarístico: Mi Carne para la Vida del Mundo.</p>
            </div>
        </div>
        <div class="container">
            <div class="text-container">
                <h2>¿QUIÉNES SOMOS?</h2>
                <p>Somos una Asociación Pública de Fieles cuyo Estatuto fue erigido en la Arquidiócesis de Trujillo, Perú;
                y cuyos fundadores viven en Estados Unidos. Para expresar una comunión inquebrantable entre los
                Iglesia en América del Norte y América del Sur, y con el acuerdo entre el Arzobispo de Trujillo,
                Perú y el Obispo de Phoenix, Estados Unidos; contaríamos con los dos Reconocimientos Canónicos Mutuos.</p>
            </div>
            <div class="image-container">
                <img src="../assets/images/imagen5.jpg" alt="Tu imagen">
            </div>            
        </div>
        <div class="container">
            <div class="image-container">
                <img src="../assets/images/imagen6.jpg" alt="Tu imagen">
            </div>
            <div class="text-container">
                <h2>NUESTRO APOSTOLADO</h2>
                <p>Emulamos a la Santísima Virgen María al “proclamar la grandeza del Señor” Lucas 1:46. Como Ella queremos
                “Ser santos y cambiar el mundo” brindando a todos la oportunidad de volver al amor de Dios.
                inspirado a evangelizar internacionalmente por el celo misionero de San Francisco Javier y la exhortación de
                Sagrada Escritura para evangelizar a todos los pueblos de “todas las naciones” (Mt 28,19).</p>
            </div>
        </div>
        <div class="container">
            <div class="text-container">
                <h2>PROYECTO GUADALUPE</h2>
                <p>El Proyecto Guadalupe ha pasado a ser una iniciativa de diez años dedicada 
                    a formar Evangelizadores Eucarísticos, quienes enseñarán a los católicos 
                    sobre la Misa y la Eucaristía. En 2031, la Iglesia en las Américas celebrará 
                    el 500 aniversario de las apariciones de Nuestra Señora de Guadalupe, y esperamos 
                    darle a Nuestra Iglesia y a Nuestra Señora el regalo de que más católicos reciban 
                    a Nuestro Señor en la Sagrada Eucaristía en la Santa Misa.</p>
            </div>
            <div class="image-container">
                <img src="../assets/images/project.jpg" alt="Tu imagen">
            </div>
        </div>
        <div class="container-consg">
            <div class="text-consg">
                <h2>CONSAGRACIÓN</h2>
                <p>Este proyecto fue consagrado a Nuestra Señora el 12 de diciembre de 2012 por el obispo Thomas Olmsted 
                    durante un rosario que se rezó frente al mosaico de la Virgen de Guadalupe ubicado en los jardines 
                    del Vaticano. Según la tradición católica, ella logró unir a las partes en conflicto (europeos e indígenas) 
                    para promover el amor de Dios en todo el continente americano.</p>
                <p>Madre Santísima, que con tu generoso “Fiat” desataste la Fuente de la
                    todas las gracias de nuestro mundo, intercede por nosotros que deseamos una fe cada vez mayor y
                    devoción a tu Divino Hijo para que cooperemos con su obra de Redención.</p>
                    Que el Señor Eucarístico encuentre siempre en nuestros corazones una morada acogedora como la encontró en los vuestros.
                    Sé nuestro refugio y compañero en nuestro peregrinar hacia la patria celestial.
                    donde contigo y todos los Santos gozamos de la comunión eterna con tu
                    Hijo que eres nuestra roca de refugio en todas las tormentas de la vida.
                    Amén.</p>
                <p>Promulgado el Jueves Santo de la Cena del Señor, 1 de abril de 2021.</p>
                <p>+Thomas J. Olmsted</p>
                <p>Obispo de Phoenix</p>
            </div>
        </div>
        
    </section>
 
    <script src="../assets/js/alumno.js"></script>

</body>
</html>