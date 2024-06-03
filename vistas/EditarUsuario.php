<?php
session_start();
require_once '../datos/Conexion.php';
require_once '../modelos/Usuario.php';
require_once '../datos/DAOUsuario.php';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Usuario</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilos.css">
  <link  href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    .is-invalid {
      border-color: #dc3545;
    }
    .is-valid {
      border-color: #28a745;
    }
    .text-danger {
      font-size: 0.875em;
    }
  </style>
</head>
<body>
  <?php require("menuPrivado.php"); ?>
  <main>
    <div class="container pt-4">
      <h1>Editar Usuario</h1>

<?php
if (!isset($_SESSION['id'])) {
  die("Acceso denegado.");
}
if (!isset($_SESSION['id'])) {
  echo "<div class='alert alert-danger'>Usuario no autenticado</div>";
  header('Location: index.php');
  exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $mensaje = '';
      $tipo = '';

      $errores = [];
      $nombre = trim($_POST['nombre']);
      $correo = trim($_POST['correo']);
      $apellido1 = trim($_POST['apellido1']);
      $apellido2 = trim($_POST['apellido2']);
      $rol = trim($_POST['rol']);
      $contrasena = trim($_POST['contrasena']);

}
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
      $id = $_GET['id'];
      $dao = new DAOUsuario();
      $usuarioObj = $dao->obtenerPorId($id);
      if ($usuarioObj) {
          $nombre = $usuarioObj->nombre;
          $correo = $usuarioObj->correo;
          $apellido1 = $usuarioObj->apellido1;
          $apellido2 = $usuarioObj->apellido2;
          $rol = $usuarioObj->rol;
          $contrasena = $usuarioObj->contrasena;
      } else {
        $mensaje  = 'No se encontro el usuario.';
        $tipo = 'error';
          header("Location: listaUsuarios.php");
          exit();
      }
    } else {
      $mensaje  = 'Usuario no identificado.';
      $tipo = 'error';
      header("Location: listaUsuarios.php");
      exit();
    }
?>

      <form id="usuarioForm" action="actualizar_usuario.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" >
          <span id="errorNombre" class="text-danger"></span>
          <?php if (isset($errores['nombre'])): ?>
            <span class="text-danger" id="errorNombre"><?php echo htmlspecialchars($errores['nombre']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" >
          <span id="errorCorreo" class="text-danger"></span>
          <?php if (isset($errores['correo'])): ?>
            <span class="text-danger" id="errorCorreo"><?php echo htmlspecialchars($errores['correo']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="apellido1" class="form-label">Apellido Paterno</label>
          <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo htmlspecialchars($apellido1); ?>" >
          <span id="errorApellido1" class="text-danger"></span>
          <?php if (isset($errores['apellido1'])): ?>
            <span class="text-danger" id="errorApellido1"><?php echo htmlspecialchars($errores['apellido1']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="apellido2" class="form-label">Apellido Materno</label>
          <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo htmlspecialchars($apellido2); ?>">
          <span id="errorApellido2" class="text-danger"></span>
          <?php if (isset($errores['apellido2'])): ?>
            <span class="text-danger" id="errorApellido2"><?php echo htmlspecialchars($errores['apellido2']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="rol" class="form-label">Rol</label>
          <select class="form-control" id="rol" name="rol" required>
            <option value="" disabled>Selecciona un rol</option>
            <option value="admin" <?php echo ($rol == 'admin') ? 'selected' : ''; ?>>Administrador</option>
            <option value="usuario" <?php echo ($rol == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
          </select>
          <span id="errorRol" class="text-danger"></span>
          <?php if (isset($errores['rol'])): ?>
            <span class="text-danger" id="errorRol"><?php echo htmlspecialchars($errores['rol']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="contrasena" class="form-label">Contraseña</label>
          <input type="text" class="form-control" id="contrasena" name="contrasena" value="<?php echo htmlspecialchars($contrasena); ?>" required>
          <span id="errorContrasena" class="text-danger"></span>
          <?php if (isset($errores['contrasena'])): ?>
            <span class="text-danger" id="errorContrasena"><?php echo htmlspecialchars($errores['contrasena']); ?></span>
          <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="listaUsuarios.php" class="btn btn-secondary">Cancelar</a>
      </form>
    </div>
  </main>
  <?php require("pie.php"); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/editarUsuarios.js"></script>
</body>
</html>
