// Función para habilitar la edición solo en la fila seleccionada
function enableEdit(editBtn) {
    // Encontrar la fila en la que se hizo clic
    var row = editBtn.closest('tr');
    
    // Buscar todas las celdas con la clase 'editable' dentro de esta fila
    var cells = row.querySelectorAll('.editable');

    // Hacer que cada celda editable sea editable (contenteditable=true)
    cells.forEach(function(cell) {
        var field = cell.getAttribute('data-label').toLowerCase(); // Obtenemos el nombre del campo
        
        // Si es la celda de membresía, convertirla en un menú desplegable
        if (field === 'estado') {
            const currentEstado = cell.innerText; // Guardar el valor actual
            const select = document.createElement('select');
            select.className = 'estado-select';
            select.innerHTML = `
                <option value='activo'>Activo</option>
                <option value='bloqueado'>Bloqueado</option>
            `;
            select.value = currentEstado; // Establecer el valor actual en el select
            cell.innerHTML = ''; // Limpiar la celda temporalmente
            cell.appendChild(select); // Añadir el select al DOM
            cell.style.backgroundColor = '#fff3cd';
        } else {
            // Para otros campos, hacerlos editables
            cell.setAttribute('contenteditable', 'true');
            cell.style.backgroundColor = '#fff3cd'; // Cambiar el fondo para indicar que está en modo edición
        }
    });

    // Cambiar el botón "Editar" a "Guardar"
    editBtn.innerHTML = "Guardar";
    editBtn.onclick = function() { saveChanges(editBtn); }; // Asignar nueva función para guardar
}

// Función para guardar los cambios realizados
function saveChanges(editBtn) {
    // Encontrar la fila en la que se hizo clic en "Guardar"
    var row = editBtn.closest('tr');
    
    // Buscar todas las celdas editables
    var cells = row.querySelectorAll('.editable');

    // Obtener el ID del usuario desde la primera celda editable
    var userId = cells[0].getAttribute('data-id');

    // Preparar los datos a enviar (campo y valor)
    var updatedData = {};
    cells.forEach(function(cell) {
        var field = cell.getAttribute('data-label').toLowerCase(); // Obtenemos el nombre del campo (nombre, email, etc.)

        // Si es la celda de membresía, obtener el valor del select
        if (field === 'estado') {
            const select = cell.querySelector('select');
            updatedData[field] = select.value; // Obtener el valor seleccionado
            cell.innerHTML = select.value; // Después de guardar, mostrar el valor de membresía como texto
            cell.style.backgroundColor = ''; // Restaurar color original
            // Aquí se selecciona la celda del número de alumnos
            numeroAlumnosTd = row.querySelector('[data-label="N° Alumnos"]');
            if (select.value === 'bloqueado') {
                numeroAlumnosTd.textContent = 'Sin acceso'; // Cambia el texto
            } else {
                // Aquí podrías obtener el número real de alumnos si tienes la lógica para ello
                const numeroAlumnos = row.getAttribute('data-numero-alumnos'); // Guarda el número en un atributo de la fila
                numeroAlumnosTd.textContent = numeroAlumnos; // Restaura el número de alumnos
                numeroAlumnosTd.style.color = ''; // Resetea el color
                location.reload();
            }
        } else {
            var value = cell.innerText; // Obtenemos el valor nuevo de la celda
            updatedData[field] = value; // Lo almacenamos en el objeto
            cell.removeAttribute('contenteditable'); // Deshabilitar la edición después de guardar
            cell.style.backgroundColor = ''; // Restaurar color original
        }
    });

    // Enviar los datos actualizados al servidor mediante AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../admin/actualizar_curso.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Convertimos los datos en formato adecuado para el envío
    var params = "id=" + userId + "&" + Object.keys(updatedData).map(key => key + "=" + encodeURIComponent(updatedData[key])).join("&");

    // Enviar la solicitud
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log("Registro actualizado exitosamente.");
        }
    };
    xhr.send(params);

    // Cambiar el botón "Guardar" nuevamente a "Editar"
    editBtn.innerHTML = "Editar";
    editBtn.onclick = function() { enableEdit(editBtn); }; // Restaurar la función de edición
}

function deleteCourse(deleteBtn) {
    var row = deleteBtn.closest('tr'); // Encuentra la fila donde se hizo clic
    var courseId = row.querySelector('[data-label="ID"]').innerText;
    // Confirmar la acción de eliminación
    if (confirm("¿Estás seguro de que deseas eliminar este curso?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin/eliminar_curso.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var params = "id=" + courseId; // Prepara los parámetros para enviar

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    console.log("Curso eliminado exitosamente.", xhr.responseText);
                    row.parentNode.removeChild(row); // Remover la fila de la tabla
                } else {
                    console.error("Error al eliminar el curso: " + xhr.statusText);
                }
            }
        };
        xhr.send(params);
    }
}

document.querySelector('.agregar-btn').addEventListener('click', function() {
    document.getElementById('nuevaFilaCurso').style.display = 'table-row';
});

document.getElementById('cancelarNuevoCurso').addEventListener('click', function() {
    document.getElementById('nuevaFilaCurso').style.display = 'none';
});

document.getElementById('guardarNuevoCurso').addEventListener('click', function() {
    // Captura los valores de los campos de la nueva fila
    var nombre = document.getElementById('nuevoNombre').value;
    var descripcion = document.getElementById('nuevaDescripcion').value;
    var estado = document.getElementById('nuevoEstado').value;
    var portada = document.getElementById('nuevaPortada').value;

    // Aquí podrías agregar la lógica para enviar estos datos a tu backend (PHP) para insertarlos en la base de datos
    // Ejemplo de una posible implementación AJAX (a añadir en tu archivo JavaScript principal)
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../admin/guardar_nv_curso.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Curso agregado exitosamente');
            location.reload();  // Recargar la página para mostrar el nuevo usuario
        } else {
            alert('Error al agregar curso');
        }
    };
    xhr.send('nombre=' + nombre + '&descripcion=' + descripcion + '&estado=' + estado + '&portada=' + portada);
    
});



