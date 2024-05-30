const regexMail = /^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/g;
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnMostrarOcultar").addEventListener("click", e => {
        if (e.target.innerText == "Ver") {
            e.target.innerText = "Ocultar";
            document.getElementById("txtPassword").type = 'text';
        } else {
            e.target.innerText = "Ver";
            document.getElementById("txtPassword").type = 'password';
        }
    });

    document.getElementById("txtEmail").onkeyup = e => {
        if (e.code == "Tab") return;
        let txt = e.target;
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

    document.getElementById("txtPassword").onkeyup = e => {
        revisarControl(e, 1, 50);
    }

    document.getElementById("btnAceptar").addEventListener("click", e => {
        let alert = e.target.parentElement.querySelector(".alert");
        if (alert) {
            alert.remove();
        }

        e.target.form.classList.add("validado");

        let txtContrasenia = document.getElementById("txtPassword");
        let txtEmail = document.getElementById("txtEmail");
        txtContrasenia.setCustomValidity("");
        txtEmail.setCustomValidity("");

        if (txtContrasenia.value.trim().length < 1 ||
            txtContrasenia.value.trim().length > 50) {
            txtContrasenia.setCustomValidity("");
        }

        if (!txtEmail.value.trim().match(regexMail)) {
            txtEmail.setCustomValidity("Campo no válido");
        }

        if (!e.target.form.checkValidity()) {
            e.preventDefault();
        }
    });
});

function revisarControl(e, min, max) {
    if (e.code == "Tab") return;
    txt = e.target;
    txt.setCustomValidity("");
    txt.classList.remove("valido");
    txt.classList.remove("novalido");
    if (txt.value.trim().length < min ||
        txt.value.trim().length > max) {
        txt.setCustomValidity("Campo no válido");
        txt.classList.add("novalido");
        return false;
    } else {
        txt.classList.add("valido");
        return true;
    }
}