<?php
class AjaxController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function periodos() {
        $curso = $_GET['curso'] ?? '';
        $curso = $this->mapCurso($curso);

        try {
            $stmt = $this->conn->prepare("
                SELECT numero_periodo 
                FROM periodos p
                JOIN cursos c ON p.id_curso = c.id_curso
                WHERE c.nome_curso = ?
                ORDER BY numero_periodo
            ");
            $stmt->execute([$curso]);
            $periodos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($periodos);
        } catch(PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function materias() {
        $curso = $_GET['curso'] ?? '';
        $periodo = $_GET['periodo'] ?? '';
        $curso = $this->mapCurso($curso);

        try {
            $stmt = $this->conn->prepare("
                SELECT DISTINCT nome_materia 
                FROM materias m
                JOIN cursos c ON m.id_curso = c.id_curso
                JOIN periodos p ON m.id_periodo = p.id_periodo
                WHERE c.nome_curso = ? AND p.numero_periodo = ?
                ORDER BY nome_materia
            ");
            $stmt->execute([$curso, $periodo]);
            $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($materias);
        } catch(PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function mapCurso($curso) {
        $cursos = [
            'ads' => 'Análise e Desenvolvimento de Sistemas',
            'gestao' => 'Gestão Comercial',
            'engenharia' => 'Engenharia Elétrica'
        ];
        return $cursos[$curso] ?? $curso;
    }
}