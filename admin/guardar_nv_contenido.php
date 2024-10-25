<?php
// Incluir la conexión a la base de datos
include '../config/conexion_be.php';  // Asegúrate de que la ruta sea correcta

// Verificar si los datos han sido enviados mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos enviados desde el formulario
    $id_curso = isset($_POST['id_curso']) ? $_POST['id_curso'] : '';  // Capturar el ID del curso
    $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : '';
    $orden = isset($_POST['orden']) ? $_POST['orden'] : '';
    $contenido = isset($_POST['contenido']) ? $_POST['contenido'] : '';

    // Verificar si el número de orden ya existe para el curso
    $checkOrdenSql = "SELECT * FROM contenidos WHERE id_curso = '$id_curso' AND orden = '$orden'";
    $checkOrdenResult = $conexion->query($checkOrdenSql);

    if ($checkOrdenResult->num_rows > 0) {
        http_response_code(409); // Conflicto: el número de orden ya existe
        echo "El número de orden ya existe para este curso."; // Mensaje adicional opcional
        return;
    }

    if ($tipo == 'imagen' && isset($_FILES['nuevoImagen'])) {
        $imagen = $_FILES['nuevoImagen'];

        // Directorio donde se guardarán las imágenes
        $uploadDir = '../uploads/';
        $uploadFile = $uploadDir . basename($imagen['name']);

        // Verifica si el archivo es una imagen válida
        $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
        $validExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($imageFileType, $validExtensions)) {
            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($imagen['tmp_name'], $uploadFile)) {
                $contenido = $uploadFile; // Guarda la ruta de la imagen en el campo contenido
            } else {
                echo "Error al subir la imagen.";
                exit;
            }
        } else {
            echo "Tipo de archivo no permitido.";
            exit;
        }
    }

    // Inserción en la base de datos
    $sql = "INSERT INTO contenidos (id_curso, tipo, contenido, orden) VALUES ('$id_curso', '$tipo', '$contenido', '$orden')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: ver_contenidos.php?id_curso=" . $id_curso);
    } else {
        echo "Error al insertar el contenido: " . $conexion->error;
    }
}
?>