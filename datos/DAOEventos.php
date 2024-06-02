<?php
require_once 'Conexion.php';

class DAOEvento {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    /**
     * Agrega un nuevo evento.
     * @param string $titulo
     * @param string $descripcion
     * @param string $fechaInicio
     * @param string $fechaFin
     * @param int $idUsuario
     * @return int|false ID del evento agregado o false si falla.
     */
    public function agregar($titulo, $descripcion, $fechaInicio, $fechaFin, $idUsuario) {
        try {
            // Validar que los campos no estén vacíos y que idUsuario sea un entero
            if (empty($titulo) || empty($descripcion) || empty($fechaInicio) || empty($fechaFin) || !is_numeric($idUsuario)) {
                return false;
            }

            // Validar formato de fecha
            if (!strtotime($fechaInicio) || !strtotime($fechaFin)) {
                return false;
            }

            // Validar longitud de título y descripción
            if (strlen($titulo) > 100 || strlen($descripcion) > 500) {
                return false;
            }

            $sql = "INSERT INTO eventos (titulo, descripcion, fechaInicio, fechaFin, idUsuario) 
                    VALUES (:titulo, :descripcion, :fechaInicio, :fechaFin, :idUsuario)";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([
                ':titulo' => $titulo,
                ':descripcion' => $descripcion,
                ':fechaInicio' => $fechaInicio,
                ':fechaFin' => $fechaFin,
                ':idUsuario' => $idUsuario
            ]);
            return $this->conexion->lastInsertId();
        } catch (Exception $e) {
            // Manejar excepciones
            error_log('Error al agregar evento: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene un evento por su ID.
     * @param int $id ID del evento.
     * @return array Arreglo de objetos representando los eventos encontrados.
     */
    public function obtenerPorId($id) {
        try {
            $sql = "SELECT * FROM eventos WHERE idUsuario = :id";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([':id' => $id]);
            return $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Obtiene todos los eventos.
     * @return array Arreglo de objetos representando los eventos encontrados.
     */
    public function obtenerTodos() {
        try {
            $sql = "SELECT * FROM eventos";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute();
            return $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * Actualiza un evento existente.
     * @param int $id
     * @param string $titulo
     * @param string $descripcion
     * @param string $fechaInicio
     * @param string $fechaFin
     * @param int $idUsuario
     * @return int|false Número de filas afectadas o false si falla.
     */
    public function actualizar($id, $titulo, $descripcion, $fechaInicio, $fechaFin, $idUsuario) {
        try {
            // Validar que los campos no estén vacíos y que idUsuario sea un entero
            if (empty($id) || empty($titulo) || empty($descripcion) || empty($fechaInicio) || empty($fechaFin) || !is_numeric($idUsuario)) {
                return false;
            }

            // Validar formato de fecha
            if (!strtotime($fechaInicio) || !strtotime($fechaFin)) {
                return false;
            }

            // Validar longitud de título y descripción
            if (strlen($titulo) > 100 || strlen($descripcion) > 500) {
                return false;
            }

            $sql = "UPDATE eventos SET titulo = :titulo, descripcion = :descripcion, fechaInicio = :fechaInicio, fechaFin = :fechaFin, idUsuario = :idUsuario WHERE id = :id";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([
                ':id' => $id,
                ':titulo' => $titulo,
                ':descripcion' => $descripcion,
                ':fechaInicio' => $fechaInicio,
                ':fechaFin' => $fechaFin,
                ':idUsuario' => $idUsuario
            ]);
            return $sentenciaSQL->rowCount();
        } catch (Exception $e) {
            // Manejar excepciones
            error_log('Error al actualizar evento: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un evento por su ID.
     * @param int $id ID del evento.
     * @return int|false Número de filas afectadas o false si falla.
     */
    public function eliminar($id) {
        try {
            // Validar que el ID no esté vacío
            if (empty($id)) {
                return false;
            }

            $sql = "DELETE FROM eventos WHERE id = :id";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([':id' => $id]);
            return $sentenciaSQL->rowCount();
        } catch (Exception $e) {
            // Manejar excepciones
            error_log('Error al eliminar evento: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene los eventos de un usuario para un mes específico.
     * @param int $idUsuario ID del usuario.
     * @return array Arreglo de objetos representando los eventos encontrados.
     */
    public function obtenerEventosDelMes($idUsuario) {
        try {
            $sql = "SELECT id, titulo, descripcion, fechaInicio, fechaFin
                    FROM eventos
                    WHERE idUsuario = :idUsuario";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([':idUsuario' => $idUsuario]);
            return $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            return [];
        }
    }
}
?>
