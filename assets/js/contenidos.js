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
        if (field === 'tipo') {
            const currentTipo = cell.innerText; // Guardar el valor actual
            const select = document.createElement('select');
            select.className = 'tipo-select';
            select.innerHTML = `
                <option value="texto">Texto</option>
                <option value="video">Video</option>
                <option value="archivo">Archivo</option>
                <option value="enlace">Enlace</option>
                <option value="imagen">Imagen</option>
            `;
            select.value = currentTipo; // Establecer el valor actual en el select
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
        if (field === 'tipo') {
            const select = cell.querySelector('select');
            updatedData[field] = select.value; // Obtener el valor seleccionado
            cell.innerHTML = select.value; // Después de guardar, mostrar el valor de membresía como texto
            cell.style.backgroundColor = ''; // Restaurar color original
        } else {
            var value = cell.innerText; // Obtenemos el valor nuevo de la celda
            updatedData[field] = value; // Lo almacenamos en el objeto
            cell.removeAttribute('contenteditable'); // Deshabilitar la edición después de guardar
            cell.style.backgroundColor = ''; // Restaurar color original
        }
    });

    // Enviar los datos actualizados al servidor mediante AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../admin/actualizar_contenidos.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Convertimos los datos en formato adecuado para el envío
    var params = "id=" + userId + "&" + Object.keys(updatedData).map(key => key + "=" + encodeURIComponent(updatedData[key])).join("&");

    // Enviar la solicitud
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log("Contenido actualizado exitosamente.");
        }
    };
    xhr.send(params);

    // Cambiar el botón "Guardar" nuevamente a "Editar"
    editBtn.innerHTML = "Editar";
    editBtn.onclick = function() { enableEdit(editBtn); }; // Restaurar la función de edición
}


function deleteContent(deleteBtn) {
    var row = deleteBtn.closest('tr'); // Encuentra la fila donde se hizo clic
    var courseId = row.querySelector('[data-label="ID"]').innerText;
    // Confirmar la acción de eliminación
    if (confirm("¿Estás seguro de que deseas eliminar este curso?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin/eliminar_contenido.php", true);
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
    document.getElementById('nuevaFilaContenido').style.display = 'table-row';
});

document.getElementById('cancelarNuevoContenido').addEventListener('click', function() {
    document.getElementById('nuevaFilaContenido').style.display = 'none';
});

/*document.getElementById('guardarNuevoContenido').addEventListener('click', function() {
    // Captura los valores de los campos de la nueva fila
    var id_curso = document.getElementById('id_curso').value; // Capturar el ID del curso
    var tipo = document.getElementById('nuevoTipo').value;
    var contenido = document.getElementById('nuevoContenido').value;
    var orden = document.getElementById('nuevoOrden').value;


    // Aquí podrías agregar la lógica para enviar estos datos a tu backend (PHP) para insertarlos en la base de datos
    // Ejemplo de una posible implementación AJAX (a añadir en tu archivo JavaScript principal)
    
    // Si el tipo es imagen, se agrega el archivo
    var archivoImagen = document.getElementById('nuevoImagen').files[0];
    if (tipo === 'imagen' && archivoImagen) {
        formData.append('imagen', archivoImagen);
    } else if (tipo === 'imagen' && !archivoImagen) {
        alert('Por favor, selecciona una imagen para subir.');
        return; // Salir si se seleccionó 'imagen' pero no se subió nada
    }
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../admin/guardar_nv_contenido.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Contenido agregado exitosamente');
            location.reload();  // Recargar la página para mostrar el nuevo usuario
        } else {
            alert('Error al agregar contenido');
        }
    };
    xhr.send('id_curso=' + id_curso + '&tipo=' + tipo + '&contenido=' + contenido + '&orden=' + orden);
    
});*/

// Función para alternar entre el campo de texto y el de imagen
function toggleImageUpload() {
    var tipo = document.getElementById('nuevoTipo').value;
    var imageUpload = document.getElementById('nuevoImagen');
    var contenidoInput = document.getElementById('nuevoContenido');
    
    if (tipo === 'imagen') {
        imageUpload.style.display = 'block';   // Mostrar el input para imágenes
        contenidoInput.style.display = 'none'; // Ocultar el input de texto
    } else {
        imageUpload.style.display = 'none';    // Ocultar el input para imágenes
        contenidoInput.style.display = 'block'; // Mostrar el input de texto
    }
}

// Captura del evento de guardar el nuevo contenido
document.getElementById('guardarNuevoContenido').addEventListener('click', function() {
    var id_curso = document.getElementById('id_curso').value;
    var nuevoTipo = document.getElementById('nuevoTipo').value;
    var nuevoContenido = document.getElementById('nuevoContenido').value;
    var nuevoOrden = document.getElementById('nuevoOrden').value;
    var nuevoImagen = document.getElementById('nuevoImagen').files[0]; // Obtener archivo de imagen si lo hay

    var formData = new FormData(); // Crear FormData para enviar imagen y otros datos
    formData.append('id_curso', id_curso);
    formData.append('tipo', nuevoTipo);
    formData.append('orden', nuevoOrden);

    // Solo agregar imagen si el tipo es 'imagen'
    if (nuevoTipo === 'imagen' && nuevoImagen) {
        formData.append('nuevoImagen', nuevoImagen); // Añadir imagen
    } else {
        formData.append('contenido', nuevoContenido); // Añadir contenido textual
    }

    // Enviar los datos con AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "guardar_nv_contenido.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) { // Cuando la solicitud se ha completado
            if (xhr.status === 200) { // La solicitud fue exitosa
                alert('Contenido agregado exitosamente');
                window.location.reload(); // Refrescar la página al completar
            } else {
                // Aquí manejas la situación de error
                if (xhr.status === 409) { // Estado específico para conflicto
                    alert('El número de orden ya existe para este curso.'); // Mostrar el mensaje de error
                    window.location.reload();
                } else {
                    alert('Error: ' + xhr.status); // Mostrar cualquier otro error
                }
            }
        }
    };
    xhr.send(formData); // Enviar FormData con la imagen o contenido
});

