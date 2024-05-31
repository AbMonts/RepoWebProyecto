<?php

session_start();
require_once '../datos/DAOEventos.php';

if (!isset($_SESSION['id'])) {
    echo "<div class='alert alert-danger'>Usuario no autenticado</div>";
    exit;
}

$idUsuario = $_SESSION['id'];

$dao = new DAOEvento();
$eventos = $dao->obtenerPorId($idUsuario);

if (!$eventos) {
    $eventos = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" integrity="sha512-Rfdu1c2/8/1hrbiSFT8+P+57odUXcFGmTfJmvjVOhdQgi1+xW6BfW8I/TPZMb/gAjTxXZ8ykA69hYbfPoc3PA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require("menuPrivado.php"); ?>
<div class="container mt-5">
    <h1 class="mb-4">Eventos del Usuario</h1>
    <div class="list-group">
        <!-- Iteramos sobre los eventos del usuario -->
        <?php
        foreach ($eventos as $evento) {
            echo '<a href="#" class="list-group-item list-group-item-action" data-bs-toggle="modal" 
            data-bs-target="#editModal" data-id="' 
            . $evento->id . '" data-titulo="' 
            . htmlspecialchars($evento->titulo) .'" data-descripcion="' 
             . htmlspecialchars($evento->descripcion) . '" data-fechainicio="' 
             . htmlspecialchars($evento->fechainicio) . '" data-fechafin="' 
             . htmlspecialchars($evento->fechafin) . '">' 
             . htmlspecialchars($evento->titulo) . '</a>';
        }
        ?>
    </div>
</div>

<!-- Modal para editar evento -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editEventForm" method="POST" action="editarEvento.php">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Editar Evento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editEventId">
                    <div class="mb-3">
                        <label for="editEventTitle" class="form-label">Título</label>
                        <input type="text" class="form-control" id="editEventTitle" value= "" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEventDescription" class="form-label">Descripción</label>
                        <textarea class="form-control" id="editEventDescription" name="descripcion"  value= "" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="editEventStartDate" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="editEventStartDate" value= "" name="fechainicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEventEndDate" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="editEventEndDate" value= "" name="fechafin" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <button type="button" class="btn btn-danger" id="deleteEventButton">Eliminar</button>
                </div>
            </form>
            <form id="deleteEventForm" method="POST" action="eliminar_evento.php" style="display:none;">
                <input type="hidden" name="id" id="deleteEventId">
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
