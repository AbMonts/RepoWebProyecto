<?php
session_start();
require_once '../datos/Conexion.php'; 
require_once '../modelos/Usuario.php'; 
require_once '../datos/DAOUsuario.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $mensaje = '';
    $tipo = '';

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
        if (empty($_POST['correo']) || !filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores['correo'] = "El correo es obligatorio y debe ser válido.";
        }
        if (empty($_POST['usuario'])) {
            $errores['usuario'] = "El nombre de usuario es obligatorio.";
        }
        if (empty($_POST['rol'])) {
            $errores['rol'] = "El rol es obligatorio.";
        }
        if (empty($_POST['contrasena']) || strlen($_POST['contrasena']) < 6) {
            $errores['contrasena'] = "La contraseña es obligatoria y debe tener al menos 6 caracteres.";
        }

        // Verificación de correo y usuario existentes
        if ($dao->obtenerPorCorreo($correo)) {
            $errores['correo'] = "El correo ya está en uso. Por favor, elige otro.";
        }
        if ($dao->obtenerPorUsuario($usuario)) {
            $errores['usuario'] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
        }

        if (count($errores) > 0) {
            $_SESSION['errores'] = $errores;
            $_SESSION['data'] = $_POST;
            header("Location: RegistroUsuarios.php?id=" . (isset($_POST['id']) ? $_POST['id'] : '')); // Redirigir al formulario con errores
            exit;
        }

        if ($id === null) { // Crear nuevo usuario
            if ($dao->agregar($usuarioObj)) {
                $mensaje = 'Se agregó un nuevo usuario correctamente :D';
                $tipo = 'success';
            } else {
                $mensaje = 'No pudo ser agregado el usuario :C';
                $tipo = 'error';
            }
        } else { // Actualizar usuario existente
            if ($dao->actualizar($usuarioObj)) {
                $mensaje = 'Se modificó el usuario correctamente :D';
                $tipo = 'success';
            } else {
                $mensaje = 'No pudo ser modificado el usuario :C';
                $tipo = 'error';
            }
        }
    } else {
        $mensaje = 'Faltan datos requeridos :C';
        $tipo = 'error';
    }

    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = $tipo;
    header("Location: listaUsuarios.php");
    exit();

} else {
    $mensaje = 'Método de solicitud no válido';
    $tipo = 'error';

    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = $tipo;
    header("Location: listaUsuarios.php");
    exit();
}
?>
