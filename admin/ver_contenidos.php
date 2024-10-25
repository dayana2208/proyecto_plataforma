<?php
// Incluir la conexión a la base de datos
include '../config/conexion_be.php';  // Asegúrate de que la ruta sea correcta

require '../vistas/menu.php';

// Verificar si se ha pasado un id_curso por GET
if (isset($_GET['id_curso'])) {
    $id_curso = $_GET['id_curso'];

    // Consulta SQL para obtener los contenidos del curso específico
    $sql = "SELECT * FROM contenidos WHERE id_curso = $id_curso";
    $result = $conexion->query($sql);
} else {
    echo "No se ha especificado un curso.";
    exit; // Salir si no se especifica un curso
}

// Obtener el nombre del curso (opcional)
$curso_sql = "SELECT nombre FROM cursos WHERE id = $id_curso";
$curso_result = $conexion->query($curso_sql);
$curso_nombre = ($curso_result->num_rows > 0) ? $curso_result->fetch_assoc()['nombre'] : 'Curso Desconocido';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <link rel="stylesheet" href="../assets/css/estilo_ver_tabla.css"> <!-- Ajusta la ruta según tu estructura -->

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <section class="home">

        <h2>CONTENIDOS DEL CURSO: <?php echo $curso_nombre; ?></h2>
        <form>
            <button type="button" class="bx bx-book-content agregar-btn" title="Agregar contenido"></button>        
        </form>

        <!-- Mostrar la tabla de usuarios -->
        <table id="tablaContenidos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Contenido</th>
                    <th>Orden</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyContenidos">
                <!-- Fila oculta para agregar un nuevo usuario -->
                <tr id="nuevaFilaContenido" style="display: none;">
                    <td></td> <!-- El ID no se ingresa manualmente -->
                    <input type="hidden" id="id_curso" value="<?php echo $id_curso; ?>">
                    <td>
                        <select id="nuevoTipo" onchange="toggleImageUpload()">
                            <option value="texto">Texto</option>
                            <option value="video">Video</option>
                            <option value="archivo">Archivo</option>
                            <option value="enlace">Enlace</option>
                            <option value="imagen">Imagen</option> <!-- Nueva opción para imagen -->
                        </select>
                    </td>
                    <td>
                        <input type="text" id="nuevoContenido" placeholder="Contenido">
                        <input type="file" id="nuevoImagen" accept="image/*" style="display:none;"> <!-- Campo para subir imagen -->
                    </td>
                    <td><input type="number" id="nuevoOrden" placeholder="Orden"></td>
                    <td>
                        <button type="button" id="guardarNuevoContenido">
                            <i class='bx bxs-save'></i>
                        </button>
                        <button type="button" id="cancelarNuevoContenido">
                            <i class='bx bxs-x-circle'></i>
                        </button>

                    </td>
                </tr>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='ID'>" . $row['id'] . "</td>";
                        echo "<td data-label='Tipo' class='editable' data-id='" . $row['id'] . "'>" . $row['tipo'] . "</td>";                       
                        echo "<td data-label='Contenido'class='editable' data-id='" . $row['id'] . "'>" . $row['contenido'] . "</td>";
                        echo "<td data-label='Orden' class='editable' data-id='" . $row['id'] . "'>" . $row['orden'] . "</td>";
                        echo "<td data-label='Acciones'>
                                <a href='#' class='bx bxs-edit edit-btn' onclick='enableEdit(this)'>Editar</a>
                                <a href='#' class='bx bxs-trash delete-btn' onclick='deleteContent(this)'>Eliminar</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No se encontraron registros</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <a href='ver_cursos.php' class='bx bx-arrow-back'>Regresar</a>
    </section>

    <script src="../assets/js/contenidos.js"></script>
</body>
</html>
