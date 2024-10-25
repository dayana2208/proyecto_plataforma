<?php

session_start(); // Asegúrate de que la sesión esté iniciada
include '../config/conexion_be.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica que el usuario haya iniciado sesión y que el ID del creador esté disponible
    if (!isset($_SESSION['id'])) {
        echo "Error: No se pudo determinar el creador del curso.";
        exit();
    }

    // Obtener los datos del curso
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];
    $portada = $_POST['portada'];
    $id_creador = $_SESSION['id']; // Obtén el ID del creador de la sesión

    // Inserción del nuevo curso
    $sqlCurso = "INSERT INTO cursos (nombre, descripcion, estado, portada, id_creador) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sqlCurso);
    $stmt->bind_param("ssssi", $nombre, $descripcion, $estado, $portada, $id_creador);
    $stmt->execute();

    if ($stmt->affected_rows > 0) { // Verifica que se haya insertado correctamente
        $id_nuevo_curso = $stmt->insert_id; // Obtener el ID del nuevo curso

        // Obtener todos los maestros para asignarlos al nuevo curso
        $sqlMaestros = "SELECT id FROM usuarios WHERE rol = 'Maestro'";
        $resultMaestros = $conexion->query($sqlMaestros);
        
        while ($rowMaestro = $resultMaestros->fetch_assoc()) {
            $id_maestro = $rowMaestro['id'];
            // Asignar cada maestro al nuevo curso
            $sqlAsignarMaestro = "INSERT INTO cursos_maestros (id_curso, id_maestro) VALUES (?, ?)";
            $stmtAsignar = $conexion->prepare($sqlAsignarMaestro);
            $stmtAsignar->bind_param("ii", $id_nuevo_curso, $id_maestro);
            $stmtAsignar->execute();
        }

        // Redirigir o mostrar un mensaje de éxito
        header("Location: ver_cursos.php?mensaje=Curso creado y maestros asignados correctamente.");
        exit();
    } else {
        echo "Error: No se pudo guardar el curso.";
    }
}

?>
