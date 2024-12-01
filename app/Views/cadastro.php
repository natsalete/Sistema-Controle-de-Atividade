<!-- app/Views/cadastro.php -->
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

    <!-- Seção principal para o cadastro de atividades -->
    <section id="cadastro-section" class="container">
        <div class="atividade">
            <!-- Título da seção -->
            <h2>CADASTRAR ATIVIDADE</h2>
            <form id="form-cadastro">
                <!-- Select para escolher o curso -->
                <select id="curso">
                    <option value="" disabled selected>Selecione um curso...</option>
                    <!-- As opções de curso serão inseridas dinamicamente via JavaScript -->
                </select>
                <!-- Select para escolher o período, inicialmente desabilitado -->
                <select name="periodo" id="periodo" required disabled>
                    <option value="" disabled selected>Selecione um período...</option>
                    <!-- As opções de período serão inseridas dinamicamente dependendo do curso escolhido -->
                </select>
                <!-- Select para escolher a matéria, inicialmente desabilitado -->
                <select name="materia" id="materia" required disabled>
                    <option value="" disabled selected>Selecione uma matéria...</option>
                    <!-- As opções de matéria serão inseridas dinamicamente dependendo do período escolhido -->
                </select>
                <!-- Campo de texto para o nome da atividade -->
                <input type="text" id="nome_atividade" placeholder="Nome da atividade" required />
                <!-- Campo para a nota da atividade, com valores entre 0 e 10 -->
                <input type="number" id="nota" placeholder="Nota" min="0" max="10" step="0.1" required />
                <!-- Botão para submeter o formulário e cadastrar a atividade -->
                <button type="submit" id="cadastrar">CADASTRAR</button>
            </form>
        </div>
    </section>

    <!-- Inclusão do jQuery (biblioteca JavaScript) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclusão do arquivo JavaScript principal que manipula a interação do formulário -->
    <script src="../public/js/main.js"></script>
</body>
</html>
