function validarFormulario() {
    var titulo = document.getElementById("titulo").value;
    var contenido = document.getElementById("contenido").value;
    var fechafin = document.getElementById("fechafin").value;
    var errorTitulo = document.querySelector("#titulo + .text-danger");
    var errorContenido = document.querySelector("#contenido + .text-danger");
    var errorFechafin = document.querySelector("#fechafin + .text-danger");
    var errores = [];

    if (titulo.length < 5) {
        errores.push("El título debe tener al menos 5 caracteres.");
        errorTitulo.innerText = "El título debe tener al menos 5 caracteres.";
    } else {
        errorTitulo.innerText = "";
    }

    if (contenido.trim() === "") {
        errores.push("El contenido es obligatorio.");
        errorContenido.innerText = "El contenido es obligatorio.";
    } else {
        errorContenido.innerText = "";
    }

    if (fechafin.trim() === "") {
        errores.push("La fecha de fin es obligatoria.");
        errorFechafin.innerText = "La fecha de fin es obligatoria.";
    } else {
        errorFechafin.innerText = "";
    }

    return errores.length === 0;
}
