$(document).ready(function() {
    // Carregar cursos para os selects
    function carregarCursos() {
        $.ajax({
            url: '?page=admin&action=listar_cursos',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#curso-periodo, #curso-materia').empty()
                    .append('<option value="" disabled selected>Selecione um Curso</option>');
                
                response.forEach(function(curso) {
                    $('#curso-periodo, #curso-materia').append(
                        `<option value="${curso.nome_curso}">${curso.nome_curso}</option>`
                    );
                });
            }
        });
    }

    // Carregar períodos ao selecionar curso
    $('#curso-materia').change(function() {
        const curso = $(this).val();
        
        $.ajax({
            url: '?page=admin&action=listar_periodos',
            method: 'GET',
            data: { curso: curso },
            dataType: 'json',
            success: function(response) {
                $('#periodo-materia')
                    .prop('disabled', false)
                    .empty()
                    .append('<option value="" disabled selected>Selecione um Período</option>');
                
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
        e.preventDefault();
        
        $.ajax({
            url: '?page=admin&action=cadastrar_curso',
            method: 'POST',
            data: {
                nome_curso: $('#nome_curso').val(),
                total_periodos: $('#total_periodos').val()
            },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                if (response.status === 'success') {
                    $('#nome_curso').val('');
                    $('#total_periodos').val('');
                    carregarCursos();
                }
            }
        });
    });

    // Submissão do formulário de período
    $('#form-periodo').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '?page=admin&action=cadastrar_periodo',
            method: 'POST',
            data: {
                curso: $('#curso-periodo').val(),
                numero_periodo: $('#numero_periodo').val()
            },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                if (response.status === 'success') {
                    $('#numero_periodo').val('');
                }
            }
        });
    });

    // Submissão do formulário de matéria
    $('#form-materia').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '?page=admin&action=cadastrar_materia',
            method: 'POST',
            data: {
                curso: $('#curso-materia').val(),
                periodo: $('#periodo-materia').val(),
                nome_materia: $('#nome_materia').val()
            },
            dataType: 'json',
            success: function(response) {
                alert(response.message);
                if (response.status === 'success') {
                    $('#nome_materia').val('');
                }
            }
        });
    });

    // Carregar cursos ao iniciar
    carregarCursos();
});