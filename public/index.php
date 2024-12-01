<?php
// Inclui os arquivos essenciais do projeto, como configuração do banco de dados e controladores
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/CadastroController.php';
require_once __DIR__ . '/../app/Controllers/VisualizacaoController.php';
require_once __DIR__ . '/../app/Controllers/AjaxController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';

// Define a página padrão como 'cadastro' caso 'page' não seja passada na URL
$page = $_GET['page'] ?? 'cadastro';

try {
    // Define as rotas da aplicação com base no valor de 'page'
    switch ($page) {
        case 'cadastro': // Rota para a página de cadastro
            $controller = new CadastroController();

            // Verifica se a ação é salvar e chama o método correspondente
            if (isset($_GET['action']) && $_GET['action'] === 'salvar') {
                $controller->salvar();
            } else {
                // Inclui a view da página de cadastro
                include __DIR__ . '/../app/Views/cadastro.php';
            }
            break;
        
        case 'visualizacao': // Rota para a página de visualização
            $controller = new VisualizacaoController();

            // Verifica se a ação é obter notas e chama o método correspondente
            if (isset($_GET['action']) && $_GET['action'] === 'obter_notas') {
                $controller->obterNotas();
            } else {
                // Inclui a view da página de visualização
                include __DIR__ . '/../app/Views/visualizacao.php';
            }
            break;
        
        case 'ajax': // Rota para chamadas AJAX
            $controller = new AjaxController();

            // Verifica qual ação AJAX foi solicitada
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'periodos': // Retorna períodos
                        $controller->periodos();
                        break;
                    case 'materias': // Retorna matérias
                        $controller->materias();
                        break;
                    case 'buscar_cursos': // Retorna cursos (novo caso)
                        $controller->buscarCursos();
                        break;
                }
            }
            break;
        
        case 'admin': // Rota para a página de administração
            $controller = new AdminController();

            // Verifica qual ação administrativa foi solicitada
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'listar_cursos': // Lista cursos cadastrados
                        $controller->listarCursos();
                        break;
                    case 'listar_periodos': // Lista períodos cadastrados
                        $controller->listarPeriodos();
                        break;
                    case 'cadastrar_curso': // Cadastra um novo curso
                        $controller->cadastrarCurso();
                        break;
                    case 'cadastrar_periodo': // Cadastra um novo período
                        $controller->cadastrarPeriodo();
                        break;
                    case 'cadastrar_materia': // Cadastra uma nova matéria
                        $controller->cadastrarMateria();
                        break;
                }
            } else {
                // Inclui a view da página de administração
                include __DIR__ . '/../app/Views/admin.php';
            }
            break;

        default: // Rota padrão para páginas não encontradas
            // Retorna um erro 404 e exibe uma mensagem ao usuário
            header("HTTP/1.0 404 Not Found");
            echo "Página não encontrada";
            break;
    }
} catch (Exception $e) {
    // Captura erros não tratados, registra no log e exibe uma mensagem genérica
    error_log($e->getMessage()); // Grava o erro no log para análise
    echo "Erro: " . $e->getMessage(); // Exibe o erro no navegador (apenas para debug)
}
