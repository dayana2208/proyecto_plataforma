<?php

    session_start();

    include '../config/conexion_be.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena = hash('sha512', $contrasena);

    //echo $contrasena;  129 caracteres
    //die();

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo='$correo' 
    and contrasena='$contrasena'");
   

if(mysqli_num_rows($validar_login) >0) //si encuentra una fila que coincida
{
    $row = mysqli_fetch_assoc ($validar_login);
    $_SESSION['usuario'] = $correo;
    $_SESSION['rol'] = $row['rol'];
    $_SESSION['id'] = $row['id'];

    //print_r($_SESSION); 
    //die();

    //Validación de roles
    if ($_SESSION['rol'] == 'Administrador'){
        header("location: ../vistas/menu.php");
    } else if ($_SESSION['rol'] == 'Maestro') {
        header("location: ../vistas/maestros.php");
    } else if ($_SESSION['rol'] == 'Alumno') {
        header("location: ../vistas/alumnos.php");
    } else {
        // Manejar roles desconocidos o no autorizados
        echo "Rol no válido.";
        exit;
    }
    
}else{
    $_SESSION['mensaje_error'] = "Usuario o contraseña incorrectos, verifique sus datos.";
    header("location: ../login.php");
    exit;
}
?>