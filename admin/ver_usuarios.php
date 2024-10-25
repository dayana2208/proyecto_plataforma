<?php
// Incluir la conexión a la base de datos
include '../config/conexion_be.php';  // Asegúrate de que la ruta sea correcta

require '../vistas/menu.php';

// Obtener el rol desde el formulario de filtro
$membresia = isset($_GET['membresia']) ? $_GET['membresia'] : '';

// Consulta SQL para obtener usuarios según el filtro de rol
$sql = "SELECT * FROM usuarios";
if (!empty($membresia)) {
    $sql .= " WHERE membresia = '$membresia'";
}

$result = $conexion->query($sql);
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

        <h2>LISTADO DE MIEMBROS Y USUARIOS</h2>

        <!-- Formulario de filtro -->
        <form method="GET" action="ver_usuarios.php">
            <label for="membresia">Filtrar por Membresía:</label>
            <select name="membresia" id="membresia">
                <option value="">Todos</option>
                <option value="Honorifico">Honorifico</option>
                <option value="Asociado">Asociado</option>
                <option value="Apostolico">Apostolico</option>
            </select>
            <input type="submit" value="Filtrar">

            <button type="button" class="bx bx-user-plus agregar-btn" title="Agregar usuario"></button>        
            
        </form>    

        <!-- Mostrar la tabla de usuarios -->
        <table id="tablaUsuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Ciudad</th>
                    <th>Membresía</th>
                    <th>Parroquia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tbodyUsuarios">
                <!-- Fila oculta para agregar un nuevo usuario -->
                <tr id="nuevaFilaUsuario" style="display: none;">
                    <td></td> <!-- El ID no se ingresa manualmente -->
                    <td><input type="text" id="nuevoNombres" placeholder="Nombres"></td>
                    <td><input type="text" id="nuevoApellidos" placeholder="Apellidos"></td>
                    <td><input type="text" id="nuevoCelular" placeholder="Celular"></td>
                    <td><input type="email" id="nuevoCorreo" placeholder="Correo"></td>
                    <td>
                        <select id="nuevoRol">
                            <option value="Alumno">Alumno</option>
                            <option value="Maestro">Maestro</option>
                            <option value="Administrador">Administrador</option>
                        </select>
                    </td>
                    <td><input type="text" id="nuevoCiudad" placeholder="Ciudad"></td>
                    <td>
                        <select id="nuevaMembresia">
                            <option value="Honorifico">Honorifico</option>
                            <option value="Asociado">Asociado</option>
                            <option value="Apostolico">Apostolico</option>
                        </select>
                    </td>
                    <td><input type="text" id="nuevaParroquia" placeholder="Parroquia"></td>
                    <td>
                        <button type="button" id="guardarNuevoUsuario">
                            <i class='bx bxs-save'></i>
                        </button>
                        <button type="button" id="cancelarNuevoUsuario">
                            <i class='bx bxs-x-circle'></i>
                        </button>

                    </td>
                </tr>

                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='ID'>" . $row['id'] . "</td>";
                        echo "<td data-label='Nombres' class='editable' data-id='" . $row['id'] . "'>" . $row['nombres'] . "</td>";
                        echo "<td data-label='Apellidos' class='editable' data-id='" . $row['id'] . "'>" . $row['apellidos'] . "</td>";                       
                        echo "<td data-label='Celular'class='editable' data-id='" . $row['id'] . "'>" . $row['celular'] . "</td>";
                        echo "<td data-label='Correo' class='editable' data-id='" . $row['id'] . "'>" . $row['correo'] . "</td>";
                        echo "<td data-label='Rol' class='editable' data-id='" . $row['id'] . "'>" . $row['rol'] . "</td>";
                        echo "<td data-label='Ciudad' class='editable' data-id='" . $row['id'] . "'>" . $row['ciudad'] . "</td>";
                        echo "<td data-label='Membresia' class='editable' data-id='" . $row['id'] . "'>" . $row['membresia'] . "</td>";
                        echo "<td data-label='Parroquia' class='editable' data-id='" . $row['id'] . "'>" . $row['parroquia'] . "</td>";
                        echo "<td data-label='Acciones'>
                                <a href='#' class='bx bxs-edit edit-btn' onclick='enableEdit(this)'>Editar</a>
                                <a href='#' class='bx bxs-trash delete-btn' onclick='deleteUser(this)'>Eliminar</a>
                            </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='11'>No se encontraron registros</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <script src="../assets/js/editar_eliminar_agregar.js"></script>
</body>
</html>
