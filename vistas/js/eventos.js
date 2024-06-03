document.addEventListener("DOMContentLoaded", function() {
    var alert = document.getElementById('alert');
    if (alert) {
        setTimeout(function() {
            alert.style.display = 'none';
        }, 5000); // Ocultar el mensaje después de 5 segundos
    }

    // Validación en tiempo real para agregar evento
    const formAgregar = document.getElementById('formAgregarEvento');
    const tituloInputAgregar = document.getElementById('titulo');
    const descripcionTextareaAgregar = document.getElementById('descripcion');
    const fechainicioInputAgregar = document.getElementById('fechainicio');
    const fechafinInputAgregar = document.getElementById('fechafin');

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

    function validarFechas(inicioInput, finInput, spanIdInicio, spanIdFin) {
        const mensajeSpanInicio = document.getElementById(spanIdInicio);
        const mensajeSpanFin = document.getElementById(spanIdFin);
        const fechaInicio = new Date(inicioInput.value);
        const fechaFin = new Date(finInput.value);

        if (inicioInput.value === "" || finInput.value === "") {
            if (inicioInput.value === "") {
                inicioInput.classList.add('is-invalid');
                mensajeSpanInicio.textContent = 'La fecha de inicio no puede estar vacía.';
                mensajeSpanInicio.style.color = 'red';
            }
            if (finInput.value === "") {
                finInput.classList.add('is-invalid');
                mensajeSpanFin.textContent = 'La fecha de fin no puede estar vacía.';
                mensajeSpanFin.style.color = 'red';
            }
            return false;
        }

        if (fechaInicio >= fechaFin) {
            inicioInput.classList.add('is-invalid');
            finInput.classList.add('is-invalid');
            mensajeSpanInicio.textContent = 'La fecha de inicio debe ser anterior a la fecha de fin.';
            mensajeSpanInicio.style.color = 'red';
            mensajeSpanFin.textContent = 'La fecha de fin debe ser posterior a la fecha de inicio.';
            mensajeSpanFin.style.color = 'red';
            return false;
        } else {
            inicioInput.classList.remove('is-invalid');
            inicioInput.classList.add('is-valid');
            finInput.classList.remove('is-invalid');
            finInput.classList.add('is-valid');
            mensajeSpanInicio.textContent = '';
            mensajeSpanFin.textContent = '';
            return true;
        }
    }

    tituloInputAgregar.addEventListener('keyup', function() {
        validarCampo(tituloInputAgregar, 255, 4, 'tituloError', 'El título debe tener entre 4 y 255 caracteres.');
    });

    descripcionTextareaAgregar.addEventListener('keyup', function() {
        validarCampo(descripcionTextareaAgregar, 1000, 4, 'descripcionError', 'La descripción debe tener entre 4 y 1000 caracteres.');
    });

    fechainicioInputAgregar.addEventListener('change', function() {
        validarFechas(fechainicioInputAgregar, fechafinInputAgregar, 'fechainicioError', 'fechafinError');
    });

    fechafinInputAgregar.addEventListener('change', function() {
        validarFechas(fechainicioInputAgregar, fechafinInputAgregar, 'fechainicioError', 'fechafinError');
    });

    formAgregar.addEventListener('submit', function(event) {
        const isTituloValid = validarCampo(tituloInputAgregar, 255, 4, 'tituloError', 'El título debe tener entre 4 y 255 caracteres.');
        const isDescripcionValid = validarCampo(descripcionTextareaAgregar, 1000, 4, 'descripcionError', 'La descripción debe tener entre 4 y 1000 caracteres.');
        const areFechasValid = validarFechas(fechainicioInputAgregar, fechafinInputAgregar, 'fechainicioError', 'fechafinError');

        if (!isTituloValid || !isDescripcionValid || !areFechasValid) {
            event.preventDefault();
        }
    });

    // Validación en tiempo real para modificar evento
    const formModificar = document.getElementById('formModificarEvento');
    const tituloInputModificar = document.getElementById('modificarTitulo');
    const descripcionTextareaModificar = document.getElementById('modificarDescripcion');
    const fechainicioInputModificar = document.getElementById('modificarFechaInicio');
    const fechafinInputModificar = document.getElementById('modificarFechaFin');

    tituloInputModificar.addEventListener('keyup', function() {
        validarCampo(tituloInputModificar, 255, 4, 'modificarTituloError', 'El título debe tener entre 4 y 255 caracteres.');
    });

    descripcionTextareaModificar.addEventListener('keyup', function() {
        validarCampo(descripcionTextareaModificar, 1000, 4, 'modificarDescripcionError', 'La descripción debe tener entre 4 y 1000 caracteres.');
    });

    fechainicioInputModificar.addEventListener('change', function() {
        validarFechas(fechainicioInputModificar, fechafinInputModificar, 'modificarFechaInicioError', 'modificarFechaFinError');
    });

    fechafinInputModificar.addEventListener('change', function() {
        validarFechas(fechainicioInputModificar, fechafinInputModificar, 'modificarFechaInicioError', 'modificarFechaFinError');
    });

    formModificar.addEventListener('submit', function(event) {
        const isTituloValid = validarCampo(tituloInputModificar, 255, 4, 'modificarTituloError', 'El título debe tener entre 4 y 255 caracteres.');
        const isDescripcionValid = validarCampo(descripcionTextareaModificar, 1000, 4, 'modificarDescripcionError', 'La descripción debe tener entre 4 y 1000 caracteres.');
        const areFechasValid = validarFechas(fechainicioInputModificar, fechafinInputModificar, 'modificarFechaInicioError', 'modificarFechaFinError');

        if (!isTituloValid || !isDescripcionValid || !areFechasValid) {
            event.preventDefault();
        }
    });
});
