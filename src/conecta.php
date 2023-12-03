<?php
$servername = "localhost";
$username = "cadastrados"; // Seu nome de usuário do banco de dados
$password = "123"; // Sua senha do banco de dados
$dbname = "CADASTRO"; // Nome do seu banco de dados

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
