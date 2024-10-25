<?php
include '../config/conexion_be.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Verificar que se recibe el ID
    if (empty($id)) {
        echo "ID no proporcionado";
        exit;
    }

    $stmt = $conexion->prepare("DELETE FROM contenidos WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Contenido eliminado";
    } else {
        echo "Error al eliminar el contenido: " . $stmt->error;
    }

    $stmt->close();
}
$conexion->close();
?>
