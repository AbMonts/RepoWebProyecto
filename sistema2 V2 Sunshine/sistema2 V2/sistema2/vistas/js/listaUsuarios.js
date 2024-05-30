/*localStorage.setItem("s21120236",
    "Mariana Rodriguez Gallardo");
localStorage.setItem("s21120236",
    "Juan Pablo Rodriguez Gallardo");

console.log(localStorage.getItem("s21120236"));

console.log(localStorage.getItem("s21120237"));
let objUsuario={contrasenia:"1234",telefono:"1234567890"};
objUsuario.nombre="Mariana";
objUsuario.email="mariana@gmail.com";

objUsuario2={};
objUsuario2["nombre"]="Juan Perez";
objUsuario2.email="jPerez@gmail.com";

console.log(objUsuario);
console.log(objUsuario2);
let usuarios=[];
usuarios[0]=objUsuario;
usuarios.push({nombre:"a",email:"a@a.aa",contrasenia:"123",telefono:""});
usuarios[5]=objUsuario2;
usuarios["hola"]="mundo";
localStorage.setItem("usuarios",JSON.stringify(usuarios));
localStorage.setItem("usuariosobj",usuarios);
console.log(usuarios);

let usuarios2=JSON.parse(localStorage.getItem("usuarios"));

*/


/*window.addEventListener("load",()=>{
    //Se ejecuta cuando se descargan todos los recursos
});*/

document.addEventListener("DOMContentLoaded",()=>{
    cargarTabla();
    //Se ejecuta cuando se analiza y carga el DOM de la página (antes que load de window)
    
    const myModal = document.getElementById('mdlUsuario');
    const myInput = document.getElementById('txtNombre');
    const btnLimpiar = document.getElementById('btnLimpiar');
    myModal.addEventListener('shown.bs.modal', (e) => {
        let correo=e.relatedTarget.getAttribute("editar");
        btnLimpiar.click();
        let operacion;
        if(correo){
            operacion="Editar";
            let usuarios=JSON.parse(localStorage.getItem("listaUsuarios"));
            let usuario=usuarios.find((element)=>element.correo==correo);
            document.getElementById("txtNombre").value=usuario.nombre;
            document.getElementById("txtEmail").value=usuario.correo;
            document.getElementById("txtTelefono").value=usuario.telefono;
        }else{
            operacion="Agregar";
        }
        myInput.focus()
        
    })
    document.getElementById("btnLimpiar").addEventListener("click",(e)=>{
        document.getElementById("msg").style.display="none";
       e.target.form.classList.remove("validado");
       let controles=e.target.form.querySelectorAll("input, select");
       for (let i = 0; i < controles.length; i++) {
            const control = controles[i];
            control.classList.remove("valido");
            control.classList.remove("novalido");
       } 
/*
       controles.forEach(control => {
            control.classList.remove("valido");
            control.classList.remove("novalido");
       });*/
    });
    document.getElementById("btnAceptar").addEventListener("click",
    e=>{
        document.getElementById("msg").innerText="";
        document.getElementById("msg").style.display="none";        
        //document.querySelector("form")
        e.target.form.className="validado";
        
        let txtNombre=document.getElementById("txtNombre");
        let txtContrasenia=document.getElementById("txtPassword");
        let txtContrasenia2=document.getElementById("txtConfirmarPassword");
        let txtEmail=document.getElementById("txtEmail");
        let txtTel=document.getElementById("txtTelefono");
        txtNombre.setCustomValidity("");
        txtContrasenia.setCustomValidity("");
        txtContrasenia2.setCustomValidity("");
        txtEmail.setCustomValidity("");
        txtTel.setCustomValidity("");

        if(txtNombre.value.trim().length<2 ||
        txtNombre.value.trim().length>60){
            txtNombre.setCustomValidity("El nombre es obligatorio (entre 2 y 60 caracteres)");
        }
        if(txtContrasenia.value.trim().length<6 ||
        txtContrasenia.value.trim().length>20){
            txtContrasenia.setCustomValidity("La contraseña es obligatoria (entre 2 y 60 caracteres)");
        }
        if(txtContrasenia2.value.trim().length<6 ||
        txtContrasenia2.value.trim().length>20){
            txtContrasenia2.setCustomValidity("Confirma la contraseña");
        }

        if(txtTel.value.trim().length>0 && txtTel.value.trim().length<10){
            txtTel.setCustomValidity("El teléfono debe tener 10 dígitos");
        }

        if(e.target.form.checkValidity()){
           //guarda 
           let usuario={nombre:txtNombre.value,
                correo:txtEmail.value,
                contrasenia: txtContrasenia.value,
                telefono: txtTelefono.value};
            let usuarios=JSON.parse(localStorage.getItem("listaUsuarios"));
            //filter devuelve una colección de todos los elementos que coincidan
            //con una función condicional
            //find devuelve el primer elemento que coincida
            //con una función condicional
            //indexOf devuelve el índice del primer elemento que coincida
            //con una función condicional
            let encontrado=usuarios.find((user)=>user.correo==usuario.correo);
            if(encontrado){
                /*txtEmail.setCustomValidity("Este correo ya se encuentra en uso, ingresa uno diferente");*/
                let msg=document.getElementById("msg")
                msg.innerText="Este correo ya se encuentra en uso, ingresa uno diferente";
                msg.style.display="block";
                //Pruebenlo añadiendo más elementos entre el email y los siguientes
                //campos, de modo que el correo quede fuera de la pantalla al hacer click
                //Además añadan el div msg dentro del contenedor div de la caja txtEmail
                document.getElementById("mdlUsuario").scrollTo(0,msg.offsetTop);
                e.preventDefault();
                return;
            }
            //Guardar el usuario
            usuarios.push(usuario);
            localStorage.setItem("listaUsuarios",JSON.stringify(usuarios));
            e.preventDefault();
            
            let modal=bootstrap.Modal.getInstance("#mdlUsuario");
            modal.hide();
            cargarTabla();
        }else{
            e.preventDefault();
        }
    });
/*
    document.getElementById("txtNombre").addEventListener("change",e=>{
        revisarNombre();
    });*/
    
    //document.getElementById("txtNombre").addEventListener("keyup",revisar("txtNombre",2,60));
    document.getElementById("txtNombre").addEventListener("keyup",
        e=>revisar("txtNombre",2,60));
    document.getElementById("txtPassword").addEventListener("keyup",
        e=>revisar(e.target.id,6,20));
    document.getElementById("txtConfirmarPassword").addEventListener("keyup",
        e=>revisar(e.target.id,6,20));
    document.getElementById("txtTelefono").addEventListener("keyup",
        e=>revisar(e.target.id,0,10));
});

function revisar(id,min,max){
    let txt=document.getElementById(id);
    txt.setCustomValidity("");
    txt.classList.remove("valido");
    txt.classList.remove("novalido");
    
    if(txt.value.trim().length<min ||
    txt.value.trim().length>max){
        txt.setCustomValidity("Campo no válido");
        txt.classList.add("novalido");
    }else{
        txt.classList.add("valido");
    }
    
    /*console.log(txtNombre.value);
    console.log(txtNombre.validity);*/
}

function inicializarDatos(){
    let datos=localStorage.getItem("listaUsuarios");
    if(!datos){
        //Crear un arreglo con datos inciales
        let objUsuario={contrasenia:"1234",telefono:"1234567890",nombre:"Arturo", correo:"Arturo@gmail.com"};
        let objUsuario1={contrasenia:"4321",telefono:"9876543219",nombre:"Jose", correo:"Jose@gmail.com"};
        let objUsuario2={contrasenia:"2314",telefono:"1342567189",nombre:"Alberto", correo:"Beto@gmail.com"};

        let usuarios=[];
        usuarios[0]=objUsuario;
        usuarios[1]=objUsuario1;
        usuarios[2]=objUsuario2;
        localStorage.setItem("listaUsuarios",JSON.stringify(usuarios));
    }
}

function cargarTabla(){
    inicializarDatos();
    let usuarios=JSON.parse(localStorage.getItem("listaUsuarios"));
    /*for (let i = 0; i < usuarios.length; i++) {
        const usuario = usuarios[i];
        
    }*/
    let tbody=document.querySelector("#tblUsuarios tbody");
    tbody.innerHTML="";
    usuarios.forEach(usuario => {
        //Crear una fila con todos los datos del usuario
        /*let fila=`<tr><td>${usuario.nombre}</td><td>${usuario.correo}</td><td>${usuario.telefono}</td><td></td></tr>`;
        //Añadir la fila concatenandola con su contenido html
        tbody.innerHTML+=fila;*/
        
        let fila=document.createElement("tr");
        let celda=document.createElement("td");
        celda.innerHTML=`<a href="#" data-bs-toggle="modal" data-bs-target="#mdlUsuario" editar="${usuario.correo}">${usuario.nombre}</a>`;
        fila.appendChild(celda);
        celda=document.createElement("td");
        celda.innerText=usuario.correo;
        fila.appendChild(celda);
        celda=document.createElement("td");
        celda.appendChild(document.createTextNode(usuario.telefono));
        fila.appendChild(celda);
        celda=document.createElement("td");
        fila.appendChild(celda);
        tbody.appendChild(fila);
    });
}