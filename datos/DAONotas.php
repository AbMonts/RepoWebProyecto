<?php
// Importa la clase conexión y el modelo para usarlos
require_once 'Conexion.php'; 

class DAONotas {
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

    // Método para obtener una nota por su ID
    public function obtenerNotaPorId($id) {
        try {
            $this->conectar();
            $id = trim($id);

            // Consulta para obtener una nota por su ID
            $sentenciaSQL = $this->conexion->prepare("SELECT id, titulo, contenido, idUsuario FROM notas WHERE id = ?");
            $sentenciaSQL->execute([$id]);

            $nota = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            return $nota;

        } catch(Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    // Método para obtener todas las notas de un usuario
    public function obtenerNotasPorUsuario($idUsuario) {
        try {
            $this->conectar();
            $idUsuario = trim($idUsuario);

            // Consulta para obtener todas las notas de un usuario
            $sentenciaSQL = $this->conexion->prepare("SELECT id, titulo, contenido, idUsuario FROM notas WHERE idUsuario = ?");
            $sentenciaSQL->execute([$idUsuario]);

            $notas = [];
            while ($fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ)) {
                $notas[] = $fila;
            }

            return $notas;

        } catch(Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    // Método para modificar una nota por su ID
    public function modificarNota($id, $titulo, $contenido) {
        try {
            $this->conectar();
            $id = trim($id);
            $titulo = trim($titulo);
            $contenido = trim($contenido);

            // Consulta para actualizar una nota
            $sentenciaSQL = $this->conexion->prepare("UPDATE notas SET titulo = ?, contenido = ? WHERE id = ?");
            $result = $sentenciaSQL->execute([$titulo, $contenido, $id]);

            return $result; // Devuelve true si la actualización fue exitosa, false en caso contrario

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    // Método para eliminar una nota por su ID
    public function eliminarNota($id) {
        try {
            $this->conectar();
            $id = trim($id);

            // Consulta para eliminar una nota
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM notas WHERE id = ?");
            $result = $sentenciaSQL->execute([$id]);

            return $result; // Devuelve true si la eliminación fue exitosa, false en caso contrario

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    // Método para agregar una nueva nota
    public function agregarNota($nota) {
        try {
            $this->conectar();
            $titulo = trim($nota->titulo);
            $contenido = trim($nota->contenido);
            $idUsuario = trim($nota->idUsuario);

            // Consulta para insertar una nueva nota
            $sentenciaSQL = $this->conexion->prepare("INSERT INTO notas (titulo, contenido, idUsuario) VALUES (?, ?, ?)");
            $result = $sentenciaSQL->execute([$titulo, $contenido, $idUsuario]);

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
