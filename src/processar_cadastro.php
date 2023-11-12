<?php
// Habilitar a exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // seu nome de usuário do banco de dados
$password = "12345"; // sua senha do banco de dados
$dbname = "cadastro";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Verifique se o método POST foi usado
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

    $stmt->close();
}

$conn->close();
?> 
