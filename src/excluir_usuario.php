<?php
session_start();
require_once 'conecta.php';


// Processa a deleção do usuário
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $userId = $_POST['id'];

    // Exclua os registros relacionados na tabela "comentarios"
    $deleteComentariosSql = "DELETE FROM comentarios WHERE usuario_id = ?";
    $deleteComentariosStmt = $conn->prepare($deleteComentariosSql);

    if (!$deleteComentariosStmt) {
        echo 'Erro na preparação da consulta: ' . htmlspecialchars($conn->error);
        exit;
    }

    $deleteComentariosStmt->bind_param("i", $userId);

    if ($deleteComentariosStmt->execute()) {
        // Agora que os comentários foram excluídos, você pode excluir o usuário
        $deleteUserSql = "DELETE FROM cadastrados WHERE id = ?";
        $deleteUserStmt = $conn->prepare($deleteUserSql);

        if (!$deleteUserStmt) {
            echo 'Erro na preparação da consulta: ' . htmlspecialchars($conn->error);
            exit;
        }

        $deleteUserStmt->bind_param("i", $userId);

        if ($deleteUserStmt->execute()) {
            echo "Usuário excluído com sucesso.";
            header("Location: dashboard.php");
        } else {
            echo "Erro ao excluir o usuário: " . $deleteUserStmt->error;
        }

        $deleteUserStmt->close();
    } else {
        echo "Erro ao excluir comentários: " . $deleteComentariosStmt->error;
    }

    $deleteComentariosStmt->close();
}

// Fechar conexão com o banco de dados
$conn->close();
?>
