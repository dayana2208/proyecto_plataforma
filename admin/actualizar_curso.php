<?php
// Conectar a la base de datos
include '../config/conexion_be.php';

// Verificar que se han recibido los datos vía POST
if (isset($_POST['id'])) {
    $id = $_POST['id']; // ID del usuario

    // Crear una consulta de actualización dinámica para los campos enviados
    $updates = [];
    if (isset($_POST['nombre'])) {
        $updates[] = "nombre = '" . mysqli_real_escape_string($conexion, $_POST['nombre']) . "'";
    }
    if (isset($_POST['descripcion'])) {
        $updates[] = "descripcion = '" . mysqli_real_escape_string($conexion, $_POST['descripcion']) . "'";
    }
    if (isset($_POST['estado'])) {
        $updates[] = "estado = '" . mysqli_real_escape_string($conexion, $_POST['estado']) . "'";
    }
    if (isset($_POST['portada'])) {
        $updates[] = "portada = '" . mysqli_real_escape_string($conexion, $_POST['portada']) . "'";
    }

    // Si hay campos que actualizar, ejecuta la consulta
    if (!empty($updates)) {
        $query = "UPDATE cursos SET " . implode(", ", $updates) . " WHERE id = $id";
        if (mysqli_query($conexion, $query)) {
            echo "Registro actualizado exitosamente";
        } else {
            echo "Error al actualizar el registro: " . mysqli_error($conexion);
        }
    }
}
?>
