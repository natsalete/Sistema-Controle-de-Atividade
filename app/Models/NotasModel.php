<?php
require_once __DIR__ . '/../../config/database.php';

class NotasModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function cadastrarNota($curso, $periodo, $materia, $atividade, $nota) {
        try {
            $stmt = $this->conn->prepare("CALL cadastrar_atividade(?, ?, ?, ?, ?)");
            return $stmt->execute([$curso, $periodo, $materia, $atividade, $nota]);
        } catch (PDOException $e) {
            throw new Exception("Erro ao cadastrar nota: " . $e->getMessage());
        }
    }

    public function obterNotas($curso, $periodo) {
        try {
            $stmt = $this->conn->prepare("CALL recuperar_notas(?, ?)");
            $stmt->execute([$curso, $periodo]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao recuperar notas: " . $e->getMessage());
        }
    }
}