document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const nombre = document.getElementById('nombre');
    const correo = document.getElementById('correo');
    const apellido1 = document.getElementById('apellido1');
    const apellido2 = document.getElementById('apellido2');
    const rol = document.getElementById('rol');
    const contrasena = document.getElementById('contrasena');

    // Add keyup event listeners for real-time validation
    nombre.addEventListener('keyup', function () { validateField(nombre, isValidName, 'El nombre es obligatorio y solo puede contener letras.'); });
    correo.addEventListener('keyup', function () { validateField(correo, validateEmail, 'El correo no es válido.'); });
    apellido1.addEventListener('keyup', function () { validateField(apellido1, isValidName, 'El apellido paterno es obligatorio y solo puede contener letras.'); });
    apellido2.addEventListener('keyup', function () { validateField(apellido2, isValidName, 'El apellido materno es obligatorio y solo puede contener letras.'); });
    contrasena.addEventListener('keyup', function () { validateField(contrasena, isValidPassword, 'La contraseña debe tener al menos 6 caracteres y no puede contener espacios.'); });

    form.addEventListener('submit', function (event) {
        let valid = true;

        clearErrors();

        if (!validateField(nombre, isValidName, 'El nombre es obligatorio y solo puede contener letras.')) {
            valid = false;
        }

        if (!validateField(correo, validateEmail, 'El correo no es válido.')) {
            valid = false;
        }

        if (!validateField(apellido1, isValidName, 'El apellido paterno es obligatorio y solo puede contener letras.')) {
            valid = false;
        }

        if (!validateField(apellido2, isValidName, 'El apellido materno es obligatorio y solo puede contener letras.')) {
            valid = false;
        }

        if (rol.value.trim() === '') {
            showError(rol, 'El rol es obligatorio.');
            valid = false;
        }

        if (!validateField(contrasena, isValidPassword, 'La contraseña debe tener al menos 6 caracteres y no puede contener espacios.')) {
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
        }
    });

    function clearErrors() {
        const errorSpans = document.querySelectorAll('.text-danger');
        errorSpans.forEach(span => span.textContent = '');
    }

    function showError(input, message) {
        const errorSpan = input.nextElementSibling;
        if (errorSpan) {
            errorSpan.textContent = message;
        } else {
            const span = document.createElement('span');
            span.className = 'text-danger';
            span.textContent = message;
            input.parentNode.appendChild(span);
        }
    }

    function validateField(input, validationFn, errorMessage) {
        if (!validationFn(input.value.trim())) {
            showError(input, errorMessage);
            return false;
        } else {
            const errorSpan = input.nextElementSibling;
            if (errorSpan) {
                errorSpan.textContent = '';
            }
            return true;
        }
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    function isValidName(name) {
        const re = /^[A-Za-zÀ-ÿ\u00f1\u00d1\s]+$/;
        return re.test(name);
    }

    function isValidPassword(password) {
        const re = /^\S{6,}$/;
        return re.test(password);
    }
});
