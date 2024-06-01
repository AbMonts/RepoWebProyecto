document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("nombre").addEventListener("keyup", validarNombre);
    document.getElementById("apellido1").addEventListener("keyup", validarApellido1);
    document.getElementById("apellido2").addEventListener("keyup", validarApellido2);
    document.getElementById("correo").addEventListener("keyup", validarCorreo);
    document.getElementById("usuario").addEventListener("keyup", validarUsuario);
    document.getElementById("rol").addEventListener("change", validarRol);
    document.getElementById("contrasena").addEventListener("keyup", validarContrasena);

    document.getElementById("correo").onblur = validarCorreo;
});

function validarNombre() {
    var nombre = document.getElementById("nombre").value.trim();
    var errorNombre = document.getElementById("errorNombre");
    errorNombre.textContent = nombre === "" ? "El nombre es obligatorio." : "";
}

function validarApellido1() {
    var apellido1 = document.getElementById("apellido1").value.trim();
    var errorApellido1 = document.getElementById("errorApellido1");
    errorApellido1.textContent = apellido1 === "" ? "El primer apellido es obligatorio." : "";
}

function validarApellido2() {
    var apellido2 = document.getElementById("apellido2").value.trim();
    var errorApellido2 = document.getElementById("errorApellido2");
    errorApellido2.textContent = apellido2 === "" ? "El segundo apellido es obligatorio." : "";
}

function validarCorreo() {
    var correo = document.getElementById("correo").value.trim();
    var correoError = document.getElementById("correoError");

    if (correo === "") {
        correoError.textContent = "El correo es obligatorio.";
        return;
    }

    // Realizar la solicitud AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "validar_correo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.valido) {
                    correoError.textContent = "";
                } else {
                    correoError.textContent = response.mensaje;
                }
            } else {
                correoError.textContent = "Error en la solicitud.";
            }
        }
    };
    xhr.send("correo=" + encodeURIComponent(correo));
}

function validarUsuario() {
    var usuario = document.getElementById("usuario").value.trim();
    var errorUsuario = document.getElementById("errorUsuario");
    errorUsuario.textContent = usuario === "" ? "El nombre de usuario es obligatorio." : "";
}

function validarRol() {
    var rol = document.getElementById("rol").value;
    var errorRol = document.getElementById("errorRol");
    errorRol.textContent = rol === "Default" ? "El rol es obligatorio." : "";
}

function validarContrasena() {
    var contrasena = document.getElementById("contrasena").value.trim();
    var errorContrasena = document.getElementById("errorContrasena");
    errorContrasena.textContent = contrasena === "" ? "La contraseña es obligatoria." : "";
}

function validarFormulario() {
    validarNombre();
    validarApellido1();
    validarApellido2();
    validarCorreo();
    validarUsuario();
    validarRol();
    validarContrasena();

    var errores = document.querySelectorAll(".text-danger");
    for (var i = 0; i < errores.length; i++) {
        if (errores[i].textContent !== "") {
            return false;
        }
    }
    return true;
}
