<?php
include "enviar_email.php";
include_once "conecta.php";
session_start();

$email = $_POST['email'];

// Verifica se a conexão com o banco de dados foi estabelecida corretamente
if ($conn === null) {
    die("Erro na conexão com o banco de dados.");
}

// Função para gerar nova senha e enviar e-mail
function processarRecuperacaoSenha($conn, $email) {
    // Gera uma nova senha aleatória
    $nova_senha = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

    // Atualiza a senha no banco de dados e envia o e-mail
    return atualizarSenhaEnviarEmail($conn, $email, $nova_senha);
}

// Função para atualizar a senha no banco de dados e enviar e-mail
function atualizarSenhaEnviarEmail($conn, $email, $nova_senha) {
    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
    $update_query = "UPDATE cadastrados SET senha = ? WHERE email = ?";
    $update_stmt = $conn->prepare($update_query);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($update_stmt === false) {
        return "Erro ao preparar a consulta de atualização.";
    }

    $update_stmt->bind_param("ss", $senha_hash, $email);
    $update_stmt->execute();

    if (envia_email($email, "Nova Senha Temporária", "Sua nova senha temporária é: $nova_senha")) {
        $conn->commit();
        return "Uma nova senha foi enviada para o seu e-mail.";
    } else {
        $conn->rollback();
        return "Falha ao enviar e-mail.";
    }
}

// Verifica se o e-mail existe e processa a recuperação de senha
function verificarEmail($conn, $email) {
    $query = "SELECT email FROM cadastrados WHERE email = ?";
    $stmt = $conn->prepare($query);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt === false) {
        return "Erro ao preparar a consulta de verificação de e-mail.";
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        return "E-mail não encontrado no banco de dados.";
    } else {
        $conn->begin_transaction();
        try {
            return processarRecuperacaoSenha($conn, $email);
        } catch (Exception $e) {
            $conn->rollback();
            return "Erro ao atualizar a senha.";
        }
    }
}

// Executa a lógica principal
$_SESSION['msg_rec'] = verificarEmail($conn, $email);
exit;
?>
