
document.addEventListener('DOMContentLoaded', function () {
    const titulo = document.getElementById('titulo');
    const descripcion = document.getElementById('descripcion');
    const fechainicio = document.getElementById('fechainicio');
    const fechafin = document.getElementById('fechafin');

    const errorTitulo = document.getElementById('errorTitulo');
    const errorDescripcion = document.getElementById('errorDescripcion');
    const errorFechainicio = document.getElementById('errorFechainicio');
    const errorFechafin = document.getElementById('errorFechafin');

    titulo.addEventListener('keyup', function () {
        if (titulo.value.trim() === '') {
            titulo.classList.add('is-invalid');
            titulo.classList.remove('is-valid');
            errorTitulo.textContent = 'El título es obligatorio.';
        } else {
            titulo.classList.remove('is-invalid');
            titulo.classList.add('is-valid');
            errorTitulo.textContent = '';
        }
    });

    descripcion.addEventListener('keyup', function () {
        if (descripcion.value.trim() === '') {
            descripcion.classList.add('is-invalid');
            descripcion.classList.remove('is-valid');
            errorDescripcion.textContent = 'La descripción es obligatoria.';
        } else {
            descripcion.classList.remove('is-invalid');
            descripcion.classList.add('is-valid');
            errorDescripcion.textContent = '';
        }
    });

    fechainicio.addEventListener('keyup', function () {
        if (fechainicio.value === '') {
            fechainicio.classList.add('is-invalid');
            fechainicio.classList.remove('is-valid');
            errorFechainicio.textContent = 'La fecha de inicio es obligatoria.';
        } else {
            fechainicio.classList.remove('is-invalid');
            fechainicio.classList.add('is-valid');
            errorFechainicio.textContent = '';
        }
    });

    fechafin.addEventListener('keyup', function () {
        if (fechafin.value === '') {
            fechafin.classList.add('is-invalid');
            fechafin.classList.remove('is-valid');
            errorFechafin.textContent = 'La fecha de fin es obligatoria.';
        } else {
            fechafin.classList.remove('is-invalid');
            fechafin.classList.add('is-valid');
            errorFechafin.textContent = '';
        }
    });

    document.getElementById('formAgregarEvento').addEventListener('submit', function (event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });

    function validarFormulario() {
        let isValid = true;

        if (titulo.value.trim() === '') {
            titulo.classList.add('is-invalid');
            titulo.classList.remove('is-valid');
            errorTitulo.textContent = 'El título es obligatorio.';
            isValid = false;
        } else {
            titulo.classList.remove('is-invalid');
            titulo.classList.add('is-valid');
        }

        if (descripcion.value.trim() === '') {
            descripcion.classList.add('is-invalid');
            descripcion.classList.remove('is-valid');
            errorDescripcion.textContent = 'La descripción es obligatoria.';
            isValid = false;
        } else {
            descripcion.classList.remove('is-invalid');
            descripcion.classList.add('is-valid');
        }

        if (fechainicio.value === '') {
            fechainicio.classList.add('is-invalid');
            fechainicio.classList.remove('is-valid');
            errorFechainicio.textContent = 'La fecha de inicio es obligatoria.';
            isValid = false;
        } else {
            fechainicio.classList.remove('is-invalid');
            fechainicio.classList.add('is-valid');
        }

        if (fechafin.value === '') {
            fechafin.classList.add('is-invalid');
            fechafin.classList.remove('is-valid');
            errorFechafin.textContent = 'La fecha de fin es obligatoria.';
            isValid = false;
        } else {
            fechafin.classList.remove('is-invalid');
            fechafin.classList.add('is-valid');
        }

        return isValid;
    }
});
