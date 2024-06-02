<?php
require_once '../datos/DAOEventos.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "Usuario no autenticado";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
    $fechaInicio = $_POST['fechainicio'];
    $fechaFin = $_POST['fechafin'];
    $idUsuario = $_SESSION['id'];

    // Validación de integridad de datos
    if (!$id || !$titulo || !$descripcion || !$fechaInicio || !$fechaFin) {
        echo "Faltan datos requeridos";
        exit;
    }

    // Validación de longitud
    if (strlen($titulo) < 3 || strlen($titulo) > 100) {
        echo "El título debe tener entre 3 y 100 caracteres.";
        exit;
    }
    
    if (strlen($descripcion) < 10 || strlen($descripcion) > 500) {
        echo "La descripción debe tener entre 10 y 500 caracteres.";
        exit;
    }

    // Validación de formato de fecha
    if (!strtotime($fechaInicio) || !strtotime($fechaFin)) {
        echo "Formato de fecha inválido";
        exit;
    }

    // Aquí puedes continuar con el resto del código, como la actualización del evento en la base de datos.
    $dao = new DAOEvento();
    $result = $dao->actualizar($id, $titulo, $descripcion, $fechaInicio, $fechaFin, $idUsuario);

    if ($result) {
        header('Location: eventos_usuario.php');
    } else {
        echo "Error al actualizar el evento";
    }
}
?>
