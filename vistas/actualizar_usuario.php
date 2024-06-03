<?php
session_start();
require_once '../datos/Conexion.php';
require_once '../modelos/Usuario.php';
require_once '../datos/DAOUsuario.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $mensaje = '';
    $tipo = '';

    if (isset($_POST['nombre']) && !empty($_POST['nombre']) &&
        isset($_POST['apellido1']) && !empty($_POST['apellido1']) &&
        isset($_POST['apellido2']) && !empty($_POST['apellido2']) &&
        isset($_POST['correo']) && !empty($_POST['correo']) &&
        isset($_POST['rol']) && !empty($_POST['rol']) &&
        isset($_POST['contrasena']) && !empty($_POST['contrasena'])) {

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
        if (empty($nombre)) {
            $errores['nombre'] = "El nombre es obligatorio.";
        }
        if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $errores['correo'] = "El correo no es válido.";
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

        // Verifica si el correo ya existe
        $dao = new DAOUsuario();
        if ($dao->obtenerPorCorreo($correo)) {
            $errores['correo'] = "El correo ya está en uso. Por favor, elige otro.";
        }

        if (count($errores) > 0) {
            $_SESSION['errores'] = $errores;
            $_SESSION['data'] = $_POST;
            header("Location: EditarUsuario.php?id=" . htmlspecialchars($id));
            exit;
        } else {
            $usuarioObj = new Usuario();
            $usuarioObj->id = $id;
            $usuarioObj->nombre = $nombre;
            $usuarioObj->correo = $correo;
            $usuarioObj->apellido1 = $apellido1;
            $usuarioObj->apellido2 = $apellido2;
            $usuarioObj->rol = $rol;
            $usuarioObj->contrasena = $contrasena;

            if ($dao->actualizar($usuarioObj)) {
                $mensaje =  "Usuario actualizado exitosamente :D";
                $tipo = 'success';
            } else {
                $mensaje =  "Error al actualizar el usuario";
                $tipo = 'error';
            }
        }
    } else {
        $mensaje =  "Faltan datos por llenar";
        $tipo = 'error';
    }

    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = $tipo;
    
    header("Location: listaUsuarios.php");
    exit();

} else {
    $mensaje =  "Método de solicitud no válido";
    $tipo = 'error';
}
$_SESSION['mensaje'] = $mensaje;
$_SESSION['tipo'] = $tipo;

header("Location: listaUsuarios.php");
exit();
?>
