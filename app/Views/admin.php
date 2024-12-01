<!-- app/Views/admin.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Área Administrativa - Sistema de Notas</title>
    <!-- Link para o arquivo CSS que estiliza a página -->
    <link rel="stylesheet" href="../public/css/main.css">
</head>
<body>
    <!-- Barra lateral de navegação -->
    <aside>
        <!-- Logo do sistema -->
        <img src="../public/img/Logo.svg" alt="Menino segurando caderno" />
        <div class="links">
            <!-- Links de navegação, com destaque para a página ativa (Área Administrativa) -->
            <a href="?page=cadastro" class="nav-link">Cadastrar</a>
            <a href="?page=visualizacao" class="nav-link">Visualizar</a>
            <a href="?page=admin" class="nav-link active">Área Administrativa</a>
        </div>
    </aside>

    <!-- Seção principal da página administrativa -->
    <section id="admin-section" class="container">
        <div class="admin-container">
            <!-- Título da página -->
            <h2>ÁREA ADMINISTRATIVA</h2>
            
            <div class="admin-forms">
                <!-- Formulário para cadastrar curso -->
                <div class="admin-form-card">
                    <h3>Cadastrar Curso</h3>
                    <form id="form-curso">
                        <!-- Campo para inserir o nome do curso -->
                        <input type="text" id="nome_curso" placeholder="Nome do Curso" required />
                        <!-- Campo para inserir o total de períodos -->
                        <input type="number" id="total_periodos" placeholder="Total de Períodos" min="1" max="10" required />
                        <!-- Botão de submit para cadastrar o curso -->
                        <button type="submit">Cadastrar Curso</button>
                    </form>
                </div>

                <!-- Formulário para cadastrar período -->
                <div class="admin-form-card">
                    <h3>Cadastrar Período</h3>
                    <form id="form-periodo">
                        <!-- Select para escolher o curso (será preenchido dinamicamente) -->
                        <select id="curso-periodo" required>
                            <option value="" disabled selected>Selecione um Curso</option>
                            <!-- Opções serão inseridas dinamicamente via JavaScript -->
                        </select>
                        <!-- Campo para inserir o número do período -->
                        <input type="number" id="numero_periodo" placeholder="Número do Período" min="1" max="10" required />
                        <!-- Botão de submit para cadastrar o período -->
                        <button type="submit">Cadastrar Período</button>
                    </form>
                </div>

                <!-- Formulário para cadastrar matéria -->
                <div class="admin-form-card">
                    <h3>Cadastrar Matéria</h3>
                    <form id="form-materia">
                        <!-- Select para escolher o curso (será preenchido dinamicamente) -->
                        <select id="curso-materia" required>
                            <option value="" disabled selected>Selecione um Curso</option>
                            <!-- Opções serão inseridas dinamicamente via JavaScript -->
                        </select>
                        <!-- Select para escolher o período (será habilitado dinamicamente após seleção do curso) -->
                        <select id="periodo-materia" required disabled>
                            <option value="" disabled selected>Selecione um Período</option>
                            <!-- Opções serão inseridas dinamicamente via JavaScript -->
                        </select>
                        <!-- Campo para inserir o nome da matéria -->
                        <input type="text" id="nome_materia" placeholder="Nome da Matéria" required />
                        <!-- Botão de submit para cadastrar a matéria -->
                        <button type="submit">Cadastrar Matéria</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Inclusão do jQuery (biblioteca JavaScript) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Inclusão do arquivo JavaScript para tratar a interação dos formulários -->
    <script src="../public/js/admin.js"></script>
</body>
</html>
