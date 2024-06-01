<?php
session_start();
require_once '../datos/Conexion.php';
require_once '../modelos/Usuario.php';
require_once '../datos/DAOUsuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $nombre = trim($_POST['nombre']) ?? "";
    $correo = trim($_POST['correo']) ?? "";
    $usuario = trim($_POST['usuario']) ?? "";
    $apellido1 = trim($_POST['apellido1']) ?? "";
    $apellido2 = trim($_POST['apellido2']) ?? "";
    $rol = trim($_POST['rol']) ?? "";
    $contrasena = trim($_POST['contrasena']) ?? "";

    $errores = [];

    if (empty($id) || !is_numeric($id)) {
        $errores['id'] = "ID de usuario no válido.";
    }
    if (empty($nombre)) {
        $errores['nombre'] = "El nombre es obligatorio.";
    }
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = "El correo no es válido.";
    }
    if (empty($usuario) || strlen($usuario) < 3) {
        $errores['usuario'] = "El usuario es obligatorio y debe tener al menos 3 caracteres.";
    }
    if (empty($apellido1)) {
        $errores['apellido1'] = "El apellido paterno es obligatorio.";
    }
    if (empty($apellido2)) {
        $errores['apellido2'] = "El apellido materno es obligatorio.";
    }
    if (empty($rol) || !in_array($rol, ['admin', 'usuario'])) {
        $errores['rol'] = "El rol no es válido.";
    }
    if (empty($contrasena) || strlen($contrasena) < 6) {
        $errores['contrasena'] = "La contraseña debe tener al menos 6 caracteres.";
    }

    if (count($errores) > 0) {
        $_SESSION['errores'] = $errores;
        $_SESSION['data'] = $_POST;
        header("Location: EditarUsuario.php?id=" . htmlspecialchars($id));
        exit;
    } else {
        $dao = new DAOUsuario();
        $obj = new Usuario();
        $obj->id = $id;
        $obj->nombre = $nombre;
        $obj->correo = $correo;
        $obj->usuario = $usuario;
        $obj->apellido1 = $apellido1;
        $obj->apellido2 = $apellido2;
        $obj->rol = $rol;
        $obj->contrasena = $contrasena;

        if ($dao->actualizar($obj)) {
            $_SESSION["msg"] = "Usuario actualizado exitosamente :D";
            header("Location: listaUsuarios.php");
            exit;
        } else {
            $_SESSION["msg"] = "No se ha podido actualizar al usuario :(";
            header("Location: EditarUsuario.php?id=" . htmlspecialchars($id));
            exit;
        }
    }
} else {
    echo "Método de solicitud no permitido.";
}
?>
