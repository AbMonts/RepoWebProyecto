<?php
session_start();
require_once("../datos/DAOUsuario.php");

// Inicializar variables de error
$_SESSION['errores'] = [];

// Función para validar datos de entrada
function validarDato($dato, $campo, $minLength = 0) {
    if (empty(trim($dato))) {
        $_SESSION['errores'][$campo] = "El campo $campo es obligatorio.";
        return false;
    }
    if (strlen($dato) < $minLength) {
        $_SESSION['errores'][$campo] = "El campo $campo debe tener al menos $minLength caracteres.";
        return false;
    }
    return true;
}

// Validar datos del formulario
$validacion = true;
$validacion &= validarDato($_POST['nombre'], 'nombre', 3);
$validacion &= validarDato($_POST['apellido1'], 'apellido1', 3);
$validacion &= validarDato($_POST['apellido2'], 'apellido2', 3);
$validacion &= validarDato($_POST['correo'], 'correo');

// Validación adicional para el correo
if (!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errores']['correo'] = "El formato del correo es inválido.";
    $validacion = false;
}

$validacion &= validarDato($_POST['usuario'], 'usuario', 3);
$validacion &= validarDato($_POST['rol'], 'rol');
$validacion &= validarDato($_POST['contrasena'], 'contrasena', 6);

// Si la validación falla, redirigir de nuevo al formulario
if (!$validacion) {
    header("Location: formulario_usuario.php?id=" . $_POST['id']);
    exit();
}

// Si la validación es exitosa, proceder con la lógica de almacenamiento en la base de datos
$dao = new DAOUsuario();
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    // Editar usuario existente
    $resultado = $dao->actualizar(new Usuario(
        $_POST['id'], 
        $_POST['nombre'], 
        $_POST['apellido1'], 
        $_POST['apellido2'], 
        $_POST['correo'], 
        $_POST['usuario'], 
        $_POST['rol'], 
        $_POST['contrasena']
    ));
} else {
    // Crear nuevo usuario
    $resultado = $dao->crear(new Usuario(
        null, 
        $_POST['nombre'], 
        $_POST['apellido1'], 
        $_POST['apellido2'], 
        $_POST['correo'], 
        $_POST['usuario'], 
        $_POST['rol'], 
        $_POST['contrasena']
    ));
}

if ($resultado) {
    $_SESSION['msg'] = "alert-success--Usuario guardado exitosamente";
} else {
    $_SESSION['msg'] = "alert-danger--No se ha podido guardar el usuario. Por favor, inténtelo de nuevo.";
}

header("Location: listaUsuarios.php");
exit();
?>
