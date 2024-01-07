<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado, senão redireciona para a página de login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

// Dados do usuário para exibir no perfil
$nome = $_SESSION["nome"];
$email = $_SESSION["email"];
// Outros dados podem ser adicionados aqui conforme necessário
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <style>
       /* Estilos globais e da navbar existentes... */
/* (Se houver) */

/* Novos estilos adicionados */
body {
    background-color: #561237;
    font-family: Arial, sans-serif;
    color: #fff;
    margin: 0;
    padding: 0;
}

/* Estilo do container do perfil */
.profile-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #123456;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

/* Estilos para a seção de informações do perfil */
.profile-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Estilo para os rótulos das informações do perfil */
.profile-info label {
    color: #FFFFFF;
    margin-bottom: 5px;
    font-weight: bold;
}

/* Estilo para os valores das informações */
.profile-info p {
    background-color: #FFF;
    color: #000;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #444;
}

/* Estilo para o botão de editar */
.profile-action-buttons a {
    background-color: #337ab7;
    color: #FFF;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
}

.profile-action-buttons a:hover {
    background-color: #286090;
}

/* Estilo para o botão de excluir conta */
.profile-action-buttons a.delete-button {
    background-color: #d9534f;
}

.profile-action-buttons a.delete-button:hover {
    background-color: #c9302c;
}

/* Estilos para o formulário de edição */
.profile-edit-options form {
    max-width: 300px;
    margin: 0 auto;
}

.profile-edit-options .form-group {
    margin-bottom: 10px;
}

.profile-edit-options label {
    display: block;
    margin-bottom: 5px;
}

/* Estilos para o botão de atualizar */
.profile-edit-options input[type="submit"] {
    background-color: #337ab7;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-decoration: none;
    display: inline-block;
    margin-top: 10px;
}

.profile-edit-options input[type="submit"]:hover {
    background-color: #45a049;
}

    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Perfil</h2>
        </div>
        <div class="profile-info">
            <label>Nome:</label>
            <p id="nomeDisplay"><?php echo htmlspecialchars($_SESSION["nome"]); ?></p>
            <label>Email:</label>
            <p><?php echo htmlspecialchars($_SESSION["email"]); ?></p>
        </div>

        <!-- Botão de editar -->
        <div class="profile-action-buttons">
            <a href="#" class="edit-button" onclick="showEditOptions()">Editar</a>
        </div>

        <div class="profile-edit-options" style="display: none;">
    <!-- Formulário de Edição -->
    <form action="update_profile.php" method="post">
        <div class="form-group">
            <label for="newName">Novo Nome:</label>
            <input type="text" name="newName" id="newName" value="<?php echo htmlspecialchars($_SESSION["nome"]); ?>">
        </div>

        <div class="form-group">
            <label for="newEmail">Novo Email:</label>
            <input type="email" name="newEmail" id="newEmail" value="<?php echo htmlspecialchars($_SESSION["email"]); ?>">
        </div>

        <div class="form-group">
            <label for="currentPassword">Senha Atual:</label>
            <input type="password" name="currentPassword" id="currentPassword">
        </div>

        <div class="form-group">
            <label for="newPassword">Nova Senha:</label>
            <input type="password" name="newPassword" id="newPassword">
        </div>

        <input type="submit" value="Atualizar">
    </form>
</div>

        <!-- Botão de excluir conta -->
        <div class="profile-action-buttons">
            <a href="#" class="delete-button" onclick="confirmDelete()">Excluir Conta</a>
        </div>

        <!-- Botões de ação -->
        <div class="profile-action-buttons">
            <a href="logout.php" class="logout-button">Sair</a>
            <a href="index.html">Tela Principal</a>
        </div>
    </div>

    <script>
        function showEditOptions() {
            var editOptions = document.querySelector('.profile-edit-options');
            editOptions.style.display = 'block';
        }

        function confirmDelete() {
            var confirmDelete = confirm("Tem certeza de que deseja excluir sua conta?");
            if (confirmDelete) {
                window.location.href = "deleta_conta.php";
            }
        }
    </script>
</body>
</html>
