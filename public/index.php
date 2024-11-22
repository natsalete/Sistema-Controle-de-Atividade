<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/CadastroController.php';
require_once __DIR__ . '/../app/Controllers/VisualizacaoController.php';
require_once __DIR__ . '/../app/Controllers/AjaxController.php';

$page = $_GET['page'] ?? 'cadastro';

try {
    switch ($page) {
        case 'cadastro':
            $controller = new CadastroController();
            if (isset($_GET['action']) && $_GET['action'] === 'salvar') {
                $controller->salvar();
            } else {
                include __DIR__ . '/../app/Views/cadastro.php';
            }
            break;
        
        case 'visualizacao':
            $controller = new VisualizacaoController();
            if (isset($_GET['action']) && $_GET['action'] === 'obter_notas') {
                $controller->obterNotas();
            } else {
                include __DIR__ . '/../app/Views/visualizacao.php';
            }
            break;
        
        case 'ajax':
            $controller = new AjaxController();
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'periodos':
                        $controller->periodos();
                        break;
                    case 'materias':
                        $controller->materias();
                        break;
                }
            }
            break;
        
        default:
            header("HTTP/1.0 404 Not Found");
            echo "Página não encontrada";
            break;
    }
} catch (Exception $e) {
    // Log error or handle it appropriately
    echo "Erro: " . $e->getMessage();
}