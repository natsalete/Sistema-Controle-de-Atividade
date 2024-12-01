<?php
// Inclui o arquivo de configuração do banco de dados
require_once __DIR__ . '/../../config/database.php';

class AdminController {
    private $conn; // Conexão com o banco de dados

    // Construtor da classe AdminController
    public function __construct() {
        $database = new Database(); // Instancia a classe Database
        $this->conn = $database->getConnection(); // Obtém a conexão com o banco de dados
    }

    // Lista todos os cursos cadastrados no banco de dados
    public function listarCursos() {
        try {
            $stmt = $this->conn->prepare("SELECT id_curso, nome_curso FROM cursos"); // Prepara a consulta SQL
            $stmt->execute(); // Executa a consulta
            $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém os resultados como um array associativo
            echo json_encode($cursos); // Retorna os resultados em formato JSON
        } catch(PDOException $e) {
            // Retorna um erro em formato JSON, útil para o frontend
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Lista os períodos de um curso específico
    public function listarPeriodos() {
        try {
            // Obtém o nome do curso a partir do parâmetro GET
            $curso = $_GET['curso'] ?? '';
            $stmt = $this->conn->prepare("
                SELECT DISTINCT numero_periodo 
                FROM periodos p
                JOIN cursos c ON p.id_curso = c.id_curso
                WHERE c.nome_curso = ?
                ORDER BY numero_periodo
            "); // Consulta SQL para listar períodos
            $stmt->execute([$curso]); // Executa a consulta passando o nome do curso como parâmetro
            $periodos = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obtém os resultados
            echo json_encode($periodos); // Retorna os resultados em formato JSON
        } catch(PDOException $e) {
            // Retorna um erro em formato JSON
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Cadastra um novo curso no banco de dados
    public function cadastrarCurso() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o método HTTP é POST
            // Obtém os dados enviados no formulário
            $nome_curso = $_POST['nome_curso'] ?? '';
            $total_periodos = $_POST['total_periodos'] ?? 0;

            try {
                // Prepara a consulta para inserir um curso
                $stmt = $this->conn->prepare("
                    INSERT INTO cursos (nome_curso, total_periodos) 
                    VALUES (?, ?)
                ");
                $stmt->execute([$nome_curso, $total_periodos]); // Executa a consulta
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Curso cadastrado com sucesso!'
                ]); // Retorna uma mensagem de sucesso
            } catch(PDOException $e) {
                // Retorna uma mensagem de erro
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao cadastrar curso: ' . $e->getMessage()
                ]);
            }
        }
    }

    // Cadastra um novo período em um curso
    public function cadastrarPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o método HTTP é POST
            // Obtém os dados enviados no formulário
            $nome_curso = $_POST['curso'] ?? '';
            $numero_periodo = $_POST['numero_periodo'] ?? 0;

            try {
                // Prepara a consulta para inserir um período
                $stmt = $this->conn->prepare("
                    INSERT INTO periodos (id_curso, numero_periodo) 
                    SELECT id_curso, ? 
                    FROM cursos 
                    WHERE nome_curso = ?
                ");
                $stmt->execute([$numero_periodo, $nome_curso]); // Executa a consulta
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Período cadastrado com sucesso!'
                ]); // Retorna uma mensagem de sucesso
            } catch(PDOException $e) {
                // Retorna uma mensagem de erro
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao cadastrar período: ' . $e->getMessage()
                ]);
            }
        }
    }

    // Cadastra uma nova matéria em um período de um curso
    public function cadastrarMateria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se o método HTTP é POST
            // Obtém os dados enviados no formulário
            $nome_curso = $_POST['curso'] ?? '';
            $numero_periodo = $_POST['periodo'] ?? 0;
            $nome_materia = $_POST['nome_materia'] ?? '';

            try {
                // Prepara a consulta para inserir uma matéria
                $stmt = $this->conn->prepare("
                    INSERT INTO materias (id_curso, id_periodo, nome_materia) 
                    SELECT c.id_curso, p.id_periodo, ? 
                    FROM cursos c
                    JOIN periodos p ON p.id_curso = c.id_curso
                    WHERE c.nome_curso = ? AND p.numero_periodo = ?
                ");
                $stmt->execute([$nome_materia, $nome_curso, $numero_periodo]); // Executa a consulta
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Matéria cadastrada com sucesso!'
                ]); // Retorna uma mensagem de sucesso
            } catch(PDOException $e) {
                // Retorna uma mensagem de erro
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao cadastrar matéria: ' . $e->getMessage()
                ]);
            }
        }
    }
}
