<?php
session_start();
require_once 'conecta.php';

// Garanta que um ID de filme foi passado
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
} else {
    echo "Erro ao excluir filme: " . $deleteStmt->error;
}

$deleteStmt->close();
$conn->close();
?>
