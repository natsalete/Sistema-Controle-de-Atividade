<?php
class CadastroController {
    private $conn;

    // Construtor da classe, inicializa a conexão com o banco de dados
    public function __construct() {
        $database = new Database(); // Cria uma instância da classe Database
        $this->conn = $database->getConnection(); // Obtém a conexão com o banco de dados
    }

    // Método para salvar uma nova atividade no banco de dados
    public function salvar() {
        // Verifica se o método de requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados enviados pelo formulário via POST
            $curso = $_POST['curso'] ?? ''; // Curso
            $periodo = $_POST['periodo'] ?? ''; // Período
            $materia = $_POST['materia'] ?? ''; // Matéria
            $nome_atividade = $_POST['nome_atividade'] ?? ''; // Nome da atividade
            $nota = $_POST['nota'] ?? ''; // Nota da atividade

            try {
                // Prepara a consulta SQL para chamar o procedimento armazenado 'cadastrar_atividade'
                $stmt = $this->conn->prepare("CALL cadastrar_atividade(?, ?, ?, ?, ?)");
                // Executa a consulta com os parâmetros recebidos do formulário
                $stmt->execute([
                    $curso, 
                    $periodo, 
                    $materia, 
                    $nome_atividade, 
                    $nota
                ]);

                // Retorna uma resposta JSON indicando sucesso
                echo json_encode(['status' => 'success', 'message' => 'Atividade cadastrada com sucesso']);
            } catch(PDOException $e) {
                // Em caso de erro, retorna uma mensagem de erro em formato JSON
                echo json_encode(['status' => 'error', 'message' => 'Erro ao cadastrar atividade: ' . $e->getMessage()]);
            }
        }
    }
}
?>
