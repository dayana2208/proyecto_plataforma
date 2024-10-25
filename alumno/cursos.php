<?php
// Incluir la conexión a la base de datos
include '../config/conexion_be.php';  // Asegúrate de que la ruta sea correcta

// Consulta para obtener los cursos
$query = "SELECT * FROM cursos WHERE estado = 'activo'";  // Asegúrate de que la columna 'estado' exista
$result = $conexion->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/estilo_alumnos.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Cursos</title>
</head>

<body>
    <header>
        <div class="header_container">
            <div class="logo_container">
                <img src="../assets/images/logo.png" alt="Logo" class="logo">
                <h1>PROYECTO GUADALUPE</h1>
            </div>

            <nav class="nav_links" id="navLinks">
                <a href="../vistas/alumnos.php">Home</a>
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
        <!-- Aquí puedes agregar el contenido de cursos -->
        <div class="text">CURSOS DISPONIBLES</div>
        <div class="courses_container">
            <?php if ($result->num_rows > 0): ?>
                <div class="cards_container"> <!-- Nueva clase para el contenedor de tarjetas -->
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="course_card"> <!-- Tarjeta de curso -->
                            <img src="<?php echo $row['portada']; ?>" alt="<?php echo $row['nombre']; ?>" class="course_image"> <!-- Imagen del curso -->
                            <h2 class="course_title"><?php echo $row['nombre']; ?></h2> <!-- Título del curso -->
                            <p class="course_description"><?php echo $row['descripcion']; ?></p> <!-- Descripción del curso -->
                            <a href="detalle_curso.php?id=<?php echo $row['id']; ?>" class="course_button">Ver Más</a> <!-- Botón -->
                        </div>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No hay cursos disponibles en este momento.</p>
            <?php endif; ?>
        </div>
    </section>
    
    <script src="../assets/js/alumno.js"></script>
</body>
</html>
