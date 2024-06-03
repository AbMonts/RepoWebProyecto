<?php
session_start();
require_once '../datos/Conexion.php';
require_once '../modelos/Usuario.php';
require_once '../datos/DAOUsuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : null;
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $contrasena = $_POST['contrasena'];

    $errores = [];

    if (empty($id) || !is_numeric($id)) {
        $errores['id'] = "ID de usuario no válido.";
    }
    if (strlen($nombre) < 3) {
        $errores['nombre'] = "El nombre debe tener al menos 3 caracteres.";
    }
    if (empty($apellido1)) {
        $errores['apellido1'] = "El apellido paterno es obligatorio.";
    }
    if (empty($apellido2)) {
        $errores['apellido2'] = "El apellido materno es obligatorio.";
    }
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo no es válido.";
    }
    if (empty($rol) || !in_array($rol, ['admin', 'usuario'])) {
        $errores['rol'] = "El rol no es válido.";
    }
    if (empty($contrasena) || strlen($contrasena) < 6) {
        $errores['contrasena'] = "La contraseña debe tener al menos 6 caracteres.";
    }

    $dao = new DAOUsuario();
    $usuarioExistente = $dao->obtenerPorCorreo($correo);
    if ($usuarioExistente && $usuarioExistente->id != $id) {
        $errores['correo'] = "El correo ya está en uso. Por favor, elige otro.";
    }

    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        $_SESSION['data'] = $_POST;
        header("Location: EditarUsuario.php?id=" . (isset($_POST['id']) ? $_POST['id'] : ''));
        exit();
    } else {
        $usuarioObj = new Usuario();
        $usuarioObj->id = $id;
        $usuarioObj->nombre = $nombre;
        $usuarioObj->apellido1 = $apellido1;
        $usuarioObj->apellido2 = $apellido2;
        $usuarioObj->correo = $correo;
        $usuarioObj->rol = $rol;
        $usuarioObj->contrasena = $contrasena;

        if ($dao->actualizar($usuarioObj)) {
            $_SESSION['mensaje'] = 'Se modificó el usuario correctamente :D';
            $_SESSION['tipo'] = 'success';
        } else {
            $_SESSION['mensaje'] = 'No pudo ser modificado el usuario :C';
            $_SESSION['tipo'] = 'error';
        }
        header("Location: listaUsuarios.php");
        exit();
    }
} else {
    $_SESSION['mensaje'] = 'Método de solicitud no válido';
    $_SESSION['tipo'] = 'error';
    header("Location: listaUsuarios.php");
    exit();
}
?>
