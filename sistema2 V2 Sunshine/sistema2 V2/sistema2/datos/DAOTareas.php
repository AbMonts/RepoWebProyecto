<?php
// Importa la clase conexión y el modelo para usarlos
require_once 'conexion.php'; 
require_once '../modelos/Tarea.php'; 

class DAOTareas {
    private $conexion; 
    
    /**
     * Permite obtener la conexión a la BD
     */
    private function conectar() {
        try {
            $this->conexion = Conexion::conectar(); 
        } catch(Exception $e) {
            die($e->getMessage()); // Si la conexion no se establece se cortara el flujo enviando un mensaje con el error
        }
    }

    public function obtenerTareas($idUser) {
        try {
            $this->conectar();
            $idUser = trim($idUser);

            // Consulta para obtener tareas   
            $sentenciaSQL = $this->conexion->prepare("SELECT id, titulo, contenido, fechainicio, fechafin, isdone FROM Tareas WHERE idUsuario = ?");
            $sentenciaSQL->execute([$idUser]);

            $tareas = [];
            while ($fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ)) {
                $tareas[] = $fila;
            }

            return $tareas;

        } catch(Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function eliminarTarea($idTarea) {
        try {
            $this->conectar();
            $idTarea = trim($idTarea);

            // Consulta para eliminar tarea
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM Tareas WHERE id = ?");
            $result = $sentenciaSQL->execute([$idTarea]);

            return $result; // Devuelve true si la eliminación fue exitosa, false en caso contrario

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function obtenerTareaPorId($idTarea) {
        try {
            $this->conectar();
            $idTarea = trim($idTarea);

            // Consulta para obtener una tarea por su ID
            $sentenciaSQL = $this->conexion->prepare("SELECT id, titulo, contenido, fechainicio, fechafin, isdone FROM Tareas WHERE id = ?");
            $sentenciaSQL->execute([$idTarea]);

            $tarea = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            return $tarea;

        } catch(Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function actualizarTarea($idTarea, $titulo, $contenido, $fechainicio, $fechafin, $isdone) {
        try {
            $this->conectar();
            $sentenciaSQL = $this->conexion->prepare("UPDATE Tareas SET titulo = ?, contenido = ?, fechainicio = ?, fechafin = ?, isdone = ? WHERE id = ?");
            $result = $sentenciaSQL->execute([$titulo, $contenido, $fechainicio, $fechafin, $isdone, $idTarea]);

            return $result; // Devuelve true si la actualización fue exitosa, false en caso contrario

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    public function agregarTarea($titulo, $contenido, $fechainicio, $fechafin, $idUsuario) {
        try {
            $this->conectar();
            $sentenciaSQL = $this->conexion->prepare("INSERT INTO Tareas (titulo, contenido, fechainicio, fechafin, isdone, idUsuario) VALUES (?, ?, ?, ?, ?, ?)");
            $result = $sentenciaSQL->execute([$titulo, $contenido, $fechainicio, $fechafin, $isdone, $idUsuario]);

            return $result; // Devuelve true si la inserción fue exitosa, false en caso contrario

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }
}
?>
