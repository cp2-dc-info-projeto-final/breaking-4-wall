<?php
session_start();

// Verifica se o usuário está logado e se o formulário foi enviado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SERVER["REQUEST_METHOD"] != "POST") {
    header("location: login.php");
    exit;
}

// Configuração das variáveis de conexão com o banco de dados
$servername = "localhost";
$username_db = "cadastrados";
$password_db = "123";
$database = "CADASTRO";

// Conecta ao banco de dados
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Recebe o novo nome do formulário e o ID da sessão
$newName = $conn->real_escape_string(trim($_POST["newName"]));
$userId = $_SESSION["id"];

// Prepara a consulta SQL para atualizar o nome do usuário
$stmt = $conn->prepare("UPDATE cadastrados SET nome = ? WHERE id = ?");
$stmt->bind_param("si", $newName, $userId);

// Executa a consulta
if ($stmt->execute()) {
    // Atualiza o nome na sessão
    $_SESSION["nome"] = $newName;
    $stmt->close();
    $conn->close();
    // Redireciona para a página de perfil
    header("Location: perfil.php");
    exit;
} else {
    echo "Erro ao atualizar o perfil: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>


