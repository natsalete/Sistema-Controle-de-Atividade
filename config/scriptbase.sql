-- Criar o banco de dados
CREATE DATABASE sistema_notas;
USE sistema_notas;

-- Tabela de Cursos
CREATE TABLE cursos (
    id_curso INT PRIMARY KEY AUTO_INCREMENT,
    nome_curso VARCHAR(100) NOT NULL,
    total_periodos INT NOT NULL
);

-- Tabela de Períodos
CREATE TABLE periodos (
    id_periodo INT PRIMARY KEY AUTO_INCREMENT,
    id_curso INT,
    numero_periodo INT NOT NULL,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso)
);

-- Tabela de Matérias
CREATE TABLE materias (
    id_materia INT PRIMARY KEY AUTO_INCREMENT,
    id_curso INT,
    id_periodo INT,
    nome_materia VARCHAR(150) NOT NULL,
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (id_periodo) REFERENCES periodos(id_periodo)
);

-- Tabela de Atividades
CREATE TABLE atividades (
    id_atividade INT PRIMARY KEY AUTO_INCREMENT,
    id_materia INT,
    nome_atividade VARCHAR(150) NOT NULL,
    nota DECIMAL(4,2) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_materia) REFERENCES materias(id_materia)
);

-- Stored Procedure para cadastrar atividade
DELIMITER //
CREATE PROCEDURE cadastrar_atividade(
    IN p_curso VARCHAR(100),
    IN p_periodo INT,
    IN p_materia VARCHAR(150),
    IN p_nome_atividade VARCHAR(150),
    IN p_nota DECIMAL(4,2)
)
BEGIN
    DECLARE v_id_curso INT;
    DECLARE v_id_periodo INT;
    DECLARE v_id_materia INT;
    -- Encontrar ID do curso
    SELECT id_curso INTO v_id_curso
    FROM cursos
    WHERE nome_curso = p_curso;
    -- Encontrar ID do período
    SELECT id_periodo INTO v_id_periodo
    FROM periodos
    WHERE id_curso = v_id_curso AND numero_periodo = p_periodo;
    -- Encontrar ID da matéria
    SELECT id_materia INTO v_id_materia
    FROM materias
    WHERE id_curso = v_id_curso AND id_periodo = v_id_periodo AND nome_materia = p_materia;
    -- Inserir atividade
    INSERT INTO atividades (id_materia, nome_atividade, nota)
    VALUES (v_id_materia, p_nome_atividade, p_nota);
END //
DELIMITER ;

-- Stored Procedure para recuperar notas por curso e período
DELIMITER //
CREATE PROCEDURE recuperar_notas(
    IN p_curso VARCHAR(100),
    IN p_periodo INT
)
BEGIN
    SELECT
        c.nome_curso,
        p.numero_periodo,
        m.nome_materia,
        a.nome_atividade,
        a.nota,
        AVG(a.nota) OVER (PARTITION BY m.nome_materia) as media_materia
    FROM
        atividades a
    JOIN
        materias m ON a.id_materia = m.id_materia
    JOIN
        periodos p ON m.id_periodo = p.id_periodo
    JOIN
        cursos c ON p.id_curso = c.id_curso
    WHERE
        c.nome_curso = p_curso AND p.numero_periodo = p_periodo;
END //
DELIMITER ;