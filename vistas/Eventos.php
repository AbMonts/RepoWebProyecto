<?php
session_start();
require_once '../datos/DAOEventos.php';

if (!isset($_SESSION['id'])) {
    echo "<div class='alert alert-danger'>Usuario no autenticado</div>";
    header('Location: index.php');
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
            $_SESSION['mensaje'] = 'El evento ha sido eliminado exitosamente.';
        } else {
            $_SESSION['mensaje'] = 'No se pudo eliminar el evento.';
        }
        header('Location: Eventos.php');
        exit;
    } elseif (isset($_POST['modificarEventoId'])) {
        $eventoId = $_POST['modificarEventoId'];
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $idUsuario = $_POST['idUsuario'];
        $resultado = $dao->actualizar($eventoId, $titulo, $descripcion, $fechainicio, $fechafin, $idUsuario);
        if ($resultado) {
            $_SESSION['mensaje'] = 'El evento ha sido modificado exitosamente.';
        } else {
            $_SESSION['mensaje'] = 'No se pudo modificar el evento.';
        }
        header('Location: Eventos.php');
        exit;
    } elseif (isset($_POST['agregarEvento'])) {
        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $fechainicio = $_POST['fechainicio'];
        $fechafin = $_POST['fechafin'];
        $resultado = $dao->agregar($titulo, $descripcion, $fechainicio, $fechafin, $idUsuario);
        if ($resultado) {
            $_SESSION['mensaje'] = 'El evento ha sido agregado exitosamente.';
        } else {
            $_SESSION['mensaje'] = 'No se pudo agregar el evento.';
        }
        header('Location: Eventos.php');
        exit;
    }
}

$mensaje = '';
if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
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
    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>
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
                <form id="formAgregarEvento" method="post" action="">
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
                    <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
                    <input type="hidden" name="agregarEvento" value="1">
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
                    <button type="submit" class="btn btn-danger" onclick="cerrarModal('confirmarEliminarModal')">Eliminar</button>
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
                    <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario; ?>">
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
                <button type="button" class="btn btn-danger mt-3" onclick="confirmarEliminar()">Eliminar Evento</button>
            </div>
        </div>
    </div>
</div>

<script>
function modificarEvento(id, titulo, descripcion, fechainicio, fechafin) {
    const modificarEventoIdInput = document.getElementById('modificarEventoId');
    const modificarTituloInput = document.getElementById('modificarTitulo');
    const modificarDescripcionInput = document.getElementById('modificarDescripcion');
    const modificarFechaInicioInput = document.getElementById('modificarFechaInicio');
    const modificarFechaFinInput = document.getElementById('modificarFechaFin');
    const idUsuarioInput = document.getElementById('idUsuario');

    modificarEventoIdInput.value = id;
    modificarTituloInput.value = titulo;
    modificarDescripcionInput.value = descripcion;
    modificarFechaInicioInput.value = fechainicio;
    modificarFechaFinInput.value = fechafin;
    idUsuarioInput.value = "<?php echo $idUsuario; ?>";

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

function confirmarEliminar() {
    const modificarEventoIdInput = document.getElementById('modificarEventoId').value;
    const eliminarEventoIdInput = document.getElementById('eliminarEventoId');
    eliminarEventoIdInput.value = modificarEventoIdInput;
    
    const confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
    confirmarEliminarModal.show();
}

function cerrarModal(modalId) {
    const modal = new bootstrap.Modal(document.getElementById(modalId));
    modal.hide();
}

document.getElementById('formEliminarEvento').addEventListener('submit', function(event) {
    cerrarModal('editModal');
    cerrarModal('confirmarEliminarModal');
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
