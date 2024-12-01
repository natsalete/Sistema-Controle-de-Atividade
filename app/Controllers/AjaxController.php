<?php
class AjaxController {
    private $conn;

    // Construtor da classe, inicializa a conexão com o banco de dados
    public function __construct() {
        $database = new Database(); // Cria uma instância da classe Database
        $this->conn = $database->getConnection(); // Obtém a conexão com o banco de dados
    }

    // Método para retornar os períodos de um curso específico
    public function periodos() {
        // Obtém o nome do curso da URL (via GET)
        $curso = $_GET['curso'] ?? '';

        try {
            // Prepara a consulta para obter os períodos distintos do curso
            $stmt = $this->conn->prepare("
                SELECT DISTINCT p.numero_periodo 
                FROM periodos p
                JOIN cursos c ON p.id_curso = c.id_curso
                WHERE c.nome_curso = ?
                ORDER BY p.numero_periodo
            ");
            $stmt->execute([$curso]); // Executa a consulta com o nome do curso
            $periodos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os períodos como um array associativo

            // Retorna os períodos no formato JSON
            echo json_encode($periodos);
        } catch(PDOException $e) {
            // Em caso de erro, retorna a mensagem de erro em formato JSON
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Método para retornar as matérias de um curso e período específicos
    public function materias() {
        // Obtém o nome do curso e o número do período da URL (via GET)
        $curso = $_GET['curso'] ?? '';
        $periodo = $_GET['periodo'] ?? '';

        try {
            // Prepara a consulta para obter as matérias do curso e período
            $stmt = $this->conn->prepare("
                SELECT DISTINCT nome_materia 
                FROM materias m
                JOIN cursos c ON m.id_curso = c.id_curso
                JOIN periodos p ON m.id_periodo = p.id_periodo
                WHERE c.nome_curso = ? AND p.numero_periodo = ?
                ORDER BY nome_materia
            ");
            $stmt->execute([$curso, $periodo]); // Executa a consulta com o curso e o período
            $materias = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todas as matérias como um array associativo

            // Retorna as matérias no formato JSON
            echo json_encode($materias);
        } catch(PDOException $e) {
            // Em caso de erro, retorna a mensagem de erro em formato JSON
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Novo método para buscar todos os cursos disponíveis
    public function buscarCursos() {
        try {
            // Prepara a consulta para obter todos os cursos
            $stmt = $this->conn->query("SELECT nome_curso FROM cursos ORDER BY nome_curso");
            $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém todos os cursos como um array associativo

            // Retorna os cursos no formato JSON
            echo json_encode($cursos);
        } catch(PDOException $e) {
            // Em caso de erro, retorna a mensagem de erro em formato JSON
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>
