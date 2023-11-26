<?php
session_start(); // Inicia a sessão para verificar o login do usuário

// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "pedro";
$password = "123456789";
$dbname = "CADASTRO";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado e se os campos atorID e filmeID foram passados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["atorID"]) && isset($_POST["filmeID"])) {
    $atorID = $_POST["atorID"];
    $filmeID = $_POST["filmeID"];

    // Prepara o statement SQL
    $stmt = $conn->prepare("INSERT INTO Atuacoes (AtorID, FilmeID) VALUES (?, ?)");
    $stmt->bind_param("ii", $atorID, $filmeID);

    // Executa o statement
    if ($stmt->execute()) {
        echo "Vinculação realizada com sucesso!";
    } else {
        echo "Erro ao vincular atuação: " . $stmt->error;
    }

    // Fecha o statement
    $stmt->close();
} else {
    // Mensagem de erro se os índices não estiverem definidos
    echo "Erro: os dados do ator ou do filme não foram enviados corretamente.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>

