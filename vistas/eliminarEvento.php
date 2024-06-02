<?php
require_once '../datos/DAOEventos.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación de existencia de parámetros
    if (!isset($_POST['id'])) {
        echo "Falta el parámetro 'id'";
        exit;
    }

    // Validación de tipo de dato
    $id = $_POST['id'];
    if (!is_numeric($id)) {
        echo "El parámetro 'id' debe ser un número";
        exit;
    }

    $dao = new DAOEvento();
    $result = $dao->eliminar($id);

    if ($result) {
        header('Location: eventos_usuario.php');
    } else {
        echo "Error al eliminar el evento";
    }
}
?>
