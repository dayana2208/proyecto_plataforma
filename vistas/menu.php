<?php

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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-------CSS---->
    <link rel="stylesheet" href="../assets/css/estilo_menu.css">

    <!--------BOX ICONS------->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>INICIO</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../assets/images/logo.png" alt="logo">
                </span>

                <div class="text header-text">
                    <span class="mision">Misioneros de María</span>
                    <span class="name">Proyecto Guadalupe</span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">
                    <!---<li class="search-box">
                        <i class='bx bx-search-alt-2 icon'></i>
                        <input type="text" placeholder="Search...">
                    </li>  --->  
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="#">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../admin/ver_usuarios.php">
                        <i class='bx bx-group icon'></i>
                        <span class="text nav-text">Miembros</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../admin/ver_cursos.php">
                        <i class='bx bx-book-bookmark icon'></i>
                        <span class="text nav-text">Cursos</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='bx bx-bell icon'></i>
                        <span class="text nav-text">Notificaciones</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='bx bx-pie-chart-alt icon'></i>
                        <span class="text nav-text">Estadisticas</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="#">
                        <i class='bx bx-bar-chart-alt-2 icon'></i>
                        <span class="text nav-text">Reportes</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="../php/cerrar_sesion.php">
                        <i class='bx bx-log-out icon'></i>
                        <span class="text nav-text">Log Out</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>

    <script src="../assets/js/script_inicio.js"></script>
</body>
</html>