<?php
$servername = "localhost";
$username = "cadastrados";
$password = "123";
$dbname = "CADASTRO";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
  die("Falha na conexão: " . $conn->connect_error);
}

// Prepara e vincula
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeCategoria = $_POST["nomeCategoria"];
    
    $stmt = $conn->prepare("INSERT INTO Categorias (Nome) VALUES (?)");
    $stmt->bind_param("s", $nomeCategoria);

    // Executa e verifica
    if ($stmt->execute()) {
        echo "Nova categoria cadastrada com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
