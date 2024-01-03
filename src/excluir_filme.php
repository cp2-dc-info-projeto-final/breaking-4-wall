<?php
session_start();
require_once 'conecta.php';

// Garanta que um ID de filme foi passado
if (!isset($_GET['id'])) {
    echo "ID do filme não fornecido.";
    exit;
}

$filmeId = $_GET['id'];

// Desative temporariamente a verificação de chave estrangeira
$conn->query("SET foreign_key_checks = 0");

// Execute a exclusão do filme
$deleteSql = "DELETE FROM Filmes WHERE ID = ?";
$deleteStmt = $conn->prepare($deleteSql);
$deleteStmt->bind_param('i', $filmeId);

if ($deleteStmt->execute()) {
    echo "Filme excluído com sucesso!";
    header("Location: lista_filmes.php");
} else {
    echo "Erro ao excluir filme: " . $deleteStmt->error;
}

$deleteStmt->close();

// Reative a verificação de chave estrangeira
$conn->query("SET foreign_key_checks = 1");

$conn->close();
?>
