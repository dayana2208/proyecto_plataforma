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
        if (field === 'membresia') {
            const currentMembresia = cell.innerText; // Guardar el valor actual
            const select = document.createElement('select');
            select.className = 'membresia-select';
            select.innerHTML = `
                <option value='Honorifico'>Honorifico</option>
                <option value='Asociado'>Asociado</option>
                <option value='Apostolico'>Apostolico</option>
            `;
            select.value = currentMembresia; // Establecer el valor actual en el select
            cell.innerHTML = ''; // Limpiar la celda temporalmente
            cell.appendChild(select); // Añadir el select al DOM
            cell.style.backgroundColor = '#fff3cd';
        } else if (field === 'rol') {
            const currentRol = cell.innerText; // Guardar el valor actual
            const select = document.createElement('select');
            select.className = 'rol-select';
            select.innerHTML = `
                <option value='Alumno'>Alumno</option>
                <option value='Maestro'>Maestro</option>
                <option value='Administrador'>Administrador</option>
            `;
            select.value = currentRol; // Establecer el valor actual en el select
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
        if (field === 'membresia') {
            const select = cell.querySelector('select');
            updatedData[field] = select.value; // Obtener el valor seleccionado
            cell.innerHTML = select.value; // Después de guardar, mostrar el valor de membresía como texto
            cell.style.backgroundColor = ''; // Restaurar color original
        } else if (field === 'rol') {
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
    xhr.open("POST", "../admin/actualizar.php", true);
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


function deleteUser(deleteBtn) {
    var row = deleteBtn.closest('tr'); // Encuentra la fila donde se hizo clic
    var userId = row.querySelector('[data-label="ID"]').innerText;
    // Confirmar la acción de eliminación
    if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "../admin/eliminar.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        var params = "id=" + userId; // Prepara los parámetros para enviar

        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    console.log("Usuario eliminado exitosamente.");
                    row.parentNode.removeChild(row); // Remover la fila de la tabla
                } else {
                    console.error("Error al eliminar el usuario: " + xhr.statusText);
                }
            }
        };
        xhr.send(params);
    }
}



document.querySelector('.agregar-btn').addEventListener('click', function() {
    document.getElementById('nuevaFilaUsuario').style.display = 'table-row';
});

document.getElementById('cancelarNuevoUsuario').addEventListener('click', function() {
    document.getElementById('nuevaFilaUsuario').style.display = 'none';
});

document.getElementById('guardarNuevoUsuario').addEventListener('click', function() {
    // Captura los valores de los campos de la nueva fila
    var nombres = document.getElementById('nuevoNombres').value;
    var apellidos = document.getElementById('nuevoApellidos').value;
    var celular = document.getElementById('nuevoCelular').value;
    var correo = document.getElementById('nuevoCorreo').value;
    var rol = document.getElementById('nuevoRol').value;
    var ciudad = document.getElementById('nuevoCiudad').value;
    var membresia = document.getElementById('nuevaMembresia').value;
    var parroquia = document.getElementById('nuevaParroquia').value;

    // Aquí podrías agregar la lógica para enviar estos datos a tu backend (PHP) para insertarlos en la base de datos
    // Ejemplo de una posible implementación AJAX (a añadir en tu archivo JavaScript principal)
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '../admin/guardar_nv.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert('Usuario agregado exitosamente');
            location.reload();  // Recargar la página para mostrar el nuevo usuario
        } else {
            alert('Error al agregar usuario');
        }
    };
    xhr.send('nombres=' + nombres + '&apellidos=' + apellidos + '&celular=' + celular + '&correo=' + correo + '&rol=' + rol + '&ciudad=' + ciudad + '&membresia=' + membresia + '&parroquia=' + parroquia);
    
});