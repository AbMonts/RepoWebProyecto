<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/estilos.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style>
        .input-error {
            border-color: red;
        }
        .text-danger {
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    <?php 
        require("menuPrivado.php"); 
        require_once("../datos/DAOUsuario.php");

        // Inicializar variables
        $usuario = null;
        $id = null;

        // Si se recibe el ID del usuario, buscar los datos en la base de datos
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = $_GET['id'];
            $dao = new DAOUsuario();
            $usuario = $dao->obtenerPorId($id);
        }
    ?>
    <main>
        <div class="container pt-4">
            <?php
                if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
                    //Se ha indicado que se debe eliminar un usuario
                    $dao = new DAOUsuario();
                    if ($dao->eliminar($_POST["id"])) {
                        $_SESSION["msg"] = "alert-success--Usuario eliminado exitosamente";
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

            <!-- Formulario de edicion -->
            <form action="guardar_usuario.php" method="post" id="usuarioForm" onsubmit="return validarFormulario()">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario->id ?? ''); ?>">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario->nombre ?? ''); ?>">
                    <span id="errorNombre" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="apellido1" class="form-label">Primer Apellido</label>
                    <input type="text" class="form-control" id="apellido1" name="apellido1" value="<?php echo htmlspecialchars($usuario->apellido1 ?? ''); ?>">
                    <span id="errorApellido1" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="apellido2" class="form-label">Segundo Apellido</label>
                    <input type="text" class="form-control" id="apellido2" name="apellido2" value="<?php echo htmlspecialchars($usuario->apellido2 ?? ''); ?>">
                    <span id="errorApellido2" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario->correo ?? ''); ?>">
                    <span id="errorCorreo" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario->usuario ?? ''); ?>">
                    <span id="errorUsuario" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select class="form-control" id="rol" name="rol">
                        <option value="Default">Selecciona un rol</option>
                        <option value="usuario" <?php echo (isset($usuario->rol) && $usuario->rol == 'usuario') ? 'selected' : ''; ?>>Usuario</option>
                        <option value="admin" <?php echo (isset($usuario->rol) && $usuario->rol == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                    </select>
                    <span id="errorRol" class="text-danger"></span>
                </div>
                <div class="mb-3">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" value="<?php echo htmlspecialchars($usuario->contrasena ?? ''); ?>">
                    <span id="errorContrasena" class="text-danger"></span>
                </div>
                <a href="listaUsuarios.php" class="btn btn-primary">Regresar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </main>

    <?php require("pie.php"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/registroUsuarios.js"></script>
</body>
</html>
