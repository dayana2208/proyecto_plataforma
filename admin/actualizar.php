<?php
// Conectar a la base de datos
include '../config/conexion_be.php';

// Verificar que se han recibido los datos vía POST
if (isset($_POST['id'])) {
    $id = $_POST['id']; // ID del usuario

    // Crear una consulta de actualización dinámica para los campos enviados
    $updates = [];
    if (isset($_POST['nombres'])) {
        $updates[] = "nombres = '" . mysqli_real_escape_string($conexion, $_POST['nombres']) . "'";
    }
    if (isset($_POST['apellidos'])) {
        $updates[] = "apellidos = '" . mysqli_real_escape_string($conexion, $_POST['apellidos']) . "'";
    }
    if (isset($_POST['celular'])) {
        $updates[] = "celular = '" . mysqli_real_escape_string($conexion, $_POST['celular']) . "'";
    }
    if (isset($_POST['correo'])) {
        $updates[] = "correo = '" . mysqli_real_escape_string($conexion, $_POST['correo']) . "'";
    }
    if (isset($_POST['rol'])) {
        $updates[] = "rol = '" . mysqli_real_escape_string($conexion, $_POST['rol']) . "'";
    }
    if (isset($_POST['ciudad'])) {
        $ciudad = mysqli_real_escape_string($conexion, $_POST['ciudad']);
        $updates[] = "ciudad = '$ciudad'";
    }
    if (isset($_POST['membresia'])) {
        $membresia = mysqli_real_escape_string($conexion, $_POST['membresia']);
        $updates[] = "membresia = '$membresia'";
    }
    if (isset($_POST['parroquia'])) {
        $parroquia = mysqli_real_escape_string($conexion, $_POST['parroquia']);
        $updates[] = "parroquia = '$parroquia'";
    }

    // Si hay campos que actualizar, ejecuta la consulta
    if (!empty($updates)) {
        $query = "UPDATE usuarios SET " . implode(", ", $updates) . " WHERE id = $id";
        if (mysqli_query($conexion, $query)) {
            echo "Registro actualizado exitosamente";
        } else {
            echo "Error al actualizar el registro: " . mysqli_error($conexion);
        }
    }
}
?>
