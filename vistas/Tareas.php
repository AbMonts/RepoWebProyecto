<?php
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
    require_once "../datos/DAOTareas.php";
    ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tareas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9oFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilos.css">
  <link  href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    .task-column {
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  <?php require("menuPrivado.php"); ?>

  <div class="container pt-4">
    <?php
   

    if (!isset($_SESSION['id'])) {
      die("Acceso denegado.");
  }
  if (!isset($_SESSION['id'])) {
      echo "<div class='alert alert-danger'>Usuario no autenticado</div>";
      header('Location: index.php');
      exit;
  }
      $userId = $_SESSION['id'];
     
      $dao = new DAOTareas();
      $lista = $dao->obtenerTareas($userId);

      $porHacer = [];
      $hechas = [];

      if ($lista) {
        foreach ($lista as $tarea) {
          if ($tarea->isdone) {
            $hechas[] = $tarea;
          } else {
            $porHacer[] = $tarea;
          }
        }
      }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["id"]) && is_numeric($_POST["id"])) {
     
      $mensaje = '';
      $tipo = '';

      $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
      if ($id === false) {
        echo "<div class='alert alert-danger'>ID de tarea inválido</div>";
      } else { //si recibe el server el id correcto en su totalidad,
        $dao = new DAOTareas();
        if ($dao->eliminarTarea($id)) {
          $mensaje  = "Tarea eliminada exitosamente :D";
          $tipo = 'success';
        } else {
          $mensaje = "No se ha podido eliminar la tarea deseada :C";
          $tipo = 'error';
        }
      }

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
    <div class= "my-5">
     <h2>Tareas</h2> <!--   ...........................     ................................................ -->
 
   
    <div class="button-group my-3">
      <a href="home.php" class="btn btn-secondary">Regresar</a>
      <a href="agregar_tarea.php" class="btn btn-primary">Agregar</a>
    </div>

    <div class="accordion" id="accordionExample">
      <?php 
    
      ?>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingPorHacer">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePorHacer" aria-expanded="true" aria-controls="collapsePorHacer">
           ----- Tareas por hacer --------
          </button>
        </h2>
        <div id="collapsePorHacer" class="accordion-collapse collapse show" aria-labelledby="headingPorHacer" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <?php if (count($porHacer) > 0): ?>
              <div class="row">
                <?php foreach ($porHacer as $index => $tarea): ?>
                  <div class="col-sm-6 task-column">
                    <div class="card">
                      <div class="card-header" id="headingPorHacer<?php echo $index; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePorHacer<?php echo $index; ?>" aria-expanded="false" aria-controls="collapsePorHacer<?php echo $index; ?>">
                          <!-- <input type="checkbox" class="me-2" aria-label="Checkbox for following text input" <?php echo $tarea->isdone ? 'checked' : ''; ?>> -->
                          <?php echo htmlspecialchars($tarea->titulo); ?>
                        </button>
                      </div>
                      <div id="collapsePorHacer<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="headingPorHacer<?php echo $index; ?>" data-bs-parent="#collapsePorHacer">
                        <div class="card-body">
                          <strong><?php echo htmlspecialchars($tarea->titulo); ?></strong><br>
                          <?php echo htmlspecialchars($tarea->contenido); ?><br>
                          <small>Fecha inicio: <?php echo htmlspecialchars($tarea->fechainicio); ?></small><br>
                          <small>Fecha fin: <?php echo htmlspecialchars($tarea->fechafin); ?></small><br>
                          <div class="button-group mt-3">
                            <a href="editar_tarea.php?id=<?php echo $tarea->id; ?>" class="btn btn-primary">Editar</a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#mdlEliminar" data-id="<?php echo $tarea->id; ?>" data-nombre="<?php echo htmlspecialchars($tarea->titulo); ?>">Eliminar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="alert alert-warning">No hay tareas por hacer disponibles</div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="accordion-item">
        <h2 class="accordion-header" id="headingHechas">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHechas" aria-expanded="false" aria-controls="collapseHechas">
           ............ Tareas hechas .............
          </button>
        </h2>
        <div id="collapseHechas" class="accordion-collapse collapse" aria-labelledby="headingHechas" data-bs-parent="#accordionExample">
          <div class="accordion-body">
            <?php if (count($hechas) > 0): ?>
              <div class="row">
                <?php foreach ($hechas as $index => $tarea): ?>
                  <div class="col-md-6 task-column">
                    <div class="card">
                      <div class="card-header" id="headingHechas<?php echo $index; ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHechas<?php echo $index; ?>" aria-expanded="false" aria-controls="collapseHechas<?php echo $index; ?>">
                          <!-- <input type="checkbox" class="me-2" aria-label="Checkbox for following text input" <?php echo $tarea->isdone ? 'checked' : ''; ?>> -->
                          <?php echo htmlspecialchars($tarea->titulo); ?>
                        </button>
                      </div>
                      <div id="collapseHechas<?php echo $index; ?>" class="accordion-collapse collapse" aria-labelledby="headingHechas<?php echo $index; ?>" data-bs-parent="#collapseHechas">
                        <div class="card-body">
                          <strong><?php echo htmlspecialchars($tarea->titulo); ?></strong><br>
                          <?php echo htmlspecialchars($tarea->contenido); ?><br>
                          <small>Fecha inicio: <?php echo htmlspecialchars($tarea->fechainicio); ?></small><br>
                          <small>Fecha fin: <?php echo htmlspecialchars($tarea->fechafin); ?></small><br>
                          <div class="button-group mt-3">
                            <a href="editar_tarea.php?id=<?php echo $tarea->id; ?>" class="btn btn-primary">Editar</a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#mdlEliminar" data-id="<?php echo $tarea->id; ?>" data-nombre="<?php echo htmlspecialchars($tarea->titulo); ?>">Eliminar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            <?php else: ?>
              <div class="alert alert-warning">No hay tareas hechas disponibles</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de confirmación para eliminar tarea -->
    <div class="modal fade" id="mdlEliminar" tabindex="-1" aria-labelledby="mdlEliminarLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="mdlEliminarLabel">Confirmar eliminación</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ¿Estás seguro de que deseas eliminar la tarea "<span id="taskName"></span>"?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <form method="POST" action="">
              <input type="hidden" name="id" id="taskId" value="">
              <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      var mdlEliminar = document.getElementById('mdlEliminar');
      mdlEliminar.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var taskId = button.getAttribute('data-id');
        var taskName = button.getAttribute('data-nombre');
        var modalBodySpan = mdlEliminar.querySelector('.modal-body #taskName');
        var modalFormInput = mdlEliminar.querySelector('.modal-footer form #taskId');
        
        modalBodySpan.textContent = taskName;
        modalFormInput.value = taskId;
      });
    </script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tareas.js">
</body>
</html>
