<?php
require_once __DIR__ . '/../../config/database.php';

class AdminController {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function listarCursos() {
        try {
            $stmt = $this->conn->prepare("SELECT id_curso, nome_curso FROM cursos");
            $stmt->execute();
            $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($cursos);
        } catch(PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function listarPeriodos() {
        try {
            $curso = $_GET['curso'] ?? '';
            $stmt = $this->conn->prepare("
                SELECT DISTINCT numero_periodo 
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

    public function cadastrarCurso() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_curso = $_POST['nome_curso'] ?? '';
            $total_periodos = $_POST['total_periodos'] ?? 0;

            try {
                $stmt = $this->conn->prepare("
                    INSERT INTO cursos (nome_curso, total_periodos) 
                    VALUES (?, ?)
                ");
                $stmt->execute([$nome_curso, $total_periodos]);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Curso cadastrado com sucesso!'
                ]);
            } catch(PDOException $e) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao cadastrar curso: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function cadastrarPeriodo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_curso = $_POST['curso'] ?? '';
            $numero_periodo = $_POST['numero_periodo'] ?? 0;

            try {
                $stmt = $this->conn->prepare("
                    INSERT INTO periodos (id_curso, numero_periodo) 
                    SELECT id_curso, ? 
                    FROM cursos 
                    WHERE nome_curso = ?
                ");
                $stmt->execute([$numero_periodo, $nome_curso]);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Período cadastrado com sucesso!'
                ]);
            } catch(PDOException $e) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao cadastrar período: ' . $e->getMessage()
                ]);
            }
        }
    }

    public function cadastrarMateria() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_curso = $_POST['curso'] ?? '';
            $numero_periodo = $_POST['periodo'] ?? 0;
            $nome_materia = $_POST['nome_materia'] ?? '';

            try {
                $stmt = $this->conn->prepare("
                    INSERT INTO materias (id_curso, id_periodo, nome_materia) 
                    SELECT c.id_curso, p.id_periodo, ? 
                    FROM cursos c
                    JOIN periodos p ON p.id_curso = c.id_curso
                    WHERE c.nome_curso = ? AND p.numero_periodo = ?
                ");
                $stmt->execute([$nome_materia, $nome_curso, $numero_periodo]);
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Matéria cadastrada com sucesso!'
                ]);
            } catch(PDOException $e) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Erro ao cadastrar matéria: ' . $e->getMessage()
                ]);
            }
        }
    }
}