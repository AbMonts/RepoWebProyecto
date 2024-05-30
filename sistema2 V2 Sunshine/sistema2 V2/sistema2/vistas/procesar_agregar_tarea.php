<?php
require_once "../datos/DAOTareas.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['titulo']) &&
        isset($_POST['contenido']) && isset($_POST['fechainicio']) &&
        isset($_POST['fechafin']) && isset($_POST['usuarioId'])) {

        $titulo = $_POST['titulo'];
        $contenido = $_POST['contenido'];
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $usuarioId = $_POST['usuarioId'];

        $dao = new DAOTareas();
        $resultado = $dao->agregarTarea($titulo, $contenido, $fechainicio, $fechafin, $usuarioId);

        if ($resultado) {
            $_SESSION["msg"] = "alert-success--Tarea agregada exitosamente";
        } else {
            $_SESSION["msg"] = "alert-danger--Error al agregar la tarea";
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
