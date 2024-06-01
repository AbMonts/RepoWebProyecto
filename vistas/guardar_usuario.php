<?php
session_start();
require_once("../datos/DAOUsuario.php");

$errores = [];
$usuario = new Usuario(
    $_POST['id'] ?? null,
    $_POST['nombre'] ?? '',
    $_POST['apellido1'] ?? '',
    $_POST['apellido2'] ?? '',
    $_POST['correo'] ?? '',
    $_POST['usuario'] ?? '',
    $_POST['rol'] ?? '',
    $_POST['contrasena'] ?? ''
);

// Validación de los campos
if (empty($usuario->nombre)) {
    $errores['nombre'] = "El nombre es obligatorio.";
}
if (empty($usuario->apellido1)) {
    $errores['apellido1'] = "El primer apellido es obligatorio.";
}
if (empty($usuario->apellido2)) {
    $errores['apellido2'] = "El segundo apellido es obligatorio.";
}
if (empty($usuario->correo)) {
    $errores['correo'] = "El correo es obligatorio.";
}
if (empty($usuario->usuario)) {
    $errores['usuario'] = "El nombre de usuario es obligatorio.";
}
if (empty($usuario->rol)) {
    $errores['rol'] = "El rol es obligatorio.";
}
if (empty($usuario->contrasena)) {
    $errores['contrasena'] = "La contraseña es obligatoria.";
}

if (count($errores) > 0) {
    $_SESSION['errores'] = $errores;
    header("Location: listaUsuarios.php?id=" . $usuario->id); //que mande al form de editar o eliminar dependiendo si se recibio un id
    exit;
} else {
    $dao = new DAOUsuario();
    if ($usuario->id) {
        // Editar usuario existente
        if ($dao->actualizar($usuario)) {
            $_SESSION["msg"] = "alert-success--Usuario actualizado exitosamente :D";
        } else {
            $_SESSION["msg"] = "alert-danger--No se ha podido actualizar al usuario :(";
        }
    } else {
        // Agregar nuevo usuario
        if ($dao->agregar($usuario)) {
            $_SESSION["msg"] = "alert-success--Usuario agregado exitosamente :D";
        } else {
            $_SESSION["msg"] = "alert-danger--No se ha podido agregar al usuario :(";
        }
    }
    header("Location: listaUsuarios.php");
}
?>

