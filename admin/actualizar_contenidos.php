<?php
// Conectar a la base de datos
include '../config/conexion_be.php';

// Verificar que se han recibido los datos vía POST
if (isset($_POST['id'])) {
    $id = $_POST['id']; // ID del usuario

    // Crear una consulta de actualización dinámica para los campos enviados
    $updates = [];
    if (isset($_POST['tipo'])) {
        $updates[] = "tipo = '" . mysqli_real_escape_string($conexion, $_POST['tipo']) . "'";
    }
    if (isset($_POST['contenido'])) {
        $updates[] = "contenido = '" . mysqli_real_escape_string($conexion, $_POST['contenido']) . "'";
    }
    if (isset($_POST['orden'])) {
        $updates[] = "orden = '" . mysqli_real_escape_string($conexion, $_POST['orden']) . "'";
    }
    // Si hay campos que actualizar, ejecuta la consulta
    if (!empty($updates)) {
        $query = "UPDATE contenidos SET " . implode(", ", $updates) . " WHERE id = $id";
        if (mysqli_query($conexion, $query)) {
            echo "Contenido actualizado exitosamente";
        } else {
            echo "Error al actualizar el contenido: " . mysqli_error($conexion);
        }
    }
}
?>
