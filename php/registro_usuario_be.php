<?php
session_start();

include '../config/conexion_be.php';

$nombres = $_POST['nombres']; /*metodo POS para obtener valores*/
$apellidos = $_POST['apellidos'];
$celular = $_POST['celular'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];

//CONTRASEÑA ENCRIPTADA
$contrasena = hash('sha512',$contrasena);

//VERIFICAR USUARIO UNICO
$verificar_correo = mysqli_query($conexion,"SELECT * FROM usuarios WHERE correo='$correo' ");

if (mysqli_num_rows($verificar_correo) > 0) {
    $_SESSION['mensaje_error'] = "Correo ya registrado.";
    header("location: ../login.php");
    exit();
}

$query = "INSERT INTO usuarios (nombres, apellidos, celular, correo, contrasena, rol) 
VALUES ('$nombres', '$apellidos', '$celular', '$correo', '$contrasena', '1')";
        
$ejecutar = mysqli_query($conexion, $query);  

if($ejecutar){
    $_SESSION['mensaje_exito'] = "Usuario registrado exitosamente";
    header("location: ../login.php");
}else{
    $_SESSION['mensaje_error'] = "Inténtalo nuevamente";
    header("location: ../login.php");
}

mysqli_close($conexion);
?>
