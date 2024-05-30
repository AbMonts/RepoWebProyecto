document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("usuarioForm");
  
    form.addEventListener("submit", function (event) {
      let valid = true;
      let messages = [];
  
      // Obtener los campos del formulario
      const nombre = document.getElementById("nombre").value.trim();
      const apellido1 = document.getElementById("apellido1").value.trim();
      const apellido2 = document.getElementById("apellido2").value.trim();
      const correo = document.getElementById("correo").value.trim();
      const usuario = document.getElementById("usuario").value.trim();
      const rol = document.getElementById("rol").value;
      const contrasena = document.getElementById("contrasena").value.trim();
  
      // Validaciones
      if (nombre === "") {
        valid = false;
        messages.push("El nombre es requerido.");
      }
  
      if (apellido1 === "") {
        valid = false;
        messages.push("El primer apellido es requerido.");
      }
  
      if (correo === "") {
        valid = false;
        messages.push("El correo es requerido.");
      } else if (!validateEmail(correo)) {
        valid = false;
        messages.push("El correo no es válido.");
      }
  
      if (usuario === "") {
        valid = false;
        messages.push("El usuario es requerido.");
      }
  
      if (rol === "") {
        valid = false;
        messages.push("El rol es requerido.");
      }
  
      if (contrasena === "") {
        valid = false;
        messages.push("La contraseña es requerida.");
      }
  
      // Si no es válido, prevenir el envío del formulario y mostrar los mensajes
      if (!valid) {
        event.preventDefault();
        alert(messages.join("\n"));
      }
    });
  
    function validateEmail(email) {
      const re = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      return re.test(String(email).toLowerCase());
    }
  });
  