<?php

// Dados de conexão ao banco de dados
$servername = "localhost";
$username = "cadastrados";
$password = "123";
$dbname = "CADASTRO";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifique se o método POST foi usado (ou seja, o formulário foi enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") 
    // Receber dados do formulário
    $titulo = $_POST['titulo'];
    $anoLancamento = $_POST['anoLancamento'];
    $diretor = $_POST['diretor'];
    $sinopse = $_POST['sinopse'];
    $avaliacaoImdb = $_POST['avaliacaoImdb'];

   // Preparar o comando SQL
$stmt = $conn->prepare("INSERT INTO Filmes (Titulo, AnoLancamento, Diretor, Sinopse, AvaliacaoImdb) VALUES (?, ?, ?, ?, ?)");

// Verificar se a preparação da consulta foi bem-sucedida
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

// Converter o ano de lançamento para um número decimal
$anoLancamento = intval($_POST['anoLancamento']);

// Bind dos parâmetros e seus tipos
$stmt->bind_param("ssssd", $titulo, $anoLancamento, $diretor, $sinopse, $avaliacaoImdb);

// Executar o comando SQL
if ($stmt->execute()) {
    header("Location: dashboard.php");
    echo "Filme cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar o filme: " . $stmt->error;
}

// Fechar statement
$stmt->close();

// Fechar conexão
$conn->close();
?>
