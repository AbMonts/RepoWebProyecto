document.addEventListener("DOMContentLoaded", function() {
    var alert = document.getElementById('alert');
    if (alert) {
        setTimeout(function() {
            alert.style.display = 'none';
        }, 5000); // Ocultar el mensaje después de 5 segundos
    }

    // Validación en tiempo real
    const tituloInput = document.getElementById('titulo');
    const contenidoTextarea = document.getElementById('contenido');
    const modificarTituloInput = document.getElementById('modificarTitulo');
    const modificarContenidoTextarea = document.getElementById('modificarContenido');

    function validarCampo(input, maxLength, minLength, spanId, mensajeError) {
        const value = input.value.trim();
        const mensajeSpan = document.getElementById(spanId);
        if (value.length < minLength || value.length > maxLength) {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
            mensajeSpan.textContent = mensajeError;
            mensajeSpan.style.color = 'red';
            return false;
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            mensajeSpan.textContent = '';
            return true;
        }
    }

    tituloInput.addEventListener('keyup', function() {
        validarCampo(tituloInput, 255, 4, 'tituloError', 'El título debe tener entre 4 y 255 caracteres.');
    });

    contenidoTextarea.addEventListener('keyup', function() {
        validarCampo(contenidoTextarea, 1000, 10, 'contenidoError', 'El contenido debe tener entre 10 y 1000 caracteres.');
    });

    modificarTituloInput.addEventListener('keyup', function() {
        validarCampo(modificarTituloInput, 255, 4, 'modificarTituloError', 'El título debe tener entre 4 y 255 caracteres.');
    });

    modificarContenidoTextarea.addEventListener('keyup', function() {
        validarCampo(modificarContenidoTextarea, 1000, 10, 'modificarContenidoError', 'El contenido debe tener entre 10 y 1000 caracteres.');
    });
});

function confirmarEliminarNota(id) {
    document.getElementById('eliminarNotaId').value = id;
    var confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
    confirmarEliminarModal.show();
}

function modificarNota(id, titulo, contenido) {
    document.getElementById('modificarNotaId').value = id;
    document.getElementById('modificarTitulo').value = titulo;
    document.getElementById('modificarContenido').value = contenido;
    var modificarNotaModal = new bootstrap.Modal(document.getElementById('modificarNotaModal'));
    modificarNotaModal.show();
}
