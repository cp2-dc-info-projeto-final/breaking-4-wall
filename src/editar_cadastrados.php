<?php
session_start();

require_once 'conecta.php';

$usuarioEncontrado = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_procurar'])) {
    $userIdProcurar = $_POST['id_procurar'];

    // Consulta para obter informações do usuário
    $sqlUserInfo = "SELECT id, nome, email FROM cadastrados WHERE id = ?";
    $stmtUserInfo = $conn->prepare($sqlUserInfo);
    $stmtUserInfo->bind_param("i", $userIdProcurar);
    $stmtUserInfo->execute();
    $resultUserInfo = $stmtUserInfo->get_result();

    if ($resultUserInfo->num_rows > 0) {
        $userInfo = $resultUserInfo->fetch_assoc();
        $usuarioEncontrado = true;
    }

    $stmtUserInfo->close();
}

// Se o formulário de edição for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    // Certifique-se de que $userIdProcurar esteja definido corretamente
    if (isset($_POST['id'])) {
        $userIdProcurar = $_POST['id'];
    }

    $newNome = $_POST['novo_nome'];
    $newEmail = $_POST['novo_email'];

    // Atualiza as informações do usuário
    $sqlUpdate = "UPDATE cadastrados SET nome = ?, email = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssi", $newNome, $newEmail, $userIdProcurar);

    if ($stmtUpdate->execute()) {
        $_SESSION['message'] = 'Informações do usuário atualizadas com sucesso!';

        // Verificação e atualização da senha
        if (!empty($_POST['senha_atual']) && !empty($_POST['nova_senha'])) {
            $senhaAtual = $_POST['senha_atual'];

            // Verifica a senha atual
            $sqlVerificaSenha = "SELECT senha FROM cadastrados WHERE id = ?";
            $stmtVerificaSenha = $conn->prepare($sqlVerificaSenha);
            $stmtVerificaSenha->bind_param("i", $userIdProcurar);
            $stmtVerificaSenha->execute();
            $resultVerificaSenha = $stmtVerificaSenha->get_result();

            if ($resultVerificaSenha->num_rows > 0) {
                $senhaArmazenada = $resultVerificaSenha->fetch_assoc()['senha'];

                if (password_verify($senhaAtual, $senhaArmazenada)) {
                    // Atualiza a senha
                    $novaSenha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
                    $sqlUpdateSenha = "UPDATE cadastrados SET senha = ? WHERE id = ?";
                    $stmtUpdateSenha = $conn->prepare($sqlUpdateSenha);
                    $stmtUpdateSenha->bind_param("si", $novaSenha, $userIdProcurar);
                    
                    if ($stmtUpdateSenha->execute()) {
                        $_SESSION['message'] .= ' Senha atualizada com sucesso!';
                    } else {
                        $_SESSION['message'] .= ' Erro ao atualizar a senha.';
                    }

                    $stmtUpdateSenha->close();
                } else {
                    $_SESSION['message'] .= ' Senha atual incorreta.';
                }
            }

            $stmtVerificaSenha->close();
        }
    } else {
        $_SESSION['message'] = 'Erro ao atualizar informações do usuário.';
    }

    $stmtUpdate->close();

    header('Location: dashboard.php'); // Redireciona para o dashboard após a atualização
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            color: #333;
        }

        .container {
            background-color: #fff;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            display: inline-block;
            margin-bottom: 20px;
        }

        button[type=submit] {
            padding: 8px 15px;
            border: none;
            background-color: #9370DB; /* Cor roxa clara */
            color: white;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type=submit]:hover {
            background-color: #7B68EE; /* Cor roxa mais escura ao passar o mouse */
        }
    </style>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
    <div class="container">
        <h1>Editar Usuário</h1>

        <form action="" method="POST">
            <label for="id_procurar">ID do Usuário:</label>
            <input type="text" id="id_procurar" name="id_procurar" required>
            <button type="submit">Procurar</button>
        </form>

        <?php if ($usuarioEncontrado): ?>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $userInfo['id']; ?>">

                <label for="novo_nome">Novo Nome:</label>
                <input type="text" id="novo_nome" name="novo_nome" value="<?php echo htmlspecialchars($userInfo['nome']); ?>">

                <label for="novo_email">Novo Email:</label>
                <input type="email" id="novo_email" name="novo_email" value="<?php echo htmlspecialchars($userInfo['email']); ?>">

                <label for="senha_atual">Senha Atual:</label>
                <input type="password" id="senha_atual" name="senha_atual">

                <label for="nova_senha">Nova Senha:</label>
                <input type="password" id="nova_senha" name="nova_senha">

                <button type="submit" name="edit">Salvar Alterações</button>
            </form>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>Usuário não encontrado.</p>
        <?php endif; ?>
    </div>
</body>
</html>
