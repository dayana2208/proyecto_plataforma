<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale-1.0">
    <title>Login y registro</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/estilo_login.css">
</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes cuenta?</h3>
                    <p>Inicia sesión para acceder</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>

                <div class="caja__trasera-registrar">
                    <h3>¿Aún no tienes cuenta?</h3>
                    <p>Registrate para acceder</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>
            </div>

            <div class="contenedor__login-register">
                <form action="php/login_usuario_be.php" method="POST" class="formulario__login">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Correo Electrónico" name="correo" required>
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button>Acceder</button>


                    <!-- Aquí se mostrará el mensaje de error -->

                    <?php
                    session_start();
                    if (isset($_SESSION['mensaje_error'])) {
                        echo '<p class="error">' . $_SESSION['mensaje_error'] . '</p>';
                        unset($_SESSION['mensaje_error']); // Limpiar el mensaje después de mostrarlo
                    }

                    // Aquí se mostrará el mensaje de éxito
                    if (isset($_SESSION['mensaje_exito'])) {
                        echo '<p class="exito">' . $_SESSION['mensaje_exito'] . '</p>';
                        unset($_SESSION['mensaje_exito']); // Limpiar el mensaje después de mostrarlo
                    }
                    ?>
                </form>

                <form action="php/registro_usuario_be.php" method="POST" class="formulario__register">
                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Nombres" name="nombres" required>
                    <input type="text" placeholder="Apellidos" name="apellidos" required>
                    <input type="text" placeholder="Celular" name="celular">
                    <input type="text" placeholder="Correo Electrónico" name="correo" required>
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button>Registrarse</button>
                </form>
            </div>
        </div>
    </main>
    <script src="assets/js/script.js"></script>
</body>
</html>