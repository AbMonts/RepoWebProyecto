<?php
require_once '../datos/Conexion.php'; 
require_once '../modelos/Usuario.php'; 
require_once '../datos/DAOUsuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (isset($_POST['nombre']) && !empty($_POST['nombre']) &&
    isset($_POST['apellido1']) && !empty($_POST['apellido1']) &&
    isset($_POST['apellido2']) && !empty($_POST['apellido2']) &&
    isset($_POST['correo']) && !empty($_POST['correo']) &&
    isset($_POST['usuario']) && !empty($_POST['usuario']) &&
    isset($_POST['rol']) && !empty($_POST['rol']) &&
    isset($_POST['contrasena']) && !empty($_POST['contrasena'])) {
    
    
     // Obtener los datos del formulario
     $id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : null;
     $nombre = $_POST['nombre'];
     $apellido1 = $_POST['apellido1'];
     $apellido2 = $_POST['apellido2'];
     $correo = $_POST['correo'];
     $usuario = $_POST['usuario'];
     $rol = $_POST['rol'];
     $contrasena = $_POST['contrasena'];

     // Crear una instancia de DAOUsuario y manejar la creación o actualización del usuario
     $dao = new DAOUsuario();
     $usuarioObj = new Usuario();
     $usuarioObj->id = $id;
     $usuarioObj->nombre = $nombre;
     $usuarioObj->apellido1 = $apellido1;
     $usuarioObj->apellido2 = $apellido2;
     $usuarioObj->correo = $correo;
     $usuarioObj->usuario = $usuario;
     $usuarioObj->rol = $rol;
     $usuarioObj->contrasena = $contrasena;

    // Validación de los campos
    $errores = array();
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = "El nombre es obligatorio.";
    }
    if (empty($_POST['apellido1'])) {
        $errores['apellido1'] = "El primer apellido es obligatorio.";
    }
    if (empty($_POST['apellido2'])) {
        $errores['apellido2'] = "El segundo apellido es obligatorio.";
    }
    if (empty($_POST['correo'])) {
        $errores['correo'] = "El correo es obligatorio.";
    }
    if (empty($_POST['usuario'])) {
        $errores['usuario'] = "El nombre de usuario es obligatorio.";
    }
    if (empty($_POST['rol'])) {
        $errores['rol'] = "El rol es obligatorio.";
    }
    if (empty($_POST['contrasena'])) {
        $errores['contrasena'] = "La contraseña es obligatoria.";
    }
    if (count($errores) > 0) {
        $_SESSION['errores'] = $errores;
        header("Location: RegistroUsuarios.php?id=" . (isset($_POST['id']) ? $_POST['id'] : '')); // Redirigir al formulario con errores
        exit;
    }

    if ($id === null) {
        // Crear nuevo usuario
        if ($dao->agregar($usuarioObj)) {
            $_SESSION['msg'] = "alert-success--Usuario creado exitosamente";
        } else {
            $_SESSION['msg'] = "alert-danger--Error al crear el usuario";
        }
    } else {
        // Actualizar usuario existente
        if ($dao->actualizar($usuarioObj)) {
            $_SESSION['msg'] = "alert-success--Usuario actualizado exitosamente";
        } else {
            $_SESSION['msg'] = "alert-danger--Error al actualizar el usuario";
        }
    }
} else {
    $_SESSION['msg'] = "alert-danger--Faltan datos requeridos";
}
} else {
$_SESSION['msg'] = "alert-danger--Método de solicitud no válido";
}

// Redirigir de vuelta a la página de lista de usuarios
header("Location: listaUsuarios.php");
exit();
?>
