<?php
// config/database.php
class Database {
    // Definindo as variáveis de conexão com o banco de dados
    private $host = 'localhost';  // Endereço do servidor MySQL
    private $db_name = 'sistema_notas';  // Nome do banco de dados
    private $username = 'root';  // Nome de usuário para o banco de dados
    private $password = '1234';  // Senha do banco de dados
    public $conn;  // A variável para armazenar a conexão com o banco

    // Função para obter a conexão com o banco de dados
    public function getConnection() {
        $this->conn = null;  // Inicializa a conexão como nula

        try {
            // Tenta estabelecer uma conexão com o banco de dados usando PDO
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            // Define o modo de erro para exceções
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Caso ocorra um erro na conexão, exibe a mensagem de erro
            echo "Erro de conexão: " . $exception->getMessage();
        }

        // Retorna a conexão ao final
        return $this->conn;
    }
}
