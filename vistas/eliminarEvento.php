<?php
require_once '../datos/DAOEventos.php';
session_start();

if (!isset($_SESSION['id'])) {
    echo "Usuario no autenticado";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $dao = new DAOEvento();
    $result = $dao->eliminar($id);

    if ($result) {
        header('Location: eventos_usuario.php');
    } else {
        echo "Error al eliminar el evento";
    }
}
?>
