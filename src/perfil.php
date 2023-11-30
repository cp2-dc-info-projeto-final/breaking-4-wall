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
    <link rel="stylesheet" href="css/style.css">
    <title>Perfil</title>
</head>
<body>
    <div class="container">
        <h2>Perfil</h2>
        <p>Nome: <?php echo $nome; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <a href="logout.php">Sair</a> <!-- Botão de Logout -->
        <a href="index.html">Ir para tela inicial</a>
    </div>
</body>
</html>
