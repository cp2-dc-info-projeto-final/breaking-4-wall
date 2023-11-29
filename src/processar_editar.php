<?php
session_start();
require_once 'conecta.php';

// Verifique se o usuário está logado como administrador
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Verificar se os dados do formulário foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Suponha que 'id', 'nome', 'email' são os campos do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // Preparar a consulta SQL para atualização
    $sql = "UPDATE Usuarios SET nome = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erro ao preparar consulta: " . $conn->error);
    }

    $stmt->bind_param('ssi', $nome, $email, $id);
    
    if ($stmt->execute()) {
        echo "Usuário atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar usuário: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
