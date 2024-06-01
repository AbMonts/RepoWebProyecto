

<?php
require_once "../datos/DAOTareas.php";

$errores = [];
$titulo = $contenido = $fechainicio = $fechafin = "";
$isdone = 0;

// Validar y sanitizar entrada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idTarea = isset($_POST['idTarea']) ? intval($_POST['idTarea']) : 0;

    if (empty($_POST["titulo"]) || strlen($_POST["titulo"]) < 5) {
        $errores['titulo'] = "El título debe tener al menos 5 caracteres.";
    } else {
        $titulo = htmlspecialchars($_POST["titulo"]);
    }

    if (empty($_POST["contenido"])) {
        $errores['contenido'] = "El contenido es obligatorio.";
    } else {
        $contenido = htmlspecialchars($_POST["contenido"]);
    }

    if (empty($_POST["fechafin"])) {
        $errores['fechafin'] = "La fecha de fin es obligatoria.";
    } else {
        $fechafin = $_POST["fechafin"];
    }

    $fechainicio = !empty($_POST["fechainicio"]) ? $_POST["fechainicio"] : null;
    $isdone = isset($_POST['isdone']) ? 1 : 0;

    // Si no hay errores, actualizar la tarea
    if (empty($errores)) {
        $dao = new DAOTareas();
        $dao->actualizarTarea($idTarea, $titulo, $contenido, $fechainicio, $fechafin, $isdone);
        header("Location: Tareas.php");
        exit;
    }
} else {
    header("Location: Tareas.php");
    exit;
}
?>