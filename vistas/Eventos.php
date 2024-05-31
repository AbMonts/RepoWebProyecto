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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminarEventoId'])) {
        $eventoId = $_POST['eliminarEventoId'];
        $resultado = $dao->eliminar($eventoId);
        if ($resultado) {
            echo "<div class='alert alert-success'>El evento ha sido eliminado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>No se pudo eliminar el evento.</div>";
        }
    } elseif (isset($_POST['modificarEventoId'])) {
        $eventoId = $_POST['modificarEventoId'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $resultado = $dao->actualizar($eventoId, $titulo, $descripcion, $fechainicio, $fechafin, $idUsuario);
        if ($resultado) {
            echo "<div class='alert alert-success'>El evento ha sido modificado exitosamente.</div>";
        } else {
            echo "<div class='alert alert-danger'>No se pudo modificar el evento.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos del Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
</head>
<body>
<?php require("menuPrivado.php"); ?>

<div class="container mt-5">
    <h1 class="mb-4">Eventos del Usuario</h1>
    <a href="home.php" class="btn btn-secondary mb-4">Regresar</a>
    <button type="button" class="btn btn-primary mb-4 ml-5" data-bs-toggle="modal" data-bs-target="#agregarEventoModal">
        Agregar Evento
    </button>
   

    <div class="list-group">
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

<!-- Modal para agregar evento -->
<div class="modal fade" id="agregarEventoModal" tabindex="-1" aria-labelledby="agregarEventoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agregarEventoModalLabel">Agregar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarEvento" method="post" action="agregarEvento.php">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fechainicio" class="form-label">Fecha de Inicio</label>
                        <input type="datetime-local" class="form-control" id="fechainicio" name="fechainicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechafin" class="form-label">Fecha de Fin</label>
                        <input type="datetime-local" class="form-control" id="fechafin" name="fechafin" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Evento</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro de que desea eliminar este evento?
            </div>
            <div class="modal-footer">
                <form id="formEliminarEvento" method="post" action="">
                    <input type="hidden" name="eliminarEventoId" id="eliminarEventoId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para modificar evento -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="modificarEventoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarEventoModalLabel">Modificar Evento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formModificarEvento" method="post" action="">
                    <input type="hidden" name="modificarEventoId" id="modificarEventoId">
                    <div class="mb-3">
                        <label for="modificarTitulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="modificarTitulo" name="titulo" required>
                    </div>
                    <div class="mb-3">
                        <label for="modificarDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="modificarDescripcion" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="modificarFechaInicio" class="form-label">Fecha de Inicio</label>
                        <input type="datetime-local" class="form-control" id="modificarFechaInicio" name="fechainicio" required>
                    </div>
                    <div class="mb-3">
                        <label for="modificarFechaFin" class="form-label">Fecha de Fin</label>
                        <input type="datetime-local" class="form-control" id="modificarFechaFin" name="fechafin" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        new Sortable(document.getElementsByClassName('list-group')[0], {
            animation: 150,
            ghostClass: 'bg-light'
        });
    });

    function confirmarEliminarEvento(id) {
        const eliminarEventoIdInput = document.getElementById('eliminarEventoId');
        eliminarEventoIdInput.value = id;
        const confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
        confirmarEliminarModal.show();
    }

    function modificarEvento(id, titulo, descripcion, fechainicio, fechafin) {
        const modificarEventoIdInput = document.getElementById('modificarEventoId');
        const modificarTituloInput = document.getElementById('modificarTitulo');
        const modificarDescripcionInput = document.getElementById('modificarDescripcion');
        const modificarFechaInicioInput = document.getElementById('modificarFechaInicio');
        const modificarFechaFinInput = document.getElementById('modificarFechaFin');

        modificarEventoIdInput.value = id;
        modificarTituloInput.value = titulo;
        modificarDescripcionInput.value = descripcion;
        modificarFechaInicioInput.value = fechainicio;
        modificarFechaFinInput.value = fechafin;

        const modificarEventoModal = new bootstrap.Modal(document.getElementById('editModal'));
        modificarEventoModal.show();
    }

    document.querySelectorAll('.list-group-item').forEach(item => {
        item.addEventListener('click', event => {
            const id = item.getAttribute('data-id');
            const titulo = item.getAttribute('data-titulo');
            const descripcion = item.getAttribute('data-descripcion');
            const fechainicio = item.getAttribute('data-fechainicio');
            const fechafin = item.getAttribute('data-fechafin');
            modificarEvento(id, titulo, descripcion, fechainicio, fechafin);
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
