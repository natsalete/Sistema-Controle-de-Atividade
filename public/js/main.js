$(document).ready(function() {

    // Função para carregar cursos nos selects
    function carregarCursos() {
        $.ajax({
            url: '?page=ajax&action=buscar_cursos', // URL para buscar cursos
            method: 'GET', // Método GET para obter os dados
            dataType: 'json', // Tipo de resposta esperado
            success: function(response) {
                // Limpa e adiciona a opção padrão no select de cursos
                $('#curso, #filtro-curso').empty()
                    .append('<option value="" disabled selected>Selecione um curso...</option>');
                
                // Preenche os selects com os cursos recebidos
                response.forEach(function(curso) {
                    $('#curso, #filtro-curso').append(
                        `<option value="${curso.nome_curso}">${curso.nome_curso}</option>`
                    );
                });
            },
            error: function() {
                alert('Erro ao carregar cursos'); // Exibe erro caso falhe ao buscar os cursos
            }
        });
    }

    // Chama a função carregarCursos ao iniciar para popular os cursos
    carregarCursos();
    
    // Função para carregar períodos com base no curso selecionado
    function atualizarPeriodos(cursoSelecionado, selectElement) {
        const select = selectElement || '#periodo'; // Define o select de períodos
        $.ajax({
            url: '?page=ajax&action=periodos', // URL para buscar os períodos
            method: 'GET', // Método GET para obter os dados
            data: { curso: cursoSelecionado }, // Envia o curso selecionado como parâmetro
            dataType: 'json', // Tipo de resposta esperado
            success: function(response) {
                $(select).empty().append('<option value="" disabled selected>Selecione um período...</option>');
                
                // Preenche o select de períodos com os dados recebidos
                response.forEach(function(periodo) {
                    $(select).append(`<option value="${periodo.numero_periodo}">${periodo.numero_periodo}º Período</option>`);
                });
                
                $(select).prop('disabled', false); // Habilita o select de períodos
            }
        });
    }

    // Função para carregar as matérias com base no curso e período selecionados
    function atualizarMaterias(curso, periodo) {
        $.ajax({
            url: '?page=ajax&action=materias', // URL para buscar as matérias
            method: 'GET', // Método GET para obter os dados
            data: { 
                curso: curso,
                periodo: periodo
            },
            dataType: 'json', // Tipo de resposta esperado
            success: function(response) {
                $('#materia').empty().append('<option value="" disabled selected>Selecione uma matéria...</option>');
                
                // Preenche o select de matérias com os dados recebidos
                response.forEach(function(materia) {
                    $('#materia').append(`<option value="${materia.nome_materia}">${materia.nome_materia}</option>`);
                });
                
                $('#materia').prop('disabled', false); // Habilita o select de matérias
            }
        });
    }

    // Evento para quando o curso é alterado no formulário de cadastro
    $('#curso').change(function() {
        const curso = $(this).val(); // Obtém o valor do curso selecionado
        atualizarPeriodos(curso); // Atualiza os períodos com base no curso
        // Limpa e desabilita o select de matérias
        $('#materia').prop('disabled', true).empty().append('<option value="" disabled selected>Selecione uma matéria...</option>');
    });

    // Evento para quando o período é alterado no formulário de cadastro
    $('#periodo').change(function() {
        const curso = $('#curso').val(); // Obtém o valor do curso selecionado
        const periodo = $(this).val(); // Obtém o valor do período selecionado
        atualizarMaterias(curso, periodo); // Atualiza as matérias com base no curso e período
    });

    // Evento de submissão do formulário de cadastro
    $('#form-cadastro').submit(function(e) {
        e.preventDefault(); // Impede o envio padrão do formulário
        
        $.ajax({
            url: '?page=cadastro&action=salvar', // URL para salvar a nota
            method: 'POST', // Método POST para enviar os dados
            data: {
                curso: $('#curso').val(),
                periodo: $('#periodo').val(),
                materia: $('#materia').val(),
                nome_atividade: $('#nome_atividade').val(),
                nota: $('#nota').val()
            },
            dataType: 'json', // Tipo de resposta esperado
            success: function(response) {
                // Exibe a mensagem de sucesso ou erro
                if (response.status === 'success') {
                    alert('Nota cadastrada com sucesso!');
                    // Limpa os campos do formulário
                    $('#nome_atividade').val('');
                    $('#nota').val('');
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Erro ao cadastrar nota'); // Exibe erro se falhar ao cadastrar
            }
        });
    });

    // Evento para o filtro de cursos na página de visualização
    $('#filtro-curso').change(function() {
        const curso = $(this).val(); // Obtém o valor do curso selecionado
        
        // Busca os períodos do curso selecionado
        $.ajax({
            url: '?page=ajax&action=periodos',
            method: 'GET',
            data: { curso: curso },
            dataType: 'json',
            success: function(response) {
                $('#filtro-periodo').empty().append('<option value="" disabled selected>Filtrar por período...</option>');
                
                // Preenche o select de períodos com os dados recebidos
                response.forEach(function(periodo) {
                    $('#filtro-periodo').append(`<option value="${periodo.numero_periodo}">${periodo.numero_periodo}º Período</option>`);
                });
                
                $('#filtro-periodo').prop('disabled', false); // Habilita o select de períodos
            }
        });
    });

    // Evento para quando o período é selecionado no filtro de visualização
    $('#filtro-periodo').change(function() {
        const curso = $('#filtro-curso').val(); // Obtém o valor do curso selecionado
        const periodo = $(this).val(); // Obtém o valor do período selecionado
    
        $.ajax({
            url: '?page=visualizacao&action=obter_notas', // URL para obter as notas
            method: 'GET', // Método GET para buscar os dados
            data: { 
                curso: curso,
                periodo: periodo
            },
            dataType: 'json', // Tipo de resposta esperado
            success: function(response) {
                console.log('Dados recebidos:', response); // Exibe dados no console para debug
                
                $('#notas-view').empty(); // Limpa a visualização de notas
                
                if (response.error) {
                    $('#notas-view').html(`<p class="error">${response.error}</p>`); // Exibe erro se houver
                    return;
                }
                
                if (response.length === 0) {
                    $('#notas-view').html('<p>Nenhuma nota encontrada para este período.</p>'); // Exibe mensagem se não houver notas
                    return;
                }
    
                // Agrupa as notas por matéria
                const notasPorMateria = {};
                
                response.forEach(function(nota) {
                    if (!notasPorMateria[nota.nome_materia]) {
                        notasPorMateria[nota.nome_materia] = {
                            atividades: [],
                            media: nota.media_materia
                        };
                    }
                    
                    // Adiciona a atividade e nota à matéria
                    notasPorMateria[nota.nome_materia].atividades.push({
                        nome_atividade: nota.nome_atividade,
                        nota: nota.nota
                    });
                });
    
                // Renderiza as notas agrupadas por matéria
                Object.keys(notasPorMateria).forEach(function(materia) {
                    const materiaData = notasPorMateria[materia];
                    
                    const materiaHtml = `
                        <div class="materia-card">
                            <h3>${materia}</h3>
                            <p class="media">Média: ${Number(materiaData.media).toFixed(1)}</p>
                            <div class="atividades-list">
                                ${materiaData.atividades.map(ativ => `
                                    <div class="atividade-item">
                                        <span>${ativ.nome_atividade}</span>
                                        <span>${Number(ativ.nota).toFixed(1)}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                    
                    $('#notas-view').append(materiaHtml); // Adiciona as matérias à visualização
                });
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição:', error); // Exibe erro na requisição
                $('#notas-view').html('<p class="error">Erro ao carregar as notas. Por favor, tente novamente.</p>');
            }
        });
    });
});
