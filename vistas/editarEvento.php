<?php
require_once '../datos/DAOEventos.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "Usuario no autenticado";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fechaInicio = $_POST['fechainicio'];
    $fechaFin = $_POST['fechafin'];
    $idUsuario = $_SESSION['id'];

    $dao = new DAOEvento();
    $result = $dao->actualizar($id, $titulo, $descripcion, $fechaInicio, $fechaFin, $idUsuario);

    if ($result) {
        header('Location: eventos_usuario.php');
    } else {
        echo "Error al actualizar el evento";
    }
}
?>
