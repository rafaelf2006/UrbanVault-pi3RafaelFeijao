<?php
$host = "localhost";
$user = "root"; // Utilizador padrão do XAMPP
$pass = "";     // Password padrão é vazia
$db   = "nome_da_tua_base_de_dados";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Definir charset para evitar problemas com acentos (ex: €)
$conn->set_charset("utf8mb4");
?>