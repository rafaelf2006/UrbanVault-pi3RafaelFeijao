<?php
$host = "o_ip_ou_link_do_servidor"; // Ex: 'sql123.hostinger.com' ou um IP
$user = "u506280443_raffeidbUser";   // O utilizador que aparecia no teu erro
$pass = "6fkmoT&P"; 
$db   = "u506280443_raffei_db";     // O nome da base de dados remota

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro na conexão ao servidor remoto: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>