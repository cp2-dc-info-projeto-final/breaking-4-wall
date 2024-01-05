<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
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

// ID do usuário
$userId = $_SESSION["id"];

// Remove as referências na tabela Comentarios
$stmtUpdateComments = $conn->prepare("UPDATE Comentarios SET UsuarioId = NULL WHERE UsuarioId = ?");
$stmtUpdateComments->bind_param("i", $userId);

if ($stmtUpdateComments->execute()) {
    // Agora você pode excluir o usuário da tabela 'cadastrados'
    $stmtUser = $conn->prepare("DELETE FROM cadastrados WHERE id = ?");
    $stmtUser->bind_param("i", $userId);

    if ($stmtUser->execute()) {
        // Encerra a sessão
        session_unset();
        session_destroy();

        // Redireciona para a página principal
        header("location: index.html");
        exit;
    } else {
        echo "Erro ao excluir a conta: " . $stmtUser->error;
    }
} else {
    echo "Erro ao atualizar os comentários: " . $stmtUpdateComments->error;
}

$stmtUpdateComments->close();
$stmtUser->close();
$conn->close();
?>

