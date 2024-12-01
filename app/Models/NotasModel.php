<?php
require_once __DIR__ . '/../../config/database.php'; // Inclui o arquivo de configuração do banco de dados

class NotasModel {
    private $conn;

    // Construtor da classe, inicializa a conexão com o banco de dados
    public function __construct() {
        $database = new Database(); // Cria uma instância da classe Database
        $this->conn = $database->getConnection(); // Obtém a conexão com o banco de dados
    }

    // Método para cadastrar uma nova nota de atividade
    public function cadastrarNota($curso, $periodo, $materia, $atividade, $nota) {
        try {
            // Prepara a consulta SQL para chamar o procedimento armazenado 'cadastrar_atividade'
            $stmt = $this->conn->prepare("CALL cadastrar_atividade(?, ?, ?, ?, ?)");
            // Executa a consulta passando os parâmetros para cadastrar a nota da atividade
            return $stmt->execute([$curso, $periodo, $materia, $atividade, $nota]);
        } catch (PDOException $e) {
            // Caso ocorra um erro ao cadastrar a nota, lança uma exceção com a mensagem de erro
            throw new Exception("Erro ao cadastrar nota: " . $e->getMessage());
        }
    }

    // Método para obter as notas de um curso e período específicos
    public function obterNotas($curso, $periodo) {
        try {
            // Prepara a consulta SQL para chamar o procedimento armazenado 'recuperar_notas'
            $stmt = $this->conn->prepare("CALL recuperar_notas(?, ?)");
            // Executa a consulta com os parâmetros de curso e período
            $stmt->execute([$curso, $periodo]);
            // Retorna os resultados como um array associativo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Caso ocorra um erro ao recuperar as notas, lança uma exceção com a mensagem de erro
            throw new Exception("Erro ao recuperar notas: " . $e->getMessage());
        }
    }
}
?>
