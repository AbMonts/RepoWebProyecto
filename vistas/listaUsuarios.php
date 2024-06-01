<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrar usuarios</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilos.css">
  <link  href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php 
  require("menuPrivado.php"); 
  require_once("../datos/DAOUsuario.php");
  ?>
  <main>
    <div class="container pt-4">
      <?php
        if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
          //Se ha indicado que se debe eliminar un usuario
          $dao = new DAOUsuario();
          if ($dao->eliminar($_POST["id"])) {
            $_SESSION["msg"] = "alert-success--Usuario eliminado exitósamente";
          } else {
            $_SESSION["msg"] = "alert-danger--No se ha podido eliminar al usuario seleccionado debido a que tiene procesos relacionados";
          }
        }

        if (isset($_SESSION["msg"])) {
          $msgInfo = explode("--", $_SESSION["msg"]);
          echo "<div class='alert $msgInfo[0]'>$msgInfo[1]</div>";
          unset($_SESSION["msg"]);
        }
      ?>
      <div>
        <a href="registroUsuarios.php" class="btn btn-primary mb-3">Agregar Usuario</a>
      </div>

      <table id="tblUsuarios" class="table table-striped">
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $dao = new DAOUsuario();
            $lista = $dao->obtenerTodos();
            if ($lista) {
              foreach ($lista as $usuario) {
                if ($usuario->rol != "admin") {
                  echo "<tr>
                    <td>" . htmlspecialchars($usuario->apellido1) . " " . htmlspecialchars($usuario->apellido2) . " " . htmlspecialchars($usuario->nombre) . "</td>
                    <td>" . htmlspecialchars($usuario->correo) . "</td>
                    <td>" . htmlspecialchars($usuario->rol) . "</td>
                    <td>
                      <a href='EditarUsuario.php?id=" . htmlspecialchars($usuario->id) . "' class='btn btn-primary'>Editar</a>
                      <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#mdlEliminar' 
                      data-id='" . htmlspecialchars($usuario->id) . "' data-nombre='" . htmlspecialchars($usuario->apellido1 . " " . $usuario->apellido2 . " " . $usuario->nombre) . "'>Eliminar</button>
                    </td>
                  </tr>";
                }
              }
            } else {
              echo "<tr><td colspan='4'>No hay usuarios disponibles :O</td></tr>";
            }
          ?>

          
        </tbody>
      </table> 
    </div>
  </main>
  <div class="modal" tabindex="-1" id="mdlEliminar" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Está a punto de eliminar al usuario <b id="UsuarioEliminar"></b>, ¿Desea continuar?
        </div>
        <div class="modal-footer">
          <form action="listaUsuarios.php" method="post">
            <input type="hidden" id="idUsuarioEliminar" name="id" value="">
            <button type="submit" class="btn btn-danger">Eliminar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php require("pie.php"); ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    var eliminarModal = document.getElementById('mdlEliminar');
    eliminarModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var userId = button.getAttribute('data-id');
      var userName = button.getAttribute('data-nombre');

      var modalBody = eliminarModal.querySelector('.modal-body #UsuarioEliminar');
      var modalInput = eliminarModal.querySelector('.modal-footer #idUsuarioEliminar');
      
      modalBody.textContent = userName;
      modalInput.value = userId;
    });
  </script>
   <script src="js/bootstrap.bundle.min.js"></script>
   
</body>
</html>
