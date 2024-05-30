<?php
require_once "../datos/DAOTareas.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['idTarea']) && is_numeric($_POST['idTarea']) &&
        isset($_POST['titulo']) &&
        isset($_POST['contenido']) && isset($_POST['fechainicio']) &&
        isset($_POST['fechafin'])) {

        $idTarea = $_POST['idTarea'];
        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $isdone = isset($_POST['isdone']) ? 1 : 0;

        $dao = new DAOTareas();
        $resultado = $dao->actualizarTarea($idTarea, $titulo, $contenido, $fechainicio, $fechafin, $isdone);

        if ($resultado) {
            session_start();
            $_SESSION["msg"] = "alert-success--Tarea actualizada exitosamente";
        } else {
            session_start();
            $_SESSION["msg"] = "alert-danger--Error al actualizar la tarea";
        }

        header("Location: tareas.php");
        exit;
    } else {
        echo "Datos incompletos";
        exit;
    }
} else {
    echo "Método no permitido";
    exit;
}
?>
