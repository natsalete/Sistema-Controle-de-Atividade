<!-- app/Views/cadastro.php -->
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

    <section id="cadastro-section" class="container">
        <div class="atividade">
            <h2>CADASTRAR ATIVIDADE</h2>
            <form id="form-cadastro">
                <select name="curso" id="curso" required>
                    <option value="" disabled selected>Selecione um curso...</option>
                    <option value="ads">Análise e Desenvolvimento de Sistema</option>
                    <option value="gestao">Gestão comercial</option>
                    <option value="engenharia">Engenharia Elétrica</option>
                </select>
                <select name="periodo" id="periodo" required disabled>
                    <option value="" disabled selected>Selecione um período...</option>
                </select>
                <select name="materia" id="materia" required disabled>
                    <option value="" disabled selected>Selecione uma matéria...</option>
                </select>
                <input type="text" id="nome_atividade" placeholder="Nome da atividade" required />
                <input type="number" id="nota" placeholder="Nota" min="0" max="10" step="0.1" required />
                <button type="submit" id="cadastrar">CADASTRAR</button>
            </form>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/main.js"></script>
</body>
</html>