<?php
require_once "../datos/DAOTareas.php";

// Verifica si se ha pasado un ID de tarea por la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $idTarea = $_GET['id'];
    $dao = new DAOTareas();
    $tarea = $dao->obtenerTareaPorId($idTarea);

    // Si no se encuentra la tarea, redirige o muestra un error
    if (!$tarea) {
        echo "Tarea no encontrada";
        exit;
    }
} else {
    echo "ID de tarea no valido";
    exit;
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
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/estilos.css">
    <link  href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require("menuPrivado.php"); ?>

<div class="container pt-4">
    <h2>Editar Tarea</h2>
    <form action="actualizar_tarea.php" method="POST">
        <input type="hidden" name="idTarea" value="<?php echo htmlspecialchars($tarea->id); ?>">

        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($tarea->titulo); ?>" required>
        </div>


        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="6" required><?php echo htmlspecialchars($tarea->contenido); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="fechainicio" class="form-label">Fecha Inicio</label>
            <input type="datetime-local" class="form-control" id="fechainicio" name="fechainicio" value="<?php echo htmlspecialchars($tarea->fechainicio); ?>">
        </div>

        <div class="mb-3">
            <label for="fechafin" class="form-label">Fecha Fin</label>
            <input type="datetime-local" class="form-control" id="fechafin" name="fechafin" value="<?php echo htmlspecialchars($tarea->fechafin); ?>" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="isdone" name="isdone" <?php echo $tarea->isdone ? 'checked' : ''; ?>>
            <label class="form-check-label" for="isdone">¿Completada?</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="tareas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
