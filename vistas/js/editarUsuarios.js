document.addEventListener('DOMContentLoaded', function () {
    const nombre = document.getElementById('nombre');
    const correo = document.getElementById('correo');
    const apellido1 = document.getElementById('apellido1');
    const apellido2 = document.getElementById('apellido2');
    const rol = document.getElementById('rol');
    const contrasena = document.getElementById('contrasena');

    const errorNombre = document.getElementById('errorNombre');
    const errorCorreo = document.getElementById('errorCorreo');
    const errorApellido1 = document.getElementById('errorApellido1');
    const errorApellido2 = document.getElementById('errorApellido2');
    const errorRol = document.getElementById('errorRol');
    const errorContrasena = document.getElementById('errorContrasena');

    function validarCampo(campo, errorSpan, mensaje) {
        if (campo.value.trim() === '') {
            campo.classList.add('is-invalid');
            campo.classList.remove('is-valid');
            errorSpan.textContent = mensaje;
            return false;
        } else {
            campo.classList.remove('is-invalid');
            campo.classList.add('is-valid');
            errorSpan.textContent = '';
            return true;
        }
    }

    function validarEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }

    function validarFormulario() {
        let isValid = true;

        isValid = validarCampo(nombre, errorNombre, 'El nombre es obligatorio.') && isValid;
        isValid = validarCampo(apellido1, errorApellido1, 'El primer apellido es obligatorio.') && isValid;
        isValid = validarCampo(apellido2, errorApellido2, 'El segundo apellido es obligatorio.') && isValid;
        isValid = validarCampo(rol, errorRol, 'El rol es obligatorio.') && isValid;
        isValid = validarCampo(contrasena, errorContrasena, 'La contraseña es obligatoria.') && isValid;

        if (correo.value.trim() === '') {
            correo.classList.add('is-invalid');
            correo.classList.remove('is-valid');
            errorCorreo.textContent = 'El correo es obligatorio.';
            isValid = false;
        } else if (!validarEmail(correo.value)) {
            correo.classList.add('is-invalid');
            correo.classList.remove('is-valid');
            errorCorreo.textContent = 'El correo no es válido.';
            isValid = false;
        } else {
            correo.classList.remove('is-invalid');
            correo.classList.add('is-valid');
            errorCorreo.textContent = '';
        }

        return isValid;
    }

    document.getElementById('usuarioForm').addEventListener('submit', function (event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });

    nombre.addEventListener('keyup', function () {
        validarCampo(nombre, errorNombre, 'El nombre es obligatorio.');
    });

    correo.addEventListener('keyup', function () {
        validarCampo(correo, errorCorreo, 'El correo es obligatorio.');
        if (!validarEmail(correo.value)) {
            correo.classList.add('is-invalid');
            correo.classList.remove('is-valid');
            errorCorreo.textContent = 'El correo no es válido.';
        }
    });

    apellido1.addEventListener('keyup', function () {
        validarCampo(apellido1, errorApellido1, 'El primer apellido es obligatorio.');
    });

    apellido2.addEventListener('keyup', function () {
        validarCampo(apellido2, errorApellido2, 'El segundo apellido es obligatorio.');
    });

    rol.addEventListener('change', function () {
        validarCampo(rol, errorRol, 'El rol es obligatorio.');
    });

    contrasena.addEventListener('keyup', function () {
        validarCampo(contrasena, errorContrasena, 'La contraseña es obligatoria.');
    });
});
