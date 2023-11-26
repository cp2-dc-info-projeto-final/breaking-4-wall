<?php
// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username = "paulo";
$password = "12345678";
$dbname = "CADASTRO";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $nome = $_POST["nome"];
    $dataNascimento = $_POST["dataNascimento"];
    $nacionalidade = $_POST["nacionalidade"];
    $genero = $_POST["genero"];
    $biografia = $_POST["biografia"];

    // Prepara o statement SQL
    $stmt = $conn->prepare("INSERT INTO Atores (Nome, DataNascimento, Nacionalidade, Genero, Biografia) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nome, $dataNascimento, $nacionalidade, $genero, $biografia);

    // Executa o statement
    if ($stmt->execute()) {
        echo "Ator cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o ator: " . $stmt->error;
    }

    // Fecha o statement
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
