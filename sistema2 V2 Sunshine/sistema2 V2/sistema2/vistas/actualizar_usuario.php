<?php
require_once '../datos/Conexion.php';
require_once '../modelos/Usuario.php';
require_once '../datos/DAOUsuario.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id']) &&
        isset($_POST['nombre']) && !empty($_POST['nombre']) &&
        isset($_POST['correo']) && !empty($_POST['correo']) &&
        isset($_POST['apellido1']) && !empty($_POST['apellido1']) &&
        isset($_POST['apellido2']) && !empty($_POST['apellido2']) &&
        isset($_POST['rol']) && !empty($_POST['rol']) &&
        isset($_POST['contrasena']) && !empty($_POST['contrasena'])) {

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $apellido1 = $_POST['apellido1'];
        $apellido2 = $_POST['apellido2'];
        $rol = $_POST['rol'];
        $contrasena = $_POST['contrasena'];

        $dao = new DAOUsuario();
        $usuarioObj = new Usuario();
        $usuarioObj->id = $id;
        $usuarioObj->nombre = $nombre;
        $usuarioObj->correo = $correo;
        $usuarioObj->apellido1 = $apellido1;
        $usuarioObj->apellido2 = $apellido2;
        $usuarioObj->rol = $rol;
        $usuarioObj->contrasena = $contrasena;

        if ($dao->actualizar($usuarioObj)) {
            $_SESSION['msg'] = "alert-success--Usuario actualizado exitosamente";
        } else {
            $_SESSION['msg'] = "alert-danger--Error al actualizar el usuario";
        }
    } else {
        $_SESSION['msg'] = "alert-danger--Faltan datos requeridos";
    }
} else {
    $_SESSION['msg'] = "alert-danger--Método de solicitud no válido";
}

header("Location: listaUsuarios.php");
exit();
