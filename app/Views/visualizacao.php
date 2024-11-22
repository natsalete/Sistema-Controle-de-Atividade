<!-- app/Views/visualizacao.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistema de Controle de Notas</title>
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>
    <aside>
        <img src="../public/img/Logo.svg" alt="Menino segurando caderno" />
        <div class="links">
            <a href="?page=cadastro" class="nav-link">Cadastrar</a>
            <a href="?page=visualizacao" class="nav-link">Visualizar</a>
        </div>
    </aside>

    <section id="visualizacao-section" class="container">
        <div class="notas-container">
            <h2>NOTAS CADASTRADAS</h2>
            <div id="filtros">
                <select id="filtro-curso" required>
                    <option value="" disabled selected>Filtrar por curso...</option>
                    <option value="ads">Análise e Desenvolvimento de Sistema</option>
                    <option value="gestao">Gestão comercial</option>
                    <option value="engenharia">Engenharia Elétrica</option>
                </select>
                <select id="filtro-periodo" required disabled>
                    <option value="" disabled selected>Filtrar por período...</option>
                </select>
            </div>
            <div id="notas-view">
                <!-- As notas serão inseridas aqui dinamicamente -->
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/main.js"></script>
</body>
</html>