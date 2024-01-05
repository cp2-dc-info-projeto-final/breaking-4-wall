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

// Função para limpar e validar os dados do formulário
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Recebe os novos dados do formulário e o ID da sessão
$newName = sanitizeInput($_POST["newName"]);
$newEmail = sanitizeInput($_POST["newEmail"]);
$currentPassword = sanitizeInput($_POST["currentPassword"]);
$newPassword = sanitizeInput($_POST["newPassword"]);
$userId = $_SESSION["id"];

// Prepara a consulta SQL para verificar a senha atual
$stmt = $conn->prepare("SELECT senha FROM cadastrados WHERE id = ?");
$stmt->bind_param("i", $userId);

// Executa a consulta
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Verifica a senha atual
    if (password_verify($currentPassword, $hashed_password)) {
        // Senha atual correta, então atualiza os dados do usuário

        // Atualiza o nome
        $stmt_update_name = $conn->prepare("UPDATE cadastrados SET nome = ? WHERE id = ?");
        $stmt_update_name->bind_param("si", $newName, $userId);
        $stmt_update_name->execute();

        // Atualiza o email
        $stmt_update_email = $conn->prepare("UPDATE cadastrados SET email = ? WHERE id = ?");
        $stmt_update_email->bind_param("si", $newEmail, $userId);
        $stmt_update_email->execute();

        // Se a nova senha foi fornecida, atualiza a senha
        if (!empty($newPassword)) {
            $hashed_new_password = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt_update_password = $conn->prepare("UPDATE cadastrados SET senha = ? WHERE id = ?");
            $stmt_update_password->bind_param("si", $hashed_new_password, $userId);
            $stmt_update_password->execute();
        }

        // Redireciona para a página de perfil
        header("Location: perfil.php");
        exit;
    } else {
        echo "Senha atual incorreta.";
    }
} else {
    echo "Erro ao recuperar dados do usuário.";
}

$stmt->close();
$conn->close();
?>
