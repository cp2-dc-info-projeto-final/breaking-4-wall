<?php
$servername = "localhost";
$username = "usuario_mysql";
$password = "senha_mysql";

// Crie uma conexão com o servidor MySQL
$conn = new mysqli($servername, $username, $password);

// Verifique a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o servidor MySQL: " . $conn->connect_error);
}

// Crie o banco de dados "login"
$sql_create_db = "CREATE DATABASE IF NOT EXISTS login";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Banco de dados 'login' criado com sucesso<br>";
} else {
    echo "Erro ao criar o banco de dados: " . $conn->error . "<br>";
}

// Use o banco de dados "login"
$conn->select_db("login");

// Crie a tabela "cadastrados"
$sql_create_table = "CREATE TABLE IF NOT EXISTS cadastrados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL
)";
if ($conn->query($sql_create_table) === TRUE) {
    echo "Tabela 'cadastrados' criada com sucesso<br>";
} else {
    echo "Erro ao criar a tabela: " . $conn->error . "<br>";
}

// Feche a conexão com o MySQL
$conn->close();
?>
