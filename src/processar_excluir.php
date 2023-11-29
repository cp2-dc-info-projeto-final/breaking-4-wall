<?php
session_start();
require_once 'conecta.php';

// Verifique se o usuário está logado como administrador
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Verificar se um ID foi fornecido
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar a consulta SQL para exclusão
    $sql = "DELETE FROM Usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar consulta: " . $conn->error);
    }

    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        echo "Usuário excluído com sucesso.";
    } else {
        echo "Erro ao excluir usuário: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
