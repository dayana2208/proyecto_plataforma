<?php
// Incluir la conexión a la base de datos
include '../config/conexion_be.php';  // Asegúrate de que la ruta sea correcta
require '../vistas/menu.php';

// Obtener el estado desde el formulario de filtro (si se aplica un filtro de estado)
$estado = isset($_GET['estado']) ? $_GET['estado'] : '';

// Consulta SQL para obtener cursos, maestro asignado y cantidad de alumnos
$sql = "SELECT c.id, c.nombre AS curso_nombre, c.descripcion, c.estado, c.portada, c.fecha_creacion, 
               GROUP_CONCAT(CONCAT(u.nombres, ' ', u.apellidos) SEPARATOR ', ') AS maestro_nombre, 
               (SELECT COUNT(*) FROM usuarios WHERE rol = 'Alumno') AS numero_alumnos, 
               CONCAT(u2.nombres, ' ', u2.apellidos) AS creador_nombre,
                (SELECT contenido FROM contenidos WHERE id_curso = c.id AND orden = 1) AS portada_contenido
        FROM cursos c
        LEFT JOIN cursos_maestros cm ON c.id = cm.id_curso
        LEFT JOIN usuarios u ON cm.id_maestro = u.id
        LEFT JOIN alumnos_cursos ac ON c.id = ac.id_curso
        LEFT JOIN usuarios u2 ON c.id_creador = u2.id";


// Aplicar el filtro de estado si está presente
if (!empty($estado)) {
    $estado = $conexion->real_escape_string($estado); // Escapa el valor para evitar inyecciones SQL
    $sql .= " WHERE c.estado = '$estado'";
}

$sql .= " GROUP BY c.id, c.nombre, c.descripcion, c.estado, c.portada, c.fecha_creacion, u2.id, u2.nombres, u2.apellidos";


$result = $conexion->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conexion->error);
}

// Obtener todos los maestros para asignarlos a un curso
$sqlMaestros = "SELECT id, CONCAT(nombres, ' ', apellidos) AS nombre FROM usuarios WHERE rol = 'Maestro'";
$resultMaestros = $conexion->query($sqlMaestros);
$maestros = [];
while ($rowMaestro = $resultMaestros->fetch_assoc()) {
    $maestros[] = $rowMaestro;
}

// Obtener contenidos de tipo imagen
$sqlImagenes = "SELECT id, contenido FROM contenidos WHERE tipo = 'imagen'";
$resultImagenes = $conexion->query($sqlImagenes);
$imagenes = [];
while ($rowImagen = $resultImagenes->fetch_assoc()) {
    $imagenes[] = $rowImagen;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>

    <link rel="stylesheet" href="../assets/css/estilo_ver_tabla.css"> <!-- Ajusta la ruta según tu estructura -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section class="home">
        <h2>LISTADO DE CURSOS</h2>

        <!-- Formulario de filtro -->
        <form method="GET" action="ver_cursos.php">
            <label for="estado">Filtrar por Estado:</label>
            <select name="estado" id="estado">
                <option value="">Todos</option>
                <option value="activo">Activo</option>
                <option value="bloqueado">Bloqueado</option>
            </select>
            <input type="submit" value="Filtrar">
            <button type="button" class="bx bxs-book agregar-btn" title="Agregar curso"></button>
        </form>    

        <!-- Mostrar la tabla de cursos -->
        <table id="tablaCursos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th>Portada</th>
                    <th>Fecha de Creacion</th>
                    <th>Maestros</th>
                    <th>N° Alumnos</th>
                    <th>Creador</th> <!-- Nueva columna para el nombre del creador -->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyCursos">
                <tr id="nuevaFilaCurso" style="display: none;">
                    <td></td> <!-- El ID no se ingresa manualmente -->
                    <td><input type="text" id="nuevoNombre" placeholder="Nombre"></td>
                    <td><input type="text" id="nuevaDescripcion" placeholder="Descripcion"></td>
                    <td>
                        <select id="nuevoEstado">
                            <option value="activo">Activo</option>
                            <option value="bloqueado">Bloqueado</option>
                        </select>
                    </td>
                    <td>
                        <select id="nuevaPortada">
                            <option value="">Seleccionar imagen</option>
                            <?php foreach ($imagenes as $imagen) { ?>
                                <option value="<?php echo $imagen['id']; ?>"><?php echo $imagen['contenido']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button type="button" id="guardarNuevoCurso">
                            <i class='bx bxs-save'></i>
                        </button>
                        <button type="button" id="cancelarNuevoCurso">
                            <i class='bx bxs-x-circle'></i>
                        </button>
                    </td>
                </tr>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='ID'>" . $row['id'] . "</td>";
                        echo "<td data-label='Nombre' class='editable' data-id='" . $row['id'] . "'>" . $row['curso_nombre'] . "</td>";
                        echo "<td data-label='Descripcion' class='editable' data-id='" . $row['id'] . "'>" . $row['descripcion'] . "</td>";
                        echo "<td data-label='Estado' class='editable' data-id='" . $row['id'] . "'>" . $row['estado'] . "</td>";
                        echo "<td data-label='Portada' class='editable' data-id='" . $row['id'] . "'>" . ($row['portada_contenido'] ? $row['portada_contenido'] : 'Sin imagen') . "</td>";
                        echo "<td data-label='Fecha de Creacion'>" . $row['fecha_creacion'] . "</td>";
                        echo "<td data-label='Maestro'>" . ($row['maestro_nombre'] ? $row['maestro_nombre'] : 'No asignado') . "</td>";
                        // Lógica para mostrar el número de alumnos según el estado del curso
                        if ($row['estado'] === 'activo') {
                            echo "<td data-label='N° Alumnos'>" . $row['numero_alumnos'] . "</td>";
                        } else {
                            echo "<td data-label='N° Alumnos'>Sin acceso</td>";
                        }
                        echo "<td data-label='Creador'>" . $row['creador_nombre'] . "</td>"; // Muestra el nombre del creador
                        echo "<td data-label='Acciones'>
                                <a href='#' class='bx bxs-edit edit-btn' onclick='enableEdit(this)'>Editar</a>
                                <a href='#' class='bx bxs-trash delete-btn' onclick='deleteCourse(this)'>Eliminar</a>
                                <a href='ver_contenidos.php?id_curso=" . $row['id'] . "' class='bx bx-detail mostrar-btn'>Mostrar</a>
                                </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No se encontraron registros</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <script src="../assets/js/edit_elim_ag_curso.js"></script>
</body>
</html>
