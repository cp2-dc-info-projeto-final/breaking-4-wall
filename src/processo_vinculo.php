<?php
// Dados de conexão ao banco de dados
$servername = "localhost";
$username = "vitor";
$password = "1234567";
$dbname = "cadastro";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Checa a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Checa se os dados foram enviados pelo formulário
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["filmeID"]) && isset($_POST["categoriaID"])) {
    $filmeID = $_POST["filmeID"];
    $categoriaID = $_POST["categoriaID"];

    // Prepara a inserção dos dados no banco
    $stmt = $conn->prepare("INSERT INTO FilmesCategorias (FilmeID, CategoriaID) VALUES (?, ?)");
    $stmt->bind_param("ii", $filmeID, $categoriaID);

    // Executa o statement
    if ($stmt->execute()) {
        echo "Vínculo entre filme e categoria realizado com sucesso!";
    } else {
        echo "Erro ao realizar o vínculo: " . $stmt->error;
    }

    // Fecha o statement
    $stmt->close();
} else {
    echo "Dados do formulário incompletos.";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
