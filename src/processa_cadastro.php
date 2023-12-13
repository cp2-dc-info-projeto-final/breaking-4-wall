<?php

// Dados de conexão ao banco de dados
$servername = "localhost";
$username = "cadastrados"; // Seu nome de usuário do banco de dados
$password = "123"; // Sua senha do banco de dados
$dbname = "CADASTRO";

// Criar conexão
$conn = new mysqli($servername, $username , $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifique se o método POST foi usado (ou seja, o formulário foi enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Receber dados do formulário
    $titulo = $_POST['titulo'];
    $anoLancamento = $_POST['anoLancamento'];
    $diretor = $_POST['diretor'];
    $sinopse = $_POST['sinopse'];

    // Preparar o comando SQL
    $stmt = $conn->prepare("INSERT INTO Filmes (Titulo, AnoLancamento, Diretor, Sinopse) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("siss", $titulo, $anoLancamento, $diretor, $sinopse);

    // Executar o comando SQL
    if ($stmt->execute()) {
        echo "Novo registro criado com sucesso";
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fechar statement
    $stmt->close();
}

// Fechar conexão
$conn->close();

?>
