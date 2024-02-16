<?php
session_start();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados de conexão com o banco de dados
    $servername = "localhost";
    $username_db = "cadastrados";
    $password_db = "123";
    $database = "CADASTRO";

    // Cria uma conexão com o banco de dados
    $conn = new mysqli($servername, $username_db, $password_db, $database);

    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    $email = $conn->real_escape_string($_POST["email"]);
    $senha = $_POST["senha"];

    // Prepara a consulta SQL para verificar se o usuário é um administrador
    $stmt_admin = $conn->prepare("SELECT id, usuario, email, senha FROM Administradores WHERE email = ?");
    $stmt_admin->bind_param("s", $email);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows === 1) {
        $user = $result_admin->fetch_assoc();
    } else {
        $message = "Nenhuma conta de administrador encontrada com esse e-mail.";
    }

    if (!empty($user) && password_verify($senha, $user['senha'])) {
        $_SESSION["loggedin"] = true;
        $_SESSION["id"] = $user["id"];
        $_SESSION["nome"] = isset($user["nome"]) ? $user["nome"] : $user["usuario"];
        $_SESSION["email"] = $user["email"];
        
        header("Location: dashboard.php"); // Redireciona para o dashboard do administrador
        exit;
    } else {
        $message = "Senha inválida ou usuário não encontrado.";
    }

    $stmt_admin->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
    <style>
    /* Estilo do corpo da página com a nova cor de fundo */
body {
    background-color: #561237; /* Cor de fundo atualizada baseada na imagem */
    font-family: Arial, sans-serif;
    color: #fff;
    margin: 0;
    padding: 0;
}

/* Estilo do container do formulário de login */
.container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #123456; /* Cor de fundo para o container do formulário */
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

/* Estilos para o formulário de login */
.login-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

/* Estilo para os rótulos do formulário */
.login-form label {
    color: #FFFFFF; /* Cor do texto para contraste com o fundo escuro */
    margin-bottom: 5px;
    font-weight: bold;
}

/* Estilo para os campos de entrada */
.login-form input[type="email"],
.login-form input[type="password"] {
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #444; /* Cor de borda ajustada para contraste */
    background-color: #FFF;
    color: #000;
}

/* Estilo para o botão de login */
.custom-button {
    background-color: rgb(255, 0, 119); /* Cor do botão atualizada para rosa */
    color: #FFF;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.custom-button:hover {
    background-color: #e6007e; /* Tom mais escuro de rosa para o estado de hover */
}

/* Mensagem de erro ou sucesso */
p {
    background-color: #444; /* Fundo para mensagem */
    color: #FFF;
    padding: 10px;
    border-radius: 4px;
    text-align: center;
}

/* Estilo para a mensagem de erro */
.login-form p {
    background-color: #ff3860; /* Cor de fundo para mensagens de erro */
    color: #ffffff;
    padding: 10px;
    border-radius: 4px;
    text-align: center;
    margin-top: 15px;
}

/* Estilo para o título do formulário */
.login-form h2 {
    color: #FFFFFF; /* Define a cor do título para branco */
    /* Outros estilos para h2 conforme necessário */
}

/* Estilo para o link "Esqueceu sua senha?" */
.login-button button a {
    text-decoration: none; /* Remove o sublinhado padrão do link */
    color: #e6007e; /* Cor do link */
    font-weight: bold; /* Deixa o texto em negrito */
}

.login-button button a:hover {
    text-decoration: underline; /* Adiciona sublinhado ao passar o mouse sobre o link */
}


    </style>
    
</head>
<body>
    <div class="container">
        <form action="login_adm.php" method="POST" class="login-form">
            <h2>Login Administrador</h2>

            <!-- Mensagem de erro ou sucesso -->
            <?php if (!empty($message)) : ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
           
            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
           
            <button type="submit" class="custom-button">Entrar</button>
        </form>
        <div class="login-button">
            <button><a href="esqueceu_senha.php">Esqueceu sua senha?</a></button>
        </div>
    </div>
</body>
</html>
