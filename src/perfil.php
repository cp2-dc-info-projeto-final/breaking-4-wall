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

        /* Estilo do corpo da página com a nova cor de fundo */
        body {
            background-color: #561237; /* Cor de fundo atualizada baseada na imagem */
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
            background-color: #123456; /* Cor de fundo para o container do perfil */
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

        /* Estilo para os botões de ação do perfil */
        .profile-action-buttons a {
            background-color: rgb(255, 0, 119); /* Cor que complementa a navbar */
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
            background-color: #ff3399; /* Tom mais escuro da cor do botão */
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
            <p><?php echo htmlspecialchars($nome); ?></p>
            <label>Email:</label>
            <p><?php echo htmlspecialchars($email); ?></p>
        </div>
        <div class="profile-action-buttons">
            <a href="logout.php">Sair</a>
            <a href="index.html">Ir para tela inicial</a>
        </div>
    </div>
</body>
</html>

