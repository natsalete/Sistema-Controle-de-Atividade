$(document).ready(function() {
    // Função para popular os períodos baseado no curso selecionado
    function atualizarPeriodos(cursoSelecionado, selectElement) {
        const select = selectElement || '#periodo';
        $.ajax({
            url: '?page=ajax&action=periodos',
            method: 'GET',
            data: { curso: cursoSelecionado },
            dataType: 'json',
            success: function(response) {
                $(select).empty().append('<option value="" disabled selected>Selecione um período...</option>');
                
                response.forEach(function(periodo) {
                    $(select).append(`<option value="${periodo.numero_periodo}">${periodo.numero_periodo}º Período</option>`);
                });
                
                $(select).prop('disabled', false);
            }
        });
    }

    // Função para popular as matérias baseado no curso e período selecionados
    function atualizarMaterias(curso, periodo) {
        $.ajax({
            url: '?page=ajax&action=materias',
            method: 'GET',
            data: { 
                curso: curso,
                periodo: periodo
            },
            dataType: 'json',
            success: function(response) {
                $('#materia').empty().append('<option value="" disabled selected>Selecione uma matéria...</option>');
                
                response.forEach(function(materia) {
                    $('#materia').append(`<option value="${materia.nome_materia}">${materia.nome_materia}</option>`);
                });
                
                $('#materia').prop('disabled', false);
            }
        });
    }

    // Evento de mudança do curso na página de cadastro
    $('#curso').change(function() {
        const curso = $(this).val();
        atualizarPeriodos(curso);
        $('#materia').prop('disabled', true).empty().append('<option value="" disabled selected>Selecione uma matéria...</option>');
    });

    // Evento de mudança do período na página de cadastro
    $('#periodo').change(function() {
        const curso = $('#curso').val();
        const periodo = $(this).val();
        atualizarMaterias(curso, periodo);
    });

    // Submissão do formulário de cadastro
    $('#form-cadastro').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '?page=cadastro&action=salvar',
            method: 'POST',
            data: {
                curso: $('#curso').val(),
                periodo: $('#periodo').val(),
                materia: $('#materia').val(),
                nome_atividade: $('#nome_atividade').val(),
                nota: $('#nota').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Nota cadastrada com sucesso!');
                    // Limpar campos do formulário
                    $('#nome_atividade').val('');
                    $('#nota').val('');
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Erro ao cadastrar nota');
            }
        });
    });

    // Eventos na página de visualização
    $('#filtro-curso').change(function() {
        const curso = $(this).val();
        
        // Buscar períodos do curso selecionado
        $.ajax({
            url: '?page=ajax&action=periodos',
            method: 'GET',
            data: { curso: curso },
            dataType: 'json',
            success: function(response) {
                $('#filtro-periodo').empty().append('<option value="" disabled selected>Filtrar por período...</option>');
                
                response.forEach(function(periodo) {
                    $('#filtro-periodo').append(`<option value="${periodo.numero_periodo}">${periodo.numero_periodo}º Período</option>`);
                });
                
                $('#filtro-periodo').prop('disabled', false);
            }
        });
    });

    // Buscar notas ao selecionar período na visualização
    $('#filtro-periodo').change(function() {
        const curso = $('#filtro-curso').val();
        const periodo = $(this).val();

        $.ajax({
            url: '?page=visualizacao&action=obter_notas',
            method: 'GET',
            data: { 
                curso: curso,
                periodo: periodo
            },
            dataType: 'json',
            success: function(response) {
                // Limpar view atual
                $('#notas-view').empty();

                // Agrupar por matéria e calcular média
                const notasPorMateria = {};
                
                response.forEach(function(nota) {
                    if (!notasPorMateria[nota.nome_materia]) {
                        notasPorMateria[nota.nome_materia] = {
                            atividades: [],
                            media: nota.media_materia
                        };
                    }
                    
                    notasPorMateria[nota.nome_materia].atividades.push({
                        nome_atividade: nota.nome_atividade,
                        nota: nota.nota
                    });
                });

                // Renderizar na tela
                Object.keys(notasPorMateria).forEach(function(materia) {
                    const materiaData = notasPorMateria[materia];
                    
                    const materiaHtml = `
                        <div class="materia-card">
                            <h3>${materia}</h3>
                            <p class="media">Média: ${materiaData.media.toFixed(1)}</p>
                            <div class="atividades-list">
                                ${materiaData.atividades.map(ativ => `
                                    <div class="atividade-item">
                                        <span>${ativ.nome_atividade}</span>
                                        <span>${ativ.nota.toFixed(1)}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                    
                    $('#notas-view').append(materiaHtml);
                });
            },
            error: function() {
                alert('Erro ao buscar notas');
            }
        });
    });
});