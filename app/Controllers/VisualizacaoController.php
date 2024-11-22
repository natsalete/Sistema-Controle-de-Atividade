<?php
class VisualizacaoController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function obterNotas() {
        $curso = $_GET['curso'] ?? '';
        $periodo = $_GET['periodo'] ?? '';
        $curso = $this->mapCurso($curso);

        try {
            $stmt = $this->conn->prepare("CALL recuperar_notas(?, ?)");
            $stmt->execute([$curso, $periodo]);
            $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($notas);
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