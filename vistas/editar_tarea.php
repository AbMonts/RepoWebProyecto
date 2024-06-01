<?php
session_start();
require_once "../datos/DAOTareas.php";

$errores = [];
$titulo = $contenido = $fechainicio = $fechafin = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idTarea = $_POST['idTarea'];
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $fechainicio = trim($_POST['fechainicio']);
    $fechafin = trim($_POST['fechafin']);
    $isdone = trim($_POST['isdone']) ? 1 : 0;
    

    if (strlen($titulo) < 5) {
        $errores['titulo'] = "El título debe tener al menos 5 caracteres.";
    }

    if (empty($contenido)) {
        $errores['contenido'] = "El contenido es obligatorio.";
    }

    if (empty($fechafin)) {
        $errores['fechafin'] = "La fecha de fin es obligatoria.";
    } if ($fechafin < $fechainicio) {
        $errores['fechafin'] = "La fecha de fin no puede ser anterior a la fecha de inicio.";
    }

    if (empty($errores)) {
        $dao = new DAOTareas();
        $actualizada = $dao->actualizarTarea($idTarea, $titulo, $contenido, $fechainicio, $fechafin,  $isdone);

        if ($actualizada) {
            header('Location: Tareas.php');
            exit;
        } else {
            $errores['general'] = "Hubo un problema al actualizar la tarea.";
        }
    }
} else {
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $idTarea = $_GET['id'];
        $dao = new DAOTareas();
        $tarea = $dao->obtenerTareaPorId($idTarea);

        if (!$tarea) {
            echo "Tarea no encontrada";
            exit;
        }

        $titulo = $tarea->titulo;
        $contenido = $tarea->contenido;
        $fechainicio = $tarea->fechainicio;
        $fechafin = $tarea->fechafin;
        $isdone = $tarea->isdone;
    } else {
        echo "ID de tarea no válido";
        exit;
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Tarea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="css/estilos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/validarFormulario.js" defer></script>
</head>
<body>
<?php require("menuPrivado.php"); ?>

<div class="container pt-4">
    <h2>Editar Tarea</h2>
    <?php if (!empty($errores['general'])): ?>
        <div class="alert alert-danger">
            <p><?php echo htmlspecialchars($errores['general']); ?></p>
        </div>
    <?php endif; ?>
    <form action="editar_tarea.php?id=<?php echo htmlspecialchars($idTarea); ?>" method="POST" onsubmit="return validarFormulario();">
        <input type="hidden" name="idTarea" value="<?php echo htmlspecialchars($idTarea); ?>">

        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo); ?>" >
            <span class="text-danger" id="error-titulo"></span>
        </div>

        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="6"><?php echo htmlspecialchars($contenido); ?></textarea>
            <span class="text-danger" id="error-contenido"></span>
        </div>

        <div class="mb-3">
            <label for="fechainicio" class="form-label">Fecha Inicio</label>
            <input type="datetime-local" class="form-control" id="fechainicio" name="fechainicio" value="<?php echo htmlspecialchars($fechainicio); ?>">
            <span class="text-danger" id="error-fechainicio"></span>
        </div>

        <div class="mb-3">
            <label for="fechafin" class="form-label">Fecha Fin</label>
            <input type="datetime-local" class="form-control" id="fechafin" name="fechafin" value="<?php echo htmlspecialchars($fechafin); ?>" required>
            <span class="text-danger" id="error-fechafin"></span>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="isdone" name="isdone" <?php echo  $isdone ? 'checked' : ''; ?>>
            <label class="form-check-label" for="isdone">¿Completada?</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="Tareas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/editarTareas.js"></script>
</body>
</html>
