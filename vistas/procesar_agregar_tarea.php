<?php
session_start();

if (!isset($_SESSION["id"])) {
    header('Location: Index.php');
    exit;
}

$usuarioId = $_SESSION["id"];
$errores = [];

// Validaciones del lado del servidor
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $fechainicio = trim($_POST['fechainicio']);
    $fechafin = trim($_POST['fechafin']);
    $usuarioId = trim($_POST['usuarioId']);

    if (strlen($titulo) < 5) {
        $errores[] = "El título debe tener al menos 5 caracteres.";
    }

    if (empty($contenido)) {
        $errores[] = "El contenido es obligatorio.";
    }

    if (empty($fechafin)) {
        $errores[] = "La fecha de fin es obligatoria.";
    }

    if (empty($errores)) {
        // Procesar los datos y guardarlos en la base de datos
        require_once "../datos/DAOTareas.php";
        $dao = new DAOTareas();
        $nuevaTarea = $dao->agregarTarea($titulo, $contenido, $fechainicio, $fechafin, $usuarioId);

        if ($nuevaTarea) {
            header('Location: tareas.php');
            exit;
        } else {
            $errores[] = "Hubo un problema al guardar la tarea.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agregar Tarea</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<?php require("menuPrivado.php"); ?>

<div class="container pt-4">
    <h2>Agregar Nueva Tarea</h2>
    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errores as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="procesar_agregar_tarea.php" method="POST">
        <div class="mb-3">
            <label for="titulo" class="form-label">Titulo</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($titulo ?? ''); ?>">
        </div>
        <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="10"><?php echo htmlspecialchars($contenido ?? ''); ?></textarea>
        </div>

        <div class="mb-3">
            <label for="fechainicio" class="form-label">Fecha Inicio</label>
            <input type="datetime-local" class="form-control" id="fechainicio" name="fechainicio" value="<?php echo htmlspecialchars($fechainicio ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="fechafin" class="form-label">Fecha Fin</label>
            <input type="datetime-local" class="form-control" id="fechafin" name="fechafin" value="<?php echo htmlspecialchars($fechafin ?? ''); ?>">
        </div>

        <input type="hidden" name="usuarioId" value="<?php echo htmlspecialchars($usuarioId); ?>">

        <button type="submit" class="btn btn-primary">Agregar Tarea</button>
        <a href="tareas.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
