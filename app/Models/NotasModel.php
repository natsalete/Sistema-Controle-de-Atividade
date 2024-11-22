<?php
// app/Models/NotasModel.php
require_once __DIR__ . '/../../config/database.php';

class NotasModel {
    private $conn;
    private $table_name = 'notas';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function cadastrarNota($curso, $periodo, $materia, $atividade, $nota) {
        $query = "INSERT INTO " . $this->table_name . " 
                  (curso, periodo, materia, atividade, nota) 
                  VALUES (:curso, :periodo, :materia, :atividade, :nota)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":curso", $curso);
        $stmt->bindParam(":periodo", $periodo);
        $stmt->bindParam(":materia", $materia);
        $stmt->bindParam(":atividade", $atividade);
        $stmt->bindParam(":nota", $nota);
        
        return $stmt->execute();
    }

    public function obterNotas($curso, $periodo) {
        $query = "SELECT materia, atividade, nota 
                  FROM " . $this->table_name . " 
                  WHERE curso = :curso AND periodo = :periodo 
                  ORDER BY materia, atividade";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":curso", $curso);
        $stmt->bindParam(":periodo", $periodo);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}