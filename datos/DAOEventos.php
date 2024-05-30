<?php
require_once 'Conexion.php';

class DAOEvento {
    private $conexion;

    public function __construct() {
        $this->conexion = Conexion::conectar();
    }

    public function agregar($titulo, $descripcion, $fechaInicio, $fechaFin, $idUsuario) {
        try {
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
            return 0;
        }
    }

    public function obtenerPorId($id) {
        try {
            $sql = "SELECT * FROM eventos WHERE idUsuario = :id";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([':id' => $id]);
            return $sentenciaSQL->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            return null;
        }
    }

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

    public function actualizar($id, $titulo, $descripcion, $fechaInicio, $fechaFin, $idUsuario) {
        try {
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
            return 0;
        }
    }

    public function eliminar($id) {
        try {
            $sql = "DELETE FROM eventos WHERE id = :id";
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute([':id' => $id]);
            return $sentenciaSQL->rowCount();
        } catch (Exception $e) {
            return 0;
        }
    }
}
