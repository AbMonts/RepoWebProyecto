const regexMail = /^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/g;

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("usuarioForm");

  document.getElementById("nombre").onkeyup = e => validarCampo(e, 1, 100);
  document.getElementById("apellido1").onkeyup = e => validarCampo(e, 1, 100);
  document.getElementById("apellido2").onkeyup = e => validarCampo(e, 0, 100);
  document.getElementById("correo").onkeyup = e => validarCorreo(e);
  document.getElementById("usuario").onkeyup = e => validarCampo(e, 1, 50);
  document.getElementById("contrasena").onkeyup = e => validarCampo(e, 1, 255);

  form.addEventListener("submit", e => {
    let alert = form.querySelector(".alert");
    if (alert) alert.remove();

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

function validarCorreo(e) {
  if (e.code === "Tab") return;
  const txt = e.target;
  if (txt.value.trim().match(regexMail)) {
    txt.setCustomValidity("");
    txt.classList.add("valido");
    txt.classList.remove("novalido");
  } else {
    txt.setCustomValidity("Campo no válido");
    txt.classList.remove("valido");
    txt.classList.add("novalido");
  }
}
