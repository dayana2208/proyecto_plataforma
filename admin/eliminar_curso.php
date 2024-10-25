<?php
include '../config/conexion_be.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Verificar que se recibe el ID
    if (empty($id)) {
        echo "ID no proporcionado";
        exit;
    }

    // Iniciar una transacción
    $conexion->begin_transaction();

    try {
        // Eliminar primero las relaciones con los maestros
        $stmtMaestros = $conexion->prepare("DELETE FROM cursos_maestros WHERE id_curso = ?");
        $stmtMaestros->bind_param("i", $id);
        $stmtMaestros->execute();
        $stmtMaestros->close();

        // Eliminar las relaciones con los alumnos
        $stmtAlumnos = $conexion->prepare("DELETE FROM alumnos_cursos WHERE id_curso = ?");
        $stmtAlumnos->bind_param("i", $id);
        $stmtAlumnos->execute();
        $stmtAlumnos->close();

        // Ahora eliminar el curso
        $stmtCurso = $conexion->prepare("DELETE FROM cursos WHERE id = ?");
        $stmtCurso->bind_param("i", $id);

        if ($stmtCurso->execute()) {
            echo "Curso eliminado";
        } else {
            echo "Error al eliminar el curso: " . $stmtCurso->error;
        }

        $stmtCurso->close();

        // Confirmar la transacción
        $conexion->commit();

    } catch (Exception $e) {
        // En caso de error, hacer rollback
        $conexion->rollback();
        echo "Error al eliminar el curso y sus dependencias: " . $e->getMessage();
    }
}

$conexion->close();
?>
