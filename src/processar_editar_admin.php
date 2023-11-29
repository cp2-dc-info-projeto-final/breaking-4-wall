<?php
session_start();
require_once 'conecta.php';

if (isset($_POST['update_admin'], $_SESSION['admin_id'])) {
    $adminId = $_SESSION['admin_id'];
    $usuario = $_POST['username'];
    $email = $_POST['email'];
    $senha = $_POST['password']; // Se você adicionou o campo de senha ao seu formulário

    // Inicia uma transação
    $conexao->begin_transaction();

    try {
        // Atualiza o usuário e o e-mail
        $sql = "UPDATE Administradores SET usuario = ?, email = ? WHERE id = ?";
        $stmt = $conexao->prepare($sql);
        if (!$stmt) {
            throw new Exception($conexao->error);
        }
        $stmt->bind_param("ssi", $usuario, $email, $adminId);
        $stmt->execute();
        $stmt->close();

        // Atualiza a senha, se fornecida
        if (!empty($senha)) {
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE Administradores SET senha = ? WHERE id = ?";
            $stmt = $conexao->prepare($sql);
            if (!$stmt) {
                throw new Exception($conexao->error);
            }
            $stmt->bind_param("si", $senhaHash, $adminId);
            $stmt->execute();
            $stmt->close();
        }

        // Se tudo deu certo, commit a transação
        $conexao->commit();
        $_SESSION['mensagem'] = "Informações atualizadas com sucesso!";
        header('Location: dashboard.php');
        exit;
    } catch (Exception $e) {
        // Em caso de erro, desfaz a transação
        $conexao->rollback();
        $_SESSION['mensagem'] = "Erro ao atualizar informações: " . $e->getMessage();
        header('Location: editar_administrador.php');
        exit;
    }
} else {
    header('Location: editar_administrador.php');
    exit;
}
?>
