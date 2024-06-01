document.addEventListener('DOMContentLoaded', function () {
    const titulo = document.getElementById('titulo');
    const contenido = document.getElementById('contenido');
    const fechainicio = document.getElementById('fechainicio');
    const fechafin = document.getElementById('fechafin');
    const errorTitulo = document.getElementById('error-titulo');
    const errorContenido = document.getElementById('error-contenido');
    const errorFechafin = document.getElementById('error-fechafin');
    const errorFechainicio = document.getElementById('error-fechainicio');

    titulo.addEventListener('input', function () {
        if (titulo.value.length < 5) {
            titulo.classList.add('is-invalid');
            titulo.classList.remove('is-valid');
            errorTitulo.textContent = 'El título debe tener al menos 5 caracteres.';
        } else {
            titulo.classList.remove('is-invalid');
            titulo.classList.add('is-valid');
            errorTitulo.textContent = '';
        }
    });

    contenido.addEventListener('input', function () {
        if (contenido.value.trim() === '') {
            contenido.classList.add('is-invalid');
            contenido.classList.remove('is-valid');
            errorContenido.textContent = 'El contenido es obligatorio.';
        } else {
            contenido.classList.remove('is-invalid');
            contenido.classList.add('is-valid');
            errorContenido.textContent = '';
        }
    });

    fechainicio.addEventListener('input', function () {
        if (fechainicio.value === '') {
            fechainicio.classList.add('is-invalid');
            fechainicio.classList.remove('is-valid');
            errorFechainicio.textContent = 'La fecha de inicio es obligatoria.';
        } else {
            fechainicio.classList.remove('is-invalid');
            fechainicio.classList.add('is-valid');
            errorFechainicio.textContent = '';
        }
        validarFechas();
    });

    fechafin.addEventListener('input', function () {
        if (fechafin.value === '') {
            fechafin.classList.add('is-invalid');
            fechafin.classList.remove('is-valid');
            errorFechafin.textContent = 'La fecha de fin es obligatoria.';
        } else {
            fechafin.classList.remove('is-invalid');
            fechafin.classList.add('is-valid');
            errorFechafin.textContent = '';
        }
        validarFechas();
    });

    function validarFechas() {
        if (fechainicio.value !== '' && fechafin.value !== '' && fechafin.value < fechainicio.value) {
            fechafin.classList.add('is-invalid');
            fechafin.classList.remove('is-valid');
            errorFechafin.textContent = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
        } else if (fechafin.value !== '') {
            fechafin.classList.remove('is-invalid');
            fechafin.classList.add('is-valid');
            errorFechafin.textContent = '';
        }
    }
});

function validarFormulario() {
    const titulo = document.getElementById('titulo');
    const contenido = document.getElementById('contenido');
    const fechainicio = document.getElementById('fechainicio');
    const fechafin = document.getElementById('fechafin');
    let isValid = true;

    if (titulo.value.length < 5) {
        titulo.classList.add('is-invalid');
        titulo.classList.remove('is-valid');
        document.getElementById('error-titulo').textContent = 'El título debe tener al menos 5 caracteres.';
        isValid = false;
    } else {
        titulo.classList.remove('is-invalid');
        titulo.classList.add('is-valid');
    }

    if (contenido.value.trim() === '') {
        contenido.classList.add('is-invalid');
        contenido.classList.remove('is-valid');
        document.getElementById('error-contenido').textContent = 'El contenido es obligatorio.';
        isValid = false;
    } else {
        contenido.classList.remove('is-invalid');
        contenido.classList.add('is-valid');
    }

    if (fechainicio.value === '') {
        fechainicio.classList.add('is-invalid');
        fechainicio.classList.remove('is-valid');
        document.getElementById('error-fechainicio').textContent = 'La fecha de inicio es obligatoria.';
        isValid = false;
    } else {
        fechainicio.classList.remove('is-invalid');
        fechainicio.classList.add('is-valid');
    }

    if (fechafin.value === '') {
        fechafin.classList.add('is-invalid');
        fechafin.classList.remove('is-valid');
        document.getElementById('error-fechafin').textContent = 'La fecha de fin es obligatoria.';
        isValid = false;
    } else if (fechafin.value < fechainicio.value) {
        fechafin.classList.add('is-invalid');
        fechafin.classList.remove('is-valid');
        document.getElementById('error-fechafin').textContent = 'La fecha de fin no puede ser anterior a la fecha de inicio.';
        isValid = false;
    } else {
        fechafin.classList.remove('is-invalid');
        fechafin.classList.add('is-valid');
    }

    return isValid;
}
