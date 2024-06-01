document.addEventListener('DOMContentLoaded', function () {
    const titulo = document.getElementById('titulo');
    const contenido = document.getElementById('contenido');
    const fechainicio = document.getElementById('fechainicio');
    const fechafin = document.getElementById('fechafin');
    const errorTitulo = document.getElementById('error-titulo');
    const errorContenido = document.getElementById('error-contenido');
    const errorFechafin = document.getElementById('error-fechafin');
    const errorFechainicio = document.getElementById('error-fechainicio');

    titulo.addEventListener('keyup', function () {
        if (titulo.value.length < 5) {
            errorTitulo.textContent = 'El título debe tener al menos 5 caracteres.';
        } else {
            errorTitulo.textContent = '';
        }
    });

    contenido.addEventListener('keyup', function () {
        if (contenido.value.trim() === '') {
            errorContenido.textContent = 'El contenido es obligatorio.';
        } else {
            errorContenido.textContent = '';
        }
    });

    fechainicio.addEventListener('input', function () {
        if (fechainicio.value === '') {
            errorFechainicio.textContent = 'La fecha de inicio es obligatoria.';
        } else {
            errorFechainicio.textContent = '';
        }
    });

    fechafin.addEventListener('input', function () {
        if (fechafin.value === '') {
            errorFechafin.textContent = 'La fecha de fin es obligatoria.';
        } else if (fechafin.value < fechainicio.value) {
            errorFechafin.textContent = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
        } else {
            errorFechafin.textContent = '';
        }
    });
});

function validarFormulario() {
    const titulo = document.getElementById('titulo').value;
    const contenido = document.getElementById('contenido').value;
    const fechainicio = document.getElementById('fechainicio').value;
    const fechafin = document.getElementById('fechafin').value;
    let isValid = true;

    if (titulo.length < 5) {
        document.getElementById('error-titulo').textContent = 'El título debe tener al menos 5 caracteres.';
        isValid = false;
    }

    if (contenido.trim() === '') {
        document.getElementById('error-contenido').textContent = 'El contenido es obligatorio.';
        isValid = false;
    }

    if (fechainicio === '') {
        document.getElementById('error-fechainicio').textContent = 'La fecha de inicio es obligatoria.';
        isValid = false;
    }

    if (fechafin === '') {
        document.getElementById('error-fechafin').textContent = 'La fecha de fin es obligatoria.';
        isValid = false;
    } else if (fechafin < fechainicio) {
        document.getElementById('error-fechafin').textContent = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
        isValid = false;
    }

    return isValid;
}
