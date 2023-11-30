<?php
session_start();
require_once 'conecta.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login_adm.php');
    exit;
}

if (isset($_POST['delete'])) {
    $userId = $_POST['id'];

    // Prepare uma declaração para exclusão segura
    $sql = "DELETE FROM Cadastrados WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Erro na preparação da consulta: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->close();

    // Redireciona de volta para a lista de usuários
    header('Location: lista_cadastrados.php');
}
?>
