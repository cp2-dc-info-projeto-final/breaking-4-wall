<?php
session_start();
require_once 'conecta.php';

// Verifique se o usuário está logado como administrador
if (!isset($_SESSION['admin_id'])) {
    header('Location: login_adm.php');
    exit;
}

// Garantir que um ID de filme foi passado
if (!isset($_GET['id'])) {
    echo "ID do filme não fornecido.";
    exit;
}

$filmeId = $_GET['id'];

// Execute a exclusão
$deleteSql = "DELETE FROM Filmes WHERE ID = ?";
$deleteStmt = $conn->prepare($deleteSql);
$deleteStmt->bind_param('i', $filmeId);

if ($deleteStmt->execute()) {
    echo "Filme excluído com sucesso!";
    // Redirecione para a lista de filmes após a exclusão
    header('Location: lista_filmes.php');
    exit;
} else {
    echo "Erro ao excluir filme: " . $deleteStmt->error;
}

$deleteStmt->close();
$conn->close();
?>
