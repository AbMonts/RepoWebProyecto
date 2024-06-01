const regexMail = /^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/g;

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("usuarioForm");

  document.getElementById("nombre").onkeyup = e => validarCampo(e, 1, 100);
  document.getElementById("apellido1").onkeyup = e => validarCampo(e, 1, 100);
  document.getElementById("apellido2").onkeyup = e => validarCampo(e, 0, 100);
  document.getElementById("usuario").onkeyup = e => validarCampo(e, 1, 50);
  document.getElementById("contrasena").onkeyup = e => validarCampo(e, 1, 255);

  // Validación de correo electrónico al perder el foco del campo
  document.getElementById("correo").onblur = e => validarCorreoDisponible(e);

  form.addEventListener("submit", e => {
    let messageElement = form.querySelector(".mensaje");
    if (messageElement) messageElement.remove();

    form.classList.add("validado");

    const nombre = document.getElementById("nombre");
    const apellido1 = document.getElementById("apellido1");
    const correo = document.getElementById("correo");
    const usuario = document.getElementById("usuario");
    const contrasena = document.getElementById("contrasena");

    nombre.setCustomValidity("");
    apellido1.setCustomValidity("");
    correo.setCustomValidity("");
    usuario.setCustomValidity("");
    contrasena.setCustomValidity("");

    if (!nombre.checkValidity() || !apellido1.checkValidity() || !correo.checkValidity() ||
        !usuario.checkValidity() || !contrasena.checkValidity()) {
      e.preventDefault();
      showMessage("Todos los campos son requeridos y deben ser válidos.");
    }
  });
});

function validarCampo(e, min, max) {
  if (e.code === "Tab") return;
  const txt = e.target;
  txt.setCustomValidity("");
  txt.classList.remove("valido");
  txt.classList.remove("novalido");
  if (txt.value.trim().length < min || txt.value.trim().length > max) {
    txt.setCustomValidity("Campo no válido");
    txt.classList.add("novalido");
  } else {
    txt.classList.add("valido");
  }
}

function validarCorreoDisponible(e) {
  if (e.code === "Tab") return;
  const txt = e.target;
  if (txt.value.trim().match(regexMail)) {
    // Realizar la solicitud AJAX para validar si el correo está disponible
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "validar_correo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          if (response.error) {
            txt.setCustomValidity(response.message);
            txt.classList.add("novalido");
            showMessage(response.message);
          } else {
            txt.setCustomValidity("");
            txt.classList.add("valido");
          }
        } else {
          console.error("Error en la solicitud.");
        }
      }
    };
    xhr.send("correo=" + encodeURIComponent(txt.value.trim()));
  } else {
    txt.setCustomValidity("Campo no válido");
    txt.classList.remove("valido");
    txt.classList.add("novalido");
    showMessage("El correo electrónico no es válido.");
  }

}

function showMessage(message) {
  var messageElement = document.createElement('div');
  messageElement.textContent = message;
  messageElement.classList.add('mensaje', 'alert', 'alert-info');
  form.appendChild(messageElement);
  setTimeout(function() {
      messageElement.remove();
  }, 3000); // Remover el mensaje después de 3 segundos
}
