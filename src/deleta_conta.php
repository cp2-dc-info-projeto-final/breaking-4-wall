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

// Exclui os comentários associados ao usuário
$stmtDeleteComments = $conn->prepare("DELETE FROM comentarios WHERE usuario_id = ?");
$stmtDeleteComments->bind_param("i", $userId);

if ($stmtDeleteComments->execute()) {
    // Comentários excluídos com sucesso

    // Agora, verifica se há comentários associados a esse usuário
    $stmtCheckComments = $conn->prepare("SELECT COUNT(*) FROM comentarios WHERE usuario_id = ?");
    $stmtCheckComments->bind_param("i", $userId);
    $stmtCheckComments->execute();
    $stmtCheckComments->bind_result($commentCount);
    $stmtCheckComments->fetch();
    $stmtCheckComments->close();

    if ($commentCount > 0) {
        echo "Você não pode excluir a conta porque existem comentários associados a ela.";
    } else {
        // Não há comentários associados, então agora você pode excluir o usuário da tabela 'cadastrados'
        $stmtDeleteUser = $conn->prepare("DELETE FROM cadastrados WHERE id = ?");
        $stmtDeleteUser->bind_param("i", $userId);

        if ($stmtDeleteUser->execute()) {
            // Encerra a sessão
            session_unset();
            session_destroy();

            // Redireciona para a página principal
            header("location: index.html");
            exit;
        } else {
            echo "Erro ao excluir a conta: " . $stmtDeleteUser->error;
        }

        $stmtDeleteUser->close();
    }
} else {
    echo "Erro ao excluir comentários: " . $stmtDeleteComments->error;
}

$stmtDeleteComments->close();
$conn->close();
?>
