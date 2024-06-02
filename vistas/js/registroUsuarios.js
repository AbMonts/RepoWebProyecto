document.addEventListener('DOMContentLoaded', function () {
    const nombre = document.getElementById('nombre');
    const correo = document.getElementById('correo');
    const apellido1 = document.getElementById('apellido1');
    const apellido2 = document.getElementById('apellido2');
    const usuario = document.getElementById('usuario');
    const rol = document.getElementById('rol');
    const contrasena = document.getElementById('contrasena');

    const errorNombre = document.getElementById('errorNombre');
    const errorCorreo = document.getElementById('errorCorreo');
    const errorApellido1 = document.getElementById('errorApellido1');
    const errorApellido2 = document.getElementById('errorApellido2');
    const errorUsuario = document.getElementById('errorUsuario');
    const errorRol = document.getElementById('errorRol');
    const errorContrasena = document.getElementById('errorContrasena');

    nombre.addEventListener('keyup', function () {
        validarCampoRequerido(nombre, errorNombre, 'El nombre es obligatorio.');
    });

    apellido1.addEventListener('keyup', function () {
        validarCampoRequerido(apellido1, errorApellido1, 'El primer apellido es obligatorio.');
    });

    apellido2.addEventListener('keyup', function () {
        validarCampoRequerido(apellido2, errorApellido2, 'El segundo apellido es obligatorio.');
    });

    correo.addEventListener('keyup', function () {
        if (correo.value.trim() === '') {
            marcarInvalido(correo, errorCorreo, 'El correo es obligatorio.');
        } else if (!validarEmail(correo.value)) {
            marcarInvalido(correo, errorCorreo, 'El correo no es válido.');
        } else {
            marcarValido(correo, errorCorreo);
        }
    });

    usuario.addEventListener('keyup', function () {
        if (usuario.value.trim() === '') {
            marcarInvalido(usuario, errorUsuario, 'El usuario es obligatorio.');
        } else if (!/^[a-zA-Z0-9]{3,15}$/.test(usuario.value)) {
            marcarInvalido(usuario, errorUsuario, 'El usuario debe tener entre 3 y 15 caracteres alfanuméricos.');
        } else {
            marcarValido(usuario, errorUsuario);
        }
    });

    rol.addEventListener('keyup', function () {
        validarCampoRequerido(rol, errorRol, 'El rol es obligatorio.');
    });

    contrasena.addEventListener('keyup', function () {
        if (contrasena.value.trim() === '') {
            marcarInvalido(contrasena, errorContrasena, 'La contraseña es obligatoria.');
        } else if (contrasena.value.length < 6) {
            marcarInvalido(contrasena, errorContrasena, 'La contraseña debe tener al menos 6 caracteres.');
        } else {
            marcarValido(contrasena, errorContrasena);
        }
    });

    document.getElementById('usuarioForm').addEventListener('submit', function (event) {
        if (!validarFormulario()) {
            event.preventDefault();
        }
    });

    function validarFormulario() {
        let isValid = true;

        isValid &= validarCampoRequerido(nombre, errorNombre, 'El nombre es obligatorio.');
        isValid &= validarCorreo(correo, errorCorreo);
        isValid &= validarCampoRequerido(apellido1, errorApellido1, 'El primer apellido es obligatorio.');
        isValid &= validarCampoRequerido(apellido2, errorApellido2, 'El segundo apellido es obligatorio.');
        isValid &= validarUsuario(usuario, errorUsuario);
        isValid &= validarCampoRequerido(rol, errorRol, 'El rol es obligatorio.');
        isValid &= validarContrasena(contrasena, errorContrasena);

        return isValid;
    }

    function validarCampoRequerido(campo, errorElem, mensajeError) {
        if (campo.value.trim() === '') {
            marcarInvalido(campo, errorElem, mensajeError);
            return false;
        } else {
            marcarValido(campo, errorElem);
            return true;
        }
    }

    function validarCorreo(campo, errorElem) {
        if (campo.value.trim() === '') {
            marcarInvalido(campo, errorElem, 'El correo es obligatorio.');
            return false;
        } else if (!validarEmail(campo.value)) {
            marcarInvalido(campo, errorElem, 'El correo no es válido.');
            return false;
        } else {
            marcarValido(campo, errorElem);
            return true;
        }
    }

    function validarUsuario(campo, errorElem) {
        if (campo.value.trim() === '') {
            marcarInvalido(campo, errorElem, 'El usuario es obligatorio.');
            return false;
        } else if (!/^[a-zA-Z0-9]{3,15}$/.test(campo.value)) {
            marcarInvalido(campo, errorElem, 'El usuario debe tener entre 3 y 15 caracteres alfanuméricos.');
            return false;
        } else {
            marcarValido(campo, errorElem);
            return true;
        }
    }

    function validarContrasena(campo, errorElem) {
        if (campo.value.trim() === '') {
            marcarInvalido(campo, errorElem, 'La contraseña es obligatoria.');
            return false;
        } else if (campo.value.length < 6) {
            marcarInvalido(campo, errorElem, 'La contraseña debe tener al menos 6 caracteres.');
            return false;
        } else {
            marcarValido(campo, errorElem);
            return true;
        }
    }

    function marcarInvalido(campo, errorElem, mensajeError) {
        campo.classList.add('is-invalid');
        campo.classList.remove('is-valid');
        errorElem.textContent = mensajeError;
    }

    function marcarValido(campo, errorElem) {
        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');
        errorElem.textContent = '';
    }

    function validarEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});
