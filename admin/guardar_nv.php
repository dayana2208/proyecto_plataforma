<?php
// Incluir la conexión a la base de datos
include '../config/conexion_be.php';  // Asegúrate de que la ruta sea correcta

// Verificar si los datos han sido enviados mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos enviados desde el formulario
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : '';
    $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : '';
    $celular = isset($_POST['celular']) ? $_POST['celular'] : '';
    $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
    $rol = isset($_POST['rol']) ? $_POST['rol'] : '';
    $ciudad = isset($_POST['ciudad']) ? $_POST['ciudad'] : '';
    $membresia = isset($_POST['membresia']) ? $_POST['membresia'] : '';
    $parroquia = isset($_POST['parroquia']) ? $_POST['parroquia'] : '';

    // Definir la contraseña predeterminada (por ejemplo, "123456")
    $password_predeterminada = "123456";

    // Encriptar la contraseña utilizando password_hash() para seguridad
    $password_hash = hash('sha512', $password_predeterminada);


    // Validar que los campos requeridos no estén vacíos
    if (empty($nombres) || empty($apellidos) || empty($correo) || empty($rol) || empty($membresia)) {
        echo 'Por favor, completa todos los campos requeridos';
        exit();
    }

    // Preparar la consulta de inserción
    $sql = "INSERT INTO usuarios (nombres, apellidos, celular, correo, rol, ciudad, membresia, parroquia, contrasena)
            VALUES ('$nombres', '$apellidos', '$celular', '$correo', '$rol', '$ciudad', '$membresia', '$parroquia', '$password_hash')";

    // Ejecutar la consulta
    if ($conexion->query($sql) === TRUE) {
        // Devolver una respuesta exitosa
        echo 'Usuario agregado correctamente';
    } else {
        // En caso de error en la consulta
        echo 'Error: ' . $sql . '<br>' . $conexion->error;
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    // Si no se recibió una solicitud POST, redirigir a la página principal
    header('Location: ver_usuarios.php');
    exit();
}
?>
