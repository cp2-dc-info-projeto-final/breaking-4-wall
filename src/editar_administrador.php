<?php
session_start();
require_once 'conecta.php';

$adminId = $_SESSION['admin_id'] ?? null;
if (!$adminId) {
    header('Location: login_adm.php');
    exit;
}

// Buscar as informações do administrador para preencher o formulário
$sql = "SELECT usuario, email FROM Administradores WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $adminId);
$stmt->execute();
$resultado = $stmt->get_result();
$admin = $resultado->fetch_assoc();
$stmt->close();
$conn->close();

if (!$admin) {
    $_SESSION['mensagem'] = "Administrador não encontrado.";
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrador</title>
    <style>
        /* Estilos Gerais */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4; /* Cor de fundo suave */
        }

        /* Estilos para a página de edição */
        .content {
            margin: 0 auto;
            max-width: 600px;
            padding: 20px;
            background: #fff; /* Fundo branco para o conteúdo */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-left: 5px solid #4ecdc4; /* Borda lateral com cor verde-azulado da logo */
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #333; /* Texto escuro para melhor leitura */
        }

        .input-group input,
        .input-group button {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
        }

        .input-group input {
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .input-group button {
            background-color: #ff6b6b; /* Botão com a cor rosa-avermelhada da logo */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .input-group button:hover {
            background-color: #ff4757; /* Cor mais escura ao passar o mouse */
        }

        .input-group small {
            display: block;
            margin-top: 10px;
            color: #666; /* Texto informativo em cinza */
        }
    </style>
</head>
<body>
    <div class="content">
        <h1>Editar Administrador</h1>
        <form action="processa_editar_admin.php" method="POST">
            <!-- Campo para o nome de usuário -->
            <div class="input-group">
                <label for="username">Usuário:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($admin['usuario']); ?>" required>
            </div>
            <!-- Campo para o email -->
            <div class="input-group">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>
            </div>
            <!-- Campo para a nova senha (opcional) -->
            <div class="input-group">
                <label for="password">Nova Senha:</label>
                <input type="password" id="password" name="password">
                <small>Deixe em branco para não alterar a senha atual.</small>
            </div>
            <button type="submit" name="update_admin">Atualizar</button>
        </form>
    </div>
</body>
</html>
