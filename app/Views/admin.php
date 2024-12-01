<!-- app/Views/admin.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Área Administrativa - Sistema de Notas</title>
    <link rel="stylesheet" href="../public/css/main.css">
   
</head>
<body>
    <aside>
        <img src="../public/img/Logo.svg" alt="Menino segurando caderno" />
        <div class="links">
            <a href="?page=cadastro" class="nav-link">Cadastrar</a>
            <a href="?page=visualizacao" class="nav-link">Visualizar</a>
            <a href="?page=admin" class="nav-link active">Área Administrativa</a>
        </div>
    </aside>

    <section id="admin-section" class="container">
        <div class="admin-container">
            <h2>ÁREA ADMINISTRATIVA</h2>
            
            <div class="admin-forms">
                <!-- Curso Form -->
                <div class="admin-form-card">
                    <h3>Cadastrar Curso</h3>
                    <form id="form-curso">
                        <input type="text" id="nome_curso" placeholder="Nome do Curso" required />
                        <input type="number" id="total_periodos" placeholder="Total de Períodos" min="1" max="10" required />
                        <button type="submit">Cadastrar Curso</button>
                    </form>
                </div>

                <!-- Período Form -->
                <div class="admin-form-card">
                    <h3>Cadastrar Período</h3>
                    <form id="form-periodo">
                        <select id="curso-periodo" required>
                            <option value="" disabled selected>Selecione um Curso</option>
                            <!-- Será preenchido dinamicamente -->
                        </select>
                        <input type="number" id="numero_periodo" placeholder="Número do Período" min="1" max="10" required />
                        <button type="submit">Cadastrar Período</button>
                    </form>
                </div>

                <!-- Matéria Form -->
                <div class="admin-form-card">
                    <h3>Cadastrar Matéria</h3>
                    <form id="form-materia">
                        <select id="curso-materia" required>
                            <option value="" disabled selected>Selecione um Curso</option>
                            <!-- Será preenchido dinamicamente -->
                        </select>
                        <select id="periodo-materia" required disabled>
                            <option value="" disabled selected>Selecione um Período</option>
                            <!-- Será preenchido dinamicamente -->
                        </select>
                        <input type="text" id="nome_materia" placeholder="Nome da Matéria" required />
                        <button type="submit">Cadastrar Matéria</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="../public/js/admin.js"></script>
</body>
</html>