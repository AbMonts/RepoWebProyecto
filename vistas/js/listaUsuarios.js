document.addEventListener("DOMContentLoaded", () => {
    cargarTabla();

    const myModal = document.getElementById('mdlUsuario');
    const myInput = document.getElementById('txtNombre');
    const btnLimpiar = document.getElementById('btnLimpiar');

    myModal.addEventListener('shown.bs.modal', (e) => {
        let correo = e.relatedTarget.getAttribute("editar");
        btnLimpiar.click();
        let operacion;
        if (correo) {
            operacion = "Editar";
            let usuarios = JSON.parse(localStorage.getItem("listaUsuarios"));
            let usuario = usuarios.find((element) => element.correo == correo);
            document.getElementById("txtNombre").value = usuario.nombre;
            document.getElementById("txtEmail").value = usuario.correo;
            document.getElementById("txtTelefono").value = usuario.telefono;
        } else {
            operacion = "Agregar";
        }
        myInput.focus();

        // Registro de la operación en LocalStorage
        let usuarioModificado = correo || ""; // Si no hay correo, dejarlo como cadena vacía
        let metodo = "shown.bs.modal"; // Método utilizado para modificar el usuario
        registrarMovimiento(operacion, usuarioModificado, metodo);
    });

    document.getElementById("btnLimpiar").addEventListener("click", (e) => {
        document.getElementById("msg").style.display = "none";
        e.target.form.classList.remove("validado");
        let controles = e.target.form.querySelectorAll("input, select");
        for (let i = 0; i < controles.length; i++) {
            const control = controles[i];
            control.classList.remove("valido");
            control.classList.remove("novalido");
        }
    });

    document.getElementById("btnAceptar").addEventListener("click", e => {
        document.getElementById("msg").innerText = "";
        document.getElementById("msg").style.display = "none";
        e.target.form.className = "validado";

        let txtNombre = document.getElementById("txtNombre");
        let txtContrasenia = document.getElementById("txtPassword");
        let txtContrasenia2 = document.getElementById("txtConfirmarPassword");
        let txtEmail = document.getElementById("txtEmail");
        let txtTel = document.getElementById("txtTelefono");
        txtNombre.setCustomValidity("");
        txtContrasenia.setCustomValidity("");
        txtContrasenia2.setCustomValidity("");
        txtEmail.setCustomValidity("");
        txtTel.setCustomValidity("");

        if (e.target.form.checkValidity()) {
            //guarda 
            let usuario = {
                nombre: txtNombre.value,
                correo: txtEmail.value,
                contrasenia: txtContrasenia.value,
                telefono: txtTelefono.value
            };
            let usuarios = JSON.parse(localStorage.getItem("listaUsuarios"));
            let encontrado = usuarios.find((user) => user.correo == usuario.correo);
            if (encontrado) {
                let msg = document.getElementById("msg")
                msg.innerText = "Este correo ya se encuentra en uso, ingresa uno diferente";
                msg.style.display = "block";
                document.getElementById("mdlUsuario").scrollTo(0, msg.offsetTop);
                e.preventDefault();
                return;
            }

            // Registro de la operación en LocalStorage
            let operacion = encontrado ? "Editar" : "Agregar";
            let usuarioModificado = usuario.correo; // Puedes cambiar esto según la información relevante
            let metodo = "onclick"; // Puedes cambiar esto según el método utilizado para modificar el usuario
            registrarMovimiento(operacion, usuarioModificado, metodo);

            usuarios.push(usuario);
            localStorage.setItem("listaUsuarios", JSON.stringify(usuarios));
            e.preventDefault();

            let modal = bootstrap.Modal.getInstance("#mdlUsuario");
            modal.hide();
            cargarTabla();
        } else {
            e.preventDefault();
        }
    });

    document.getElementById("txtNombre").addEventListener("keyup", e => revisar("txtNombre", 2, 60));
    document.getElementById("txtPassword").addEventListener("keyup", e => revisar(e.target.id, 6, 20));
    document.getElementById("txtConfirmarPassword").addEventListener("keyup", e => revisar(e.target.id, 6, 20));
    document.getElementById("txtTelefono").addEventListener("keyup", e => revisar(e.target.id, 0, 10));

    function revisar(id, min, max) {
        let txt = document.getElementById(id);
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

    function inicializarDatos() {
        let datos = localStorage.getItem("listaUsuarios");
        if (!datos) {
            let objUsuario = { contrasenia: "1234", telefono: "1234567890", nombre: "Arturo", correo: "Arturo@gmail.com" };
            let objUsuario1 = { contrasenia: "4321", telefono: "9876543219", nombre: "Jose", correo: "Jose@gmail.com" };
            let objUsuario2 = { contrasenia: "2314", telefono: "1342567189", nombre: "Alberto", correo: "Beto@gmail.com" };

            let usuarios = [];
            usuarios[0] = objUsuario;
            usuarios[1] = objUsuario1;
            usuarios[2] = objUsuario2;
            localStorage.setItem("listaUsuarios", JSON.stringify(usuarios));
        }
    }

    function cargarTabla() {
        inicializarDatos();
        let usuarios = JSON.parse(localStorage.getItem("listaUsuarios"));
        let tbody = document.querySelector("#tblUsuarios tbody");
        tbody.innerHTML = "";
        usuarios.forEach(usuario => {
            let fila = document.createElement("tr");
            let celda = document.createElement("td");
            celda.innerHTML = `<a href="#" data-bs-toggle="modal" data-bs-target="#mdlUsuario" editar="${usuario.correo}">${usuario.nombre}</a>`;
            fila.appendChild(celda);
            celda = document.createElement("td");
            celda.innerText = usuario.correo;
            fila.appendChild(celda);
            celda = document.createElement("td");
            celda.appendChild(document.createTextNode(usuario.telefono));
            fila.appendChild(celda);
            celda = document.createElement("td");
            fila.appendChild(celda);
            tbody.appendChild(fila);
        });
    }

    function registrarMovimiento(operacion, usuarioModificado, metodo) {
        let movimientos = localStorage.getItem("movimientos") || ""; // Obtener movimientos actuales o cadena vacía si no hay
        let movimiento = {
            fecha: new Date().toISOString(),
            operacion: operacion,
            usuarioModificado: usuarioModificado,
            metodo: metodo
        };
        movimientos += JSON.stringify(movimiento) + "\n"; // Agregar nuevo movimiento al final de la cadena
        localStorage.setItem("movimientos", movimientos);
    }
});


//Para ver el registro debemos usar la consulta: localStorage.getItem("movimientos")
// O para imprimirlos en la consola: console.log(localStorage.getItem("movimientos"));