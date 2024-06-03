<?php
session_start();

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilos.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require("menuPrivado.php"); ?>

<div class="container pt-4">
  <h2>Notas</h2>
  
  <?php
    require_once '../datos/DAONotas.php';

    if (!isset($_SESSION['id'])) {
        die("Acceso denegado.");
    }

    $daoNotas = new DAONotas();
    $idUsuario = $_SESSION['id']; 
    $notas = $daoNotas->obtenerNotasPorUsuario($idUsuario);

    function validarLongitud($campo, $longitudMaxima) {
        return strlen($campo) <= $longitudMaxima;
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $mensaje = '';
        $tipo = '';

      if (isset($_POST['eliminarNotaId'])) {
          $notaId = filter_input(INPUT_POST, 'eliminarNotaId', FILTER_VALIDATE_INT);
          if ($notaId) {
              $resultado = $daoNotas->eliminarNota($notaId);
              if ($resultado) {
                  $mensaje = 'Nota eliminada con éxito.';
                  $tipo = 'success';
              } else {
                  $mensaje = 'Error al eliminar la nota.';
                  $tipo = 'error';
              }
          }
      }
  
    if (isset($_POST['modificarNotaId'], $_POST['titulo'], $_POST['contenido'])) {
      $notaId = filter_input(INPUT_POST, 'modificarNotaId', FILTER_VALIDATE_INT);
      $titulo = $_POST['titulo'];
      $contenido = $_POST['contenido'];

      if ($notaId && $titulo && $contenido && validarLongitud($titulo, 255) && validarLongitud($contenido, 1000)) {
          // Prevención de inyección SQL
          $titulo = htmlspecialchars($titulo);
          $contenido = htmlspecialchars($contenido);
          
          $resultado = $daoNotas->modificarNota($notaId, $titulo, $contenido);
          if ($resultado) {
              $mensaje = 'Nota modificada con éxito.';
              $tipo = 'success';
          } else {
              $mensaje = 'Error al modificar la nota.';
              $tipo = 'error';
          }
      }
  }

  //el de agregar nota el proceso se encuentra en ---> agregarNota.php
  
   

    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = $tipo;
    
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

if (isset($_SESSION['mensaje']) && isset($_SESSION['tipo'])) {
  $mensaje = htmlspecialchars($_SESSION['mensaje']);
  $tipo = htmlspecialchars($_SESSION['tipo']);
  unset($_SESSION['mensaje']);
  unset($_SESSION['tipo']);
  echo "<div id='alert' class='alert alert-{$tipo}'>{$mensaje}</div>";
}
  ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var alert = document.getElementById('alert');
        if (alert) {
            setTimeout(function() {
                alert.style.display = 'none';
            }, 5000); // Ocultar el mensaje después de 5 segundos
        }
    });
</script>
  <!-- Botón para abrir el modal -->
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#agregarNotaModal">
    Agregar Nota
  </button>
  <div>
  <a href="home.php" class="btn btn-secondary">Regresar</a>
  </div>
  
  <div id="notasContainer" class="row">
    <?php
      if ($notas) {
        foreach ($notas as $nota) {
          echo "
          <div class='col-12 col-md-6 mb-3'>
            <div class='card h-100'>
              <div class='card-header'>
                <h5 class='mb-0'>
                  " . htmlspecialchars($nota->titulo) . "
                </h5>
              </div>
              <div class='card-body'>
                <div class='accordion' id='accordionNota{$nota->id}'>
                  <div class='accordion-item'>
                    <h2 class='accordion-header' id='headingNota{$nota->id}'>
                      <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapseNota{$nota->id}' aria-expanded='false' aria-controls='collapseNota{$nota->id}'>
                        Ver contenido
                      </button>
                   
                      </h2>
                      <div id='collapseNota{$nota->id}' class='accordion-collapse collapse' aria-labelledby='headingNota{$nota->id}' data-bs-parent='#accordionNota{$nota->id}'>
                        <div class='accordion-body'>
                          <p>" . htmlspecialchars($nota->contenido) . "</p>
                          <a href='descargarNota.php?id=" . $nota->id . "' class='btn btn-primary' download><i class='fas fa-download'></i> Descargar</a>
                          <button class='btn btn-danger ms-2' onclick='confirmarEliminarNota(" . $nota->id . ")'><i class='fas fa-trash'></i> Eliminar</button>
                          <button class='btn btn-warning ms-2' onclick='modificarNota(" . $nota->id . ", \"" . htmlspecialchars($nota->titulo) . "\", \"" . htmlspecialchars($nota->contenido) . "\")'><i class='fas fa-edit'></i> Modificar</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>";
          }
        } else {
          echo "<div class='alert alert-warning'>No hay notas disponibles</div>";
        }
      ?>
    </div>
  </div>
  
  <!-- Modal para agregar nota -->
  <div class="modal fade" id="agregarNotaModal" tabindex="-1" aria-labelledby="agregarNotaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="agregarNotaModalLabel">Agregar Nota</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAgregarNota" method="post" action="agregarNota.php" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="titulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="titulo" name="titulo" >
            </div>
            <div class="mb-3">
              <label for="contenido" class="form-label">Contenido</label>
              <textarea class="form-control" id="contenido" name="contenido" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label for="archivoNota" class="form-label">O cargar desde archivo</label>
              <input type="file" class="form-control" id="archivoNota" name="archivoNota" accept=".txt">
            </div>
            <input type="hidden" name="idUsuario" value="<?php echo htmlspecialchars($idUsuario); ?>">
            <button type="submit" class="btn btn-primary">Guardar Nota</button>
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
          ¿Está seguro de que desea eliminar esta nota?
        </div>
        <div class="modal-footer">
          <form id="formEliminarNota" method="post" action="">
            <input type="hidden" name="eliminarNotaId" id="eliminarNotaId">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Eliminar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Modal para modificar nota -->
  <div class="modal fade" id="modificarNotaModal" tabindex="-1" aria-labelledby="modificarNotaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modificarNotaModalLabel">Modificar Nota</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formModificarNota" method="post" action="">
            <input type="hidden" name="modificarNotaId" id="modificarNotaId">
            <div class="mb-3">
              <label for="modificarTitulo" class="form-label">Título</label>
              <input type="text" class="form-control" id="modificarTitulo" name="titulo" >
            </div>
            <div class="mb-3">
              <label for="modificarContenido" class="form-label">Contenido</label>
              <textarea class="form-control" id="modificarContenido" name="contenido" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/notas.js"></script>
  
  </body>
  </html>
