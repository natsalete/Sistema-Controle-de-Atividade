<!-- app/Views/visualizacao.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema de Controle de Notas</title>
    <!-- Link para o arquivo CSS que estiliza a página -->
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>
    <!-- Barra lateral de navegação -->
    <aside>
        <!-- Logo do sistema -->
        <img src="../public/img/Logo.svg" alt="Menino segurando caderno" />
        <div class="links">
            <!-- Links de navegação para diferentes páginas -->
            <a href="?page=cadastro" class="nav-link">Cadastrar</a>
            <a href="?page=visualizacao" class="nav-link">Visualizar</a>
            <a href="?page=admin" class="nav-link">Área Administrativa</a>
        </div>
    </aside>

    <!-- Seção principal para a visualização das notas -->
    <section id="visualizacao-section" class="container">
        <div class="notas-container">
            <!-- Título da seção -->
            <h2>NOTAS CADASTRADAS</h2>
            <div id="filtros">
                <!-- Select para filtrar por curso -->
                <select id="filtro-curso">
                    <option value="" disabled selected>Selecione um curso...</option>
                    <!-- As opções de curso serão inseridas dinamicamente via JavaScript -->
                </select>
                <!-- Select para filtrar por período, inicialmente desabilitado -->
                <select id="filtro-periodo" required disabled>
                    <option value="" disabled selected>Filtrar por período...</option>
                    <!-- As opções de período serão inseridas dinamicamente dependendo do curso escolhido -->
                </select>
            </div>
            <div id="notas-view">
                <!-- As notas cadastradas serão inseridas aqui dinamicamente com base nos filtros selecionados -->
            </div>
        </div>
    </section>

    <!-- Inclusão do jQuery (biblioteca JavaScript) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclusão do arquivo JavaScript principal que manipula a interação da visualização -->
    <script src="../public/js/main.js"></script>
</body>
</html>
