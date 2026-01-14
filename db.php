<?php
// Configurações da base de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'urbanvault');

// Criar conexão
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão à base de dados: " . $conn->connect_error);
}

// Definir charset UTF-8
$conn->set_charset("utf8mb4");

// Opcional: Ativar report de erros (desativa em produção)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>