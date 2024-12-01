<?php
class CadastroController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $curso = $_POST['curso'] ?? '';
            $periodo = $_POST['periodo'] ?? '';
            $materia = $_POST['materia'] ?? '';
            $nome_atividade = $_POST['nome_atividade'] ?? '';
            $nota = $_POST['nota'] ?? '';

            try {
                $stmt = $this->conn->prepare("CALL cadastrar_atividade(?, ?, ?, ?, ?)");
                $stmt->execute([
                    $curso, 
                    $periodo, 
                    $materia, 
                    $nome_atividade, 
                    $nota
                ]);

                echo json_encode(['status' => 'success', 'message' => 'Atividade cadastrada com sucesso']);
            } catch(PDOException $e) {
                echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar atividade: ' . $e->getMessage()]);
            }
        }
    }
}