<?php
require_once '../datos/Conexion.php';
require_once '../modelos/Usuario.php';
require_once '../datos/DAOUsuario.php';

session_start();

$errores = $_SESSION['errores'] ?? [];
$data = $_SESSION['data'] ?? [];

$id = $data['id'] ?? null;
$nombre = $data['nombre'] ?? "";
$correo = $data['correo'] ?? "";
$apellido1 = $data['apellido1'] ?? "";
$apellido2 = $data['apellido2'] ?? "";
$rol = $data['rol'] ?? "";
$contrasena = $data['contrasena'] ?? "";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    if (empty($data)) {
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
            echo "No se encontró el usuario con ID: " . htmlspecialchars($id);
            exit;
        }
    }
} else {
    echo "ID de usuario no válido";
    exit;
}
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
</head>
<body>
  <?php require("menuPrivado.php"); ?>
  <main>
    <div class="container pt-4">
      <h1>Editar Usuario</h1>
      <form action="actualizar_usuario.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nombre</label>
          <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" >
          <?php if(isset($errores['nombre'])): ?>
            <span class="text-danger"><?php echo htmlspecialchars($errores['nombre']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="correo" class="form-label">Correo</label>
          <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" >
          <?php if(isset($errores['correo'])): ?>
            <span class="text-danger"><?php echo htmlspecialchars($errores['correo']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="apellido1" class="form-label">Apellido Paterno</label>
          <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo htmlspecialchars($apellido1); ?>" >
          <?php if(isset($errores['apellido1'])): ?>
            <span class="text-danger"><?php echo htmlspecialchars($errores['apellido1']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="apellido2" class="form-label">Apellido Materno</label>
          <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo htmlspecialchars($apellido2); ?>">
          <?php if(isset($errores['apellido2'])): ?>
            <span class="text-danger"><?php echo htmlspecialchars($errores['apellido2']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="rol" class="form-label">Rol</label>
          <select class="form-control" id="rol" name="rol" required>
            <option value="" disabled>Selecciona un rol</option>
            <option value="admin" <?php echo ($rol == 'admin') ? 'selected' : ''; ?>>Administrador</option>
            <option value="user" <?php echo ($rol == 'user') ? 'selected' : ''; ?>>Usuario</option>
          </select>
          <?php if(isset($errores['rol'])): ?>
            <span class="text-danger"><?php echo htmlspecialchars($errores['rol']); ?></span>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="contrasena" class="form-label">Contraseña</label>
          <input type="text" class="form-control" id="contrasena" name="contrasena" value="<?php echo htmlspecialchars($contrasena); ?>" required>
          <?php if(isset($errores['contrasena'])): ?>
            <span class="text-danger"><?php echo htmlspecialchars($errores['contrasena']); ?></span>
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
<?php
unset($_SESSION['errores']);
unset($_SESSION['data']);
?>
