function showMessage(message) {
    var messageContainer = document.createElement('div'); // Cambiamos de 'span' a 'div' para facilitar el estilo
    messageContainer.textContent = message;
    messageContainer.classList.add('message-container');

    var closeButton = document.createElement('button');
    closeButton.textContent = 'X';
    closeButton.classList.add('close-button');
    closeButton.addEventListener('click', function() {
        messageContainer.remove();
    });

    messageContainer.appendChild(closeButton);

    document.body.appendChild(messageContainer);

    setTimeout(function() {
        messageContainer.remove();
    }, 3000); // Remover el mensaje después de 3 segundos
}




function modificarEvento(id, titulo, descripcion, fechainicio, fechafin) {
    const modificarEventoIdInput = document.getElementById('modificarEventoId');
    const modificarTituloInput = document.getElementById('modificarTitulo');
    const modificarDescripcionInput = document.getElementById('modificarDescripcion');
    const modificarFechaInicioInput = document.getElementById('modificarFechaInicio');
    const modificarFechaFinInput = document.getElementById('modificarFechaFin');
    const idUsuarioInput = document.getElementById('idUsuario');

    modificarEventoIdInput.value = id;
    modificarTituloInput.value = titulo;
    modificarDescripcionInput.value = descripcion;
    modificarFechaInicioInput.value = fechainicio;
    modificarFechaFinInput.value = fechafin;
    idUsuarioInput.value = "<?php echo $idUsuario; ?>";

    const modificarEventoModal = new bootstrap.Modal(document.getElementById('editModal'));
    modificarEventoModal.show();
}

document.querySelectorAll('.list-group-item').forEach(item => {
    item.addEventListener('click', event => {
        const id = item.getAttribute('data-id');
        const titulo = item.getAttribute('data-titulo');
        const descripcion = item.getAttribute('data-descripcion');
        const fechainicio = item.getAttribute('data-fechainicio');
        const fechafin = item.getAttribute('data-fechafin');
        modificarEvento(id, titulo, descripcion, fechainicio, fechafin);
    });
});

function confirmarEliminar() {
    const modificarEventoIdInput = document.getElementById('modificarEventoId').value;
    const eliminarEventoIdInput = document.getElementById('eliminarEventoId');
    eliminarEventoIdInput.value = modificarEventoIdInput;

    const confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
    confirmarEliminarModal.show();
}

function cerrarModal(modalId) {
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.hide();
}

document.getElementById('formEliminarEvento').addEventListener('submit', function(event) {
    event.preventDefault();
    cerrarModal('editModal');
    cerrarModal('confirmarEliminarModal');
    showMessage('Evento eliminado con éxito');
    this.submit();
});

function validarAgregarEvento() {
    const titulo = document.getElementById('titulo').value.trim();
    const descripcion = document.getElementById('descripcion').value.trim();
    const fechainicio = new Date(document.getElementById('fechainicio').value);
    const fechafin = new Date(document.getElementById('fechafin').value);
    const fechaActual = new Date();

    if (!titulo || !descripcion || !fechainicio || !fechafin) {
        showMessage('Todos los campos son obligatorios');
        return false;
    }

    if (titulo.length < 3 || titulo.length > 100) {
        showMessage('El título debe tener entre 3 y 100 caracteres');
        return false;
    }

    if (descripcion.length < 10 || descripcion.length > 500) {
        showMessage('La descripción debe tener entre 10 y 500 caracteres');
        return false;
    }

    if (fechainicio.getTime() >= fechafin.getTime() || fechainicio.getTime() < fechaActual.getTime()) {
        showMessage('La fecha de inicio debe ser anterior a la fecha de fin y posterior a la fecha actual');
        return false;
    }

    showMessage('Evento agregado con éxito');
    return true;
}

function validarModificarEvento() {
    const titulo = document.getElementById('modificarTitulo').value.trim();
    const descripcion = document.getElementById('modificarDescripcion').value.trim();
    const fechainicio = new Date(document.getElementById('modificarFechaInicio').value);
    const fechafin = new Date(document.getElementById('modificarFechaFin').value);

    if (!titulo || !descripcion || !fechainicio || !fechafin) {
        showMessage('Todos los campos son obligatorios');
        return false;
    }

    if (titulo.length < 3 || titulo.length > 100) {
        showMessage('El título debe tener entre 3 y 100 caracteres');
        return false;
    }

    if (descripcion.length < 10 || descripcion.length > 500) {
        showMessage('La descripción debe tener entre 10 y 500 caracteres');
        return false;
    }

    if (fechainicio.getTime() >= fechafin.getTime()) {
        showMessage('La fecha de inicio debe ser anterior a la fecha de fin');
        return false;
    }

    showMessage('Evento modificado con éxito');
    return true;
}


// Función para validar formularios de eventos
function validarFormulario(form) {
    var isValid = true;

    form.querySelectorAll('input, textarea').forEach(function(input) {
        var errorElement = document.getElementById(input.id + 'Error');

        if (input.id.includes('titulo') || input.id.includes('modificarTitulo')) {
            if (input.value.trim().length <= 3) {
                isValid = false;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                errorElement.textContent = 'El título debe tener más de 3 caracteres.';
                errorElement.style.display = 'block';
            } else {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        }

        if (input.id.includes('descripcion') || input.id.includes('modificarDescripcion')) {
            if (input.value.trim().length <= 3) {
                isValid = false;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                errorElement.textContent = 'La descripción debe tener más de 3 caracteres.';
                errorElement.style.display = 'block';
            } else {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        }

        if (input.id.includes('fechainicio') || input.id.includes('modificarFechaInicio')) {
            if (input.value.trim() === '') {
                isValid = false;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                errorElement.textContent = 'La fecha de inicio es obligatoria.';
                errorElement.style.display = 'block';
            } else {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        }

        if (input.id.includes('fechafin') || input.id.includes('modificarFechaFin')) {
            if (input.value.trim() === '') {
                isValid = false;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                errorElement.textContent = 'La fecha de fin es obligatoria.';
                errorElement.style.display = 'block';
            } else {
                input.classList.add('is-valid');
                input.classList.remove('is-invalid');
                errorElement.style.display = 'none';
            }
        }
    });

    // Validar que la fecha de fin sea mayor o igual a la fecha de inicio
    var fechainicio = form.querySelector('#fechainicio') ? form.querySelector('#fechainicio').value : form.querySelector('#modificarFechaInicio').value;
    var fechafin = form.querySelector('#fechafin') ? form.querySelector('#fechafin').value : form.querySelector('#modificarFechaFin').value;

    if (new Date(fechainicio) > new Date(fechafin)) {
        var fechaFinInput = form.querySelector('#fechafin') ? form.querySelector('#fechafin') : form.querySelector('#modificarFechaFin');
        var fechaFinError = document.getElementById(fechaFinInput.id + 'Error');
        fechaFinInput.classList.add('is-invalid');
        fechaFinInput.classList.remove('is-valid');
        fechaFinError.textContent = 'La fecha de fin debe ser mayor o igual a la fecha de inicio.';
        fechaFinError.style.display = 'block';
        isValid = false;
    }

    return isValid;
}

// Validar formulario de agregar evento
document.getElementById('formAgregarEvento').addEventListener('submit', function(event) {
    if (!validarFormulario(this)) {
        event.preventDefault();
        event.stopPropagation();
    }
});

// Validar formulario de modificar evento
document.getElementById('formModificarEvento').addEventListener('submit', function(event) {
    if (!validarFormulario(this)) {
        event.preventDefault();
        event.stopPropagation();
    }
});

// Función para mostrar el modal de confirmación de eliminación
function confirmarEliminar() {
    var eliminarEventoIdInput = document.getElementById('eliminarEventoId');
    var modificarEventoIdInput = document.getElementById('modificarEventoId').value;
    eliminarEventoIdInput.value = modificarEventoIdInput;
    var confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
    confirmarEliminarModal.show();
}

// Función para mostrar el modal de modificación con datos precargados
function modificarEvento(id, titulo, descripcion, fechainicio, fechafin) {
    document.getElementById('modificarEventoId').value = id;
    document.getElementById('modificarTitulo').value = titulo;
    document.getElementById('modificarDescripcion').value = descripcion;
    document.getElementById('modificarFechaInicio').value = fechainicio;
    document.getElementById('modificarFechaFin').value = fechafin;
    var modificarModal = new bootstrap.Modal(document.getElementById('editModal'));
    modificarModal.show();
}

document.querySelectorAll('.list-group-item').forEach(function(item) {
    item.addEventListener('click', function() {
        var id = item.getAttribute('data-id');
        var titulo = item.getAttribute('data-titulo');
        var descripcion = item.getAttribute('data-descripcion');
        var fechainicio = item.getAttribute('data-fechainicio');
        var fechafin = item.getAttribute('data-fechafin');
        modificarEvento(id, titulo, descripcion, fechainicio, fechafin);
    });
});

// Función para cerrar un modal
function cerrarModal(modalId) {
    var modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.hide();
}

document.getElementById('formEliminarEvento').addEventListener('submit', function(event) {
    cerrarModal('editModal');
    cerrarModal('confirmarEliminarModal');
});

