$(document).ready(function() {
    // Função para carregar os cursos nos selects
    function carregarCursos() {
        $.ajax({
            url: '?page=admin&action=listar_cursos', // URL para listar os cursos
            method: 'GET', // Método GET para buscar os dados
            dataType: 'json', // Tipo de dados esperado como resposta
            success: function(response) {
                // Limpa e adiciona a opção de "Selecione um Curso"
                $('#curso-periodo, #curso-materia').empty()
                    .append('<option value="" disabled selected>Selecione um Curso</option>');
                
                // Preenche os selects com os cursos recebidos
                response.forEach(function(curso) {
                    $('#curso-periodo, #curso-materia').append(
                        `<option value="${curso.nome_curso}">${curso.nome_curso}</option>`
                    );
                });
            }
        });
    }

    // Carregar os períodos ao selecionar um curso
    $('#curso-materia').change(function() {
        const curso = $(this).val(); // Obtém o valor do curso selecionado
        
        $.ajax({
            url: '?page=admin&action=listar_periodos', // URL para listar os períodos
            method: 'GET', // Método GET para buscar os dados
            data: { curso: curso }, // Envia o curso como parâmetro
            dataType: 'json', // Tipo de dados esperado como resposta
            success: function(response) {
                // Habilita o select de períodos e limpa as opções anteriores
                $('#periodo-materia')
                    .prop('disabled', false) // Habilita o select de períodos
                    .empty() // Limpa as opções existentes
                    .append('<option value="" disabled selected>Selecione um Período</option>');
                
                // Preenche o select com os períodos recebidos
                response.forEach(function(periodo) {
                    $('#periodo-materia').append(
                        `<option value="${periodo.numero_periodo}">${periodo.numero_periodo}º Período</option>`
                    );
                });
            }
        });
    });

    // Submissão do formulário de curso
    $('#form-curso').submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        
        $.ajax({
            url: '?page=admin&action=cadastrar_curso', // URL para cadastrar o curso
            method: 'POST', // Método POST para enviar os dados
            data: {
                nome_curso: $('#nome_curso').val(), // Obtém o valor do nome do curso
                total_periodos: $('#total_periodos').val() // Obtém o valor do total de períodos
            },
            dataType: 'json', // Tipo de dados esperado como resposta
            success: function(response) {
                alert(response.message); // Exibe a mensagem de resposta
                if (response.status === 'success') {
                    // Limpa os campos de entrada
                    $('#nome_curso').val('');
                    $('#total_periodos').val('');
                    carregarCursos(); // Recarrega a lista de cursos
                }
            }
        });
    });

    // Submissão do formulário de período
    $('#form-periodo').submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        
        $.ajax({
            url: '?page=admin&action=cadastrar_periodo', // URL para cadastrar o período
            method: 'POST', // Método POST para enviar os dados
            data: {
                curso: $('#curso-periodo').val(), // Obtém o curso selecionado
                numero_periodo: $('#numero_periodo').val() // Obtém o número do período
            },
            dataType: 'json', // Tipo de dados esperado como resposta
            success: function(response) {
                alert(response.message); // Exibe a mensagem de resposta
                if (response.status === 'success') {
                    // Limpa o campo de número do período
                    $('#numero_periodo').val('');
                }
            }
        });
    });

    // Submissão do formulário de matéria
    $('#form-materia').submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        
        $.ajax({
            url: '?page=admin&action=cadastrar_materia', // URL para cadastrar a matéria
            method: 'POST', // Método POST para enviar os dados
            data: {
                curso: $('#curso-materia').val(), // Obtém o curso selecionado
                periodo: $('#periodo-materia').val(), // Obtém o período selecionado
                nome_materia: $('#nome_materia').val() // Obtém o nome da matéria
            },
            dataType: 'json', // Tipo de dados esperado como resposta
            success: function(response) {
                alert(response.message); // Exibe a mensagem de resposta
                if (response.status === 'success') {
                    // Limpa o campo de nome da matéria
                    $('#nome_materia').val('');
                }
            }
        });
    });

    // Carregar cursos ao iniciar a página
    carregarCursos(); // Chama a função para carregar os cursos no início
});
