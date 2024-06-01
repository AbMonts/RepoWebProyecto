document.addEventListener('DOMContentLoaded', function () {
    const nombre = document.getElementById('nombre');
    const apellido1 = document.getElementById('apellido1');
    const apellido2 = document.getElementById('apellido2');
    const correo = document.getElementById('correo');
    const usuario = document.getElementById('usuario');
    const rol = document.getElementById('rol');
    const contrasena = document.getElementById('contrasena');

    const errorNombre = document.getElementById('errorNombre');
    const errorApellido1 = document.getElementById('errorApellido1');
    const errorApellido2 = document.getElementById('errorApellido2');
    const errorCorreo = document.getElementById('errorCorreo');
    const errorUsuario = document.getElementById('errorUsuario');
    const errorRol = document.getElementById('errorRol');
    const errorContrasena = document.getElementById('errorContrasena');

    nombre.addEventListener('input', function () {
        if (nombre.value.trim() === '') {
            nombre.classList.add('is-invalid');
            nombre.classList.remove('is-valid');
            errorNombre.textContent = 'El nombre es obligatorio.';
        } else {
            nombre.classList.remove('is-invalid');
            nombre.classList.add('is-valid');
            errorNombre.textContent = '';
        }
    });

    apellido1.addEventListener('input', function () {
        if (apellido1.value.trim() === '') {
            apellido1.classList.add('is-invalid');
            apellido1.classList.remove('is-valid');
            errorApellido1.textContent = 'El primer apellido es obligatorio.';
        } else {
            apellido1.classList.remove('is-invalid');
            apellido1.classList.add('is-valid');
            errorApellido1.textContent = '';
        }
    });

    apellido2.addEventListener('input', function () {
        if (apellido2.value.trim() === '') {
            apellido2.classList.add('is-invalid');
            apellido2.classList.remove('is-valid');
            errorApellido2.textContent = 'El segundo apellido es obligatorio.';
        } else {
            apellido2.classList.remove('is-invalid');
            apellido2.classList.add('is-valid');
            errorApellido2.textContent = '';
        }
    });

    correo.addEventListener('input', function () {
        if (correo.value.trim() === '') {
            correo.classList.add('is-invalid');
            correo.classList.remove('is-valid');
            errorCorreo.textContent = 'El correo es obligatorio.';
        } else if (!validarEmail(correo.value)) {
            correo.classList.add('is-invalid');
            correo.classList.remove('is-valid');
            errorCorreo.textContent = 'El correo no es válido.';
        } else {
            correo.classList.remove('is-invalid');
            correo.classList.add('is-valid');
            errorCorreo.textContent = '';
        }
    });

    usuario.addEventListener('input', function () {
        if (usuario.value.trim() === '') {
            usuario.classList.add('is-invalid');
            usuario.classList.remove('is-valid');
            errorUsuario.textContent = 'El nombre de usuario es obligatorio.';
        } else {
            usuario.classList.remove('is-invalid');
            usuario.classList.add('is-valid');
            errorUsuario.textContent = '';
        }
    });

    rol.addEventListener('input', function () {
        if (rol.value === 'Default') {
            rol.classList.add('is-invalid');
            rol.classList.remove('is-valid');
            errorRol.textContent = 'El rol es obligatorio.';
        } else {
            rol.classList.remove('is-invalid');
            rol.classList.add('is-valid');
            errorRol.textContent = '';
        }
    });

    contrasena.addEventListener('input', function () {
        if (contrasena.value.trim() === '') {
            contrasena.classList.add('is-invalid');
            contrasena.classList.remove('is-valid');
            errorContrasena.textContent = 'La contraseña es obligatoria.';
        } else {
            contrasena.classList.remove('is-invalid');
            contrasena.classList.add('is-valid');
            errorContrasena.textContent = '';
        }
    });

    function validarEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(String(email).toLowerCase());
    }
});

function validarFormulario() {
    const nombre = document.getElementById('nombre');
    const apellido1 = document.getElementById('apellido1');
    const apellido2 = document.getElementById('apellido2');
    const correo = document.getElementById('correo');
    const usuario = document.getElementById('usuario');
    const rol = document.getElementById('rol');
    const contrasena = document.getElementById('contrasena');
    let isValid = true;

    if (nombre.value.trim() === '') {
        nombre.classList.add('is-invalid');
        nombre.classList.remove('is-valid');
        document.getElementById('errorNombre').textContent = 'El nombre es obligatorio.';
        isValid = false;
    } else {
        nombre.classList.remove('is-invalid');
        nombre.classList.add('is-valid');
    }

    if (apellido1.value.trim() === '') {
        apellido1.classList.add('is-invalid');
        apellido1.classList.remove('is-valid');
        document.getElementById('errorApellido1').textContent = 'El primer apellido es obligatorio.';
        isValid = false;
    } else {
        apellido1.classList.remove('is-invalid');
        apellido1.classList.add('is-valid');
    }

    if (apellido2.value.trim() === '') {
        apellido2.classList.add('is-invalid');
        apellido2.classList.remove('is-valid');
        document.getElementById('errorApellido2').textContent = 'El segundo apellido es obligatorio.';
        isValid = false;
    } else {
        apellido2.classList.remove('is-invalid');
        apellido2.classList.add('is-valid');
    }

    if (correo.value.trim() === '') {
        correo.classList.add('is-invalid');
        correo.classList.remove('is-valid');
        document.getElementById('errorCorreo').textContent = 'El correo es obligatorio.';
        isValid = false;
    } else if (!validarEmail(correo.value)) {
        correo.classList.add('is-invalid');
        correo.classList.remove('is-valid');
        document.getElementById('errorCorreo').textContent = 'El correo no es válido.';
        isValid = false;
    } else {
        correo.classList.remove('is-invalid');
        correo.classList.add('is-valid');
    }

    if (usuario.value.trim() === '') {
        usuario.classList.add('is-invalid');
        usuario.classList.remove('is-valid');
        document.getElementById('errorUsuario').textContent = 'El nombre de usuario es obligatorio.';
        isValid = false;
    } else {
        usuario.classList.remove('is-invalid');
        usuario.classList.add('is-valid');
    }

    if (rol.value === 'Default') {
        rol.classList.add('is-invalid');
        rol.classList.remove('is-valid');
        document.getElementById('errorRol').textContent = 'El rol es obligatorio.';
        isValid = false;
    } else {
        rol.classList.remove('is-invalid');
        rol.classList.add('is-valid');
    }

    if (contrasena.value.trim() === '') {
        contrasena.classList.add('is-invalid');
        contrasena.classList.remove('is-valid');
        document.getElementById('errorContrasena').textContent = 'La contraseña es obligatoria.';
        isValid = false;
    } else {
        contrasena.classList.remove('is-invalid');
        contrasena.classList.add('is-valid');
    }

    return isValid;
}

function validarEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(String(email).toLowerCase());
}
