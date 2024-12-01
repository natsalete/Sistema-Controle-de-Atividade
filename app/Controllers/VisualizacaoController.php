<?php
class VisualizacaoController {
    private $conn;

    // Construtor da classe, inicializa a conexão com o banco de dados
    public function __construct() {
        $database = new Database(); // Cria uma instância da classe Database
        $this->conn = $database->getConnection(); // Obtém a conexão com o banco de dados
    }

    // Método para obter as notas de um curso e período específicos
    public function obterNotas() {
        // Obtém o nome do curso e o número do período da URL (via GET)
        $curso = $_GET['curso'] ?? ''; // Se não houver valor, define como string vazia
        $periodo = $_GET['periodo'] ?? ''; // Se não houver valor, define como string vazia

        try {
            // Prepara a consulta SQL para chamar o procedimento armazenado 'recuperar_notas'
            $stmt = $this->conn->prepare("CALL recuperar_notas(?, ?)");
            // Executa a consulta com os parâmetros de curso e período
            $stmt->execute([$curso, $periodo]);
            // Obtém os resultados como um array associativo
            $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retorna as notas no formato JSON
            echo json_encode($notas);
        } catch(PDOException $e) {
            // Em caso de erro, retorna a mensagem de erro em formato JSON
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
