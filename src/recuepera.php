<?php
include "envia_email.php";
include "conecta.php";
session_start();

$email = $_POST['email'];

// Função para gerar nova senha e enviar e-mail
function processarRecuperacaoSenha($mysqli, $email) {
    // Gera uma nova senha aleatória
    $nova_senha = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

    // Atualiza a senha no banco de dados e envia o e-mail
    return atualizarSenhaEnviarEmail($mysqli, $email, $nova_senha);
}

// Função para atualizar a senha no banco de dados e enviar e-mail
function atualizarSenhaEnviarEmail($mysqli, $email, $nova_senha) {
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    $update_query = "UPDATE cadastrados SET senha = ? WHERE email = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param("ss", $senha_hash, $email);
    $update_stmt->execute();

    if(envia_email($email, "Nova Senha Temporária", "Sua nova senha temporária é: $nova_senha")) {
        $mysqli->commit();
        return "Uma nova senha foi enviada para o seu e-mail.";
    } else {
        $mysqli->rollback();
        return "Falha ao enviar e-mail.";
    }
}

// Verifica se o e-mail existe e processa a recuperação de senha
function verificarEmail($mysqli, $email) {
    $query = "SELECT email FROM cadastrados WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "E-mail não encontrado no banco de dados.";
    } else {
        $mysqli->begin_transaction();
        try {
            return processarRecuperacaoSenha($mysqli, $email);
        } catch (Exception $e) {
            $mysqli->rollback();
            return "Erro ao atualizar a senha.";
        }
    }
}

// Executa a lógica principal
$_SESSION['msg_rec'] = verificarEmail($mysqli, $email);
exit;
?>

